<?php

namespace App\Http\Middleware;

use App\P_Notificacion;
use App\Rel_Usuario_Sector;
use Closure;

class VerificarNotificaciones
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        (\Auth::user());
        if (null !== \Auth::user()) {
            if (\Auth::user()->id_tipo_usuario == 2) {
                // DGI
                $sectores           = array();

                $rel_usuario_sector = \Auth::user()->sectores()->get();
                foreach ($rel_usuario_sector as $value) {
                    array_push($sectores, $value->id);
                }
                $notificaciones = P_Notificacion::whereIn('id_sector', $sectores)
                    ->latest()
                    ->limit(5)
                    ->get();
            } else {
                // DEPENDENCIA
                $notificaciones = P_Notificacion::where('id_usuario_destino', '=', \Auth::user()->id)
                    ->latest()
                    ->limit(5)
                    ->get();
            }
            session(['notificaciones' => $notificaciones]);
        }

        return $next($request);
    }
}
