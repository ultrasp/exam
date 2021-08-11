<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['title',"eId"];

    public static $rules = [
        'eld' => 'integer|nullable',
        'title' => 'required|string|min:3|max:12',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,'category_product');
    }

    public static function store($data){
        $item = self::firstOrNew(
            [
                'eId' => $data->eId
            ],
            [
                'title' => $data->title
            ]
        );
        $item->save();
        return $item;
    }
}
