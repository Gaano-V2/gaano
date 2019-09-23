<!doctype html>

<html lang="{{ app()->getLocale() }}">

<head>

<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Gaano</title>

<link rel="icon" href="/tools/logo-top.png" type="image/gif" sizes="16x16">

<link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>

<div id="app">

    <main-app />

</div>

<script src="{{ asset('js/app.js') }}" defer></script>

</body>

</html>
