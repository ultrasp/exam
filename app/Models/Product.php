<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = ['title',"eId","price"];
    //
    public static $rules = [
        'eld' => 'integer|nullable',
        'title' => 'required|string|min:3|max:12',
        'price' => 'required|between:0,200.00',
        'categoriesEId' => 'array' 
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_product');
    }

    public static function store($data ){
        // dd($data);
        $item = self::firstOrNew(
            [ 
                'eId' => $data->eId
            ],
            [  
                'title' => $data->title,
                'price' => $data->price,
            ]
        );
        $item->save();
        $cat_ids = Category::whereIn('eId',$data->categoryEId)->pluck('id')->toArray();
        $item->categories()->sync($cat_ids);

        return $item;
    }
}
