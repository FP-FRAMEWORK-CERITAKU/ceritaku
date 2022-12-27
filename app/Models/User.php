<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo'
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

    // @section relations

    public function posts()
    {
        return $this->hasMany(
            Post::class,
            'creator_id',
            'id'
        );
    }

    public function comments()
    {
        return $this->hasManyThrough(
            Comment::class,
            Post::class,
            'creator_id',
            'post_id',
            'id',
            'id'
        );
    }

    // @section helper

    public function hasRoleSuperadmin(): string
    {
        return $this->hasRole('Superadmin');
    }

    public function hasRoleAnggota(): string
    {
        return $this->hasRole('Anggota');
    }

    public function getPhotoUrl()
    {
        return !empty($this->photo)
            ? Storage::url($this->photo)
            : null;
    }

    public function savePhoto(UploadedFile $photo)
    {
        $this->deletePhoto();

        $renamed = Helper::uuidv4() . '.' . $photo->getClientOriginalExtension();

        $this->photo = $photo->storeAs('avatar', $renamed);
        return $this->save();
    }

    public function deletePhoto()
    {
        if (!empty($this->photo)) {
            Storage::delete($this->photo);
            return $this->update(['photo' => null]);
        }

        return false;
    }
}
