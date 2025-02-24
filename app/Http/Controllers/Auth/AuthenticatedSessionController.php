<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        // Tambahkan logika pencatatan IP
        $ip = $request->ip(); // Ambil IP user
        Session::put('ip_address', $ip); // Simpan ke session

        // Cek apakah koordinat IP sudah ada di cache
        $cacheKey = "user_location_{$ip}";
        if (!Cache::has($cacheKey)) {
            $response = Http::get("http://ip-api.com/json/{$ip}")->json();

            if ($response && $response['status'] === 'success') {
                Cache::put($cacheKey, [
                    'lat' => $response['lat'],
                    'lon' => $response['lon'],
                ], now()->addDay()); // Simpan ke cache selama 24 jam
            }
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
