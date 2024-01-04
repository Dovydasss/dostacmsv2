@php
    use App\Models\Colors;

    $footerBackgroundColor = Colors::where('name', 'footer_background_color')->value('color') ?? '#00000';
    $footerTextColor = Colors::where('name', 'footer_text_color')->value('color') ?? '#00000';
@endphp

<style>
    .footer {
        background-color: {{ $footerBackgroundColor }};
        color: {{ $footerTextColor }};
    }
</style>
<footer class="footer">
    {!! $footer->footer_text !!}
</footer>