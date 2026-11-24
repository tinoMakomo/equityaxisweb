<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'slug'           => $this->slug,
            'description'    => $this->description,
            'position'       => $this->position,
            'displayInNavbar'=> (bool) $this->display_in_navbar,
            'hasChildren'    => $this->hasChildren(),
            'hasParent'      => $this->hasParent(),
            'parent'         => $this->parent,
            'children'       => CategoryResource::collection(
                                    $this->whenLoaded('children')
                                ),
            'url'            => "/category/{$this->id}/{$this->slug}",
        ];
    }
}
