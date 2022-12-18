<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;



class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id','title', 'created_by'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'created_by' => 'integer',
    ];

    public function  scopeSelection($query){

        return $query -> select('id','title', 'created_by');
    }


    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
