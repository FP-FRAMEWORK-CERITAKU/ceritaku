<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'title',
        'content',
        'slug',
        'photo_background',
        'is_publish',
    ];

    // @section relations

    public function comments()
    {
        return $this->hasMany(
            Comment::class,
            'post_id',
            'id'
        );
    }

    public function creator()
    {
        return $this->hasOne(
            User::class,
            'id',
            'creator_id'
        );
    }

    // @section helpers

    public function isEdited()
    {
        return $this->created_at != $this->updated_at;
    }

    public function getPhotoUrl()
    {
        return !empty($this->photo_background)
            ? Storage::url($this->photo_background)
            : null;
    }

    public function savePhoto(UploadedFile $photo_background)
    {
        $this->deletePhoto();

        $renamed = Helper::uuidv4() . '.' . $photo_background->getClientOriginalExtension();

        $this->photo_background = $photo_background->storeAs('avatar', $renamed);
        return $this->save();
    }

    public function deletePhoto()
    {
        if (!empty($this->photo_background)) {
            Storage::delete($this->photo_background);
            return $this->update(['photo_background' => null]);
        }

        return false;
    }
}
