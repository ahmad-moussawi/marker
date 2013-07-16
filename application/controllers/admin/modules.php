<?php

class Modules extends CI_Controller {

    private $table = 'lists';

    public function __construct() {
        parent::__construct();
        Auth::validate_request();
        $this->load->database();
        $this->load->helper('array');
    }

    function GetModules($id = FALSE) {
        header('Content-Type:application/json');
        $data = $this->db->get_where($this->table, array('ispublished' => 1))->result();
        echo json_encode($data);
    }

    function GetItem($moduleId, $id = FALSE) {
        header('Content-Type:application/json');

        $module = $this->_getModuleMetadata($moduleId);

        $data = $this->db->from($module->mapped_table);

        if ($id) {
            $data = $data->where(array('id' => $id))->get()->row();
        } else {
            $data = $data->get()->result();
        }
        echo json_encode($data);
    }

    function SetItem($moduleId, $id = FALSE) {

        $response = FALSE;

        $module = $this->_getModuleMetadata($moduleId);

        $data = elements($module->fields_array, $this->input->post());


        if (!$id) {
            // create

            $this->db->insert($module->mapped_table, $data);
            $id = $this->db->insert_id();
            $response = $id;
        } else {
            // update
            $this->db->update($module->mapped_table, $data, array('id' => $id));
            $response = $this->db->affected_rows();
        }

        // Todo updates columns
        echo json_encode(array($response,$data, $module));
    }

    function DeleteItem($moduleId, $id) {
        try {
            $module = $this->_getModuleMetadata($moduleId);
            $this->db->delete($module->mapped_table, array('id' => $id));
            $response = TRUE;
        } catch (Exception $exc) {
            $response = FALSE;
        }
        echo json_encode($response);
    }

    function renderView($viewName = FALSE, $moduleId = FALSE) {
        if (!$viewName) {
            echo '';
            return;
        }

        $this->load->helper('inflector');
        $data['module'] = $this->db->get_where('lists', array('id' => $moduleId), 1)->row();
        $data['fields'] = $this->db->get_where('fields', array('listid' => $moduleId))->result();
        $data['term'] = singular($data['module']->title);
        $this->load->view('admin/modules/' . $viewName, $data);
    }

    private function _getModuleMetadata($moduleId) {
        $data = $this->db->from($this->table)->where(array('id' => $moduleId))->get()->row();
        $data->ispublished = !!$data->ispublished;
        $data->fields = $this->db->where(array('listid' => $moduleId))->get('fields')->result();
        $data->table_exists = !!$this->db->table_exists($data->mapped_table);

        $data->fields_array = array();
        foreach ($data->fields as $field) {
            $data->fields_array[] = $field->internaltitle;
        }

        return $data;
    }

}
