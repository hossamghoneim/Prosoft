<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class Permission
{
    /**
     * @throws \Exception
     */
    public function handle($request, Closure $next, $module, $permission)
    {
        // Check if the user has the required permission
       if ( !can($module, $permission) )
           throw new Exception("You don't have permission to access this module.", 403);

        return $next($request);
    }

}


