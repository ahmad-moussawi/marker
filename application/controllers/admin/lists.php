<?php

class Lists extends CI_Controller {

    private $table = 'lists';
    private $internalTables = array('ci_sessions', 'fields', 'fields_types', 'lists', 'members', 'membersinroles', 'roles', 'pages');

    public function __construct() {
        parent::__construct();
        Auth::ValidateRequest();
        $this->load->database();
        $this->load->helper('array');
        $this->load->model('queries');
        $this->load->dbforge();
        header('Content-Type:application/json');
    }
    
    function Get($id = FALSE) {
        if ($id) {
            $data = $this->queries->getListMetadata($id);
        } else {
            $data = $this->db->from($this->table)->get()->result();
            foreach ($data as $row) {
                $row->ispublished = !!$row->ispublished;
            }
        }
        echo json_encode($data);
    }

    function Set($id = FALSE) {
        $response = FALSE;
        $data = elements(array('title', 'internaltitle', 'mapped_table', 'description', 'ispublished', 'attrs'), Request::Post());
        if (!$id) {
            // create

            $data['mapped_table'] = 'lists_' . $data['internaltitle'];
            // Create the table
            $this->load->dbforge();
            $this->dbforge->add_field('id');
            $this->dbforge->create_table($data['mapped_table']);

            $data['created'] = date('Y-m-d');
            $data['attrs'] = json_encode($data['attrs']);
            $data['createdby'] = Auth::IsAuthenticated()->login;
            $this->db->insert($this->table, $data);
            $id = $this->db->insert_id();
            $response = $id;
        } else {
            // update
            $data['modified'] = date('Y-m-d');
            $data['attrs'] = json_encode($data['attrs']);

            $fields = Request::Post('fields');
            //Update the fields
            $i = 1;
            foreach ($fields as $field) {
                $fieldData = elements(array('title', 'typeref', 'ispublished', 'description', 'attrs'), (array) $field);
                $fieldData['attrs'] = json_encode($fieldData['attrs']);
                $fieldData['roworder'] = $i++;
                $this->db->update('fields', $fieldData, array('id' => $field->id));
            }

            // Update the list
            $this->db->update($this->table, $data, array('id' => $id));

            $response = $this->db->affected_rows();
        }

        // Todo updates columns

        echo json_encode($response);
    }

    function Delete($id) {
        try {
            //$list = $this->_getList($id, FALSE, FALSE);
            $this->db->delete('fields', array('listid' => $id));
            $this->db->delete($this->table, array('id' => $id));
            //$this->dbforge->drop_table($list->mapped_table);
            $response = TRUE;
        } catch (Exception $exc) {
            $response = FALSE;
        }
        echo json_encode($response);
    }

    function createFromExisting() {
        $list = Request::Post('list');


        // Add the list
        $data = elements(array('title', 'internaltitle', 'mapped_table', 'description', 'ispublished', 'attrs'), (array) $list);
        $data['created'] = date('Y-m-d');
        $data['createdby'] = Auth::IsAuthenticated()->login;
        $data['identity'] = $this->_getIdentityFieldTitle($list->fields);
        $data['attrs'] = json_encode($data['attrs']);

        $this->db->insert($this->table, $data);
        $list->id = $this->db->insert_id();

        // Add fields
        foreach ($list->fields as &$field) {
            if (!$field->primary_key) {
                $fieldData = elements(array('title', 'internaltitle', 'typeref', 'ispublished', 'description', 'attrs'), (array) $field);
                $fieldData['internaltitle'] = $field->name;
                $fieldData['listid'] = $list->id;
                $this->db->insert('fields', $fieldData);
                $field->id = $this->db->insert_id();
            }
        }


        return $this->json(TRUE, $list);
    }

    function setTitleField($fieldId, $listId) {
        $this->db->update('fields', array('istitle' => 1), array('id' => $fieldId));
        $this->db->update('fields', array('istitle' => 0), array('listid' => $listId));

        return $this->json(array('field' => $this->db->get_where('fields', array('id' => $fieldId), 1)->row()));
    }

    /**
     * 
     * @param int or string $id the list id or internal name
     */
    function GetFields($id) {
        $data = $this->db->get_where('fields', array('listid' => $id))->result();
        echo json_encode($data);
    }

    function AddField($listId) {
        $list = $this->db->where(array('id' => $listId))->limit(1)->get($this->table)->row();
        $field = elements(array('title', 'internaltitle', 'ispublished', 'typeref', 'description', 'attrs'), Request::Post());

        // Create new column in the table
        $this->dbforge->add_column($list->mapped_table, array(
            $field['internaltitle'] => (array) $this->_getFieldDBType($field['typeref'])
        ));

        $field['listid'] = $listId;
        $this->db->insert('fields', $field);
        echo json_encode(array($this->db->affected_rows(), $field));
    }

    function DeleteField($fieldId) {
        try {
            $field = $this->_getField($fieldId);
            $this->db->delete('fields', array('id' => $fieldId));
            $this->dbforge->drop_column($field->list->mapped_table, $field->internaltitle);
            echo json_encode($field);
        } catch (Exception $exc) {
            // echo $exc->getTraceAsString();
            echo json_encode(FALSE);
        }
    }

    function GetField($fieldId) {
        echo json_encode($this->_getField($fieldId));
    }

    function getTables() {
        try {
            $tables = $this->db->list_tables();
            $tables = array_values(array_diff($tables, $this->internalTables));
            return $this->json(TRUE, $tables);
        } catch (Exception $exc) {
            return $this->json(FALSE, $exc, $exc->getTraceAsString());
        }
    }

    function getTableFields($table) {
        try {

            if (!$this->db->table_exists($table)) {
                return $this->json(FALSE, NULL, 'Table not found');
            } else if (in_array($table, $this->internalTables)) {
                return $this->json(FALSE, NULL, 'Table protected!, You cannot select this table');
            }

            $fields = $this->db->field_data($table);
            return $this->json(TRUE, $fields);
        } catch (Exception $exc) {
            return $this->json(FALSE, $exc, $exc->getTraceAsString());
        }
    }

    private function _getField($fieldId) {
        $field = $this->db->get_where('fields', array('id' => $fieldId), 1)->row();
        $field->list = $this->db->get_where($this->table, array('id' => $field->listid), 1)->row();
        return $field;
    }

    private function _getList($listId, $getFields = TRUE, $checkIfTableExists = TRUE) {
        
        $data = $this->db->from($this->table)->where(array('id' => $listId))->get()->row();
        $data->ispublished = !!$data->ispublished;

        if ($getFields) {
            $data->fields = $this->db->where(array('listid' => $listId))->get('fields')->result();

            foreach ($data->fields as &$row) {
                $row->ispublished = !!$row->ispublished;
                $row->attrs = json_decode($row->attrs);
            }
        }

        if ($checkIfTableExists) {
            if (stripos(php_uname('s'), 'win') !== FALSE) {
                // windows
                $data->table_exists = !!$this->db->table_exists(strtolower($data->mapped_table));
            } else {
                $data->table_exists = !!$this->db->table_exists($data->mapped_table);
            }
        }

        return $data;
    }

    private function _getFieldType($reference) {
        return $this->db->get_where('fields_types', array('reference' => $reference), 1)->row();
    }

    private function _getFieldDBType($reference) {
        return json_decode($this->_getFieldType($reference)->db_type);
    }

    private function _getIdentityFieldTitle($fields) {
        foreach ($fields as $field) {
            if ($field->primary_key) {
                return $field->name;
            }
        }
        return 'id';
    }

}
