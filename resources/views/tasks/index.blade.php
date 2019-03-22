<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>To Do List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
    <body>
        <div id='app'>
            <div class="header">
                <h1>To Do List:</h1>
            </div>
            <tasks-table></tasks-table>
            <add-task></add-task>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>