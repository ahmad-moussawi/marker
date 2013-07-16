<?php

class Lists extends CI_Controller {

    private $table = 'lists';

    public function __construct() {
        parent::__construct();
        Auth::validate_request();
        $this->load->database();
        $this->load->helper('array');
        $this->load->dbforge();
        header('Content-Type:application/json');
    }

    function Get($id = FALSE) {


        if ($id) {
            $data = $this->_getList($id);
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

        $data = elements(array('title', 'internaltitle', 'mapped_table', 'description', 'ispublished'), $this->input->post());


        if (!$id) {
            // create

            $data['mapped_table'] = 'lists_' . $data['internaltitle'];
            // Create the table
            $this->load->dbforge();
            $this->dbforge->add_field('id');
            $this->dbforge->create_table($data['mapped_table']);

            $data['created'] = date('Y-m-d');
            $this->db->insert($this->table, $data);
            $id = $this->db->insert_id();
            $response = $id;
        } else {
            // update
            $data['modified'] = date('Y-m-d');
            $this->db->update($this->table, $data, array('id' => $id));
            $response = $this->db->affected_rows();
        }

        // Todo updates columns

        echo json_encode($response);
    }

    function Delete($id) {
        try {
            $list = $this->_getList($id, FALSE, FALSE);
            $this->db->delete('fields', array('listid' => $id));
            $this->db->delete($this->table, array('id' => $id));
            $this->dbforge->drop_table($list->mapped_table);
            $response = TRUE;
        } catch (Exception $exc) {
            $response = FALSE;
        }
        echo json_encode($response);
    }

    /**
     * 
     * @param int or string $id the list id or internal name
     */
    function GetFields($id) {
        $data = $this->db->from('fields')->where(array('id' => $id))->result();
        return json_encode($data);
    }

    function GetTypes() {
        echo json_encode($this->db->get('fields_types')->result());
    }

    function AddField($listId) {
        $list = $this->db->where(array('id' => $listId))->limit(1)->get($this->table)->row();
        $field = elements(array('title', 'internaltitle', 'ispublished', 'type', 'description', 'attrs'), $this->input->post());

        // Create new column in the table
        $this->dbforge->add_column($list->mapped_table, array(
            $field['internaltitle'] => (array) $this->_getFieldDBType($field['type'])
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
        }

        if ($checkIfTableExists) {
            $data->table_exists = !!$this->db->table_exists($data->mapped_table);
        }

        return $data;
    }

    private function _getFieldType($reference) {
        return $this->db->get_where('fields_types', array('reference' => $reference), 1)->row();
    }

    private function _getFieldDBType($reference) {
        return json_decode($this->_getFieldType($reference)->db_type);
    }

}
