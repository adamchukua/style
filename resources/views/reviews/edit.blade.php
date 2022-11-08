@extends('layouts.app')

@section('title', 'Editing review – ' . config('app.name', 'Laravel'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2 class="text-center">Editing review of "{{ $review->work->title }}"</h2>

        <form method="POST" action="/review/{{ $review->work->id }}/edit" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row mb-3">
                <label for="text" class="col-md-4 col-form-label text-md-end">{{ __('Text') }}</label>

                <div class="col-md-6">
                    <textarea id="text"
                              class="form-control @error('text') is-invalid @enderror"
                              name="text"
                              value="{{ old('text', $review->text) }}"
                              required autocomplete="text" autofocus maxlength="500"></textarea>

                    @error('text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="complexity" class="col-md-4 col-form-label text-md-end">{{ __('Complexity mark') }}</label>

                <div class="col-md-2">
                    <input id="complexity"
                           type="number"
                           min="1"
                           max="10"
                           class="form-control @error('complexity') is-invalid @enderror"
                           name="complexity"
                           value="{{ old('complexity', $review->complexity) }}"
                           required autocomplete="complexity" autofocus>

                    @error('complexity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="creativity" class="col-md-4 col-form-label text-md-end">{{ __('Creativity mark') }}</label>

                <div class="col-md-2">
                    <input id="creativity"
                           type="number"
                           min="1"
                           max="10"
                           class="form-control @error('creativity') is-invalid @enderror"
                           name="creativity"
                           value="{{ old('creativity', $review->creativity) }}"
                           required autocomplete="creativity" autofocus>

                    @error('creativity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="innovativeness" class="col-md-4 col-form-label text-md-end">{{ __('Innovativeness mark') }}</label>

                <div class="col-md-2">
                    <input id="innovativeness"
                           type="number"
                           min="1"
                           max="10"
                           class="form-control @error('innovativeness') is-invalid @enderror"
                           name="innovativeness"
                           value="{{ old('innovativeness', $review->innovativeness) }}"
                           required autocomplete="innovativeness" autofocus>

                    @error('innovativeness')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Edit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
