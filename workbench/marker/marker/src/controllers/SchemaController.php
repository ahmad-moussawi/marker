<?php

class SchemaController extends BaseController {

    // GET /tables
    public function getTables() {
        $tables = DB::select('SHOW TABLES');
        $privatetables = Config::get('marker.private_tables');
        $return = array();
        foreach ($tables as $row) {
            $row = array_values((array) $row);
            if (!in_array($row[0], $privatetables)) {
                $return[] = $row[0];
            }
        }

        return Response::json($return);
    }

    public function getFields($table) {
        $fields = DB::select("DESCRIBE $table");
        return Response::json($fields);
    }

    public function getDefinitions() {
        return Response::json(DB::table('fieldsdefinitions')->get());
    }

}
