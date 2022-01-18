<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;

class Project extends Model
{
    //

    protected $fillable = [
        'title',
        'description',
        'owner_id',
        'notes'
    ];

    public function path()
    {
        return "/project/{$this->id}";
    }



    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function addTask($body){

        return $this->tasks()->create(compact('body'));
    }


    protected $guarded = [];
}
