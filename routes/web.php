<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;

// function create_user_helper(...$names): void
// {
//     if (count($names) === 0) {
//         return;
//     }
//     collect($names)
//         ->whereNotNull()
//         ->map(fn (string $name) => [
//             'name' => $name,
//             'email' => str_replace(' ', '.', $name) . '@gmail.com',
//             'password' => '123'
//         ])
//         ->each(fn (User $user) => User::create($user));
// }
// function get_user_list(): array
// {
//     return DB::table('users')->get()->toArray();
// }
Route::get('/', function () {
    // $users = DB::table('users')->get()->toArray();
    // dd($users);
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::post('/profile/avatar/ai', [AvatarController::class, 'generate'])->name('profile.avatar.ai');
});
require __DIR__ . '/auth.php';
Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');

Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->user();
    $user = User::updateOrCreate(
        ['email' => $githubUser->getEmail()],
        [
            'name' => $githubUser->getName() ?? $githubUser->getNickname(),
            'password' => 'password',
        ]
);
    Auth::login($user);
    return redirect('/dashboard');
});
Route::middleware('auth')->group(function () {
    Route::resource('/ticket',TicketController::class);
});
