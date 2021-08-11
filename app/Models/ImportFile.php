<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ImportFile extends Model
{
    const STATUS_ON_PROCESS = 'on_process';
    const STATUS_FINISHED = 'finished';

    protected $fillable = ['file',"status","error_"];

    public static function start($file){
        $item = new self([
            'file' => $file,
            'status' => self::STATUS_ON_PROCESS
        ]);
        $item->save();
        return $item;
    }

    public function finish(){
        $this->status = self::STATUS_FINISHED;
        $this->save();
    }
}
