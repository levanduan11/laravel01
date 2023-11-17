<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateAvatarRequest;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request)
    {
        $path = $request
            ->file('avatar')
            ->store('avatars', 'public');

        $path = Storage::disk('public')
            ->put('avatars', $request->file('avatar'));

        $userData = User::find(auth()->user()->id);
        if ($old_avatar = $userData->avatar) {
            Storage::disk('public')->delete($old_avatar);
        }
        $userData->avatar = $path;
        $userData->save();
        return redirect('/profile')
            ->with('message', 'Avatar is changed.');
    }
    public function generate()
    {
        $res = OpenAI::images()->create([
            'prompt' => 'create avatar for user login',
            'n' => 1,
            'size' => '256x256',
        ]);
        $content = file_get_contents($res->data[0]->url);
        $file_name = Str::random(25);
        Storage::disk('public')->put("avatars/$file_name.jpg", $content);
        $user = User::find(auth()->user()->id);
        $message = 'Avatar is changed.';
        if ($user) {
            $user->avatar = "";
            $user->save();
        } else {
            $message = 'Avatar can not change.';
        }
        return redirect('profile')->with('message', $message);
    }
}
