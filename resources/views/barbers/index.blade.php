<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Peluqueros
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow rounded">
            <a href="{{ route('barbers.create') }}" class="text-blue-500 underline">+ Agregar otro</a>
            
            <ul class="mt-4">
                @foreach($barbers as $barber)
                    <li class="border-b py-2">
                        <strong>{{ $barber->name }}</strong>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>