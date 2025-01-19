<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Projektek</title>
</head>
<body>
    <h1>Projektek</h1>

    @include('projects.input') <!-- Input mező -->
    @include('projects.list', ['projects' => $projects]) <!-- Lista -->
    @include('projects.dialog') <!-- Dialog ablak -->

    <!-- Export gomb -->
    <button id="open-export-dialog">Export</button>

    <!-- Export dialog -->
    <div id="export-dialog" style="display: none; position: fixed; top: 10%; left: 10%; width: 80%; height: 80%; background: white; border: 1px solid #ccc; padding: 20px; overflow: auto; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);">
    <div id="export-content">
        <!-- az export -->
    </div>
        <button id="close-export-dialog">Close</button>
    </div>

</body>
</html>
