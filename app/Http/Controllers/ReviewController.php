<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Work;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Work $work)
    {
        $this->authorize('create', Review::class);

        if ($work->type != auth()->user()->expert->type) {
            abort(403);
        }

        return view('reviews.create', compact('work'));
    }

    public function store(Work $work, Request $request)
    {
        $this->authorize('create', Review::class);

        $user = auth()->user();
        if ($work->type != $user->expert->type) {
            abort(403);
        }

        $data = $request->validate([
            'text' => ['required', 'string', 'max:500'],
            'complexity' => ['required', 'numeric', 'min:1', 'max:10'],
            'creativity' => ['required', 'numeric', 'min:1', 'max:10'],
            'innovativeness' => ['required', 'numeric', 'min:1', 'max:10'],
        ]);

        $user->reviews()->create(array_merge($data, [
            'work_id' => $work->id
        ]));

        return redirect('/work/' . $work->id);
    }

    public function edit(Review $review)
    {
        $this->authorize('update', $review);

        if ($review->work->type != auth()->user()->expert->type) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Review $review, Request $request)
    {
        $this->authorize('create', $review);

        $user = auth()->user();
        if ($review->work->type != $user->expert->type) {
            abort(403);
        }

        $data = $request->validate([
            'text' => ['required', 'string', 'max:500'],
            'complexity' => ['required', 'numeric', 'min:1', 'max:10'],
            'creativity' => ['required', 'numeric', 'min:1', 'max:10'],
            'innovativeness' => ['required', 'numeric', 'min:1', 'max:10'],
        ]);

        $review->update($data);

        return redirect('/work/' . $review->work->id);
    }

    public function delete(Review $review)
    {
        $this->authorize('delete', $review);

        $user = auth()->user();
        if ($review->work->type != $user->expert->type) {
            abort(403);
        }

        $review->delete();

        return redirect('/work/' . $review->work->id);
    }
}
