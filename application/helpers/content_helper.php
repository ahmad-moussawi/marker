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

    public static function renderEditField($field) {
        $html = '';
        $str = '';

        if (!empty($field->attrs)) {
            $attrs = json_decode($field->attrs);
        }

        switch ($field->type) {
            case '1.1':
                if (isset($attrs)) {
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

                    if (isset($attrs->default) && $attrs->default) {
                        //$str .= " ng-init=\"item.$field->internaltitle = '$attrs->default'\"";
                    }
                }

                $html .="<input $str name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;

            case '1.2':
                if (isset($attrs)) {
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

                    if (isset($attrs->default) && $attrs->default) {
                        $str .= " ng-init=\"item.$field->internaltitle='$attrs->default'\"";
                    }
                }

                $html .="<textarea $str name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" ></textarea>";
                break;

            case '1.3':
                if (isset($attrs)) {
                    if (isset($attrs->required) && $attrs->required) {
                        $str = ' required="required"';
                    }

                    if (isset($attrs->default) && $attrs->default) {
                        $str .= " ng-init=\"item.$field->internaltitle='$attrs->default'\"";
                    }

                    if (isset($attrs->theme) && $attrs->theme > 0) {
                        $str .= ' theme="' . $attrs->theme . '"';
                    }
                }

                $html .="<textarea ck-editor $str name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" ></textarea>";
                break;

            case '1.4':
                if (isset($attrs)) {
                    if (isset($attrs->required) && $attrs->required) {
                        $str = ' required="required"';
                    }

                    if (isset($attrs->default) && $attrs->default) {
                        $str .= " ng-init=\"item.$field->internaltitle='$attrs->default'\"";
                    }

                    if (isset($attrs->theme) && $attrs->theme > 0) {
                        $str .= ' theme="' . $attrs->theme . '"';
                    }
                }
                $html .="<div class=\"editor\" data-ace=\"\" data-ng-model=\"item.$field->internaltitle\"></div>";
                break;
            case '1.5':
                $html .="<input color-picker type=\"color\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;

            case '1.6':
                $html .="<input type=\"text\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;

            case 2:
                $html .="<input type=\"number\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;
            case 3:
                $html .="<textarea name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" ></textarea>";
                break;

            case '4.1':
                $attrs_str = array();
                if (isset($attrs->required) && $attrs->required) {
                    $attrs_str['required'] = 'required';
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
                    $html .= form_dropdown($field->internaltitle, $options, false, "ng-model=\"item.$field->internaltitle\"");
                }

                if ($attrs->type == 'internal') {
                    $html .= "<select name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" field:internal=\"$attrs->type_internal\" field:display=\"$attrs->type_internal_display\"></select>";
                }

                break;
            case '4.4':
                $html .="<input type=\"checkbox\" ng-model=\"item.$field->internaltitle\" ng-true-value=\"1\" ng-false-value=\"0\"/>";
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

                $html .="<marker:upload type=\"image\" ng-model='item.$field->internaltitle' path='uploads/upload/$field->id'></marker:upload>";
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
                $html .="<marker:upload type=\"video\" ng-model='item.$field->internaltitle' path='uploads/upload/$field->id/video'></marker:upload>";
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
                $html .="<marker:upload type=\"audio\" ng-model='item.$field->internaltitle' path='uploads/upload/$field->id/audio'></marker:upload>";
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
                $html .="<input type=\"text\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
        }

        return $html;
    }

    public static function renderViewField($field) {
        $html = '';
        $attrs = json_decode($field->attrs);
        switch ($field->type) {
            case 1:
            case '1.5':
                $html .="<span class=\"color-box\" style=\"border-color:{{item.$field->internaltitle}};\">{{item.$field->internaltitle}}</span>";
                break;

            case '1.6':
                $html .="<div marker:barcode type=\"ean13\" ng-model=\"item.$field->internaltitle\"></div>";
                break;
            case 2:
            case 3:
                $html .="{{item.$field->internaltitle}}";
                break;
            case '4.1':
                if ($attrs->type == 'internal') {
                    $html .="{{item.__$field->internaltitle | field_view_41:'$attrs->type_internal_display'}}";
                }
                break;
            case '4.4':
                $html .="{{item.$field->internaltitle | checkmark}}";
                break;
            case '5.1':
                $html .= "<div ng-bind-html-unsafe=\"item.{$field->internaltitle} | images_view:0:3\"></div>";
                break;
            case '5.2':
                $html .= "<div marker:video-preview ng-model=\"item.{$field->internaltitle}\">rendering...</div>";
                break;

            case '5.3':
                $html .= "<div marker:audio-preview ng-model=\"item.{$field->internaltitle}\">rendering...</div>";
                break;
            case 6:
            default:
                $html .="{{item.$field->internaltitle}}";
        }

        return $html;
    }

    public static function renderIndexField($field) {
        $html = '';
        $attrs = json_decode($field->attrs);
        switch ($field->type) {
            case 1:
            case '1.3':
                $html .= "<span ng-bind-html-unsafe=\"item.$field->internaltitle | truncate:100\"></span>";
                break;
            case '1.5':
                $html .="<span class=\"color-box\" style=\"border-color:{{item.$field->internaltitle}};\">{{item.$field->internaltitle}}</span>";
                break;

            case '1.6':
                $html .="<div marker:barcode type=\"ean13\" ng-model=\"item.$field->internaltitle\"></div>";
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
                $html .= "<div ng-bind-html-unsafe=\"item.{$field->internaltitle} | images_index\"></div>";
                break;

            case '5.2':
                $html .= "<div marker:video-preview ng-model=\"item.{$field->internaltitle}\">rendering...</div>";
                break;

            case '5.3':
                $html .= "<div marker:audio-preview ng-model=\"item.{$field->internaltitle}\">rendering...</div>";
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
