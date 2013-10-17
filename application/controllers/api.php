<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        Auth::validate_request();   
        $this->load->database();
        $this->load->library('xml');
    }

    public function get($id, $rowid = FALSE) {
        $list = $this->_getList($id);
        if (empty($list)) {
            return $this->json(FALSE, NULL, 'List not found');
        }

        if ($rowid) {
            $data = $this->db->get_where($list->mapped_table, array('id' => $rowid), 1)->row();
            if (empty($data)) {
                return $this->json(FALSE, NULL, 'Not found');
            } else {
                return $this->json(TRUE, $data);
            }
        } else {
            $data = $this->db->get_where($list->mapped_table)->result();
            return $this->json(TRUE, $data);
        }
    }

    public function getXML($id, $rowid = FALSE) {
        header('Content-Type:text/xml');
        $list = $this->_getList($id);
        if (empty($list)) {
            return $this->json(FALSE, NULL, 'List not found');
        }
        $data = $this->db->get_where($list->mapped_table)->result();
        echo $this->xml->xml_encode($data);
    }

    private function _getList($id) {
        if (((int) $id) > 0) {
            $where = array('id' => $id);
        } else {
            $where = array('internaltitle' => $id);
        }
        return $this->db->get_where('lists', $where, 1)->row();
    }

}

