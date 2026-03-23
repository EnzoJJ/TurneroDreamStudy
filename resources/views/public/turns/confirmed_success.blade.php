<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Turno Confirmado!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-lg text-center">
        <h1 class="text-3xl font-bold text-green-600 mb-4">¡Listo, {{ $turn->client_name }}!</h1>
        <p class="text-gray-700 mb-6">Tu turno para el día <strong>{{ $turn->start_time }}</strong> ha sido confirmado con éxito.</p>
        <p class="text-sm text-gray-500">Te esperamos en la peluquería.</p>
        <a href="{{ route('turns.confirm', $turn->token) }}" class="mt-6 inline-block text-blue-500 underline">Volver al inicio</a>
    </div>
</body>
</html>