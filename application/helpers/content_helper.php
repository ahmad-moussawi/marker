<?php

/**
 * Content Helper Class
 */
class Content {

    public static function link($href, $base = 'assets/') {
        return '<link href="' . site_url($base . $href) . '" type="text/css" rel="stylesheet" />';
    }

    public static function script($src, $base = 'assets/') {
        return '<script src="' . site_url($base . $src) . '" type="text/javascript"></script>';
    }

    public static function renderEditField($field, $createMode = false) {
        $html = '';
        $str = '';

        if (!empty($field->attrs)) {
            $attrs = $field->attrs;
        } else {
            $attrs = new stdClass;
        }

        switch ($field->typeref) {
            case '1.1':
                if (isset($attrs)) {
                    $str = '';
                    if (isset($attrs->required) && $attrs->required) {
                        $str = ' required="required"';
                    }

                    if (isset($attrs->validation)) {
                        $str .= " type=\"$attrs->validation\"";
                    } else {
                        $str .= ' type="text"';
                    }

                    if (isset($attrs->max_len) && $attrs->max_len > 0) {
                        $str .= ' maxlength="' . $attrs->max_len . '"';
                    }

                    if (isset($attrs->min_len) && $attrs->min_len > 0) {
                        $str .= ' minlength="' . $attrs->min_len . '"';
                    }

                    if (isset($attrs->unique) && $attrs->unique) {
                        $attrs->unique = $attrs->unique === TRUE ? 1 : $attrs->unique;
                        $str .= " marker-unique=\"$field->listid.$field->internaltitle\" max-count=\"$attrs->unique\"";
                        if (!$createMode) {
                            $str .=" skip=\"{{item.{$field->list->identity}}}\"";
                        }
                    }

                    if (isset($attrs->unique_group)) {

                        $fields = array();
                        $values = array();
                        $titles = array();
                        foreach ($field->list->fields as $otherfield) {
                            if (isset($otherfield->attrs) && isset($otherfield->attrs->unique_group) && $otherfield->attrs->unique_group == $attrs->unique_group
                            ) {
                                $titles[] = $otherfield->title;
                                $fields[] = $field->listid . '.' . $otherfield->internaltitle;
                                $values[] = '{{item.' . $otherfield->internaltitle . '}}';
                            }
                        }

                        $str .= " marker-unique-group=\"$attrs->unique_group\"";
                        $str .= 'fields="' . implode(',', $fields) . '"';
                        $str .= 'values="' . implode('__markersep__', $values) . '"';
                        if (!$createMode) {
                            $str .=" skip=\"{{item.{$field->list->identity}}}\"";
                        }
                    }

                    if ($createMode && isset($attrs->default) && $attrs->default) {
                        $str .= " ng-init=\"item.$field->internaltitle = '$attrs->default'\"";
                    }
                }

                $html .="<input class=\"form-control\" $str name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                if (isset($attrs->unique)) {
                    $html .='<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.unique">Value already exists</span>' .
                            '<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.validatingunique">Checking the new value ...</span>';
                }
                if (isset($attrs->unique_group)) {
                    $html .='<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.uniquegroup">The combination ' . implode(', ', $titles) . ' already exists</span>' .
                            '<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.validatinguniquegroup">Checking the new values ...</span>';
                }
                break;
            case '1.2':
                if (isset($attrs)) {
                    $str = '';
                    if (isset($attrs->required) && $attrs->required) {
                        $str = ' required="required"';
                    }

                    if (isset($attrs->validation)) {
                        $str .= " type=\"$attrs->validation\"";
                    } else {
                        $str .= ' type="text"';
                    }

                    if (isset($attrs->max_len) && $attrs->max_len > 0) {
                        $str .= ' maxlength="' . $attrs->max_len . '"';
                    }

                    if (isset($attrs->min_len) && $attrs->min_len > 0) {
                        $str .= ' minlength="' . $attrs->min_len . '"';
                    }

                    if ($createMode) {
                        if (!isset($attrs->default) || !$attrs->default) {
                            $attrs->default = '';
                        }
                        $html .= "<span ng-init=\"item.$field->internaltitle='$attrs->default'\"></span>";
                    }
                }

                $html .="<textarea class=\"form-control\" $str name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" ></textarea>";
                break;
            case '1.3':
                if (isset($attrs)) {
                    $str = '';
                    if (isset($attrs->required) && $attrs->required) {
                        $str = ' ng-required="true"';
                    }

                    if (isset($attrs->theme) && $attrs->theme > 0) {
                        $str .= ' theme="' . $attrs->theme . '"';
                    }

                    if ($createMode) {
                        if (!isset($attrs->default) || !$attrs->default) {
                            $attrs->default = '';
                        }
                        $html .= "<span ng-init=\"item.$field->internaltitle='$attrs->default'\"></span>";
                    }
                }

                $html .="<textarea class=\"form-control\" ck-editor $str name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" ></textarea>";
                break;
            case '1.4':
                if (isset($attrs)) {
                    $str = '';
                    if (isset($attrs->required) && $attrs->required) {
                        $str = ' required="required"';
                    }

                    if (isset($attrs->theme) && $attrs->theme > 0) {
                        $str .= ' theme="' . $attrs->theme . '"';
                    }

                    if ($createMode) {
                        if (!isset($attrs->default) || !$attrs->default) {
                            $attrs->default = '/* Write your code here */';
                        }
                        $html .= "<span ng-init=\"item.$field->internaltitle='$attrs->default'\"></span>";
                    }
                }
                $html .="<div $str class=\"editor\" data-ace=\"\" ng-model=\"item.$field->internaltitle\"></div>";
                break;
            case '1.5':
                if (isset($attrs)) {
                    $str = '';
                    if (isset($attrs->required) && $attrs->required) {
                        $str = ' required="required"';
                    }

                    if (isset($attrs->mode)) {
                        $str .= "mode=\"{$attrs->mode}\"";
                    } else {
                        $str .= "mode=\"hex\"";
                    }
                    if ($createMode) {
                        if (isset($attrs->default) && $attrs->default) {
                            $default = $attrs->default;
                        } else {
                            $default = '#000000';
                        }
                        $html .="<span ng-init=\"item.$field->internaltitle='$default'\"></span>";
                    }
                }
                $html .="<div><input $str color-picker type=\"color\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" /> <span class=\"label label-default\">{{item.$field->internaltitle}}</span></div>";
                break;
            case '1.6':
                $html .="<input class=\"form-control\" type=\"text\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;
            case 2:
                $html .="<input class=\"form-control\" type=\"number\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;
            case 3:
                $html .="<textarea class=\"form-control\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" ></textarea>";
                break;
            case '3.1':

                if (isset($attrs)) {
                    $str = '';
                    if (isset($attrs->required) && $attrs->required) {
                        $str .= ' required="required"';
                    }

                    if (isset($attrs->unique) && $attrs->unique) {
                        $attrs->unique = $attrs->unique === TRUE ? 1 : $attrs->unique;
                        $str .= " marker-unique=\"$field->listid.$field->internaltitle\" max-count=\"$attrs->unique\"";
                        if (!$createMode) {
                            $str .=" skip=\"{{item.{$field->list->identity}}}\"";
                        }
                    }

                    if (isset($attrs->unique_group)) {

                        $fields = array();
                        $values = array();
                        $titles = array();
                        foreach ($field->list->fields as $otherfield) {
                            if (isset($otherfield->attrs) && isset($otherfield->attrs->unique_group) && $otherfield->attrs->unique_group == $attrs->unique_group
                            ) {
                                $titles[] = $otherfield->title;
                                $fields[] = $field->listid . '.' . $otherfield->internaltitle;
                                $values[] = '{{item.' . $otherfield->internaltitle . '}}';
                            }
                        }

                        $str .= " marker-unique-group=\"$attrs->unique_group\"";
                        $str .= 'fields="' . implode(',', $fields) . '"';
                        $str .= 'values="' . implode('__markersep__', $values) . '"';
                        if (!$createMode) {
                            $str .=" skip=\"{{item.{$field->list->identity}}}\"";
                        }
                    }
                }
                $html .="<input $str class=\"form-control\" type=\"number\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                if (isset($attrs->unique)) {
                    $html .='<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.unique">Value already exists</span>' .
                            '<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.validatingunique">Checking the new value ...</span>';
                }
                if (isset($attrs->unique_group)) {
                    $html .='<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.uniquegroup">The combination ' . implode(', ', $titles) . ' already exists</span>' .
                            '<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.validatinguniquegroup">Checking the new values ...</span>';
                }
                break;


