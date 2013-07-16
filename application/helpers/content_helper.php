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
                        $str .= " ng-init=\"item.$field->internaltitle='$attrs->default'\"";
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
            case 2:
                $html .="<input type=\"number\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
                break;
            case 3:
                $html .="<textarea name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" ></textarea>";
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

                    if (isset($attrs->thumbnail) && $attrs->thumbnail) {

                        if (!isset($attrs->thumbnail_width)) {
                            $attrs->thumbnail_width = '250';
                        }

                        if (!isset($attrs->thumbnail_height)) {
                            $attrs->thumbnail_height = '150';
                        }

                        $str .= ' thumbnail="' . $attrs->thumbnail_height . ',' . $attrs->thumbnail_width . '"';
                    }

                    if (isset($attrs->ext) && $attrs->ext) {
                        $str .= ' ext="' . $attrs->ext . '"';
                    }
                }


                $html .="<div form=\"form\" working=\"working\" doupload=\"alert('do upload')\" $str upload=\"" . site_url('admin/uploads/upload/' . $field->id) . "\" property=\"item.$field->internaltitle\" fieldid=\"$field->id\" name=\"$field->internaltitle\">upload</div>
                    <!--<pre>{{item.{$field->internaltitle}}}</pre>-->
                    ";
                break;
            case 6:
            default:
                $html .="<input type=\"text\" name=\"$field->internaltitle\" id=\"$field->internaltitle\" ng-model=\"item.$field->internaltitle\" />";
        }

        return $html;
    }

    public static function renderViewField($field) {
        $html = '';
        switch ($field->type) {
            case 1:
            case 2:
            case 3:
                $html .="{{item.$field->internaltitle}}";
                break;
            case '5.1':
                $html .= "<div ng-bind-html-unsafe=\"item.{$field->internaltitle} | images_view:0:3\"></div>";
                break;
                break;
            case 6:
            default:
                $html .="{{item.$field->internaltitle}}";
        }

        return $html;
    }

    public static function renderIndexField($field) {
        $html = '';
        switch ($field->type) {
            case 1:
            case 2:
            case 3:
                $html .="{{item.$field->internaltitle}}";
                break;
            case '5.1':
                $html .= "<div ng-bind-html-unsafe=\"item.{$field->internaltitle} | images_index\"></div>";
                break;
                break;
            case 6:
            default:
                $html .="{{item.$field->internaltitle}}";
        }

        return $html;
    }

}
