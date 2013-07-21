<?php

class Modules extends CI_Controller {

    private $table = 'lists';
    private $errors = array();
    private static $complexSeperator = '::';
    private static $complexPrefix = '__';

    public function __construct() {
        parent::__construct();
        Auth::validate_request();
        $this->load->database();
        $this->load->helper('array');
        $this->load->model('queries');
    }

    function GetModules($id = FALSE) {
        $data = $this->db->get_where($this->table, array('ispublished' => 1))->result();
        return $this->json($data);
    }

    function get($moduleId, $id = FALSE) {
        $module = $this->queries->getModuleMetadata($moduleId);
        $data = $this->db->from($module->mapped_table);

        if ($this->input->get('select')) {
            $select = explode(',', $this->input->get('select'));
            $data = $data->select($select);
        }


        if ($id) {
            $data = $data->where(array("$module->mapped_table.id" => $id))->limit(1);
        }

        foreach ($module->fields as $field) {
            if ($field->type == '4.1') {
                $attrs = json_decode($field->attrs);
                if ($attrs->type == 'internal') {

                    // get the list internal title to make a join
                    $list = $this->queries->getListTableById($attrs->type_internal);

                    if (!empty($list)) {
                        // append the field id to the alias in case more than 
                        // on field lookup to the same list
                        $alias = $list . '_' . $field->id;

                        $displayFieldId = explode(',', $attrs->type_internal_display);
                        foreach ($displayFieldId as $fieldid) {
                            $fieldTitle = $this->queries->getFieldInternalTitleById($fieldid);
                            $data->select("$alias.$fieldTitle `" . $field->internaltitle . self::$complexSeperator . $fieldTitle . '`');
                            $data->select("$alias.$fieldTitle `" . $field->internaltitle . self::$complexSeperator . $fieldid . '`');
                        }

                        $data = $data->join(
                                "$list `$alias`", 
                                "$alias.id = $module->mapped_table.$field->internaltitle",
                                'left'
                        );
                    }
                }
            }
        }
        $this->db->select("$module->mapped_table.*");
        $data = $data->get()->result_array();

        $data = $this->convertData($data);
        
        if ($id) {
            $data = $data[0];
        }

        return $this->json($data, $this->errors);
    }

    function set($moduleId, $id = FALSE) {

        $response = FALSE;

        $module = $this->queries->getModuleMetadata($moduleId);

        $data = elements($module->fields_array, $this->input->post());
        //return $this->json($data);
        
        if (!$id) {
// create

            $this->db->insert($module->mapped_table, $data);
            $id = $this->db->insert_id();
            $response = $id;
        } else {
// update
            $this->db->update($module->mapped_table, $data, array('id' => $id));
            $response = $this->db->affected_rows();
        }

// Todo updates columns
        return $this->json(array($response, $data));
    }

    function delete($moduleId, $id) {
        try {
            $module = $this->queries->getModuleMetadata($moduleId);
            $this->db->delete($module->mapped_table, array('id' => $id));
            $response = TRUE;
        } catch (Exception $exc) {
            $response = FALSE;
        }
        echo json_encode($response);
    }

    function fieldInternalDataLookup($moduleId) {
        $module = $this->queries->getModuleMetadata($moduleId);
        $data = $this->db->from($module->mapped_table);
        $map = $inverse = array();

        if ($this->input->get('select')) {
            $select = explode(',', $this->input->get('select'));
            $select[] = -1; // add the id field
            $map = array();
            foreach ($select as $value) {
                $map[$value] = $this->queries->getFieldTitle($value, $module->fields);
            }

            $data = $data->select($map);
            $inverse = array_flip($map);
        }

        $data = $data->get()->result_array();

//return $this->json(array($data,$map,$inverse));
        $data2 = array();
        foreach ($data as $row) {
            $newrow = array();
            foreach ($row as $field => $value) {
                $newrow[$inverse[$field]] = $value;
            }
            $data2[] = $newrow;
        }

        return $this->json(array('rows' => $data2, 'map' => $map), $this->errors);
    }

    function renderView($viewName = FALSE, $moduleId = FALSE) {
        if (!$viewName) {
            echo '';
            return;
        }

        $this->load->helper('inflector');
        $data['module'] = $this->db->get_where('lists', array('id' => $moduleId), 1)->row();
        $data['fields'] = $this->db->get_where('fields', array('listid' => $moduleId))->result();
        $data['term'] = singular($data['module']->title);
        $this->load->view('admin/modules/' . $viewName, $data);
    }

    private function convertData($data) {
        foreach ($data as &$row) {
            foreach ($row as $key => $field) {
                if (strpos($key, self::$complexSeperator)) {
                    $split = explode(self::$complexSeperator, $key);
                    $newkey = self::$complexPrefix . $split[0];
                    if (!array_key_exists($newkey, $row) || !is_array($row[$newkey])) {
                        $row[$newkey] = array();
                    }
                    $row[$newkey][$split[1]] = $field;
                }
            }
        }
        return $data;
    }

}
