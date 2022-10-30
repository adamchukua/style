@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="dashboard">
            <h1>Welcome, {{ $user->firstname }}</h1>

            <div class="dashboard-info">
                <div class="dashboard-info-block">
                    Total
                    <span class="dashboard-info-block__number">{{ $total_works }}</span>
                </div>

                <div class="dashboard-info-block">
                    Music
                    <span class="dashboard-info-block__number">{{ $music_works }}</span>
                </div>

                <div class="dashboard-info-block">
                    Painting
                    <span class="dashboard-info-block__number">{{ $painting_works }}</span>
                </div>

                <div class="dashboard-info-block">
                    Literature
                    <span class="dashboard-info-block__number">{{ $literature_works }}</span>
                </div>
            </div>

            <div class="dashboard-manage">
                <a href="/work/create" class="btn btn-primary">New Work</a>
                <a href="/user/edit" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>

        <h2>Works</h2>

        <div class="works-list">
            @foreach($user->works as $work)
                <div class="works-list__item">
                    <a href="/work/{{ $work->id }}">
                        <p>{{ $work->type }}</p>

                        <p>{{ $work->title }}</p>

                        <p>{{ $work->created_at }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
