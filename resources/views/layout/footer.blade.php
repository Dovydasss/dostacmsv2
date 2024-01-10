
<style>
    .footer {
        background-color: {{ $colors['footer_background_color'] ?? '#000000' }};
        color: {{ $colors['footer_text_color'] ?? '#000000' }};
    }
</style>
<footer class="footer">
    {!! $footer->footer_text !!}
</footer>