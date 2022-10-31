@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <span>{{ $work->type }}</span>

        <h1>{{ $work->title }}</h1>

        <a href="/user/{{ $work->user->id }}">{{ $work->user->firstname }} {{ $work->user->lastname }}</a>

        <p>{{ $work->text }}</p>

        <div class="attachments">
            @foreach($work->attachments as $attachment)
                <a href="/storage/{{ $attachment->path }}">
                    <div class="attachments-item">
                        <img src="/img/svg/download.svg" class="attachments-item__img">
                        <p>{{ $attachment->getFilename($attachment->path) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <h2>Comments</h2>

        <div class="comments">
            <form action="/work/{{ $work->id }}/comment/create" method="POST">
                @csrf

                <div class="input-group">
                    <input type="text" name="text" class="form-control" placeholder="Your comment..." aria-label="Your comment..." required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Comment</button>
                    </div>
                </div>
            </form>

            @foreach($work->comments as $comment)
                {{ $comment->text }}<br>
            @endforeach
        </div>
    </div>
</div>
@endsection
