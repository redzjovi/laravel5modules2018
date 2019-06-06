<?php

namespace Modules\Theme\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\Resource;

class ThemeResource extends Resource
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
        $data['group'] = $this->group;
        $data['section'] = $this->section;
        $data['type'] = $this->type;
        $data['value'] = $this->value;
        $data['title'] = $this->title;
        $data['content'] = $this->content;

        if ($withs = $request->query('with')) {
            if (in_array('translations', $withs)) {
                foreach (config('cms.locales') as $locale => $localeName) {
                    $data['title_'.$locale] = $this->{'title_'.$locale};
                    $data['content_'.$locale] = $this->{'content_'.$locale};
                }
            }
        }

        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;

        return $data;
    }
}
