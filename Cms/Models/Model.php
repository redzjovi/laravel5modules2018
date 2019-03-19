<?php

namespace Modules\Cms\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function __construct()
    {
        $this->setFillable();
    }

    public function setFillable()
    {
        $fields = \Cache::remember($this->getTable().'_model_fillable', 60, function () {
            return \Schema::getColumnListing($this->table);
        });
        $this->fillable = $fields;
    }
}
