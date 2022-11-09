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
        $works = Work::orderBy('created_at', 'desc')->paginate(10);

        return view('welcome', compact('works'));
    }

    public function search(Request $request)
    {
        if ($request['name']) {
            $works = User::where(DB::raw("CONCAT(`firstname`, ' ', `lastname`)"), 'like', '%' . $request['name'] . '%')
                ->first()
                ->works();
        } else {
            $works = Work::select(DB::raw('`works`.`title`, `works`.`text`, `works`.`type`, `works`.`created_at`, `works`.`user_id`, `works`.`id`'));
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

        switch ($request['sort'])
        {
            case 'time':
                $works = $works->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $works = $works
                    ->addSelect(DB::raw('SUM(`reviews`.`complexity` + `reviews`.`creativity` + `reviews`.`innovativeness`) as mark'))
                    ->join('reviews', 'works.id', '=', 'reviews.work_id')
                    ->groupBy('works.title')
                    ->orderBy('mark', 'desc');
                break;
        }

        $works = $works->paginate(10);

        return view('welcome', compact('works'));
    }
}
