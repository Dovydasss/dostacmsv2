@extends('layout.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">


<style>
#gridContainer {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    max-width: 100%; /* Ensures the grid does not exceed the width of its container */
    overflow-x: auto;
    /* Adjust minmax values based on your design needs */
}


    .grid-cell {
        border: 1px solid #ddd;
        min-height: 100px;
        /* Adjust as needed */
        min-width: 100px;
        /* Adjust as needed */
        background-color: #f8f8f8;
        /* Light background for visibility */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        box-sizing: border-box;
        position: relative;
        overflow: auto;
        /* Include padding in width and height */
    }

    .resize-handle {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background-color: #ccc;
        cursor: se-resize;
        /* Cursor indicates resizable area */
    }

    
    @media screen and (max-width: 1920px) {
    .grid-cell {
        min-width: 100px;
        /* Other styles */
    }
}

@media screen and (max-width: 1440px) {
    .grid-cell {
        min-width: 80px;
        /* Other styles */
    }
}

/* Add more media queries as needed for different resolutions */



    .grid-cell div {
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="col">

        <!-- Grid Configuration Form -->
        <form id="gridForm" class="form-inline">
    <div class="form-row align-items-center">
        <div class="col-auto">
            <label for="rows" class="sr-only">Number of Rows</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">Rows</div>
                </div>
                <input type="number" class="form-control" id="rows" placeholder="Enter number of rows">
            </div>
        </div>
        <div class="col-auto">
            <label for="columns" class="sr-only">Number of Columns</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">Columns</div>
                </div>
                <input type="number" class="form-control" id="columns" placeholder="Enter number of columns">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">Create Grid</button>
        </div>
    </div>
</form>



    </div>
</div>

<div class="mt-3"></div>
@include('layout.header') {{-- Include the header.blade.php file here --}}
@if(isset($menusToShow) && $menusToShow->isNotEmpty())
@include('layout.menu', ['menus' => $menusToShow])
@endif
<div id="gridContainer" class="mt-4"></div>

@include('layout.footer') {{-- Include the footer.blade.php file here --}}




<!-- Available Blocks Area -->
<div class="col-md-3">
    <h2>Available Blocks</h2>
    <div id="available-blocks">
        @foreach ($allBlocks as $block)
        @if ($block->page_id == $pagedesign->id)
        <div class="available-block" draggable="true" ondragstart="drag(event)" id="block-{{ $block->id }}" data-content="{{ $block->content }}">
            {{ $block->title }}
        </div>
        @endif
        @endforeach
    </div>
</div>


<button id="saveChanges" class="btn btn-success">Save Changes</button>
<button id="deleteGrid" class="btn btn-danger">Delete Grid</button>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    var gridLayout = <?php echo json_encode($gridLayout); ?>;
    loadExistingGridLayout(gridLayout);
});



function loadExistingGridLayout(gridLayout) {
    if (!gridLayout || gridLayout.length === 0) return;

    rebuildGrid(gridLayout); // Create the grid based on the layout
    placeExistingBlocks(gridLayout); // Place the blocks in the grid
}

function rebuildGrid(gridLayout) {
    const gridContainer = document.getElementById('gridContainer');
    gridContainer.innerHTML = '';

    const numColumns = Math.max(...gridLayout.map(item => item.column));
    gridContainer.style.display = 'grid';
    gridContainer.style.gridTemplateColumns = `repeat(${numColumns}, 1fr)`;

    gridLayout.sort((a, b) => a.row - b.row || a.column - b.column);

    gridLayout.forEach(item => {
        const cell = document.createElement('div');
        cell.className = 'grid-cell';
        cell.style.gridRowStart = item.row;
        cell.style.gridColumnStart = item.column;
        cell.style.width = item.width + 'px';
        cell.style.height = item.height + 'px';
        cell.setAttribute('data-row', item.row);
        cell.setAttribute('data-column', item.column);

        addEventListenersToCell(cell);

        gridContainer.appendChild(cell);
    });
}


function placeExistingBlocks(gridLayout) {
    gridLayout.forEach(item => {
        if (item.blockId) {
            const blockElement = document.getElementById(item.blockId);
            if (blockElement) {
                const cellSelector = `.grid-cell[data-row="${item.row}"][data-column="${item.column}"]`;
                const cell = document.querySelector(cellSelector);
                if (cell) {
                    displayBlockContent(blockElement, cell); // Display the block content
                }
            }
        }
    });
}


function addEventListenersToCell(cell) {
    cell.ondragover = allowDrop;
    cell.ondrop = function(event) {
        drop(event, cell);
    };
    const resizeHandle = document.createElement('div');
    resizeHandle.className = 'resize-handle';
    resizeHandle.onmousedown = initiateResize;
    cell.appendChild(resizeHandle);

    cell.addEventListener('click', function(event) {
        if (cell.children.length > 1) {
            const blockId = cell.getAttribute('data-block-id');
            if (blockId) {
                const originalBlock = document.getElementById(blockId);
                if (originalBlock) {
                    originalBlock.style.display = ''; // Show the block in the available blocks
                    cell.innerHTML = ''; // Clear the cell
                    cell.appendChild(resizeHandle); // Re-add the resize handle
                    cell.removeAttribute('data-block-id'); // Remove block ID attribute
                }
            }
        }
    });
}







