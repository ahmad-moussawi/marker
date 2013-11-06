<?php

/**
 * @author Ahmad Moussawi <aymoussawi@gmail.com>
 */
class Field {

    static function RenderIndex($def) {
        $ci = & get_instance();

        $def->attrs = self::extendAttrs($def->typeref, $def->attrs->values());

        $data = array(
            'def' => $def
        );

        $path = "admin/controls/$def->typeref/index";

        if (file_exists(APPPATH . "/views/$path.php")) {
            $html = $ci->load->view($path, $data, TRUE);
        } else {
            $html = $ci->load->view('admin/controls/default/index', $data, TRUE);
        }

        return $html;
    }

    static function RenderView($def) {
        $ci = & get_instance();

        $def->attrs = self::extendAttrs($def->typeref, $def->attrs->values());

        $data = array(
            'def' => $def
        );

        $path = "admin/controls/$def->typeref/view";

        if (file_exists(APPPATH . "/views/$path.php")) {
            $html = $ci->load->view($path, $data, TRUE);
        } else {
            $html = $ci->load->view('admin/controls/default/view', $data, TRUE);
        }


        return $html;
    }

    static function RenderEdit($def, $new = FALSE) {
        $ci = & get_instance();

        $def->attrs = self::extendAttrs($def->typeref, $def->attrs->values());

        $data = array(
            'def' => $def,
            'new' => $new,
            'attrs' => self::parseAttrs($def, $new)
        );

        $header = "admin/controls/default/tmpl/edit/header";
        $footer = "admin/controls/default/tmpl/edit/footer";

        if (file_exists(APPPATH . "/views/admin/controls/{$def->typeref}/tmpl/edit/header.php")) {
            $header = "admin/controls/{$def->typeref}/tmpl/edit/header";
        }

        if (file_exists(APPPATH . "/views/admin/controls/{$def->typeref}/tmpl/edit/footer.php")) {
            $footer = "admin/controls/{$def->typeref}/tmpl/edit/footer";
        }



        $path = "admin/controls/$def->typeref/edit";

        $html = $ci->load->view($header, $data, TRUE);

        if (file_exists(APPPATH . "/views/$path.php")) {
            $html .= $ci->load->view($path, $data, TRUE);
        } else {
            $html .= $ci->load->view('admin/controls/default/edit', $data, TRUE);
        }
        $html .= $ci->load->view($footer, $data, TRUE);

        return $html;
    }

    private static function parseAttrs($def, $new) {
        $arr = array();
        $str = array();

        // transform the attributes
        foreach ((array) $def->attrs->values() as $key => $value) {


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

    private static function extendAttrs($typeref, $attrs) {

        if (!$attrs) {
            $attrs = array();
        } else {
            $attrs = (array) $attrs;
        }

        $default = (array) self::defaultAttrs($typeref);

        foreach ($default as $key => $value) {
            if (!array_key_exists($key, $attrs)) {
                $attrs[$key] = $value;
            }
        }

        return new Attributes($attrs);
    }

    private static function defaultAttrs($typeref) {

        $default = array(
            'required' => FALSE,
            'default' => ''
        );

        switch ($typeref) {

            case 44:
                $default['default'] = FALSE;
                break;

            case 16:
                $default['type'] = 'ean13';
                break;

            case 51:
                $default['max'] = 5;
                break;
        }

        return (object) $default;
    }

}

class Attributes {

    private $attrs = array();

    public function __construct($attrs) {
        $this->attrs = (array) $attrs;
    }

    function __get($name) {
        if (array_key_exists($name, $this->attrs)) {
            return $this->attrs[$name];
        }

        return NULL;
    }

    function values() {
        return $this->attrs;
    }

}

class Validation {

    static function unique_group($def, $otherFields, $skip) {
        
        $titles = array();
        $fields = array();
        $values = array();
        $return = array();

        foreach ($otherFields as $otherfield) {
            
            if (
                    isset($otherfield->attrs) 
                    //&& isset($otherfield->attrs->unique_group) 
                    && $otherfield->attrs->unique_group == $def->attrs->unique_group
            ) {
                
//                var_dump($otherfield->title);
                
                $titles[] = $otherfield->title;
                $fields[] = $def->listid . '.' . $otherfield->internaltitle;
                $values[] = '{{item.' . $otherfield->internaltitle . '}}';
            }
        }

        $return['marker-unique-group'] = $def->attrs->unique_group;
        $return['fields'] = implode(',', $fields);
        $return['values'] = implode('__markersep__', $values);
        $return['titles'] = implode(',', $titles);

        if (!$skip) {
            $return['skip'] = "{{item.{$def->list->identity}}}";
        }

        return $return;
    }

}
