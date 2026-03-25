<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-zinc-800 leading-tight uppercase tracking-tighter">
            Configuración de DreamStudy
        </h2>
    </x-slot>

    <div class="py-12 bg-zinc-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-zinc-900 text-white rounded-2xl shadow-lg text-xs font-bold uppercase tracking-widest">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-[0_10px_40px_rgba(0,0,0,0.04)] rounded-3xl border border-zinc-200 p-8 mb-8">
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-zinc-900 uppercase tracking-widest">Horarios de Atención</h3>
                    <p class="text-zinc-500 text-sm">Configurá la franja horaria general del local.</p>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase text-zinc-400 mb-2">Apertura</label>
                            <input type="time" name="opening_time" value="{{ substr($settings->opening_time, 0, 5) }}" class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-zinc-400 mb-2">Cierre</label>
                            <input type="time" name="closing_time" value="{{ substr($settings->closing_time, 0, 5) }}" class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-zinc-400 mb-2">Duración (min)</label>
                            <input type="number" name="slot_duration" value="{{ $settings->slot_duration }}" class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-zinc-800 text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-black transition">
                            Actualizar Horarios
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-[0_10px_40_rgba(0,0,0,0.04)] rounded-3xl border border-zinc-200 p-8">
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-zinc-900 uppercase tracking-widest">Días no laborables</h3>
                    <p class="text-zinc-500 text-sm">Bloqueá fechas para todos o para un barbero específico.</p>
                </div>

                <form action="{{ route('admin.blocked-days.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    @csrf
                    <input type="date" name="date" min="{{ date('Y-m-d') }}" 
                        class="bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition" required>
                    
                    <select name="barber_id" class="...">
                        <option value="">Todos los barberos</option>
                        @foreach($barbers as $barber)
                            <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="reason" placeholder="Motivo (opcional)" 
                        class="bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-3 focus:ring-2 focus:ring-black transition">

                    <button type="submit" class="bg-black text-white px-4 py-3 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-zinc-800 transition">
                        Bloquear
                    </button>
                </form>

                <div class="space-y-3">
                    @forelse($blockedDays as $blocked)
                        <div class="flex justify-between items-center p-4 bg-zinc-50 rounded-2xl border border-zinc-100 group hover:border-zinc-300 transition">
                            <div class="flex items-center space-x-4">
                                <div class="flex flex-col">
                                    <span class="font-black text-zinc-800 uppercase tracking-tight text-sm">
                                        {{ \Carbon\Carbon::parse($blocked->date)->translatedFormat('l d \d\e F') }}
                                    </span>
                                    @if($blocked->reason)
                                        <span class="text-[10px] text-zinc-400 italic font-medium uppercase tracking-widest">{{ $blocked->reason }}</span>
                                    @endif
                                </div>
                                <span class="px-2 py-1 {{ $blocked->barber_id ? 'bg-zinc-200 text-zinc-600' : 'bg-black text-white' }} text-[8px] font-black rounded-md uppercase tracking-tighter">
                                    {{ $blocked->barber ? $blocked->barber->name : 'LOCAL CERRADO' }}
                                </span>
                            </div>

                            <form action="{{ route('admin.blocked-days.destroy', $blocked) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-zinc-300 hover:text-red-600 transition p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-zinc-400 text-xs uppercase tracking-widest py-4 italic">No hay días bloqueados próximamente.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>