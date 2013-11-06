<?php

class Modules extends CI_Controller {

    private $table;
    private $errors = array();
    private static $complexSeperator = '::';
    private static $complexPrefix = '__';

    public function __construct() {
        parent::__construct();
        Auth::ValidateRequest();
        $this->table = getTableName('lists');
        $this->load->database();
        $this->load->helper('array');
        $this->load->model('queries');
    }

    function GetModules($id = FALSE) {
        $data = $this->db->get_where($this->table, array('ispublished' => 1))->result();
        return $this->json($data);
    }

    function get($entityId, $id = FALSE) {

        $module = new Entity($entityId);
        if (!$module->id) {
            if ($exc->getCode() === 404) {
                return $this->json(FALSE, new Exception('NotFoundException'));
            }
        }
        
        //$module->getPublishedFields();

        //$this->db->get();

        //$this->db->from($module->mapped_table);

        if ($this->input->get('select')) {
            $select = explode(',', $this->input->get('select'));
            $this->db->select($select);
        }


        if ($id) {
            $this->db->where(array("$module->mapped_table.$module->identity" => $id))->limit(1);
        }


        foreach ($module->getPublishedFields() as $field) {
            if ($field->typeref == 41 && $field->attr('type') === 'internal') {

                // get the list internal title to make a join
                $parent = new Entity($field->attr('type_internal'));

                if (!empty($parent)) {
                    // append the field id to the alias in case more than 
                    // one field lookup to the same list
                    $alias = $parent->mapped_table . '_' . $field->id;

                    $displayFieldId = explode(',', $field->attr('type_internal_display'));
                    foreach ($displayFieldId as $fieldid) {
                        $fieldTitle = $this->queries->getFieldInternalTitleById($fieldid);
                        $data->select("$alias.$fieldTitle `" . $field->internaltitle . self::$complexSeperator . $fieldTitle . '`');
                        $data->select("$alias.$fieldTitle `" . $field->internaltitle . self::$complexSeperator . $fieldid . '`');
                    }

                    $data->join(
                            "{$parent->mapped_table} `$alias`", "$alias.id = $module->mapped_table.$field->internaltitle", 'left'
                    );
                }
            }
        }
        
        
        $this->db->select("$module->mapped_table.*");
        $data = $this->db->get($module->mapped_table)->result_array();
        var_dump($this->db->last_query());

        var_dump($data);die;
        $data = $this->_convertData($data);

        if ($id) {
            return $this->json(TRUE, array('row' => $data[0], 'errors' => $this->errors));
        } else {
            return $this->json(TRUE, array('rows' => $data, 'errors' => $this->errors));
        }
    }

    function set($listId, $id = FALSE) {
        $list = $this->queries->getListMetadata($listId);

        $data = elements($list->published_fields_array, Request::Post());

        // transform Array to JSON
        foreach ($data as &$row) {
            if (is_array($row)) {
                $row = json_encode($row);
            }
        }

        if (!$id) {
// create
            if (!$list->attrs->view_create) {
                return $this->json(FALSE, NULL, 'Operation failed, Create permission is disabled for this list');
            }

            $this->db->insert($list->mapped_table, $data);
            return $this->json(TRUE, array($this->db->insert_id(), $data));
        } else {
// update
            if (!$list->attrs->view_edit) {
                return $this->json(FALSE, NULL, 'Operation failed, Edit permission is disabled for this list');
            }

            $this->db->update($list->mapped_table, $data, array($list->identity => $id));
            return $this->json($this->db->affected_rows() > 0);
        }
    }

    function delete($entityId, $id) {
        try {
            $module = $this->queries->getListMetadata($entityId);
            if (!$module->attrs->view_delete) {
                return $this->json(FALSE, NULL, 'Operation failed, Create permission is disabled for this list');
            }
            $this->db->delete($module->mapped_table, array($module->identity => $id));
            $response = TRUE;
        } catch (Exception $exc) {
            $response = FALSE;
        }
        return $this->json($response);
    }

    function fieldInternalDataLookup($entityId) {
        $module = $this->queries->getListMetadata($entityId);
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

        return $this->json(TRUE, array('rows' => $data2, 'map' => $map));
    }

    function validateCount($listId, $fieldName, $val, $skipRowId = FALSE) {
        $list = $this->queries->getListMetadata($listId);
        if (empty($list)) {
            return $this->json(FALSE, array('Exception' => 'ListNotFound'), 'List not found');
        } else {
            $fieldFound = FALSE;
            foreach ($list->fields as $field) {
                if ($field->internaltitle === $fieldName) {
                    $fieldFound = TRUE;
                    break;
                }
            }

            if (!$fieldFound) {
                return $this->json(FALSE, array('Exception' => 'FieldNotFound'), 'Field not found');
            }
        }

        if ($skipRowId) {
            $this->db->where(array($list->identity . ' !=' => $skipRowId));
        }

        $count = $this->db->where(array($fieldName => $val))->count_all_results($list->mapped_table);
        return $this->json(TRUE, $count);
    }

    function validateGroup() {
        $params = Request::post();


        if (empty($params['fields']) || empty($params['fields'][0])) {
            return $this->json(FALSE, array('Exception' => 'FieldsNotProvided'), 'Fields not provided');
        }

        if (count($params['fields']) !== count($params['values'])) {
            return $this->json(FALSE, array('Exception' => 'FieldsAndValuesCount'), 'The fields count must match the values fields');
        }

        $listId = explode(',', $params['fields'][0]);
        $listId = $listId[0];

        $list = $this->queries->getListMetadata($listId);
        if (empty($list)) {
            return $this->json(FALSE, array('Exception' => 'ListNotFound'), 'List not found');
        }

        for ($i = 0; $i < count($params['fields']); $i++) {
            $fieldName = explode('.', $params['fields'][$i]);
            $fieldName = $fieldName[1];
            $this->db->where($fieldName, $params['values'][$i]);
        }

        if (!empty($params['skip'])) {
            $this->db->where(array($list->identity . ' !=' => $params['skip']));
        }

        $count = $this->db->count_all_results($list->mapped_table);
        return $this->json(TRUE, $count);
    }

    function renderView($viewType, $listId) {


        //$data['list'] = $this->queries->getListMetadata($listId);

        $data['list'] = new Entity($listId);
        $data['fields'] = $data['list']->getPublishedFields($viewType);

        if ($viewType == 'create' && !$data['list']->attr('view_create')) {
            echo '<div class="alert alert-danger">You cannot create a new item on this list</div>';
            return;
        }

        if ($viewType == 'edit' && !$data['list']->attr('view_edit')) {
            echo '<div class="alert alert-danger">You cannot edit items on this list</div>';
            return;
        }

        if ($viewType == 'delete' && !$data['list']->attr('view_delete')) {
            echo '<div class="alert alert-danger">You cannot delete items on this list</div>';
            return;
        }

        if (empty($data['list'])) {
            echo '<div class="alert alert-danger">Module not found</div>';
            return;
        }
        $this->load->view('admin/modules/' . $viewType, $data);
    }

    function getView($viewType) {
        $this->load->view('admin/modules/tmpl/' . $viewType);
    }

    private function _convertData($data) {
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
