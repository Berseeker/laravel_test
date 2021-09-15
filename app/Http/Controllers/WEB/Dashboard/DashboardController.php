<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $url = config('app.url');

        //dd(session('sanctum-token'));
 
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('sanctum-token')
        ])->get($url.'/api/empresas');

        $result = $response->json();

        $status = NULL;
        $message = NULL;
        
        if($result['code'] == 401)
        {
            $status = 'error';
            $message = 'Usuario no authenticado';
        }

        $status = $result['status'];
        $message = $result['message'];
        $empresas = paginate($result['data']);

        $url = config('app.url');
        $empresas->setPath($url.'/home');


        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('sanctum-token')
        ])->get($url.'/api/empleados');

        $result = $response->json();

        $empleados = paginate($result['data']);
        $empleados->setPath($url.'/home');
       

        return view('home',[
            'empresas' => $empresas,
            'empleados' => $empleados
        ]);
    }
}

function paginate($items, $perPage = 5, $page = null, $options = [])
{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}

