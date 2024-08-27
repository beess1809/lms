<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\Menu;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function employeeLoginSubmit(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            $user = Auth::guard('employee')->user();
            $role_ids = [];
            foreach ($user->roles as $role) {
                $role_ids[] = $role->id;
            };
            $menus = $this->getMenus($role_ids, null);
            $request->session()->put('menus', $menus);

            return redirect()->intended('/home');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    private function getMenus($role_ids, $menu_id)
    {
        $query = Menu::whereIn('id', function ($query) use ($role_ids) {
            $query->select('menu_id')->from('menu_role')
                ->whereIn('role_id', $role_ids);
        });
        if ($menu_id === null) {
            $query->whereNull('menu_id');
        } else {
            $query->where('menu_id', '=', $menu_id);
        }
        $menus = $query->get();

        foreach ($menus as $key => $menu) {
            $childs = $this->getMenus($role_ids, $menu->id);
            $menus[$key]->menus = $childs;
        }

        return $menus;
    }

    public function auth($url)
    {
        $param = base64_decode($url);
        $json = openssl_decrypt($param, "AES-128-ECB", 'keypasswordsangatrahasia');

        $decode = json_decode($json);

        if (Auth::guard('employee')->loginUsingId($decode->uuid, false)); {
            $user = Auth::guard('employee')->user();
            $role_ids = [];
            foreach ($user->roles as $role) {
                $role_ids[] = $role->id;
            };
            $menus = $this->getMenus($role_ids, null);
            session()->put('menus', $menus);
            session()->put('trainer', $decode->trainer);

            return redirect()->intended('/dashboard');
        }
    }
    public function redirect()
    {
        return Redirect::to(env('PHINTER'));
    }
}
