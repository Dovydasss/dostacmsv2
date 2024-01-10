{{-- header.index.blade.php --}}
@extends('layout.admin')

@section('content')
<div class="container mt-4">
    <h1>Edit Header</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('header.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label for="header_image" class="form-label">Header Image</label>
            <input type="file" class="form-control" name="header_image" id="header_image">
            <div class="mt-3">

            @if(optional($header)->header_image)
                <img src="{{ asset($header->header_image) }}" alt="Header Image" style="max-width: 200px;">
            @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="width" class="form-label">Header Width (%)</label>
            <input type="text" class="form-control" name="width" id="width" value="{{ optional($header)->width ?? '100' }}">
        </div>

        <div class="mb-3">
            <label for="height" class="form-label">Header Height (%)</label>
            <input type="text" class="form-control" name="height" id="height" value="{{ optional($header)->height ?? '25' }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="show_header" id="show_header" {{ optional($header)->show_header ? 'checked' : '' }}>
            <label class="form-check-label" for="show_header">Show Header</label>
        </div>

        <button type="submit" class="btn btn-primary">Save Header</button>
    </form>
</div>
@endsection
