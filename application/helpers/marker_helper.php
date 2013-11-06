<?php

function getTableName($table){
    $tables = config_item('marker_tables');
    if(array_key_exists($table, $tables)){
        return $tables[$table];
    }
    
    throw new Exception('Table mapping not found :' . $table);
}

function getMarkerTables(){
    return config_item('marker_tables');
}

/** load custom classes **/
include_once APPPATH . 'models/entities/Entity.php';
include_once APPPATH . 'models/entities/EntityField.php';