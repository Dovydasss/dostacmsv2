@extends('layout.admin')

@section('content')
<div class="container">
    <h1>Edit Content Block</h1>

    <form action="{{ route('blocks.update', $block->id) }}" method="POST">
        @csrf
        @method('PUT')


        <div class="form-group">
            <label for="title">Block Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $block->title }}">
        </div>

        <div class="form-group">
            <label for="page_id">Select Page</label>
            <select name="page_id" id="page_id" class="form-control">
                @foreach($pages as $page)
                <option value="{{ $page->id }}" {{ $block->page_id == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type">Block Type</label>
            <select name="type" id="type" class="form-control">
                <option value="text" {{ $block->type == 'text' ? 'selected' : '' }}>Text</option>
                <option value="image" {{ $block->type == 'image' ? 'selected' : '' }}>Image</option>
                <!-- Add other types as needed -->
            </select>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="4">{{ $block->content }}</textarea>
        </div>

        <div class="form-group">
            <label for="order">Order</label>
            <input type="number" name="order" id="order" class="form-control" value="{{ $block->order }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Block</button>
    </form>
</div>
@endsection