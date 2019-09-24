<!doctype html>

<html lang="{{ app()->getLocale() }}">

<head>

<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Gaano</title>

<link rel="icon" href="/tools/logo-top.png" type="image/gif" sizes="16x16">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://kit.fontawesome.com/f5d29584b8.js" crossorigin="anonymous"></script>

</head>

<body>

<div id="app">

    <main-app />

</div>

<script src="{{ asset('js/app.js') }}" defer></script>

</body>

</html>
