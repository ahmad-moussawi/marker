<?php

class Field extends Eloquent {

    protected $table = 'fields';

    public function getAttrsAttribute($value) {
        return json_decode($value);
    }

    public function setAttrsAttribute($value) {
        $this->attributes['attrs'] = json_encode($value);
    }

    public function setInternalTitleAttribute($title) {
        $slug = str_replace('-', '', Str::slug($title));
        $slugCount = count($this->whereRaw("internaltitle REGEXP '^{$slug}(-[0-9]*)?$' AND `entityid` = {$this->entityid}")->get());
        $this->attributes['internaltitle'] = ($slugCount > 0) ? "{$slug}_{$slugCount}" : $slug;
    }

    /**
     * Determine if this field is a pointer to a foreign entity
     * @return boolean
     */
    public function isPointer() {
        return $this->attr('pointer');
    }

    /**
     * Get the parent entity id 
     * 
     * @return int
     */
    public function getPointedEntityId() {
        return $this->attr('pointer') ? $this->attr('pointer') : null;
    }

    /**
     * Get the parent entity
     * 
     * @return Entity
     * @throws NotAForeignFieldException
     */
    public function getPointedEntity() {
        if (!$this->getPointedEntityId()) {
            throw new NotAPointerFieldException();
        }

        return Entity::find($this->getPointedEntityId());
    }

    /**
     * Get the fields id that must appear
     * 
     * @return integer[]
     */
    public function getPointedFieldsIds() {
        return $this->attr('pointer') ? $this->attr('pointer_show') : null;
    }

    public function getPointedFields() {
        if (!$this->getPointedFieldsIds()) {
            throw new NotAPointedFieldException();
        }

        if ($this->getPointedFieldsIds() === null) {
            return array();
        }

        return Field::whereIn('id', $this->getPointedFieldsIds())->get();
    }

    public function entity() {
        return $this->belongsTo('Entity', 'entityid');
    }

    public function attr($key, $default = null) {
        return property_exists((object) $this->attrs, $key) ? $this->attrs->{$key} : $default;
    }

    function renderIndex() {
        $view = "admin.controls.$this->definition.index";
        $data = array('field' => $this);
        if (View::exists($view)) {
            return View::make($view, $data);
        } else {
            return View::make('admin.controls.default.index', $data);
        }
    }

    function RenderView() {


        $data = array('field' => $this);
        $view = "admin.controls.$this->definition.view";

        if (View::exists($view)) {
            return View::make($view, $data);
        } else {
            return View::make('admin.controls.default.view', $data);
        }
    }

    function RenderEdit($new = FALSE) {
        $data = array(
            'field' => $this,
            'new' => $new,
            'htmlattr' => array()
        );

        $header = 'admin.controls.default.tmpl.edit.header';
        $footer = 'admin.controls.default.tmpl.edit.footer';
        $view = 'admin.controls.default.edit';

        if (View::exists("admin.controls.{$this->definition}.tmpl.edit.header")) {
            $header = "admin.controls.{$this->definition}.tmpl.edit.header";
        }

        if (View::exists("admin.controls.{$this->definition}.tmpl.edit.footer")) {
            $footer = "admin.controls.{$this->definition}.tmpl.edit.footer";
        }

        if (View::exists("admin.controls.{$this->definition}.edit")) {
            $view = "admin.controls.{$this->definition}.edit";
        }

        $data['htmlattr'] = $this->parseHtmlAttrs();


        $html = View::make($header, $data)->render();
        $html .= View::make($view, $data)->render();
        $html .= View::make($footer, $data)->render();

        return $html;
    }

    public function parseHtmlAttrs() {
        $attr = array();

        $ngrules = array(
            'required',
            'minlength', 
            'maxlength', 
        );

        $mkrules = array(
            'min',
            'max'
        );
        
        if ($this->attr('pattern')) {
                $attr["ng-pattern"] = "/{$this->attr('pattern')}/";
            }
        

        foreach ($ngrules as $rule) {
            if ($this->attr($rule)) {
                $attr["ng-$rule"] = $this->attr($rule);
            }
        }
        
        foreach ($mkrules as $rule) {
            if ($this->attr($rule)) {
                $attr["mk-$rule"] = $this->attr($rule);
            }
        }

        return $attr;
    }

}
