@extends('layout.admin')

@section('content')
<div class="container mt-4">
    <h1>Color Settings</h1>



    <form action="{{ url('admin/colors') }}" method="POST">
        @csrf
        <!-- Color Picker for Menu Background -->
        <div class="mb-3">
            <label for="menuBackgroundColor" class="form-label">Menu Background Color:</label>
<input type="color" class="form-control" name="menu_background_color" id="menuBackgroundColor" value="{{ $settings['menu_background_color'] ?? '#ffffff' }}">
        </div>

        <div class="mb-3">
            <label for="menuTextColor" class="form-label">Menu Text Color:</label>
            <input type="color" class="form-control" name="menu_text_color" id="menuTextColor" value="{{ $settings['menu_text_color'] ?? '#ffffff' }}">
        </div>

        <div class="mb-3">
            <label for="BackgroundColor" class="form-label">Background Color:</label>
            <input type="color" class="form-control" name="background_color" id="BackgroundColor" value="{{ $settings['background_color'] ?? '#ffffff' }}">
        </div>

        <div class="mb-3">
            <label for="TextColor" class="form-label">Text Color:</label>
            <input type="color" class="form-control" name="text_color" id="TextColor" value="{{ $settings['text_color'] ?? '#ffffff' }}">
        </div>

        <div class="mb-3">
            <label for="footerBackgroundColor" class="form-label">Footer Background Color:</label>
            <input type="color" class="form-control" name="footer_background_color" id="footerBackgroundColor" value="{{ $settings['footer_background_color'] ?? '#ffffff' }}">
        </div>
        <div class="mb-3">
            <label for="footerTextColor" class="form-label">Footer Text Color:</label>
            <input type="color" class="form-control" name="footer_text_color" id="footerTextColor" value="{{ $settings['footer_text_color'] ?? '#ffffff' }}">
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
        @if(session('success'))
        <div class="mt-3 alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    </form>
</div>
@endsection
