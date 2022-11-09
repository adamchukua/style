@extends('layouts.app')

@section('title', 'Experts – ' . config('app.name', 'Laravel'))

@section('content')
<div class="container">
    <div class="row">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Experts</h2>

            <a href="/admin/expert/create" class="btn btn-primary">Add Expert</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Number of reviews</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($experts as $expert)
                    <tr>
                        <th scope="row">{{ $expert->id }}</th>
                        <td>{{ $expert->user->getFullname($expert->user) }}</td>
                        <td>{{ $expert->type }}</td>
                        <td>{{ $expert->user->reviews()->first() != null ? $expert->user->reviews->count() : 0 }}</td>
                        <td><a href="/admin/expert/{{ $expert->id }}/edit" class="btn btn-secondary">Edit</a></td>
                        <td>
                            <form action="/admin/expert/{{ $expert->id }}/delete" method="POST">
                                @csrf

                                <button type="submit" class="btn btn-secondary">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    There are no experts...
                @endforelse
            </tbody>
        </table>

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $experts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
