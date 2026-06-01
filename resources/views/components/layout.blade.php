<!doctype html>
<html lang="nl">
<head>
<meta charset="utf-8"/>
<title>{{ $title ?? 'Vakantieplanner' }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="/css/app.css"/>
</head>
<body>
{{ $slot }}
</body>
</html>
