<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ImportFileError extends Model
{
    protected $fillable = ['import_file_id',"indx","data","error_","parseTime"];

    public $timestamps = false;
    public static function store($file_id,$indx,$data,$error){
        $item = new self([
            'import_file_id' => $file_id,
            'indx' => $indx,
            'data' => json_encode($data),
            'error_' => $error,
            'parseTime' => date('Y-m-d H:i:s')
        ]);
        $item->save();
        return $item;
    }

}
