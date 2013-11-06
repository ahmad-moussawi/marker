<?php

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function Index() {
        if (!Auth::IsAuthenticated()) {
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
}
