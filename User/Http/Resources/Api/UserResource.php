<?php

namespace Modules\User\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
        $data['email'] = $this->email;
        $data['verification_code'] = $this->verification_code;
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;

        if ($withs = $request->query('with')) {
            if (in_array('roles', $withs)) {
                $data['roles'] = $this->roles;
            }
        }

        return $data;
    }
}
