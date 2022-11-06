@extends('layouts.app')

@section('title', 'Editing "' . $work->title . '" – ' . config('app.name', 'Laravel'))

@section('content')
<div class="container">
    <div class="row">
        <h2 class="text-center">Editing "{{ $work->title }}"</h2>

        <form method="POST" action="/work/{{ $work->id }}/edit" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row mb-3">
                <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                <div class="col-md-6">
                    <input id="title"
                           type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           name="title"
                           value="{{ old('title', $work->title) }}"
                           autocomplete="title" autofocus>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="text" class="col-md-4 col-form-label text-md-end">{{ __('Text') }}</label>

                <div class="col-md-6">
                    <textarea id="text"
                           class="form-control @error('text') is-invalid @enderror"
                           name="text"
                           value="{{ old('text', $work->text) }}"
                           autocomplete="text" autofocus></textarea>

                    @error('text')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('Type of work') }}</label>

                <div class="col-md-6">
                    <select name="type" class="form-control form-select">
                        <option value="music" {{ old('type', $work->type) == 'music' ? 'selected' : '' }}>Music</option>
                        <option value="painting" {{ old('type', $work->type) == 'painting' ? 'selected' : '' }}>Painting</option>
                        <option value="literature" {{ old('type', $work->type) == 'literature' ? 'selected' : '' }}>Literature</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="attachment" class="col-md-4 col-form-label text-md-end">{{ __('Attachment') }}</label>

                <div class="col-md-6">
                    <input type="file"
                           class="form-control form-control-file"
                           id="attachment"
                           name="attachments[]"
                           accept=".pdf, .mp3, .png" multiple>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
