<?php

namespace App\Jobs;

use App\Events\ImportProductEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessImportableFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $shop_type;
    protected $user_id;
    protected $enable_price_override;
    protected $csv_path;
    protected $headings;
    protected $isUpdate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($importable, $headings)
    {
        $this->shop_type = $importable['shop_type'];
        $this->enable_price_override = $importable['enable_price_override'];
        $this->user_id = $importable['user_id'];
        $this->csv_path = $importable['csv_path'];
        $this->headings = $headings;
        $this->isUpdate = isset($importable['is_update']) ? true : false;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $start = microtime(true);
        event(new ImportProductEvent($this->shop_type, $this->enable_price_override, $this->user_id, $this->isUpdate, $this->csv_path, $this->headings));
        $end = microtime(true) - $start;
        Log::info("This script took $end second to execute.");
    }
}
