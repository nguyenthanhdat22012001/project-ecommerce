<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AddDataCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:add {quantity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new Category';

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
     * @return int
     */
    public function handle()
    {
        $quantity=$this->argument('quantity');
        for ($i=0;$i<=$quantity;$i++){
            try {
                Category::create([
                    'name'=>'Category'.$i,
                    'slug'=>Str::slug('category'.$i),
                    'img'=>'category'.$i,
                    'description'=>'Category'.$i,
                    'hide'=>1
                    ]);
            }catch (\Exception $exception){
                    Log::info($exception->getMessage());
            }
        }
    }
}
