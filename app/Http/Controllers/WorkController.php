<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Work::class);

        return view('works.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', Work::class);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:1000'],
            'type' => ['required', 'in:music,painting,literature'],
            'attachments' => ['required', 'array'],
            'attachments.*' => ['required', 'mimes:pdf,mp3,png', 'max:15360'],
        ]);

        $workId = auth()->user()->works()->create($data)->id;

        foreach(request('attachments') as $attachment)
        {
            $attachment->storeAs('public/attachments', $attachment->getClientOriginalName());

            Attachment::create([
                'work_id' => $workId,
                'path' => 'attachments/' . $attachment->getClientOriginalName(),
            ]);
        }

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Work $work)
    {
        return view('works.show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Work $work)
    {
        $this->authorize('update', auth()->user());

        return view('works.edit', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Work $work)
    {
        $this->authorize('update', auth()->user());

        $data = $request->validate([
            'title' => ['string', 'max:255'],
            'text' => ['string', 'max:1000'],
            'type' => ['in:music,painting,literature'],
            'attachments' => ['array'],
            'attachments.*' => ['mimes:pdf,mp3,png', 'max:15360'],
        ]);

        $work->attachments->each->delete();
        $work->update($data);

        if ($request['attachments'])
        {
            foreach(request('attachments') as $attachment)
            {
                $attachment->storeAs('public/attachments', $attachment->getClientOriginalName());

                Attachment::create([
                    'work_id' => $work->id,
                    'path' => 'attachments/' . $attachment->getClientOriginalName(),
                ]);
            }
        }

        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Work $work)
    {
        $this->authorize('delete', $work);

        $work->delete();

        return redirect('/dashboard');
    }
}
