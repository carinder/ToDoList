<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>To Do List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
    <body>
        <div id='app'>
            <nav class="navbar navbar-dark bg-dark">
                <span class="navbar-brand mb-0 h1">To Do:</span>
                <add-task></add-task>
            </nav>
            <tasks-table></tasks-table>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>