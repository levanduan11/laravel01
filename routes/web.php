<?php

use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;

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
    Route::patch('/profile/avatar',[AvatarController::class,'update'])->name('profile.avatar');
    Route::post('/profile/avatar/ai', [AvatarController::class,'generate'])->name('profile.avatar.ai');
});

require __DIR__ . '/auth.php';

