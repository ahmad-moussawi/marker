<?php

class Users extends CI_Controller {

    private $members_table;
    private $roles_table;
    private $members_roles_table;

    public function __construct() {
        parent::__construct();
        Auth::ValidateRequest();

        $this->members_roles_table = getTableName('membersinroles');
        $this->members_table = getTableName('members');
        $this->roles_table = getTableName('roles');

        $this->load->database();
        $this->load->helper('array');
        header('Content-Type:application/json');
    }

    function Get($memberId = FALSE, $roleId = FALSE) {
        $data = $this->db->from($this->members_table);
        if ($memberId) {
            $data = $data->where(array('id' => $memberId));
            if ($roleId) {
                $data = $data->where(array('roleid' => $roleId));
            }
            $data = $data->get()->row();
            $roles = $this->db->select('roleid')
                            ->where(array('memberid' => $memberId))
                            ->get($this->members_roles_table)->result();

            $data->roles = array();
            foreach ($roles as $role) {
                $data->roles[] = $role->roleid;
            }
        } else {
            $data = $data->get()->result();
        }
        return $this->json(TRUE, $data);
    }

    function Set($id = FALSE) {

        $response = FALSE;

        $data = elements(array('login', 'description', 'password'), Request::Post());


        if (!$id) {
            // create
            $this->db->insert($this->members_table, $data);
            $id = $this->db->insert_id();
            $response = $id;
        } else {
            // update
            $this->db->update($this->members_table, $data, array('id' => $id));
            $response = $this->db->affected_rows();
        }

        // update roles
        $this->db->delete($this->members_roles_table, array('memberid' => $id));

        foreach (Request::post('roles') as $role) {
            $this->db->insert($this->members_roles_table, array('roleid' => $role, 'memberid' => $id));
        }

        return $this->json($response);
    }

    function Delete($id) {
        try {
            $this->db->delete($this->members_roles_table, array('memberid' => $id));
            $this->db->delete($this->members_table, array('id' => $id));
            $response = TRUE;
        } catch (Exception $exc) {
            $response = FALSE;
        }
        return $this->json($response);
    }

    function getRoles($memberId = FALSE) {
        if ($memberId) {
            $data = $this->db->query("SELECT {$this->roles_table}.*, (SELECT roleid > 0 from {$this->members_roles_table} WHERE memberid = $memberId and roleid = roles.id ) inrole FROM `{$this->roles_table}` 
LEFT JOIN {$this->members_roles_table} ON roles.id = {$this->members_roles_table}.roleid")->result();
            return $this->json(TRUE, $data);
        } else {
            $data = $this->db->get($this->roles_table)->result();
            return $this->json(TRUE, $data);
        }
    }

}
