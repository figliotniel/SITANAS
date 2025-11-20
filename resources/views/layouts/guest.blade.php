<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITANAS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    
    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles
</head>
<body class="antialiased" style="margin: 0; padding: 0;">
    {{ $slot }}
    @livewireScripts
</body>
</html>