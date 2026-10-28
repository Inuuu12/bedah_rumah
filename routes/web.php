<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/penerima-kecamatan/{id_kec}', [HomeController::class, 'getPenerimaByKecamatan'])->name('api.penerima.kecamatan');

// Authentication Routes
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('admin.login');
})->name('login');

Route::get('/admin/login', function () {
    return redirect()->route('login');
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'string'],
        'password' => ['required', 'string'],
    ], [
        'email.required' => 'Email atau username wajib diisi.',
        'password.required' => 'Kata sandi wajib diisi.',
    ]);

    $loginInput = trim($request->input('email'));
    $password = $request->input('password');
    $remember = $request->boolean('remember');

    // 1. Cek jika input adalah admin default (menerima 'admin', 'admin123', dsb)
    $isAdminInput = in_array(strtolower($loginInput), ['admin', 'admin@bogorkab.go.id']);
    if ($isAdminInput && in_array($password, ['admin', 'admin123', 'admin#123', 'password', '123456'])) {
        $user = User::firstOrCreate(
            ['email' => 'admin@bogorkab.go.id'],
            [
                'name' => 'Administrator Pemkab Bogor',
                'password' => Hash::make($password),
            ]
        );

        $user->password = Hash::make($password);
        $user->save();

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // 2. Cek otentikasi standar Laravel via tabel users
    $email = $isAdminInput ? 'admin@bogorkab.go.id' : $loginInput;
    if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // 3. Fallback: cek ke tabel bawaan legacy app_md_user
    $legacyUser = DB::table('app_md_user')
        ->where('login_user', $loginInput)
        ->where('flag_del', 0)
        ->where(function ($q) use ($password) {
            $q->where('pswd', md5($password))
                ->orWhere('pswd', $password);
        })
        ->first();

    // Izinkan juga jika user kecamatan mencoba password umum
    if (! $legacyUser && in_array($password, ['admin', 'admin123', '123456'])) {
        $legacyUser = DB::table('app_md_user')
            ->where('login_user', $loginInput)
            ->where('flag_del', 0)
            ->first();
    }

    if ($legacyUser) {
        $user = User::firstOrCreate(
            ['email' => $legacyUser->login_user.'@bogorkab.go.id'],
            [
                'name' => $legacyUser->name_user,
                'password' => Hash::make($password),
            ]
        );

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'email' => 'Email/Username atau kata sandi tidak cocok. Gunakan username "admin" dan password "admin123" atau "admin".',
    ])->onlyInput('email');
})->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
})->name('logout');

// Protected Admin Panel Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/bnba', [AdminController::class, 'bnba'])->name('bnba');
    Route::get('/bnba/{id}', [AdminController::class, 'bnbaDetail'])->name('bnba.detail');
    Route::post('/bnba/{id}/status', [AdminController::class, 'bnbaUpdateStatus'])->name('bnba.status');
    Route::get('/wilayah', [AdminController::class, 'wilayah'])->name('wilayah');
});
