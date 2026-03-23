<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-zinc-800 leading-tight uppercase tracking-tighter">
            Staff de Barberos
        </h2>
    </x-slot>

    <div class="py-12 bg-zinc-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-zinc-900 text-white rounded-2xl shadow-lg text-sm font-bold uppercase tracking-widest animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif
            <div class="flex justify-between items-center mb-8">
                <p class="text-zinc-500 text-sm uppercase tracking-widest font-bold">Gestión de equipo</p>
                <a href="{{ route('admin.barbers.create') }}" class="bg-black text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-zinc-800 transition-all active:scale-95 shadow-lg">
                    + Agregar Barbero
                </a>
            </div>

            <div class="bg-white shadow-[0_10px_40px_rgba(0,0,0,0.04)] rounded-3xl border border-zinc-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-50 border-b border-zinc-100">
                            <th class="p-6 text-xs font-black uppercase tracking-widest text-zinc-400">Nombre del Barbero</th>
                            <th class="p-6 text-xs font-black uppercase tracking-widest text-zinc-400 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach($barbers as $barber)
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="p-6">
                                    <span class="font-bold text-zinc-800 uppercase tracking-tight text-lg">{{ $barber->name }}</span>
                                </td>
                                <td class="p-6 text-right flex justify-end space-x-3">
                                    <a href="{{ route('admin.barbers.edit', $barber) }}" class="p-2 text-zinc-400 hover:text-black transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.barbers.destroy', $barber) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-zinc-300 hover:text-red-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($barbers->isEmpty())
                    <div class="p-20 text-center">
                        <p class="text-zinc-400 italic">No hay barberos registrados todavía.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>