<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        header('Content-Type:application/json');

        if (!isset($_SESSION)) {
            session_start();
        }
    }

    private $members_table = 'members';
    private $roles_table = 'roles';
    private $members_roles_table = 'membersinroles';

    function auth() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_decode(new Exception('Unauthorized access', '403'));
            die;
        }

        $member = $this->db->select('id,login,description')->get_where($this->members_table, array(
                    'login' => $this->input->post('login'),
                    'password' => $this->input->post('password'),
                        ), 1
                )->row();

        if (!empty($member)) {
            $_SESSION['login'] = $member;
            echo json_encode($member);
        } else {
            echo json_encode(FALSE);
        }
    }

    function is_authenticated() {
        if (empty($_SESSION['login'])) {
            echo json_encode(FALSE);
        } else {
            echo json_encode($_SESSION['login']);
        }
    }

    function logout() {
        
        sleep(1);
        unset($_SESSION['login']);
        session_destroy();
    }

    function in_role() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_decode(new Exception('Unauthorized access', '403'));
            die;
        }

        if (empty($_SESSION['login'])) {
            echo json_decode(new Exception('Unauthorized access', '403'));
            die;
        }

        $role = $this->input->post('role');
        $where = array("$this->roles_table.role" => $role, "$this->members_roles_table.memberid" => $_SESSION['login']->id);
        $success = $this->db->join($this->roles_table, "$this->roles_table.id = $this->members_roles_table.roleid")
                        ->where($where)->count_all_results() === 1;

        echo json_encode($success);
    }

}
