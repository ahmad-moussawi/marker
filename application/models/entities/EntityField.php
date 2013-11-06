<?php

/**
 * Description of Field
 *
 * @author ahmad
 */
class EntityField {

    public $id;
    public $listid;
    public $internaltitle;
    public $title;
    public $typeref;

    /**
     * Json representation
     * @var String 
     */
    public $attrs;
    public $description;
    public $roworder;
    public $ispublished;
    private $list;
    private $_attrs;
    private $ci;

    public function __construct() {
        $this->ci = & get_instance();
    }

    public function getList() {
        return $this->list;
    }

    public function setList($list) {
        $this->list = $list;
        return $this;
    }

    public function attr($key, $default = NULL) {

        if ($this->_attrs === NULL) {
            $this->_attrs = (array) json_decode($this->attrs);
        }

        if (array_key_exists($key, $this->_attrs)) {
            return $this->_attrs[$key];
        }
        return $default;
    }

    function RenderIndex() {

        $path = "admin/controls/$this->typeref/index";
        $data = array('field' => $this);

        if (file_exists(APPPATH . "/views/$path.php")) {
            $html = $this->ci->load->view($path, $data, TRUE);
        } else {
            $html = $this->ci->load->view('admin/controls/default/index', $data, TRUE);
        }

        return $html;
    }

    function RenderView() {


        $data = array('field' => $this);

        $path = "admin/controls/$this->typeref/view";

        if (file_exists(APPPATH . "/views/$path.php")) {
            $html = $this->ci->load->view($path, $data, TRUE);
        } else {
            $html = $this->ci->load->view('admin/controls/default/view', $data, TRUE);
        }


        return $html;
    }

    function RenderEdit($new = FALSE) {

        $data = array(
            'field' => $this,
            'new' => $new,
            'attrs' => $this->parseHtmlAttrs($new)
        );

        $header = "admin/controls/default/tmpl/edit/header";
        $footer = "admin/controls/default/tmpl/edit/footer";

        if (file_exists(APPPATH . "/views/admin/controls/{$this->typeref}/tmpl/edit/header.php")) {
            $header = "admin/controls/{$this->typeref}/tmpl/edit/header";
        }

        if (file_exists(APPPATH . "/views/admin/controls/{$this->typeref}/tmpl/edit/footer.php")) {
            $footer = "admin/controls/{$this->typeref}/tmpl/edit/footer";
        }

        $path = "admin/controls/$this->typeref/edit";

        $html = $this->ci->load->view($header, $data, TRUE);

        if (file_exists(APPPATH . "/views/$path.php")) {
            $html .= $this->ci->load->view($path, $data, TRUE);
        } else {
            $html .= $this->ci->load->view('admin/controls/default/edit', $data, TRUE);
        }
        $html .= $this->ci->load->view($footer, $data, TRUE);

        return $html;
    }

    private function parseHtmlAttrs($new) {
        $arr = array();
        $str = array();

        // transform the attributes
        foreach ((array) $this->_attrs as $key => $value) {


            // add the ng- prefix for angular attributes
            if (in_array($key, array('required', 'minlengh', 'maxlength', 'pattern', 'trim'))) {
                $arr['ng-' . $key] = $value;
            }

            // html & html5 attributes
            if (in_array($key, array('min', 'max'))) {
                $arr[$key] = $value;
            }

//            // unique_group validation
//            if ($key === 'unique_group') {
//                $arr = array_merge($arr, Validation::unique_group($def, $def->list->published_fields, $new));
//            }
        }

        foreach ($arr as $key => $value) {
            $str[] = "$key = \"$value\"";
        }

        return implode(' ', $str);
    }
}
