<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        $publishedAt  = $this->publish_at ? strtotime($this->publish_at) : null;
        $year         = $publishedAt ? date('Y', $publishedAt) : null;
        $month        = $publishedAt ? date('n', $publishedAt) : null;

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'excerpt'     => $this->excerpt(200),
            'body'        => $this->body,
            'status'      => $this->status,
            'publishedAt' => $this->publish_at,
            'editorspick' => (bool) $this->editors_pick,
            'isArchived'  => (bool) $this->is_archived,
            'tags'        => $this->tags(),
            'category'    => $this->getCategory(),
            'categories'  => CategoryResource::collection(
                                $this->whenLoaded('categories')
                             ),
            'author'      => $this->whenLoaded('user', fn () => $this->user ? [
                                'id'     => $this->user->id,
                                'name'   => $this->user->name,
                                'avatar' => $this->user->avatar(),
                             ] : null),
            'thumbnail'   => $this->thumbnail(),
            'thumbnailSm' => $this->thumbnailSmall(),
            'featured'    => $this->featuredImage(),
            'url'         => $year && $month
                                ? "/post/{$this->id}/{$year}/{$month}/{$this->slug}"
                                : null,
            'createdAt'   => $this->created_at,
            'updatedAt'   => $this->updated_at,
        ];
    }
}
