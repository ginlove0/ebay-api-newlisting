<?php

namespace App\Console\Commands;

use App\Events\MessagePushed;
use App\Item;
use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertNewItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ItemInterface $item_di)
    {
        parent::__construct();
        $this->item_di = $item_di;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
       $newData = $this->item_di->insertAll();
        $data = DB::table('items')->orderBy('created_at', 'desc')->get();
        foreach ($newData as $item)
        {
            event(new MessagePushed($item));
        }
    }
}
