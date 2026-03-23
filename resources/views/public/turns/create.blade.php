<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Turno - Peluquería</title>
    <script src="https://cdn.tailwindcss.com"></script> </head>
<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Reserva tu Turno</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('turns.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block">Elegí tu Peluquero:</label>
                <select name="barber_id" class="w-full border p-2 rounded" required>
                    <option value="">Seleccione uno...</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Tu Nombre:</label>
                <input type="text" name="client_name" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block">Tu Email:</label>
                <input type="email" name="client_email" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block">Tu numero de celular:</label>
                <input type="number" name="client_phone" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block">Fecha y Hora:</label>
                <input type="datetime-local" name="start_time" class="w-full border p-2 rounded" required>
            </div>

            <button type="submit" class="w-full bg-black text-white p-3 rounded font-bold">
                RESERVAR TURNO
            </button>
        </form>
    </div>
</body>
</html>