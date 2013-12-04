<?php

class FieldDefinition extends Eloquent {

    protected $table = 'fieldsdefinitions';

    public function scopeByRef($query, $ref) {
        return $query->where('ref', '=', $ref);
    }

    public function getDbTypeAttribute($value) {
        return json_decode($value);
    }

}
