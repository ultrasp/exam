<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\ImportFile;
use App\Models\ImportFileError;
use Illuminate\Console\Command;
use \JsonMachine\JsonMachine;

class ImportObjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:objects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import objects from json files';

    private $cat_file = 'categories.json';
    private $product_file = 'products.json';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param  \App\Support\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $this->importFromFile($this->cat_file,'App\Models\Category');
        $this->importFromFile($this->product_file,'App\Models\Product');
    }

    public function importFromFile($file, $class){
        //import file history story in DB
        $proc = ImportFile::start($file);

        /*Starting import category object */
        // $objects = json_decode(file_get_contents(storage_path('app/import/'.$file)));
        $objects = JsonMachine::fromFile(storage_path('app/import/'.$file));
        foreach ($objects as $key => $item) {
            $obj = (object) $item;
            // dd($obj);
            try {
                //validate before store
                if($this->validate($obj,$class::$rules))
                    //store data to DB
                    $class::store($obj);
            }catch (\Throwable $e) {
                // dd($e);
                $message = $e->getMessage();
                //store erorrs on save or validation to check 
                ImportFileError::store($proc->id,$key,$obj,$message);
            }
        }
        // make status finished the category import
        $proc->finish();
    }

    public function validate($data, $rules){
        return \Validator::make((array) $data, $rules)->validate();
    }
}