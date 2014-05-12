<?php

/**
 * Description of EntitiesController
 *
 * @author ahmad
 */
class EntitiesController extends BaseController {

    public function getIndex($entityId = null) {

        if ($entityId) {
            $entity = Entity::filterByIdOrTitle($entityId)->first();
            if (Input::get('fields')) {
                $entity->fields;
                //$entity->fields = $entity->fields()->orderBy('roworder')->get()->toArray();
            }
            return Response::json($entity->toArray());
        } else {
            $rows = Entity::all();
            return Response::json($rows);
        }
    }

    // POST /:id
    public function postIndex($entityId = null) {
        if (Input::get('existing') == 'true') {
            return $this->createFromExisting();
        }

        if ($entityId) {
            // update

            try {
                $data = (object) Input::get();
                $entity = Entity::find($entityId);
                $entity->title = $data->title;
                $entity->description = $data->description;
                $entity->ispublished = $data->ispublished;
                $entity->attrs = $data->attrs;
                $entity->save();

                $this->updateEntityFields($entity, $data->fields);


                return Response::json($entity);
            } catch (Exception $exc) {
                return Response::json($exc->getMessage() . ' ' . $exc->getLine(), 500);
            }
        } else {
            // create
            try {
                $data = (object) Input::get();

                $entity = new Entity();
                $entity->title = $data->title;
                $entity->internaltitle = $entity->getSlug($entity->title);
                $entity->mappedtable = $entity->internaltitle;
                $entity->description = $data->description;
                $entity->ispublished = $data->ispublished;
                $entity->attrs = $data->attrs;
                $entity->identity = $data->identity;

                $entity->save();

                // update the schema
                Schema::create($entity->mappedtable, function($table) use ($entity) {
                    $table->increments($entity->identity);
                });

                $this->createLink($entity, $data->link);

                return Response::json($entity);
            } catch (Exception $exc) {
                if (strpos($exc->getMessage(), 'Duplicate entry')) {
                    return Response::json('Dupplicate entity title', 500);
                } elseif (strpos($exc->getMessage(), 'Column already exists')) {
                    return Response::json('Dupplicate column title', 500);
                } else {
                    return Response::json($exc->getMessage() . ' line: ' . $exc->getLine(), 500);
                }
            }

            return Response::json(Input::get());
        }
    }

    public function createFromExisting() {
        // create
        try {
            $data = (object) Input::get();

            $entity = new Entity();
            $entity->title = $data->title;
            $entity->internaltitle = $entity->getSlug($entity->title);
            $entity->mappedtable = $data->mappedtable;
            $entity->description = $data->description;
            $entity->ispublished = $data->ispublished;
            $entity->attrs = $data->attrs;
            $entity->identity = $data->identity;
            $entity->save();



            $this->updateEntityFields($entity, $data->fields, false);
            $this->createLink($entity, $data->link);

            return Response::json($entity);
        } catch (Exception $exc) {
            if (strpos($exc->getMessage(), 'Duplicate entry')) {
                return Response::json('Dupplicate entity title', 500);
            } elseif (strpos($exc->getMessage(), 'Column already exists')) {
                return Response::json(array('Dupplicate column title', $exc->getMessage()), 500);
            } else {
                return Response::json($exc->getMessage() . ' ' . $exc->getLine(), 500);
            }
        }

        return Response::json(Input::get());
    }

    // DELETE /:id
    public function postDelete($entityId) {
        try {
            $affected = 0;
            DB::transaction(function() use($entityId, &$affected) {
                $entity = Entity::find($entityId);
                Field::where('entityid', '=', $entityId)->delete();
                $affected = Entity::where('id', '=', $entityId)->delete();
                // drop table
                //Schema::drop($entity->mappedtable);
            });
            return Response::json($affected);
        } catch (Exception $exc) {
            return Response::json($exc->getMessage(), 500);
        }
    }

    private function updateEntityFields($entity, $fieldsData, $updateSchema = true) {

        $order = 1;
        $foundFieldsId = array();
        foreach ($fieldsData as $fieldData) {
            $fieldData = (object) $fieldData;

            $field = null;

            if (isset($fieldData->id)) {
                // existing field
                $field = Field::find($fieldData->id);
                $foundFieldsId[] = $fieldData->id;
            } else {
                // new field
                $field = new Field();
                $field->entityid = $entity->id;

                if ($fieldData->internaltitle) {
                    $field->internaltitle = $fieldData->internaltitle;
                } else {
                    $field->internaltitle = $fieldData->title;
                }

                if ($updateSchema) {
                    Schema::table($entity->mappedtable, function($table) use($field, $fieldData) {
                        $dbtype = FieldDefinition::byref($fieldData->definition)->get()->first()->db_type->type;
                        switch (strtolower($dbtype)) {
                            case 'text':
                                $table->text($field->internaltitle);
                                break;
                            case 'varchar':
                                $table->string($field->internaltitle);
                                break;
                            case 'tinyint':
                                $table->boolean($field->internaltitle);
                                break;
                            case 'int':
                                $table->integer($field->internaltitle);
                                break;
                            case 'float':
                                $table->float($field->internaltitle);
                                break;
                            case 'double':
                                $table->double($field->internaltitle);
                                break;
                            case 'date':
                                $table->date($field->internaltitle);
                                break;
                            case 'datetime':
                                $table->datetime($field->internaltitle);
                                break;
                            case 'year':
                                $table->integer($field->internaltitle);
                                break;
                        }
                    });
                }
            }

            $field->title = $fieldData->title;
            $field->description = $fieldData->description;
            $field->ispublished = $fieldData->ispublished;
            $field->definition = $fieldData->definition;
            $field->attrs = $fieldData->attrs;
            $field->roworder = $order++;


            $field->save();
            $foundFieldsId[] = $field->id;
        }

        if ($updateSchema) {
            // Delete removed fields
            $entity->fields()->whereNotIn('id', $foundFieldsId)->delete();
        }
    }

    private function createLink($entity, $link) {
        if ($link['create']) {
            $dashboardModule = Entity::filterByIdOrTitle('dashboard')->first();
            DB::table($dashboardModule->mappedtable)->insert(array(
                'title' => $link['title'],
                'link' => "m/$entity->internaltitle",
                'ispublished' => 1
            ));
        }
    }

}
