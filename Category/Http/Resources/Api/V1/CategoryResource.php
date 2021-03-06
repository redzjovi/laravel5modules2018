<?php

namespace Modules\Category\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Medium\Http\Resources\Api\V1\MediumResource;

class CategoryResource extends Resource
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
        $data['slug'] = $this->slug;
        $data['excerpt'] = $this->excerpt;
        $data['content'] = $this->content;

        if ($withs = $request->query('with')) {
            if (in_array('translations', $withs)) {
                foreach (config('cms.locales') as $locale => $localeName) {
                    $data['title_'.$locale] = $this->{'title_'.$locale};
                    $data['slug_'.$locale] = $this->{'slug_'.$locale};
                    $data['excerpt_'.$locale] = $this->{'excerpt_'.$locale};
                    $data['content_'.$locale] = $this->{'content_'.$locale};
                }
            }
        }

        $data['images'] = MediumResource::collection($this->getMedia('category_image'));
        $data['galleries'] = MediumResource::collection($this->getMedia('category_gallery'));
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;

        return $data;
    }
}
