<?php

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //TODO >> Check for logged users
    }

    function Index() {
        if (!Auth::IsAuthenticated()) {
//           redirect('admin/index/auth');
            $data = array();
            $this->load->view('admin/account/header', $data);
            $this->load->view('admin/account/login', $data);
            $this->load->view('admin/account/footer', $data);
        } else {
            $this->loadView('index/index', array(), 'admin');
        }
    }

    function Auth() {
        $data = array();
        $this->load->view('admin/account/header', $data);
        $this->load->view('admin/account/login', $data);
        $this->load->view('admin/account/footer', $data);
    }

    function JSON() {
        $types =
                array(
                    array('type' => 'VARCHAR', 'constraint' => '255'),
                    array('type' => 'TEXT'),
                    array('type' => 'TEXT'),
                    array('type' => 'TEXT'),
                    array('type' => 'TEXT'),
                    array('type' => 'INT'),
                    array('type' => 'FLOAT'),
                    array('type' => 'FLOAT'),
        );

        echo json_encode($types);
    }

}
