<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\api\ReservasController;

class QrActivacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $datos;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reservasController = (new ReservasController);
        $reservasController->qrActivar($this->datos);
    }
}
