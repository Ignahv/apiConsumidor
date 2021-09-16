<?php

namespace App\Jobs;

use App\Models\Tramite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public $timeout=120;
    protected $table;

    public function __construct(Tramite $table)
    {
        $this->table = $table;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $table = $this->table;

        $tramite_path = public_path($table->org_path);



    }
}
