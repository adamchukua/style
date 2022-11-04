@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <header>
                    <h1 class="header__title">Style</h1>
                    <p class="header__subtitle">Music. Painting. Literature.</p>
                </header>

                <div class="search">
                    <div class="d-flex justify-content-between">
                        <h2>Explore the works</h2>

                        <search-input-component></search-input-component>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="search-filters">
                            <a
                                class="btn {{ request()->type == 'all' ? 'btn-secondary' : 'btn-primary' }}"
                                href="/search?type=all{{ request()->sort ? '&sort=' . request()->sort : '' }}">
                                All
                            </a>

                            <a
                                class="btn {{ request()->type == 'music' ? 'btn-secondary' : 'btn-primary' }}"
                                href="/search?type=music{{ request()->sort ? '&sort=' . request()->sort : '' }}">
                                Music
                            </a>

                            <a
                                class="btn {{ request()->type == 'painting' ? 'btn-secondary' : 'btn-primary' }}"
                                href="/search?type=painting{{ request()->sort ? '&sort=' . request()->sort : '' }}">
                                Painting
                            </a>

                            <a
                                class="btn {{ request()->type == 'literature' ? 'btn-secondary' : 'btn-primary' }}"
                                href="/search?type=literature{{ request()->sort ? '&sort=' . request()->sort : '' }}">
                                Literature
                            </a>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Sort by:
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                   href="/search?sort=time{{ request()->type ? '&type=' . request()->type : '' }}">
                                    time
                                </a>

                                <a class="dropdown-item"
                                   href="/search?sort=rating{{ request()->type ? '&type=' . request()->type : '' }}">
                                    rating
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="works-list">
                    @foreach($works as $work)
                        <div class="works-list__item">
                            <a href="/work/{{ $work->id }}">
                                <p>{{ $work->user->firstname }} {{ $work->user->lastnameFirstLetter($work->user) }}</p>

                                <p>{{ $work->type }}</p>

                                <p>{{ $work->title }}</p>

                                <p>{{ $work->created_at }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
