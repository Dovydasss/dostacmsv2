@extends('layout.admin')

@section('content')
<div class="container mt-4">
    <h1>Edit Footer</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('footer.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <div class="mb-3">
            <label for="footer_text" class="form-label">Footer Text</label>
            <textarea class="form-control" name="footer_text" id="footer_text" rows="3">{{ $footer->footer_text }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
