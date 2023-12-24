<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Data - Admin Panel</title>
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('resources/sass/app.scss') }}">
    
</head>

<body>
    <div id="app">
        <users-table :users="{{ $users }}"></users-table>
    </div>
    <script type="module" src="{{ mix('resources/js/app.js') }}"></script>
</body>

</html>
