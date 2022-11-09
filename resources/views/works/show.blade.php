@extends('layouts.app')

@section('title',  $work->title . ' – ' . $work->type . ' – ' . config('app.name', 'Laravel'))

@section('content')
<div class="container">
    <div class="row">
        <p class="work__type work__type--{{ $work->type }}">{{ $work->type }}</p>

        <div class="d-flex justify-content-between align-items-center">
            <h1 class="work__title">{{ $work->title }}</h1>

            @can('create', \App\Models\Review::class)
                @if(auth()->user()->expert->type == $work->type)

                    @php
                        $review = auth()->user()->reviews->where('work_id', $work->id)->first()
                    @endphp

                    @if($review)
                        <div class="d-flex">
                            <a href="/review/{{ $review->id }}/edit" class="btn btn-secondary me-2">Edit review</a>

                            <form method="POST" action="/review/{{ $review->id }}/delete">
                                @csrf

                                <button class="btn btn-secondary" type="submit">Delete review</button>
                            </form>
                        </div>
                    @else
                        <a href="/work/{{ $work->id }}/review/create" class="btn btn-secondary">Review this work</a>
                    @endif
                @endif
            @endcan
        </div>

        <a href="/user/{{ $work->user->id }}" class="work__author">
            {{ $work->user->firstname }} {{ $work->user->lastname }}
        </a>

        <p>{{ $work->text }}</p>

        <div class="attachments">
            @foreach($work->attachments as $attachment)
                <a href="/storage/{{ $attachment->path }}" class="link-unstyled">
                    <div class="attachments-item">
                        <img src="/img/svg/download.svg" class="attachments-item__img">

                        <p class="attachments-item__path">{{ $attachment->getFilename($attachment->path) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="reviews-list">
            @foreach($work->reviews as $review)
                @can('view', $review)
                    <div class="reviews-item">
                        <p class="reviews-item__name">{{ $review->user->firstname }} {{ $review->user->lastname }}</p>

                        <p class="reviews-item__text">{{ $review->text }}</p>

                        <p class="reviews-item__mark">Complexity: {{ $review->complexity }}/10</p>
                        <p class="reviews-item__mark">Creativity: {{ $review->creativity }}/10</p>
                        <p class="reviews-item__mark">Innovativeness: {{ $review->innovativeness }}/10</p>
                    </div>
                @endcan
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

            <div class="comments-list">
                @forelse($work->comments()->where('comment-response_id', null)->orderBy('created_at', 'desc')->get() as $comment)
                    <div class="comments-list-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="/user/{{ $comment->user->id }}" class="comments-list-item__name">
                                    {{ $comment->user->getFullname($comment->user) }}
                                </a>

                                <p class="role role--{{ $comment->user->getRoleName($comment->user) }}">
                                    {{ $comment->user->getRoleName($comment->user) }}
                                    {{ $comment->user->role == \App\Models\Role::EXPERT ? ' of ' . $comment->user->expert->type : '' }}
                                </p>
                            </div>

                            <p class="comments-list-item__time">{{ $comment->created_at }}</p>
                        </div>

                        <p class="comments-list-item__text">{{ $comment->text }}</p>

                        <answer-component work-id="{{ $work->id }}" comment-id="{{ $comment->id }}"></answer-component>

                        @foreach($work->comments()->where('comment-response_id', $comment->id)->orderBy('created_at', 'asc')->get() as $response)
                            <div class="comments-list-item ms-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <a href="/user/{{ $response->user->id }}" class="comments-list-item__name">
                                            {{ $response->user->getFullname($response->user) }}
                                        </a>

                                        <p class="role role--{{ $response->user->getRoleName($response->user) }}">
                                            {{ $response->user->getRoleName($response->user) }}
                                            {{ $response->user->role == \App\Models\Role::EXPERT ? ' of ' . $response->user->expert->type : '' }}
                                        </p>
                                    </div>

                                    <p class="comments-list-item__time">{{ $response->created_at }}</p>
                                </div>

                                <p class="comments-list-item__text">{{ $response->text }}</p>

                                <answer-component work-id="{{ $work->id }}" comment-id="{{ $comment->id }}"></answer-component>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="mt-3">There are no comments...</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
