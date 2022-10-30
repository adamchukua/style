<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
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

        return view('dashboard', compact('user', 'total_works',
            'music_works', 'painting_works', 'literature_works'));
    }
}
