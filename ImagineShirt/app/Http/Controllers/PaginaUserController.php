<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Categorias;
use App\Models\Precos;
use App\Models\Cores;
use App\Models\TShirts;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Encomendas;
use App\Models\ItensEncomenda;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class PaginaUserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(): View
    {   
        $user = Auth::user();

        if($user->user_type == 'A'){

            $tipoUser = 'Administrador';

            $numencomendas = Encomendas::count();

            $numutilizadores = User::whereNull('deleted_at')->count();

            $numCategorias = Categorias::whereNull('deleted_at')->count();

            $numCores = Cores::whereNull('deleted_at')->count();
            
            return view('administradores.index',compact('user','tipoUser','numencomendas','numutilizadores','numCategorias','numCores'));
        }

        if($user->user_type == 'E'){
            
            $tipoUser = 'Funcionário';

            $numencomendas = Encomendas::where('status','=','pending')->orwhere('status','=','paid')->count();

            return view('funcionarios.index',compact('user','tipoUser','numencomendas'));
        }

        if($user->user_type == 'C'){

            $tipoUser = 'Cliente';

            $numencomendas = Encomendas::where('customer_id', '=', $user->id)->count();

            $numTshirts = TShirts::whereNull('deleted_at')->where('customer_id', '=', $user->id)->count();
            
            return view('clientes.index',compact('user','tipoUser','numencomendas', 'numTshirts'));
        }
    }

    public function edit(User $user): View{

        if($user->user_type == 'A'){
            $tipoUser = 'Administrador';
            return view('administradores.edit',compact('user','tipoUser'));
        }

        if($user->user_type == 'E'){
            $tipoUser = 'Funcionário';
            return view('funcionarios.edit',compact('user','tipoUser'));
        }

        if($user->user_type == 'C'){
            $tipoUser = 'Cliente';
            return view('clientes.edit',compact('user','tipoUser'));
        }
        
    }

    public function update(UserRequest $request, User $user): RedirectResponse{
        
        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $user, $request) {

            $user->name = $formData['name'];
            // enviar email de confirmação se for diferente - TODO
            $user->email = $formData['email'];
            
            if (Auth::user()->user_type == 'A'){
                $user->user_type = $formData['userType'];
            }
            
            $user->save();

            if ($user->user_type === 'C'){
                $cliente = $user->cliente;
                $cliente->nif = $formData['nif'];
                $cliente->address = $formData['name'];
                $cliente->default_payment_type = $formData['default_payment_type'];
                $cliente->default_payment_ref = $formData['default_payment_ref'];
                $cliente->save();
            }

            if ($request->hasFile('image')) {
                if ($user->photo_url) {
                    Storage::delete('public/photos/' . $user->photo_url);
                }
                $path = $request->image->store('public/photos');
                $user->photo_url = basename($path);
                $user->save();
            }

            return $user;
        });

        $tipoUser = self::getTipoUser($user);

        $htmlMessage = "O $tipoUser $user->name foi alterado com sucesso!";
        
        Alert::success('Editado com sucesso!', $htmlMessage);
        
        return Auth::user()->id == $user->id ? redirect()->route('user', $user) : redirect()->route('user.gerirUsers', Auth::user());
    }

    public function destroy_foto(User $user): RedirectResponse
    {
        if ($user->photo_url) {
            Storage::delete('public/photos/' . $user->photo_url);
            $user->photo_url = null;
            $user->save();
        }

        $tipoUser = self::getTipoUser($user);

        $htmlMessage = "A foto do $tipoUser $user->name foi eliminada!";

        Alert::success('Eliminada com sucesso!', $htmlMessage);

        return Auth::user() == $user ? redirect()->route('user', $user) : redirect()->route('user.gerirUsers', Auth::user());
    }

    public function showEncomendas(User $user): View{
        
        if($user->user_type == 'A'){

            $encomendas = Encomendas::select('orders.id','orders.status','orders.date','orders.total_price','users.name','users.email')
            ->leftJoin('customers','customer_id','=','customers.id')
            ->leftJoin('users','customers.id','=','users.id')
            ->orderByDesc('date')->paginate(15);
            
            return view('users.shared.fields_encomendas',compact('user','encomendas'));
        }

        if($user->user_type == 'E'){

            $encomendas = Encomendas::select('orders.id','orders.status','orders.date','orders.total_price','users.name','users.email')
            ->where('status','=','pending')->orwhere('status','=','paid')->join('customers','orders.customer_id','=','customers.id')
            ->join('users','customers.id','=','users.id')
            ->orderByDesc('date')->paginate(15);

            return view('users.shared.fields_encomendas',compact('user','encomendas'));
        }

        if($user->user_type == 'C'){

            $encomendas = Encomendas::where('customer_id', '=', $user->id)->orderByDesc('date')->paginate(15);

            return view('users.shared.fields_encomendas',compact('user','encomendas'));
        }
    }

    public function showUsers(User $user): View{

        $utilizadores = User::whereNull('deleted_at')->orderByDesc('user_type')->paginate(15);

        return view('administradores.users', compact('user','utilizadores'));
    }

    public function showMinhasTShirts(User $user): View{

        $t_shirts = TShirts::whereNull('deleted_at')->where('customer_id', '=', $user->id)->orderBy('created_at')->paginate(15);

        return view('clientes.minhasTshirts', compact('user', 't_shirts'));
    }

    public function updateStatusBlock (Request $request, User $user): RedirectResponse{

        $blocked = $user->blocked;
        $user->blocked = $request->blocked;
        $user->save();

        $tipoUser = self::getTipoUser($user);

        if ($blocked){
            $htmlMessage = "A conta do $tipoUser $user->name foi desbloqueada!";
            Alert::success('Desbloqueado com sucesso!', $htmlMessage);
        }else{
            $htmlMessage = "A conta do $tipoUser $user->name foi bloqueada!";
            Alert::success('Bloqueada com sucesso!', $htmlMessage);
        }

        return Auth::user() == $user ? redirect()->route('user', $user) : redirect()->route('user.gerirUsers', Auth::user());
    }

    public function destroy_user (User $user): RedirectResponse{

        $user->delete();

        $tipoUser = self::getTipoUser($user);

        $htmlMessage = "A conta do $tipoUser $user->name foi eliminada!";

        Alert::success('Eliminada com sucesso!', $htmlMessage);

        return Auth::user() == $user ? redirect()->route('user', $user) : redirect()->route('user.gerirUsers', Auth::user());
    }

    public function create(): View{

        $user = new User();
        return view('users.create', compact('user'));
    }

    public function store(UserRequest $request): RedirectResponse{

        $formData = $request->validated();
        $user = DB::transaction(function() use ($formData, $request){

            $newUser = new User();

            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->user_type = $formData['userType'];
            $newUser->blocked = '0';
            //password
            $newUser->password = Hash::make($formData['password']);

            if ($request->hasFile('image')){
                $path = $request->image->store('public/photos/');
                $newUser->photo_url = basename($path);  
            }

            $newUser->save();
            return $newUser;
        });

        $tipoUser = self::getTipoUser($user);

        $htmlMessage = "A conta do $tipoUser $user->name foi criada!";

        Alert::success('Criada com sucesso!', $htmlMessage);

        return redirect()->route('user.gerirUsers', Auth::user());
    }

    public function estatisticas(User $user): View
    {
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

        $usersNovos = User::whereNull('deleted_at')->orderBy('created_at', 'desc')->take(6)->get();

        $tshirtsvendidas = ItensEncomenda::join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
        ->select('tshirt_images.name','tshirt_images.image_url', 'order_items.tshirt_image_id', DB::raw('COUNT(*) as numtshirtsvendidas'))
        ->groupBy('order_items.tshirt_image_id', 'tshirt_images.name')
        ->whereNull('customer_id')
        ->orderByDesc('numtshirtsvendidas')
        ->take(6)
        ->get();

        return view('administradores.estatisticas', compact('user','orderNum','clientCount','totalSumMes','totalSumAno','earningsData','clientData','usersNovos','tshirtsvendidas'));
    }

    // tem de ser sempre a ultima 

    private function getTipoUser(User $user){

        switch($user->user_type){
            case 'C': 
                $tipoUser = "Cliente"; 
                break;
            case 'A':
                $tipoUser = "Administrador";
                break;
            case 'E':
                $tipoUser = "Funcionário";
                break;
        }

        return $tipoUser;
    }
}
