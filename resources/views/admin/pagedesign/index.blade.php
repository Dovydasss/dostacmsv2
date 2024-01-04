@extends('layout.admin')

@section('content')
<div class="container">
    <h1>Page Design</h1>
    <form id="pageDesignForm" action="" method="GET">
        <div class="form-group">
            <label for="page_id">Select Page to Design:</label>
            <select name="page_id" id="page_id" class="form-control" onchange="updateFormAction(this)">
                <option value="">Select a Page</option>
                @foreach ($pages as $page)
                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Go to Design</button>
    </form>
</div>

<script>
function updateFormAction(select) {
    var form = document.getElementById('pageDesignForm');
    form.action = '/admin/pagedesign/' + select.value + '/edit';
}
</script>
@endsection
