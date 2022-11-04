<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class WelcomeController extends Controller
{
    public function index()
    {
        // Sort by time by default
        $works = Work::orderBy('created_at', 'desc')->get();

        return view('welcome', compact('works'));
    }

    public function search(Request $request)
    {
        if ($request['name']) {
            $works = User::where(DB::raw("CONCAT(`firstname`, ' ', `lastname`)"), 'like', '%' . $request['name'] . '%')
                ->first()
                ->works();
        } else {
            $works = Work::select('*');
        }

        switch ($request['type']) {
            case 'all':
                break;

            case 'music':
                $works->where('type', 'music');
                break;

            case 'painting':
                $works->where('type', 'painting');
                break;

            case 'literature':
                $works->where('type', 'literature');
                break;
        }

        // Sort by time by default
        $works = $works->orderBy('created_at', 'desc');

        if ($request['sort'] == 'time') {
            // TODO: sort by rating
        }

        $works = $works->get();

        return view('welcome', compact('works'));
    }
}
