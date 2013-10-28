<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {
    public function __construct() {
        parent::__construct();
        Auth::ValidateRequest();
        $this->load->database();
        $this->load->model('queries');
        $this->load->library('xml');
    }

    public function get($id, $rowid = FALSE) {
        $list = $this->queries->getListMetadata($id);
        if (empty($list)) {
            return $this->json(FALSE, NULL, 'List not found');
        }
        
        if ($rowid) {
            $data = $this->db->get_where($list->mapped_table, array('id' => $rowid), 1)->row();
            if (empty($data)) {
                return $this->json(FALSE, NULL, 'Item not found');
            } else {
                return $this->json(TRUE, $data);
            }
        } else {
            $data = $this->db->get_where($list->mapped_table)->result();
            return $this->json(TRUE, $data);
        }
    }
}

