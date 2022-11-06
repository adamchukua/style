@extends('layouts.app')

@section('title', 'Experts – ' . config('app.name', 'Laravel'))

@section('content')
<div class="container">
    <div class="row">
        <h1>Experts</h1>

        <a href="/admin/expert/create" class="btn btn-primary">Add Expert</a>

        <div class="experts-list">
            @forelse($experts as $expert)
                <div class="expert-list__item d-flex justify-content-between">
                    <p>{{ $expert->user->firstname }} {{ $expert->user->lastname }}</p>

                    <p>{{ $expert->type }}</p>

                    <p>{{ $expert->reviews != null ? $expert->reviews->count() : 0 }}</p>

                    <a href="/admin/expert/{{ $expert->id }}/edit" class="btn btn-secondary">Edit</a>

                    <form action="/admin/expert/{{ $expert->id }}/delete" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-secondary">Delete</button>
                    </form>
                </div>
            @empty
                There are no experts...
            @endforelse

            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{ $experts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
