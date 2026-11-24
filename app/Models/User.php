<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable  implements HasMedia
{
    use InteractsWithMedia, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
        'bio',
        'twitter',
        'linkedin',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getSlug() : String
    {
        return Str::slug($this->name);
    }

    public function getFirstName() : String
    {
        return  explode(" ", $this->name)[0];
    }


    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function preferences()
    {
        return $this->hasOne(Preference::class);
    }

    public function isAdmin()
    {
        return Str::lower($this->userType->name) == 'admin';
    }

    public function isAuthor()
    {
        return Str::lower($this->userType->name) == 'author';
    }

    public function isEditor()
    {
        return Str::lower($this->userType->name) == 'editor';
    }

        /**
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->crop('crop-center', 200, 200);
    }


    /**
     * @return string
     */
    public function avatar()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl('avatar');
        }
        return asset('images/icons/avatar.png');
    }
}
