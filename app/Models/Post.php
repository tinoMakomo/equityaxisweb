<?php

namespace App\Models;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Typesense\LaravelTypesense\Interfaces\TypesenseDocument;


class Post extends Model implements HasMedia, TypesenseDocument
{
    use InteractsWithMedia, HasFactory, Sluggable, SoftDeletes;
    use Searchable {
        queueMakeSearchable as protected scoutQueueMakeSearchable;
        queueRemoveFromSearch as protected scoutQueueRemoveFromSearch;
    }

    /**
     * Sync post updates to Typesense without breaking post creation/editing if Typesense is lagging or unavailable.
     */
    public function queueMakeSearchable($models)
    {
        try {
            return $this->scoutQueueMakeSearchable($models);
        } catch (\Throwable $e) {
            Log::warning('Typesense index update skipped: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Sync post deletions to Typesense without breaking post deletion if Typesense is lagging or unavailable.
     */
    public function queueRemoveFromSearch($models)
    {
        try {
            return $this->scoutQueueRemoveFromSearch($models);
        } catch (\Throwable $e) {
            Log::warning('Typesense index delete skipped: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = [
        'title',
        'body',
        'slug',
        'user_id',
        'permalink',
        'status',
        'publish_at',
        'excerpt',
        'tags',
        'editors_pick',
        'is_archived'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts');
    }

    public function tags()
    {
        if ($this->tags == NULL  || strlen(trim($this->tags)) == 0) {
            return [];
        }

        return explode(";;", $this->tags);
    }

    public function getCategory()
    {
        if ($this->categories->count() == 0) {
            return "Uncategorized";
        }
        return $this->categories->first()->name;
    }

    /**
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('featured')
            ->crop('crop-center', 900, 600);
        $this->addMediaConversion('thumb')
            ->crop('crop-center', 600, 400);
        $this->addMediaConversion('thumb-sm')
            ->crop('crop-center', 450, 300);
    }


    /**
     * @return string
     */
    public function thumbnailSmall()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl('thumb-sm');
        }
        return asset('images/posts/ea-logo-post-450.png');
    }

    /**
     * @return string
     */
    public function thumbnail()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl('thumb');
        }
        return asset('images/posts/ea-logo-post-600.png');
    }

    /**
     * @return string
     */
    public function featuredImage()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl('featured');
        }
        return asset('images/posts/ea-logo-post-900.png');
    }


    public function excerpt(int $len = 200): string
    {
        return Str::limit(strip_tags($this->excerpt), $len);
    }


    public function getStatus(): string
    {
        return Str::ucfirst(str_replace("_", " ", $this->status));
    }

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'posts_index';
    }


    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return array_merge(
            $this->toArray(),
            [
                // Cast id to string and turn created_at into an int32 timestamp
                // in order to maintain compatibility with the Typesense index definition below
                'id' => (string) $this->id,
                'created_at' => $this->created_at->timestamp,
            ]
        );
    }

    /**
     * The Typesense schema to be created.
     *
     * @return array
     */
    public function getCollectionSchema(): array
    {
        return [
            'name' => $this->searchableAs(),
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'string',
                ],
                [
                    'name' => 'title',
                    'type' => 'string',
                ],
                [
                    'name' => 'created_at',
                    'type' => 'int64',
                ],
            ],
            'default_sorting_field' => 'created_at',
        ];
    }

    /**
     * The fields to be queried against. See https://typesense.org/docs/0.21.0/api/documents.html#search.
     *
     * @return array
     */
    public function typesenseQueryBy(): array
    {
        return [
            'title',
        ];
    }
}