// Load the grid layout when the page loads

    document.getElementById('gridForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const rows = document.getElementById('rows').value;
        const columns = document.getElementById('columns').value;
        createGrid(rows, columns);
    });

    // Object to hold the current state of the grid
    // Global variable to hold the current state of the grid
    var gridState = [];
    var detachedBlocks = {};
    var numRows = 0;
    var numColumns = 0;


    function storeCurrentGridState() {
        const availableBlocks = document.getElementById('available-blocks');

        document.querySelectorAll('.grid-cell').forEach((cell) => {
            if (cell.children.length > 1) { // Check if there's a block in addition to the resize handle
                const block = cell.removeChild(cell.children[1]); // Assuming block is the second child
                availableBlocks.appendChild(block);
            }
        });

        // Reset the gridState as it's no longer needed in this approach
        gridState = [];
    }



    function createGrid(rows, columns) {
        numRows = parseInt(rows, 10);
    numColumns = parseInt(columns, 10);
    const gridContainer = document.getElementById('gridContainer');
    storeCurrentGridState();
    gridContainer.innerHTML = '';

    gridContainer.style.display = 'grid';
    gridContainer.style.gridTemplateRows = `repeat(${rows}, 1fr)`;
    gridContainer.style.gridTemplateColumns = `repeat(${columns}, 1fr)`;

    for (let i = 1; i <= rows; i++) {
        for (let j = 1; j <= columns; j++) {
            const cell = document.createElement('div');
            cell.className = 'grid-cell';
            cell.style.border = '1px solid #ddd';
            cell.style.minHeight = '100px';
            cell.style.minWidth = '100px';
            cell.dataset.gridWidth = '100';
            cell.dataset.gridHeight = '100';
            cell.setAttribute('data-row', i);
            cell.setAttribute('data-column', j);

            addEventListenersToCell(cell);

            gridContainer.appendChild(cell);
        }
    }
}




    function initiateResize(event) {
        event.preventDefault();
        const cell = event.target.parentElement;
        const startX = event.clientX;
        const startY = event.clientY;
        const startWidth = cell.offsetWidth;
        const startHeight = cell.offsetHeight;

        function doResize(moveEvent) {
            const newWidth = startWidth + moveEvent.clientX - startX;
            const newHeight = startHeight + moveEvent.clientY - startY;
            cell.style.width = newWidth + 'px';
            cell.style.height = newHeight + 'px';

            // Store the new dimensions in the cell's dataset
            cell.dataset.gridWidth = newWidth;
            cell.dataset.gridHeight = newHeight;
        }


        function stopResize() {
            window.removeEventListener('mousemove', doResize);
            window.removeEventListener('mouseup', stopResize);
        }

        window.addEventListener('mousemove', doResize);
        window.addEventListener('mouseup', stopResize);
    }




    function drop(ev, cell) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var draggedElement = document.getElementById(data);

    // Hide the block in the available blocks
    draggedElement.style.display = 'none';

    // Use the cell directly
    if (cell && cell.className.includes('grid-cell') && cell.children.length === 1) {
        displayBlockContent(draggedElement, cell);
        const row = cell.getAttribute('data-row');
        const col = cell.getAttribute('data-column');
        gridState[row - 1][col - 1] = data; // Update grid state with block ID
    } else {
        alert("This cell is already occupied.");
    }
}



function displayBlockContent(block, cell) {
    const content = block.getAttribute('data-content');
    if (content) {
        const contentDiv = document.createElement('div');
        contentDiv.innerHTML = content;
        contentDiv.dataset.blockId = block.id; // Store the block's original ID
        cell.appendChild(contentDiv);
        cell.setAttribute('data-block-id', block.id); // Set block ID attribute on the cell
    }
}






    function allowDrop(ev) {
        ev.preventDefault(); // Necessary to allow dropping
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }


    // Save the grid configuration to the server
// Save the grid configuration to the server
document.getElementById('saveChanges').addEventListener('click', function() {
    const gridCells = document.querySelectorAll('.grid-cell');
    const gridData = [];

    gridCells.forEach((cell) => {
        // Retrieve the row and column from the cell's dataset
        const row = cell.getAttribute('data-row');
        const column = cell.getAttribute('data-column');
        const width = cell.offsetWidth; // Outer width including padding and borders
        const height = cell.offsetHeight; // Outer height including padding and borders
        const blockId = cell.getAttribute('data-block-id') || null; // Use null if no blockId

        // Push cell data into gridData
        gridData.push({
            row,
            column,
            width,
            height,
            blockId
        });
    });

    // Send this data to the server
    saveGridConfiguration(gridData, pageId);
});


    function calculateCellWidth(cell) {
    return cell.offsetWidth; // Outer width including padding and borders
}

function calculateCellHeight(cell) {
    return cell.offsetHeight;
}

document.getElementById('deleteGrid').addEventListener('click', function() {
        if (confirm('Are you sure you want to delete the grid layout?')) {
            fetch('/admin/pagedesign/' + <?php echo json_encode($pagedesign->id); ?> + '/delete-grid', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert(data.message);
                // Optionally, reload the page or redirect
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting grid');
            });
        }
    });





    var pageId = <?php echo json_encode($pagedesign->id); ?>;
    //send data
    function saveGridConfiguration(gridData, pageId) {
        fetch('/admin/pagedesign/' + pageId + '/save-grid', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    gridData: gridData
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                alert('Grid saved successfully');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving grid');
            });
    }
</script>

@endsection