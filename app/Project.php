<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    protected $fillable = [
        'title',
        'description',
        'owner_id'
    ];

    public function path()
    {
        return "/project/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    protected $guarded = [];
}