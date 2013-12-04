<?php

/**
 * Description of ModuleController
 *
 * @author ahmad
 */
use Illuminate\Support\Contracts\ArrayableInterface;

class ResultSet implements ArrayableInterface {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    private function parseRow(&$row) {
        $row = (array) $row;
        foreach ($row as $field => $value) {
            if (strpos($field, '>') > 0) {

                list($prefix, $suffix) = explode('>', $field);

                if (!array_key_exists($prefix, $row)) {
                    $row[$prefix] = array();
                }

                $row[$prefix][$suffix] = $value;

                unset($row[$field]);
            }
        }
    }

    public function toRow() {
        $this->parseRow($this->data);
        return $this->data;
    }

    public function toArray() {

        //return $this->data;

        foreach ($this->data as &$row) {
            $this->parseRow($row);
        }

        return $this->data;
    }

}

class ModulesController extends BaseController {

    public function __construct() {
        $this->beforeFilter('auth');
    }

    public function Index($entityId) {
        $entity = Entity::filterByIdOrTitle($entityId)->first();

        if ($entity === null) {
            return Response::json(array(
                        'status' => false,
                        'exception' => 'EntityNotFound'
            ));
        }

        try {
            $where = json_decode(Input::get('where', '{}'));
        } catch (Exception $exc) {
            $where = array();
        }

        /* @var $query \Illuminate\Database\Query\Builder */
        $query = $entity->getDataQuery();

        if (Input::get('where')) {
            $where = explode(',', Input::get('where', ''));

            foreach ($where as $expr) {
                preg_match('/([A-z0-9_]+)([=<>:][><]*)(.*)/', $expr, $matches);

                $col = $matches[1];
                $operator = $matches[2];
                $value = $matches[3];

                if ($operator === ':') {
                    $operator = 'LIKE';
                }

                $query->where($col, $operator, $value);
            }
        }

        if (Input::get('limit')) {
            $query->limit(Input::get('limit'));
        }

        if (Input::get('select')) {
            $query->select(explode(',', Input::get('select')));
        }



        if (Input::get('orderBy')) {
            $order = explode(',', Input::get('orderBy', ''));
            foreach ($order as $column) {
                $direction = $column[0] === '-' ? 'desc' : 'asc';
                $column = $column[0] === '-' ? substr($column, 1) : $column;
                $query->orderBy($column, $direction);
            }
        }


        //dd(json_decode(Input::get('where')));

        $rows = new ResultSet($query->get());

        //dd(DB::getQueryLog());

        return Response::json(array(
                    'status' => true,
                    'data' => $rows->toArray(),
        ));
    }

    public function Get($entityId, $itemId) {


        $entity = Entity::filterByIdOrTitle($entityId)->first();


        $row = new ResultSet($entity->getDataQuery()->where($entity->fullIdentity, '=', $itemId)->first());
        return Response::json(array(
                    'status' => true,
                    'data' => $row->toRow()
        ));
    }

    // POST modules create
    public function postCreate($entityId) {
        $entity = Entity::filterByIdOrTitle($entityId)->first();
        $input = Input::get();
        try {
            $input['id'] = DB::table($entity->mappedtable)->insertGetId($input);
            return Response::json(array(
                        'status' => true,
                        'data' => $input
            ));
        } catch (Exception $exc) {
            return Response::json(array(
                        'status' => false,
                        'exception' => $exc->getMessage()
            ));
        }
    }

    // PUT update/:id/:id 
    public function putUpdate($entityId, $itemId) {
        $entity = Entity::filterByIdOrTitle($entityId)->first();

        //filter out foreign key starting with ___ (3 underscores)
        foreach (Input::get() as $key => $val) {
            if (strpos($key, '___') !== 0) {
                $input[$key] = $val;
            }
        }

        try {
            DB::table($entity->mappedtable)->
                    where($entity->identity, '=', $itemId)
                    ->update($input);
            return Response::json(array(
                        'status' => true,
                        'data' => $input
            ));
        } catch (Exception $exc) {
            return Response::json(array(
                        'status' => false,
                        'exception' => $exc->getMessage()
            ));
        }
    }

    // POST delete/:id/:id
    public function postDelete($entityId, $itemId) {
        $entity = Entity::filterByIdOrTitle($entityId)->first();
        $input = Input::get();
        try {
            DB::table($entity->mappedtable)
                    ->where($entity->identity, '=', $itemId)->delete();
            return Response::json(array(
                        'status' => true,
            ));
        } catch (Exception $exc) {
            return Response::json(array(
                        'status' => false,
                        'exception' => $exc->getMessage()
            ));
        }
    }

}
