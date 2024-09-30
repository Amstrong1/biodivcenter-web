<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show()
    {
        $user = User::where('id', request('id'))
            ->select('id', 'name', 'email', 'organization', 'contact', 'picture', 'role', 'ong_id')
            ->get()
            ->append('role_label')
            ->append('country');
        return response()->json($user, 200);
    }

    public function update()
    {
        $user = User::find(request('id'));
        $data = request()->all();
        if (request()->hasFile('picture')) {
            $name = $user['slug'] . '_user.' . request()->picture->extension();
            $data['picture'] = request()->picture->storeAs('user', $name, 'public');

            if ($user->picture) {
                Storage::delete($user->picture);
            }
        }

        $user->update($data);
        return response()->json(200);
    }
}
