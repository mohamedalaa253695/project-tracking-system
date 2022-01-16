<?php

namespace App;
use App\Project;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    protected $fillable = [
        'body'
    ];

    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }


}
