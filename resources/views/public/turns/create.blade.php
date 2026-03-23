<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamStudy | Reserva tu Turno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-zinc-100 text-zinc-900">

    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="mb-10 text-center">
            <h1 class="text-5xl font-black tracking-tighter uppercase italic">DreamStudy</h1>
            <p class="text-zinc-500 tracking-[0.3em] uppercase text-xs mt-2">Barber Shop & Studio</p>
        </div>

        <div class="w-full max-w-md bg-white shadow-[20px_20px_60px_#bebebe,-20px_-20px_60px_#ffffff] rounded-3xl p-8 border border-zinc-200">
            
            <h2 class="text-2xl font-bold mb-6 border-b border-zinc-100 pb-4 text-center">Reserva tu experiencia</h2>

            @if(session('success'))
                <div class="bg-zinc-900 text-white p-4 mb-6 rounded-xl text-sm text-center animate-pulse">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('turns.store') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-zinc-400 mb-2">Elegí a tu Barbero</label>
                    <select name="barber_id" id="barber_id" class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition" required>
                        <option value="">Seleccionar...</option>
                        @foreach($barbers as $barber)
                            <option value="{{ $barber->id }}">{{ strtoupper($barber->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-zinc-400 mb-2">Nombre Completo</label>
                        <input type="text" name="client_name" placeholder="Ej: Juan Pérez" class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-zinc-400 mb-2">Email de contacto</label>
                        <input type="email" name="client_email" placeholder="tu@email.com" class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-zinc-400 mb-2">Número de Celular</label>
                        <input type="tel" name="client_phone" placeholder="Ej: 11 1234 5678" 
                            class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition" 
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-zinc-400 mb-2">Fecha</label>
                        <input type="date" id="date_picker" min="{{ date('Y-m-d') }}" class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-zinc-400 mb-2">Hora disponible</label>
                        <select id="time_picker" name="start_time" class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition disabled:opacity-50" required disabled>
                            <option value="">Elegí barbero y fecha...</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-black text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-zinc-800 transition-all active:scale-95 shadow-lg">
                    Confirmar Cita
                </button>
            </form>
        </div>

        <p class="mt-10 text-zinc-400 text-[10px] uppercase tracking-widest">© 2026 DreamStudy Professional Barbering</p>
    </div>

    <script>
        const barberSelect = document.getElementById('barber_id');
        const dateInput = document.getElementById('date_picker');
        const timeSelect = document.getElementById('time_picker');

        async function updateAvailableTimes() {
            const barberId = barberSelect.value;
            const date = dateInput.value;

            // Solo disparamos si ambos están seleccionados
            if (!barberId || !date) return;

            timeSelect.disabled = true;
            timeSelect.innerHTML = '<option>Buscando horarios...</option>';

            try {
                const response = await fetch(`/api/available-times?barber_id=${barberId}&date=${date}`);
                const times = await response.json();

                timeSelect.innerHTML = '<option value="">Seleccioná una hora</option>';
                
                times.forEach(item => {
                    const option = document.createElement('option');
                    // El valor es Fecha + Hora para que tu controlador lo reciba igual que antes
                    option.value = `${date} ${item.time}`; 
                    option.textContent = item.time + (item.is_available ? '' : ' (OCUPADO)');
                    option.disabled = !item.is_available;
                    
                    if (!item.is_available) {
                        option.classList.add('text-zinc-400');
                    }
                    timeSelect.appendChild(option);
                });

                timeSelect.disabled = false;
            } catch (error) {
                timeSelect.innerHTML = '<option>Error al cargar horarios</option>';
            }
        }

        barberSelect.addEventListener('change', updateAvailableTimes);
        dateInput.addEventListener('change', updateAvailableTimes);
    </script>
</body>
</html>