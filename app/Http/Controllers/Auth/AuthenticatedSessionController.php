<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use App\Models\Article;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        $user = User::all();
        $blog = Blog::all();
        $article = Article::all();
        return view('dashboard', compact('user','article','blog'));
    }


    public function profile()
    {
        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        $user_update = User::where('id', Auth::user()->id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $notification = array(
            'message' => 'Profile updated successfully',
            'alert-type' => 'success'
        );

        return Redirect()->route('login')->with($notification);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if($token = auth()->guard('api')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){

			User::where('id', auth()->guard('api')->user()->id)->update([
				'auth_token' => $token
			]);
		}

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
