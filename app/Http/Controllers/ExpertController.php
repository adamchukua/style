<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ExpertController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Expert::class);

        $experts = Expert::all();

        return view('experts.index', compact('experts'));
    }

    public function create()
    {
        $this->authorize('create', Expert::class);

        $countries = DB::table('countries')->get();

        return view('experts.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Expert::class);

        $user_data = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female,other'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $expert_data = $request->validate([
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'type' => ['required', 'in:music,painting,literature'],
            'nationality' => ['required', 'string', 'max:60'],
        ]);

        $user_data['password'] = bcrypt($user_data['password']);
        $user_id = User::create(array_merge($user_data, [
            'role' => Role::EXPERT,
        ]))->id;

        Expert::create(array_merge($expert_data, [
            'user_id' => $user_id,
        ]));

        return redirect('/admin/experts');
    }

    public function edit(Expert $expert)
    {
        $this->authorize('update', $expert);

        $countries = DB::table('countries')->get();

        return view('experts.edit', compact('countries', 'expert'));
    }

    public function update(Request $request, Expert $expert)
    {
        $this->authorize('update', $expert);

        $user_data = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female,other'],
        ]);

        $expert_data = $request->validate([
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'type' => ['required', 'in:music,painting,literature'],
            'nationality' => ['required', 'string', 'max:60'],
        ]);

        $expert->user()->update($user_data);
        $expert->update($expert_data);

        return redirect('/admin/experts');
    }
}
