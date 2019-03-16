<?php

namespace Modules\Role\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\Resource;

class RoleResource extends Resource
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
        $data['name'] = $this->name;
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;

        if ($withs = $request->query('with')) {
            if (in_array('permissions', $withs)) {
                $data['permissions'] = $this->permissions;
            }
        }

        return $data;
    }
}