            case '4.1':

                $str = '';
                if (isset($attrs->required) && $attrs->required) {
                    $str .= ' required="required"';
                }

                if (isset($attrs->unique) && $attrs->unique) {
                    $attrs->unique = $attrs->unique === TRUE ? 1 : $attrs->unique;
                    $str .= " marker-unique=\"$field->listid.$field->internaltitle\" max-count=\"$attrs->unique\"";
                    if (!$createMode) {
                        $str .=" skip=\"{{item.{$field->list->identity}}}\"";
                    }
                }

                if (isset($attrs->unique_group)) {

                    $fields = array();
                    $values = array();
                    $titles = array();
                    foreach ($field->list->fields as $otherfield) {
                        if (isset($otherfield->attrs) && isset($otherfield->attrs->unique_group) && $otherfield->attrs->unique_group == $attrs->unique_group
                        ) {
                            $titles[] = $otherfield->title;
                            $fields[] = $field->listid . '.' . $otherfield->internaltitle;
                            $values[] = '{{item.' . $otherfield->internaltitle . '}}';
                        }
                    }

                    $str .= " marker-unique-group=\"$attrs->unique_group\"";
                    $str .= 'fields="' . implode(',', $fields) . '"';
                    $str .= 'values="' . implode('__markersep__', $values) . '"';
                    if (!$createMode) {
                        $str .=" skip=\"{{item.{$field->list->identity}}}\"";
                    }
                }

