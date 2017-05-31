<?php

namespace App\Http\Middleware;
use App\P_Menu;
use App\Http\Controllers\Funciones;
use Closure;

class ValidaRuta
{
	use Funciones;
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $ruta)
	{
		$menu = P_Menu::where('ruta', $ruta)->first();
		if (count($menu) == 1) {
			$menus = $this->getIdsMenus();
			if (in_array($menu->id, $menus))
				return $next($request);
		}
		return redirect('sin_permiso');
	}
}
