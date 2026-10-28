<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/penerima-kecamatan/{id_kec}', [HomeController::class, 'getPenerimaByKecamatan'])->name('api.penerima.kecamatan');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->intended('/admin/dashboard');
    }

    return view('admin.login');
})->name('login');

Route::get('/admin/login', function () {
    return redirect()->route('login');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'string'],
        'password' => ['required', 'string'],
    ], [
        'email.required' => 'Email atau username wajib diisi.',
        'password.required' => 'Kata sandi wajib diisi.',
    ]);

    // Percobaan otentikasi
    try {
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }
    } catch (Throwable $e) {
        // Fallback jika database belum dikonfigurasi
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi tidak sesuai.',
    ])->onlyInput('email');
})->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');
