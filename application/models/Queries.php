<?php

/**
 * Description of Queries
 *
 * @author amoussawi
 */
class Queries extends CI_Model {

    private static $listsId = NULL;
    private static $InternalTitlesId = NULL;

    public function getModuleMetadata($moduleId) {
        $data = $this->db->from('lists')->where(array('id' => $moduleId))->get()->row();
        $data->ispublished = !!$data->ispublished;
        $data->fields = $this->db->where(array('listid' => $moduleId))->get('fields')->result();
        $data->table_exists = !!$this->db->table_exists($data->mapped_table);

        $data->fields_array = array();
        foreach ($data->fields as $field) {
            $data->fields_array[] = $field->internaltitle;
        }

        return $data;
    }

    public function getFieldTitle($fieldId, Array $fields) {
        if ($fieldId == -1) {
            return 'id';
        } else {
            foreach ($fields as $field) {
                if ($field->id == $fieldId) {
                    return $field->internaltitle;
                }
            }
            return NULL;
        }
    }

    public function getListTableById($id) {
        if (self::$listsId === NULL) {
            $result = $this->db->query('SELECT id,mapped_table FROM lists WHERE ispublished = 1')->result();
            foreach ($result as $row) {
                self::$listsId[$row->id] = $row->mapped_table;
            }
        }
        if (array_key_exists($id, self::$listsId)) {
            return self::$listsId[$id];
        } else {
            return NULL;
        }
    }

    public function getFieldInternalTitleById($id) {
        if ($id == -1) {
            return 'id';
        }

        if (self::$InternalTitlesId === NULL) {
            $result = $this->db->query('SELECT id,internaltitle FROM fields')->result();
            foreach ($result as $row) {
                self::$InternalTitlesId[$row->id] = $row->internaltitle;
            }
        }
        return self::$InternalTitlesId[$id];
    }

    

}
