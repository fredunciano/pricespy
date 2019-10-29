<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportProductEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $shop_type;
    public $enable_price_override;
    public $user_id;
    public $isUpdate;
    public $csv_path;
    public $headings;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($shop_type, $enable_price_override, $user_id, $isUpdate, $csv_path, $headings)
    {
        $this->shop_type = $shop_type;
        $this->enable_price_override = $enable_price_override;
        $this->user_id = $user_id;
        $this->isUpdate = $isUpdate;
        $this->csv_path = $csv_path;
        $this->headings = $headings;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('importProductInfo.' . $this->user_id);
//    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
//    public function broadcastAs()
//    {
//        return 'csv-upload';
//    }
}
