<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Console\Command;

class DeleteItemsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteItem';

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
        $this->item_di->truncateData();
        $this->item_di->insertAll();
    }
}
