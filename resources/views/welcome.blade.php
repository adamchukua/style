@extends('layouts.app')

@section('content')
    <header class="header">
        <img src="/img/svg/logo-big.svg" alt="" class="header__title">
        <p class="header__subtitle">Music. Painting. Literature.</p>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="search">
                    <div class="d-flex justify-content-between align-items-center">
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

                <div class="works-list mt-4 row g-4">
                    @forelse($works as $work)
                            <div class="works-list-item col-3">
                                <a href="/work/{{ $work->id }}" class="link-unstyled ">
                                    <p class="works-list-item__type works-list-item__type--{{ $work->type }}">
                                        {{ $work->type }}
                                    </p>

                                    <p class="works-list-item__author">{{ $work->user->firstname }} {{ $work->user->lastnameFirstLetter($work->user) }}</p>

                                    <p class="works-list-item__title">{{ $work->title }}</p>
                                </a>

                                <p class="works-list-item__date">{{ $work->created_at }}</p>
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
            </div>
        </div>
    </div>
@endsection
