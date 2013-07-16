<?php

class Members extends CI_Controller {

    public function __construct() {
        parent::__construct();
        Auth::validate_request();
        $this->load->database();
        $this->load->helper('array');
        header('Content-Type:application/json');
    }

    function Get($memberId = FALSE, $roleId = FALSE) {

        $data = $this->db->from('members');

        if ($memberId) {
            $data = $data->where(array('id' => $memberId));

            if ($roleId) {
                $data = $data->where(array('roleid' => $roleId));
            }

            $data = $data->get()->row();
            $roles = $this->db->select('roleid')
                            ->where(array('memberid' => $memberId))
                            ->get('membersinroles')->result();

            $data->roles = array();

            foreach ($roles as $role) {
                $data->roles[] = $role->roleid;
            }
            
        } else {
            $data = $data->get()->result();
        }

        echo json_encode($data);
    }

    function Set($id = FALSE) {

        $response = FALSE;

        $data = elements(array('login', 'description' ,'password'), $this->input->post());


        if (!$id) {
            // create
            $this->db->insert('members', $data);
            $id = $this->db->insert_id();
            $response = $id;
        } else {
            // update
            $this->db->update('members', $data, array('id' => $id));
            $response = $this->db->affected_rows();
        }

        // update roles
        $this->db->delete('membersinroles', array('memberid' => $id));

        foreach ($this->input->post('roles') as $role) {
            $this->db->insert('membersinroles', array('roleid' => $role, 'memberid' => $id));
        }
        
        echo json_encode($response);
    }
    
    function Delete($id){
        try {
            $this->db->delete('membersinroles', array('memberid' => $id));
            $this->db->delete('members', array('id' => $id));
            $response = TRUE;
        } catch (Exception $exc) {
            $response = FALSE;
        }
        echo json_encode($response);
    }

    function getRoles($memberId = FALSE) {
        if ($memberId) {
            $data = $this->db->query('SELECT roles.*, (SELECT roleid > 0 from membersinroles WHERE memberid = 4 and roleid = roles.id ) inrole FROM `roles` 
LEFT JOIN membersinroles ON roles.id = membersinroles.roleid')->result();
            echo json_encode($data);
        } else {
            $data = $this->db->get('roles')->result();
            echo json_encode($data);
        }
    }

}
