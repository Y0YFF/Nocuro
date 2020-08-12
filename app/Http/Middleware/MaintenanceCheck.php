<?php

namespace App\Http\Middleware;

use Closure;

class MaintenanceCheck
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
        $request::setTrustedProxies([$request->getClientIp()], $request::HEADER_X_FORWARDED_ALL);

        $ip = $request->getClientIp();

        $allowIp = explode(',', config('app.maintenance_ip'));

        if(!empty($allowIp[0]) && !in_array($ip, $allowIp)){
            throw new HttpException(503);
        }
        
        return $next($request);
    }
}
