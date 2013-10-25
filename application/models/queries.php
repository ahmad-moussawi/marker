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
        $list = $this->db->from('lists')->where($where)->limit(1)->get()->row();

        if (empty($list)) {
            throw new Exception('Module not found', 404);
        }

        $list->ispublished = !!$list->ispublished;

        // set the identity column to 'id' in case of empty
        if (empty($list->identity)) {
            $list->identity = 'id';
        }

        // set the default attributes
        $default = array(
            'cssClass' => '',
            'view_edit' => FALSE,
            'view_delete' => FALSE,
            'view_create' => FALSE,
        );

        $list->attrs = (object) array_merge($default, (array) json_decode($list->attrs));

        // Manage the list fields
        $list->fields = $this->db->where(array('listid' => $list->id))->order_by('roworder')->get('fields')->result();
        if (stripos(php_uname('s'), 'win') !== FALSE) {
            $list->table_exists = !!$this->db->table_exists(strtolower($list->mapped_table));
        } else {
            $list->table_exists = !!$this->db->table_exists($list->mapped_table);
        }

        $list->fields_array = $list->published_fields_array = $list->published_fields = array();
        foreach ($list->fields as &$field) {
            
            $field->ispublished = !!$field->ispublished;
            $field->attrs = json_decode($field->attrs);
            $list->fields_array[] = $field->internaltitle;
            if ($field->ispublished) {
                $list->published_fields[] = $field;
                $list->published_fields_array[] = $field->internaltitle;
            }
        }

        return $list;
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