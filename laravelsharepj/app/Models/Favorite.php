<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $fillable=[
        'post_id',
        'user_id'
    ];
    public function post(){
        return $this -> belongsTo(Post::class);
    }
}
