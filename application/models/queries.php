<?php

class Queries extends CI_Model {

    private static $listsId = NULL;
    private static $InternalTitlesId = NULL;

    public function getListMetadata($listId) {

        if (((int) $listId) > 0) {
            $where = array('id' => $listId);
        } else {
            $where = array('internaltitle' => $listId);
        }
        $data = $this->db->from('lists')->where($where)->get()->row();

        if (empty($data)) {
            throw new Exception('Module not found', 404);
        }

        $data->ispublished = !!$data->ispublished;

        // set the identity column to 'id' in case of empty
        if (empty($data->identity)) {
            $data->identity = 'id';
        }

        $data->fields = $this->db->where(array('listid' => $listId))->get('fields')->result();
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