                if ($attrs->type == 'static') {
                    $options = array();
                    foreach (explode("\n", $attrs->type_static) as $row) {
                        if (strpos($row, '::')) {
                            $row = explode('::', $row);
                            $options[$row[0]] = $row[1];
                        } else {
                            $options[$row] = $row;
                        }
                    }
                    $html .= form_dropdown($field->internaltitle, $options, false, "ng-model=\"item.$field->internaltitle\" $str");
                }

                if ($attrs->type == 'internal') {
                    $html .= "<select $str class=\"form-control\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" field:internal=\"$attrs->type_internal\" field:display=\"$attrs->type_internal_display\"></select>";
                }

                if (isset($attrs->unique)) {
                    $html .='<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.unique">Value already exists</span>' .
                            '<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.validatingunique">Checking the new value ...</span>';
                }
                if (isset($attrs->unique_group)) {
                    $html .='<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.uniquegroup">The combination ' . implode(', ', $titles) . ' already exists</span>' .
                            '<span class="help-block" ng-show="form.' . $field->internaltitle . '.$error.validatinguniquegroup">Checking the new values ...</span>';
                }

                break;
            case '4.4':
                $html .="<span checkbox ng-model=\"item.$field->internaltitle\"></span>";
                break;
            case '5.1':

                if (isset($attrs)) {
                    if (isset($attrs->required) && $attrs->required) {
                        $str .= ' required="true"';
                    }
                    if (isset($attrs->max) && $attrs->max) {
                        $str .= ' max="' . $attrs->max . '"';
                    } else {
                        $str .= ' max="30"';
                    }
                }

                $html .="<marker-upload type=\"image\" ng-model='item.$field->internaltitle' path='uploads/upload/$field->id'></marker-upload>";
                break;

            case '5.2':
                if (isset($attrs)) {
                    if (isset($attrs->required) && $attrs->required) {
                        $str .= ' required="true"';
                    }
                    if (isset($attrs->max) && $attrs->max) {
                        $str .= ' max="' . $attrs->max . '"';
                    } else {
                        $str .= ' max="30"';
                    }
                }
                $html .="<marker-upload type=\"video\" ng-model='item.$field->internaltitle' path='uploads/upload/$field->id/video'></marker-upload>";
                break;

            case '5.3':
                if (isset($attrs)) {
                    if (isset($attrs->required) && $attrs->required) {
                        $str .= ' required="true"';
                    }
                    if (isset($attrs->max) && $attrs->max) {
                        $str .= ' max="' . $attrs->max . '"';
                    } else {
                        $str .= ' max="30"';
                    }
                }
                $html .="<marker-upload type=\"audio\" ng-model='item.$field->internaltitle' path='uploads/upload/$field->id/audio'></marker-upload>";
                break;
            case 6:break;

            case '7.1':
                $html .="<input date-picker type=\"date\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;

            case '7.2':
                $html .="<input datetime-picker type=\"datetime\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;

            case '7.3':
                $html .="<input month-picker type=\"month\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;

