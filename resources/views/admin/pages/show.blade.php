@extends('layout.app')

<style>
    #gridContainer {
        display: grid;
        gap: 10px;
        margin-left: auto;
        margin-right: auto;
        max-width: 100%; 
        /* Use repeat and minmax for responsive columns */
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        grid-auto-rows: minmax(100px, auto); /* Rows adjust based on content */
        max-height: 100%; /* Maximum height - be cautious with this */
        overflow: auto;
    }

 

    /* ...other styles... */
</style>

@section('content')
    @if (isset($page))
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-md-12">
                    @if (isset($layout))
                        <div id="gridContainer">
                            @foreach ($layout as $layoutItem)
                                <div class="grid-cell" style="grid-column: {{ $layoutItem['column'] }} / span {{ $layoutItem['columnSpan'] ?? 1 }}; grid-row: {{ $layoutItem['row'] }} / span {{ $layoutItem['rowSpan'] ?? 1 }};">
                                    @if (isset($layoutItem['blockId']) && isset($preparedBlocks[$layoutItem['blockId']]))
                                        {!! $preparedBlocks[$layoutItem['blockId']]->content !!}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div>{!! $page->content !!}</div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <p>Page content not found.</p>
    @endif
@endsection
