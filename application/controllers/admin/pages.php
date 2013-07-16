<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        Auth::validate_request();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->helper('array');
    }

    function get($id = NULL) {
        if ($id !== NULL) {
            $data = $this->db->get_where('pages', array('id' => $id), 1)->row();
            $data->ispublished = !!$data->ispublished;
            $data->isdraft = !!$data->isdraft;
            $this->json(array('page' => $data));
        } else {
            $data = $this->db->get('pages')->result();
            foreach ($data as $k => $row) {
                $data[$k]->ispublished = !!$row->ispublished;
                $data[$k]->isdraft = !!$row->isdraft;
            }
            $this->json(array('pages' => $data));
        }
    }

    function delete() {
        header('Content-Type:application/json');

        $this->db->delete('pages', array('id' => $this->input->post('id')));

        echo json_encode($this->db->affected_rows());
    }

    function set($id = NULL) {

        // Set the validation
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->json(NULL, validation_errors());
        }

        $form = elements(array('title', 'body', 'meta', 'isdraft', 'ispublished', 'urlpath', 'images'), $this->input->post());
        
        if ($id) {
            unset($form['created']);
            unset($form['urlpath']);
            $this->db->update('pages', $form, array('id' => $id));
            return $this->json(array('page' => $form));
        } else {
            
            $form['urlpath'] = empty($form['urlpath'])?$form['title']:$form['urlpath'];
            $form['urlpath'] = $this->_getValidUrlPath( url_title($form['urlpath']) );
            
            $form['created'] = date('Y-m-d H:i:s');
            $form['createdby'] = Auth::is_authenticated()->login;
            $this->db->insert('pages', $form);
            $form['id'] = $this->db->insert_id();

            return $this->json(array('page' => $form));
        }
    }
    
    private function _getValidUrlPath($urlpath){
        $this->load->helper('string');
        while($this->db->from('pages')->where(array('urlpath' => $urlpath))->count_all_results() > 0){
            $urlpath = increment_string($urlpath ,'-');
        }
        
        return $urlpath;
    }

}