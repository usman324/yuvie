<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['image','file_name', 'imageable_type', 'imageable_id'];


    /**
     * Store the provided note.
     *
     * @param array $noteDetail
     * @return Note
     */
    public static function saveImage(array $imageDetail): self
    {
        $note = new self();
        $note->image = $imageDetail['image'];
        $note->imageable_type = $imageDetail['imageable_type'] ;
        $note->file_name = $imageDetail['file_name'] ;
        // $note->imageable_id = $imageDetail['imageable_id'] ;
        $note->save();

        return $note;
    }
    /**
     * Get the noteable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
