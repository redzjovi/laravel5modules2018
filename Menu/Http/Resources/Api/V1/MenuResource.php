<?php

namespace Modules\Menu\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Medium\Http\Resources\Api\V1\MediumResource;

class MenuResource extends Resource
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
        $data['title'] = $this->title;
        $data['excerpt'] = $this->excerpt;

        if ($withs = $request->query('with')) {
            if (in_array('translations', $withs)) {
                foreach (config('cms.locales') as $locale => $localeName) {
                    $data['title_'.$locale] = $this->{'title_'.$locale};
                    $data['excerpt_'.$locale] = $this->{'excerpt_'.$locale};
                }
            }
        }

        $data['nestable'] = $this->nestable;
        $data['images'] = MediumResource::collection($this->getMedia('tag_image'));
        $data['galleries'] = MediumResource::collection($this->getMedia('tag_gallery'));
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;

        return $data;
    }
}
