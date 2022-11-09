@extends('layouts.app')

@section('title', $user->firstname . ' ' . $user->lastname . ' – ' . config('app.name', 'Laravel'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="dashboard">
            <p class="role role--{{ $user->getRoleName($user) }}">
                {{ $user->getRoleName($user) }}
                {{ $user->role == \App\Models\Role::EXPERT ? ' of ' . $user->expert->type : '' }}
            </p>

            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ $user->firstname }} {{ $user->lastname }}</h1>

                @can('update', $user)
                    <div class="dashboard-manage">
                        @can('create', \App\Models\Work::class)
                            <a href="/work/create" class="btn btn-primary">New Work</a>
                        @else
                            <button class="btn disabled">New Work</button>
                        @endcan

                        <a href="/edit-profile" class="btn btn-primary">Edit Profile</a>
                    </div>
                @endcan
            </div>

            <div class="dashboard-info">
                <div class="dashboard-info-block dashboard-info-block--total">
                    Total works
                    <span class="dashboard-info-block__number">{{ $total_works }}</span>
                </div>

                <div class="dashboard-info-block dashboard-info-block--music">
                    Music
                    <span class="dashboard-info-block__number">{{ $music_works }}</span>
                </div>

                <div class="dashboard-info-block dashboard-info-block--painting">
                    Painting
                    <span class="dashboard-info-block__number">{{ $painting_works }}</span>
                </div>

                <div class="dashboard-info-block dashboard-info-block--literature">
                    Literature
                    <span class="dashboard-info-block__number">{{ $literature_works }}</span>
                </div>

                <div class="dashboard-info-block dashboard-info-block--comments">
                    Comments
                    <span class="dashboard-info-block__number">{{ $user->comments->count() }}</span>
                </div>

                @can('create', \App\Models\Review::class)
                    <div class="dashboard-info-block dashboard-info-block--reviews">
                        Reviews
                        <span class="dashboard-info-block__number">{{ $user->reviews->count() }}</span>
                    </div>
                @endcan
            </div>
        </div>

        <h2>Works</h2>

        <div class="works-list row">
            @forelse($works as $work)
                <div class="works-list-item col-3">
                    <div class="works-list-item-shadow">
                        <a href="/work/{{ $work->id }}" class="link-unstyled">
                            <p class="works-list-item__type works-list-item__type--{{ $work->type }}">
                                {{ $work->type }}
                            </p>

                            <p class="works-list-item__title">{{ $work->title }}</p>

                            <p class="works-list-item__date">{{ $work->created_at }}</p>
                        </a>

                        <div class="d-flex">
                            @can('update', $user)
                                <a href="/work/{{ $work->id }}/edit" class="btn btn-secondary me-3">Edit</a>
                            @endcan

                            @can('delete', $work)
                                <form action="/work/{{ $work->id }}/delete" method="POST">
                                    @csrf

                                    <button type="submit" class="btn btn-secondary">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                There are no works...
            @endforelse

            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{ $works->links() }}
                </div>
            </div>
        </div>

        @can('viewAny', \App\Models\Review::class)
            <h2>Reviews</h2>

            <div class="works-list">
                @forelse($user->reviews as $review)
                    @can('view', $review)
                        <div class="works-list__item">
                            <a href="/work/{{ $review->work->id }}">
                                <p>{{ $review->work->type }}</p>

                                <p>{{ $review->work->title }}</p>

                                <p>{{ $review->work->created_at }}</p>
                            </a>
                        </div>
                    @endcan
                @empty
                    There are no reviews...
                @endforelse

                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $works->links() }}
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>
@endsection
