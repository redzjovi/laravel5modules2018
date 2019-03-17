<?php

namespace Modules\Medium\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\Resource;

class MediumResource extends Resource
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
        $data['collection_name'] = $this->collection_name;
        $data['name'] = $this->name;
        $data['file_name'] = $this->file_name;
        $data['full_url'] = $this->getFullUrl();
        $data['mime_type'] = $this->mime_type;
        $data['size'] = $this->size;
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;

        return $data;
    }
}
