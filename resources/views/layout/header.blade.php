<div class="d-flex justify-content-center align-items-center" 
     style="width: 100%; max-height: {{ $header->height ?? '20' }}vh; overflow: hidden;">
    @if(optional($header)->header_image)
        <img src="{{ asset($header->header_image) }}" alt="Header Image" 
             style="width: {{ $header->width ?? '100' }}%; height: auto; object-fit: scale-down;">
    @else
        Header image not set.
    @endif
</div>
