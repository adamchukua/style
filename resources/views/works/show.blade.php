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
            @can('create', \App\Models\Comment::class)
                <form action="">
                    @csrf

                    <input type="text">
                </form>
            @endcan

            @foreach($work->comments as $comment)
                {{ $comment->text }}<br>
            @endforeach
        </div>
    </div>
</div>
@endsection