            case '7.4':
                $html .="<input year-picker type=\"year\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;

            default:
                $html .="<input class=\"form-control\" type=\"text\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
        }

        return $html;
    }

    public static function renderViewField($field) {
        $html = '';
        $attrs = $field->attrs;
        switch ($field->typeref) {
            case '1.3':
                $html .= "<span ng-bind-html-unsafe=\"item.$field->internaltitle | truncate:100\"></span>";
                break;
            case '1.5':
                if (isset($attrs->mode) && $attrs->mode === 'minirgb') {
                    $style = "style=\"border-color:rgb({{item.$field->internaltitle}});\"";
                } else {
                    $style = "style=\"border-color:{{item.$field->internaltitle}};\"";
                }
                $html .="<span class=\"color-box\" $style >{{item.$field->internaltitle}}</span>";
                break;

            case '1.6':
                $html .="<div marker-barcode type=\"ean13\" ng-model=\"item.$field->internaltitle\"></div>";
                break;
            case 2:
            case 3:
                $html .="{{item.$field->internaltitle}}";
                break;
            case '4.1':
                if ($attrs->type == 'internal') {
                    $html .="{{item.__$field->internaltitle | field_view_41:'$attrs->type_internal_display'}}";
                } else {
                    $html .="{{item.$field->internaltitle}}";
                }
                break;
            case '4.4':
                $html .="{{item.$field->internaltitle | checkmark}}";
                break;
            case '5.1':
                //$html .= "<div ng-bind-html-unsafe=\"item.{$field->internaltitle} | images_view:0:3\"></div>";
                $html .= "<div marker-image-preview limit=\"3\" max-width=\"130\"  ng-model=\"item.{$field->internaltitle}\"></div>";
                break;
            case '5.2':
                $html .= "<div marker-video-preview ng-model=\"item.{$field->internaltitle}\">rendering...</div>";
                break;

            case '5.3':
                $html .= "<div marker-audio-preview ng-model=\"item.{$field->internaltitle}\">rendering...</div>";
                break;
            case 6:
            default:
                $html .="{{item.$field->internaltitle}}";
        }

        return $html;
    }

    public static function renderIndexField($field) {
        $html = '';
        $attrs = $field->attrs;
        switch ($field->typeref) {
            case 1:
            case '1.2':
                $html .= "<span>{{item.$field->internaltitle | truncate:100}}</span>";
                break;
            case '1.3':
                $html .= "<span ng-bind-html-unsafe=\"item.$field->internaltitle | truncate:100\"></span>";
                break;
            case '1.5':
                if (isset($attrs->mode) && $attrs->mode === 'minirgb') {
                    $style = "style=\"border-color:rgb({{item.$field->internaltitle}});\"";
                } else {
                    $style = "style=\"border-color:{{item.$field->internaltitle}};\"";
                }
                $html .="<span class=\"color-box\" $style >{{item.$field->internaltitle}}</span>";
                break;

            case '1.6':
                $html .="<div marker-barcode type=\"ean13\" ng-model=\"item.$field->internaltitle\"></div>";
                break;
            case 2:
            case 3:
                $html .="{{item.$field->internaltitle}}";
                break;
            case '4.1':
                if ($attrs->type == 'internal') {
                    $html .="{{item.__$field->internaltitle | field_view_41:'$attrs->type_internal_display'}}";
                } else {
                    $html .="{{item.$field->internaltitle}}";
                }
                break;
            case '4.4':
                $html .="{{item.$field->internaltitle | checkmark}}";
                break;
            case '5.1':
                //$html .= "<div ng-bind-html-unsafe=\"item.{$field->internaltitle} | images_index\"></div>";
                $html .= "<div marker-image-preview limit=\"0\" ng-model=\"item.{$field->internaltitle}\"></div>";
                break;

            case '5.2':
                $html .= "<div marker-video-preview ng-model=\"item.{$field->internaltitle}\">rendering...</div>";
                break;

            case '5.3':
                $html .= "<div marker-audio-preview ng-model=\"item.{$field->internaltitle}\">rendering...</div>";
                break;
            case 6:
            default:
                $html .="{{item.$field->internaltitle}}";
        }

        return $html;
    }

    public static function parseAttr(Array $attrs) {
        $str = '';
        foreach ($attrs as $key => $value) {
            if (isset($value)) {
                $str .= " $key=\"$value\"";
            }
        }
        return $str;
    }

}
