<?php

namespace App\Console\Commands;

use App\Events\MessagePushed;
use App\Item;
use App\Notifications\iosNotification;
use App\Notifications\OneSignalNotification;
use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        new iosNotification();
       $newData = $this->item_di->insertAll();
        $oneSignal = new OneSignalNotification();
        foreach ($newData as $item)
        {
            Log::debug($item);

            $content = $item['title'];
            $content .= ' --- Seller: ' . $item['seller'];
            $heading = '$' . $item['price'];
            $heading .= ' - '. $item['from_site'];
            $media = $item['galaryPlus'];
            $subtitle = 'Shipping: ' . $item['shipping_cost'];
            $subtitle .= ' - ' . $item['item_condition'];


//            convert http picture to https
            $url = str_ireplace( 'http://', 'https://', $media );

            $oneSignal->send($content, $heading,$item, $subtitle ,$url, $item['id']);
            event(new MessagePushed($item));
        }
    }
}
