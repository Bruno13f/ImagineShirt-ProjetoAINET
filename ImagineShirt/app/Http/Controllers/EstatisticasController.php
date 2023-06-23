<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Encomendas;
use App\Models\User;
use App\Models\ItensEncomenda;
use Auth;

class EstatisticasController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(): View{

        $user = Auth::user();

        $totalSumAno = Encomendas::where('date', '>=', Encomendas::raw('DATE_SUB(CURDATE(), INTERVAL 1 YEAR)'))
        ->whereIn('status', ['closed', 'paid'])
        ->sum('total_price');

        $totalSumMes = Encomendas::where('date', '>=', Encomendas::raw('DATE_SUB(CURDATE(), INTERVAL 1 MONTH)'))
        ->whereIn('status', ['closed', 'paid'])
        ->sum('total_price');

        $clientCount = User::where('user_type', 'C')
        ->whereNull('deleted_at')
        ->count();

        $orderNum = Encomendas::whereIn('status', ['closed', 'paid'])->count();

        $earningsData = Encomendas::selectRaw('DATE_FORMAT(date, "%Y-%m") AS month, SUM(total_price) AS earnings')
        ->where('date', '>=', Encomendas::raw('DATE_SUB(CURDATE(), INTERVAL 12 MONTH)'))
        ->whereIn('status', ['closed', 'paid'])
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $clientCount = User::where('user_type', 'C')->whereNull('deleted_at')->count();
        $adminCount = User::where('user_type', 'A')->whereNull('deleted_at')->count();
        $employeeCount = User::where('user_type', 'E')->whereNull('deleted_at')->count();

        $totalCount = $clientCount + $adminCount + $employeeCount;
        $clientPercentage = round(($clientCount / $totalCount) * 100, 2);
        $adminPercentage = round(($adminCount / $totalCount) * 100, 2);
        $employeePercentage = round(($employeeCount / $totalCount) * 100, 2);

        $clientData = [
            ['label' => 'Clientes', 'percentage' => $clientPercentage],
            ['label' => 'Administradores', 'percentage' => $adminPercentage],
            ['label' => 'Funcionários', 'percentage' => $employeePercentage],
        ];

        $usersNovos = User::whereNull('deleted_at')->orderBy('created_at', 'desc')->take(7)->get();

        $tshirtsvendidas = ItensEncomenda::select('tshirt_images.name','tshirt_images.image_url', 'order_items.tshirt_image_id')
        ->join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
        ->whereNull('tshirt_images.deleted_at')
        ->whereNull('tshirt_images.customer_id')
        ->groupBy('tshirt_image_id')
        ->orderByRaw('SUM(qty) DESC')
        ->take(5)
        ->get();

        return view('estatisticas.index', compact('user','orderNum','clientCount','totalSumMes','totalSumAno','earningsData','clientData','usersNovos','tshirtsvendidas'));
    }

}
