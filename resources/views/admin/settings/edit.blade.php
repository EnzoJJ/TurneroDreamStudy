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
            </div>
        </div>
    </div>
</x-app-layout>