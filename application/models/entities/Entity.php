<?php

/**
 * Description of List
 *
 * @author ahmad
 */
class Entity {

    public $id;
    public $internaltitle;
    public $mapped_table;
    public $title;
    public $description;
    public $identity;
    public $ispublished;
    public $created;
    public $modified;
    public $createdby;
    public $modifiedby;
    public $protected;
    public $attrs;
    private $_attrs;
    
    // private fields 
    private static $_fields = array();
    private $fields_table;
    private $lists_table;
    private $ci;

    public function __construct($id) {
        $this->ci = & get_instance();
        $this->ci->load->database();
        $this->fields_table = getTableName('fields');
        $this->lists_table = getTableName('lists');

        // load the entity
        if (((int) $id) > 0) {
            $where = array('id' => $id);
        } else {
            $where = array('internaltitle' => $id);
        }

        $metadata = $this->ci->db->from($this->lists_table)
                ->where($where)->limit(1)->get()
                ->row();
        $this->populateEntity($metadata);
    }

    /**
     * 
     * @param String $key
     * @param mixed $default
     * @return mixed
     */
    public function attr($key, $default = NULL) {

        if ($this->_attrs === NULL) {
            $this->_attrs = (array) json_decode($this->attrs);
        }

        if (array_key_exists($key, $this->_attrs)) {
            return $this->_attrs[$key];
        }
        return $default;
    }
    
    public function getIdentity(){
        if(!empty($this->identity)){
            return $this->identity;
        }else{
            return 'id';
        }
    }
    /**
     * get the entity fields
     * 
     * @return EntityField[]
     */
    public function getFields() {

        if (array_key_exists($this->id, self::$_fields)) {
            return self::$_fields[$this->id];
        } else {
            self::$_fields[$this->id] = $this->ci->db
                    ->get_where($this->fields_table, array('listid' => $this->id))
                    ->custom_result_object('EntityField');

            foreach (self::$_fields[$this->id] as $field) {
                /* @var $field EntityField */
                $field->setList($this);
            }

            return self::$_fields[$this->id];
        }
    }

    /**
     * get the published fields, optionaly filter by a view type
     * 
     * @param String $viewType
     * @return EntityField[]
     */
    public function getPublishedFields($viewType = FALSE) {
        if (!array_key_exists($this->id, self::$_fields)) {
            $this->getFields();
        }

        $fields = array();
        foreach (self::$_fields[$this->id] as $field) {
            /* @var $field EntityField */

            $condition = $field->ispublished;
            if ($viewType) {
                $condition &=!$field->attr('hide_' . $viewType);
            }

            if ($condition) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    private function populateEntity($metadata) {
        foreach ($metadata as $field => $value) {
            if (property_exists('Entity', $field)) {
                $this->{$field} = $value;
            }
        }
    }

}
