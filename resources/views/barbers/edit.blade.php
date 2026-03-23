<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-zinc-800 leading-tight uppercase tracking-tighter">
            Editar Barbero: {{ $barber->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-zinc-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('admin.barbers.index') }}" class="text-xs font-bold uppercase tracking-widest text-zinc-400 hover:text-black transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Cancelar y Volver
                </a>
            </div>

            <div class="bg-white shadow-[0_10px_40px_rgba(0,0,0,0.04)] rounded-3xl border border-zinc-200 p-8">
                <form method="POST" action="{{ route('admin.barbers.update', $barber) }}" class="space-y-6">
                    @csrf
                    @method('PUT') <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-zinc-400 mb-2">Nombre del Profesional</label>
                        <input type="text" name="name" value="{{ $barber->name }}" 
                            class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-4 focus:ring-2 focus:ring-black transition font-bold text-lg" 
                            required autofocus>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-black text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-zinc-800 transition-all active:scale-95 shadow-lg">
                            Actualizar Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>