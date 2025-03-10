<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class NormalizeDatatablesSearchAndFilterRequests
{

    public function handle($request, Closure $next)
    {
        // if the current route index ( where datatable exists ) and request is ajax ( requested from datatable )
        if ( str_ends_with(Route::currentRouteName(), '.index') && $request->ajax() ){

            if ( is_array(request()->input('search')) ) // handle general search
                request()->merge(['search' => request()->input('search')['value']]);


            if ( is_array(request()->input('columns')) ) { // handle filters

                $filtered = array_reduce(request()->input('columns'), function($result, $column) {
                    if (!is_null($column['name']) && $column['search']['value'] !== 'all') {
                        $result[$column['name']] = $column['search']['value'];
                    }
                    return $result;
                }, []);

                request()->merge($filtered);
            }
        }

        return $next($request);
    }
}
