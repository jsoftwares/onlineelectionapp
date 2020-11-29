<?php

namespace App\Jobs;

use App\Imports\AttendeeImportQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportAttendees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file,
        $event_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $event_id)
    {
        $this->file = $file;
        $this->event_id = $event_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Excel::import(new AttendeeImportQueue($this->event_id), 'public/data_upload/'. $this->file);
        unlink(storage_path('app/public/data_upload/'.$this->file));
    }
}
