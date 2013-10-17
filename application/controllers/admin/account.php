<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (!isset($_SESSION)) {
            session_start();
        }
    }

    private $members_table = 'members';
    private $roles_table = 'roles';
    private $members_roles_table = 'membersinroles';

    function auth() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(FALSE, new Exception('Unauthorized access', '403'));
        }
        $member = $this->db->select('id,login,description')->get_where($this->members_table, array(
                    'login' => Request::Post('login'),
                    'password' => Request::Post('password'),
                        ), 1
                )->row();

        if (!empty($member)) {
            $_SESSION['login'] = $member;
            return $this->json(TRUE, $member);
        } else {
            return $this->json(FALSE);
        }
    }

    function is_authenticated() {
        if (empty($_SESSION['login'])) {
           return $this->json(FALSE);
        } else {
            return $this->json(TRUE, $_SESSION['login']);
        }
    }

    function logout() {
        unset($_SESSION['login']);
        session_destroy();
    }

    function in_role() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(FALSE, new Exception('Unauthorized access', '403'));
        }

        if (empty($_SESSION['login'])) {
            return $this->json(FALSE, new Exception('Unauthorized access', '403'));
        }

        $role = $this->input->post('role');
        $where = array("$this->roles_table.role" => $role, "$this->members_roles_table.memberid" => $_SESSION['login']->id);
        $success = $this->db->join($this->roles_table, "$this->roles_table.id = $this->members_roles_table.roleid")
                        ->where($where)->count_all_results() === 1;
        return $this->json($success);
    }

}
