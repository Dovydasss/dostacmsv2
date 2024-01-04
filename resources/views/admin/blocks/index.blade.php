@extends('layout.admin')

@section('content')
<div class="container">
    <h1>Content Blocks</h1>
    <a href="{{ route('blocks.create') }}" class="btn btn-success mb-3">Create New Block</a>

    <table class="table">
        <thead>
            <tr>
                <th>Block ID</th>
                <th>Block title</th>
                <th>Page</th>
                <th>Type</th>
                <th>Content Preview</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blocks as $block)
                <tr>
                    <td>{{ $block->id }}</td>
                    <td>{{ $block->title }}</td>
                    <td>{{ $block->page->title }}</td>
                    <td>{{ $block->type }}</td>
                    <td>{{ Str::limit($block->content, 50) }}</td>
                    <td>
                        <a href="{{ route('blocks.edit', $block->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('blocks.destroy', $block->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
