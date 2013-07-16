<?php

class Fields extends CI_Controller {

    private $table = 'fields_types';

    public function __construct() {
        parent::__construct();
        Auth::validate_request();
        $this->load->database();
        $this->load->helper('array');
        $this->load->dbforge();
        header('Content-Type:application/json');
    }

    function Types() {
        echo json_encode($this->db->get($this->table)->result());
    }
}
