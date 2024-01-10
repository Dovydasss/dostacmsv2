@extends('layout.admin') {{-- Use your admin layout --}}

@section('content')
<div class="container mt-4">
    <h1>Site Settings</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($settings)
            <tr>
                <td>{{ $settings->title }}</td>
                <td>{{ $settings->description }}</td>
                <td>
                    @if($settings->icon)
                    <img src="{{ asset($pageSettings->icon) }}" alt="Page Icon" width="30" height="30">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.page-settings.edit', $settings->id) }}" class="btn btn-info">Edit</a>

                    {{-- Delete Button --}}
                    <form action="{{ route('admin.page-settings.destroy', $settings->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @else
            <tr>
                <td colspan="4">No settings found. <a href="{{ route('admin.page-settings.create') }}">Create new settings</a></td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection