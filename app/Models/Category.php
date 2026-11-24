<?php

namespace App\Models;

use App\Utilities\Helper;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use Sluggable, HasFactory;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name',
        'description',
        'parent',
        'position',
        'display_in_navbar',
    ];


    public function children()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function hasChildren()
    {
        return $this->children->count() > 0;
    }

    public function hasParent()
    {
        return $this->parent != 0;
    }

    public function parentModel()
    {
        return $this->belongsTo(Category::class, "parent");
    }

    public function getParentName(): string
    {
        if (!empty($this->parent)) {
            return optional($this->parentModel)->name ?? "--";
        }
        return "--";
    }

    public function getPosts(int $limit = 6)
    {
        $isArchived = Helper::getIsArchivedValue();
        $version = Helper::getCacheVersion();
        $cacheKey = "site:v{$version}:category:{$this->id}:posts:{$isArchived}:{$limit}";

        return Cache::remember($cacheKey, 300, function () use ($isArchived, $limit) {
            $categoryIds = $this->getSelfAndChildCategoryIds();

            return Post::select('posts.id', 'posts.title', 'posts.slug', 'posts.created_at')
                ->where('posts.status', 'published')
                ->where('posts.is_archived', $isArchived)
                ->whereExists(function ($query) use ($categoryIds) {
                    $query->selectRaw('1')
                        ->from('category_posts')
                        ->whereColumn('category_posts.post_id', 'posts.id')
                        ->whereIn('category_posts.category_id', $categoryIds);
                })
                ->orderBy('posts.id', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    public function getSelfAndChildCategoryIds()
    {
        $categoryIds = array();
        array_push($categoryIds, $this->id);
        foreach ($this->children as $child) {
            array_push($categoryIds, $child->id);
        }
        return $categoryIds;
    }
}
