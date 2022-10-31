<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user = $user->exists ? $user : auth()->user();
        $total_works = count($user->works);
        $music_works = DB::table('works')
            ->where('user_id', $user->id)
            ->where('type', 'music')
            ->count();
        $painting_works = DB::table('works')
            ->where('user_id', $user->id)
            ->where('type', 'painting')
            ->count();
        $literature_works = DB::table('works')
            ->where('user_id', $user->id)
            ->where('type', 'literature')
            ->count();

        return view('users.show', compact('total_works', 'music_works',
            'painting_works', 'literature_works', 'user'));
    }

    public function edit()
    {
        $user = auth()->user();

        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female,other'],
        ]);

        $user->update($data);

        return redirect('/dashboard');
    }
}
