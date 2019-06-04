<?php

namespace Modules\Menu\Http\Resources\Api\V1\Menu\Nestable;

use Illuminate\Http\Resources\Json\Resource;

class TypeTitleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;

        if ($this->resource instanceof \Modules\User\Models\User) {
            $data['title'] = $this->name;
        } else {
            $data['title'] = $this->title;
        }

        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;

        return $data;
    }
}
