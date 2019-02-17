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
        $fields = \Schema::getColumnListing($this->table);
        $this->fillable = $fields;
    }
}
