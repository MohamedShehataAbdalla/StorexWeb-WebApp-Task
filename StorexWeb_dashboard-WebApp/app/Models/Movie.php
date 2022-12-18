<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;



class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'title', 'description', 'rate', 'image', 'category_id', 'created_by'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'created_by' => 'integer',
        'rate' => "decimal:2",
    ];

    protected function Rate(): Attribute
    {
        return new Attribute(
            get: fn ($value) => number_format($value, 2,'.', ''),
            set: fn ($value) => (float)$value,
        );
    }

    public function  scopeSelection($query){

        return $query -> select('id', 'title', 'description', 'rate', 'image', 'category_id', 'created_by');
    }



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
