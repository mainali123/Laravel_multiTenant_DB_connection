<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RegisterCompany</title>
</head>
<body>

<form method="post" id="registerCompany">
    @csrf
    <label for="name">Company Name:</label>
    <input type="text" id="name" name="name">

    <label for="domain">Domain:</label>
    <input type="text" id="domain" name="domain">

    <button type="submit">Register</button>
</form>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('js/ajax.js') }}"></script>

</body>
</html>
