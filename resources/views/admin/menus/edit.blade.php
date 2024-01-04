@extends('layout.admin')

@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-4">
    <h1>Edit Menu</h1>
    <form method="POST" action="{{ route('menus.update', $menu->id) }}" class="mt-4">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Menu Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $menu->name }}" required>
        </div>

        <div class="mb-3">
    <label for="pages" class="form-label">Pages</label>
    <select name="pages[]" id="pages" class="form-control" multiple>
        {{-- Loop through all pages and list them as options --}}
        @foreach($allPages as $page)
        <option value="{{ $page->id }}" {{ in_array($page->id, json_decode(old('pages', $menu->pages ?? '[]'), true)) ? 'selected' : '' }}>
            {{ $page->title }}
        </option>
        @endforeach
    </select>
</div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
@endsection