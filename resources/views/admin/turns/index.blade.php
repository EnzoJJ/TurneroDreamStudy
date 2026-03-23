<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Agenda de Turnos Confirmados
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 mb-6 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse($turns as $barberName => $days)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-700">Peluquero: {{ $barberName }}</h3>
                        
                        {{-- Iteramos por cada día --}}
                        @foreach($days as $dateLabel => $barberTurns)
                            <div class="mb-6">
                                {{-- Etiqueta del día --}}
                                <p class="text-xs font-bold text-gray-400 uppercase mb-3 tracking-wider">
                                    {{ $dateLabel }}
                                </p>

                                {{-- Iteramos los turnos de ese día --}}
                                @foreach($barberTurns as $turn)
                                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200 shadow-sm">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-lg font-bold text-blue-600">
                                                    {{ \Carbon\Carbon::parse($turn->start_time)->format('H:i') }} hs
                                                </p>
                                                <p class="font-medium text-gray-800">{{ $turn->client_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $turn->client_phone }}</p>
                                            </div>
                                            
                                            <form action="{{ route('admin.turns.destroy', $turn) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return" class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded-full transition shadow">
                                                    Finalizar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div class="col-span-full bg-white p-10 text-center rounded shadow">
                        <p class="text-gray-500 text-xl font-medium">No hay turnos confirmados.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>