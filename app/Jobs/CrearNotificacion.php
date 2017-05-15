<?php

namespace App\Jobs;

use App\P_Notificacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CrearNotificacion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $destino, $envio, $sector, $detalle;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($destino=null, $envio=null, $sector=null, $detalle=null)
    {
        //
        $this->destino  = $destino;
        $this->envio    = $envio;
        $this->sector   = $sector;
        $this->detalle = $detalle;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $notificacion                       = new P_Notificacion;
            $notificacion->id_usuario_destino   = ($this->destino) ? $this->destino : null;
            $notificacion->id_usuario_envio     = ($this->envio) ? $this->envio : null;
            $notificacion->id_sector            = ($this->sector) ? $this->sector : null;
            $notificacion->detalle_notificacion = ($this->detalle) ? $this->detalle : null;
            $notificacion->bleido               = 0;
            $notificacion->save();
        } catch (Exception $e) {
            return $e;
        }

    }
}
