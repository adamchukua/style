@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1>Experts</h1>

        <a href="/admin/expert/create" class="btn btn-primary">Add Expert</a>

        <div class="experts-list">
            @foreach($experts as $expert)
                <div class="expert-list__item d-flex justify-content-between">
                    <p>{{ $expert->user->firstname }} {{ $expert->user->lastname }}</p>

                    <p>{{ $expert->type }}</p>

                    <a href="/admin/expert/{{ $expert->id }}/edit" class="btn btn-secondary">Edit</a>

                    <a href="/admin/expert/{{ $expert->id }}/delete" class="btn btn-secondary">Delete</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
