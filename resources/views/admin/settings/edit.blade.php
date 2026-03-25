<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Configuración de Agenda</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
                
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-bold text-gray-700">Hora de Apertura:</label>
                        <input type="time" name="opening_time" value="{{ $settings->opening_time }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700">Hora de Cierre:</label>
                        <input type="time" name="closing_time" value="{{ $settings->closing_time }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700">Duración del Turno (minutos):</label>
                        <input type="number" name="slot_duration" value="{{ $settings->slot_duration }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <p class="text-xs text-gray-400 mt-1 italic">* Ejemplo: 40 para turnos cada 40 minutos.</p>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                        GUARDAR CAMBIOS
                    </button>
                </form>
                <div class="mt-12 bg-white overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.04)] sm:rounded-3xl border border-zinc-200 p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-zinc-900 uppercase tracking-widest">Días no laborables</h3>
                        <p class="text-zinc-500 text-sm">Cancelá fechas completas (feriados, descansos o urgencias).</p>
                    </div>

                    <form action="{{ route('admin.blocked-days.store') }}" method="POST" class="flex gap-4 mb-8">
                        @csrf
                        <div class="flex-grow">
                            <input type="date" name="date" min="{{ date('Y-m-d') }}" 
                                class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition" required>
                        </div>
                        <div class="flex-grow">
                            <input type="text" name="reason" placeholder="Motivo (opcional)" 
                                class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition">
                        </div>
                        <button type="submit" class="bg-black text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-zinc-800 transition">
                            Bloquear Día
                        </button>
                    </form>

                    <div class="space-y-3">
                        @foreach($blockedDays as $blocked)
                            <div class="flex justify-between items-center p-4 bg-zinc-50 rounded-2xl border border-zinc-100">
                                <div>
                                    <span class="font-bold text-zinc-800 uppercase tracking-tight">
                                        {{ \Carbon\Carbon::parse($blocked->date)->translatedFormat('l d \d\e F') }}
                                    </span>
                                    @if($blocked->reason)
                                        <span class="ml-2 text-[10px] text-zinc-400 uppercase font-black italic">// {{ $blocked->reason }}</span>
                                    @endif
                                </div>
                                <form action="{{ route('admin.blocked-days.destroy', $blocked) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-zinc-300 hover:text-red-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
