@extends('layout.admin')

@section('content')
<div class="container">
    <h1>Create Content Block</h1>

    <form action="{{ route('blocks.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Block Title</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>

        <div class="form-group">
            <label for="page_id">Select Page</label>
            <select name="page_id" id="page_id" class="form-control">
                @foreach($pages as $page)
                <option value="{{ $page->id }}">{{ $page->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type">Block Type</label>
            <select name="type" id="type" class="form-control">
                <option value="text">Text</option>
                <option value="image">Image</option>
                <!-- Add other types as needed -->
            </select>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="order">Order</label>
            <input type="number" name="order" id="order" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Create Block</button>
    </form>
</div>
@endsection