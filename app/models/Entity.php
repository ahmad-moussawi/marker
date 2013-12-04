<?php

class Entity extends Eloquent {

    //protected $table = 'entities';
    protected $appends = array('full_identity');

    public function scopePublished($query) {
        return $query->where('ispublished', '=', 1);
    }

    public function scopeFilterByIdOrTitle($query, $id) {

        if ((int) $id > 0) {
            $query = $query->where('id', '=', $id);
        } else {
            $query = $query->where('internaltitle', '=', $id);
        }

        return $query->take(1);
    }

    public function getAttrsAttribute($value) {
        return json_decode($value);
    }

    public function setAttrsAttribute($value) {
        $this->attributes['attrs'] = json_encode($value);
    }

    public function setMappedtableAttribute($value) {
        $this->attributes['mappedtable'] = str_replace('-', '_', $value);
    }

    public function getIdentityAttribute($value) {
        return $value === '' ? 'id' : $value;
    }

    public function getFullIdentityAttribute() {
        return "{$this->mappedtable}.{$this->identity}";
    }

    public function fields() {
        return $this->hasMany('Field', 'entityid');
    }

    private function pointerFields() {
        $return = array();
        foreach ($this->fields as $field) {
            if ($field->isPointer()) {
                $return[] = $field;
            }
        }
        return $return;
    }

    public function attr($key, $default = null) {
        return property_exists((object) $this->attrs, $key) ? $this->attrs->{$key} : $default;
    }

    public function getDataQuery() {

        $query = DB::table($this->mappedtable);

        // build the joins
        foreach ($this->pointerFields() as $field) {
            $parentEntity = $field->getPointedEntity();
            $parentAlias = $parentEntity->mappedtable . '_' . $this->id;

            $parentFields = $parentEntity->fields()->
                            whereIn($parentEntity->identity, $field->getPointedFieldsIds())->get();

            // select the local fields
            $query = $query->select("$this->mappedtable.*");

            // select the parent fields
            foreach ($parentFields as $parentField) {
                //$parentFieldAlias1 = $parentEntity->internaltitle. '>' . $parentField->internaltitle;
                //$query = $query->addSelect("$parentAlias.$parentField->internaltitle as $parentFieldAlias1");

                $parentFieldAlias = "{$parentEntity->internaltitle}>{$parentField->internaltitle}";
                $query = $query->addSelect("$parentAlias.$parentField->internaltitle as $parentFieldAlias");
            }



            $query = $query->leftjoin(
                    "$parentEntity->mappedtable as $parentAlias", "$this->mappedtable.$field->internaltitle", '=', "$parentAlias.$parentEntity->identity");
        }

        return $query;
    }

    public function getSlug($title) {
        $slug = Str::slug($title);
        $slugCount = count($this->whereRaw("internaltitle REGEXP '^{$slug}(-[0-9]*)?$'")->get());
        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

}
