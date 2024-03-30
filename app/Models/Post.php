<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded     = ['id','_token'];

    public function user(){
    
        return $this->BelongsTo('App\Models\User','user_id');
    }
}
