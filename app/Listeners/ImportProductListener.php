<?php

namespace App\Listeners;

use App\Events\ImportProductEvent;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportProductListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ImportProductEvent $event
     * @return void
     */
    public function handle(ImportProductEvent $event)
    {
        Auth::loginUsingId($event->user_id);
        Excel::import(new ProductImport(
            (int)$event->shop_type,
            $event->enable_price_override,
            $event->isUpdate,
            $event->csv_path,
            $event->headings),
            $event->csv_path, null, \Maatwebsite\Excel\Excel::CSV);
        Auth::logout();
        unlink($event->csv_path);
    }
}
