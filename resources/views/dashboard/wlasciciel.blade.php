<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Właściciela') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Witaj, właścicielu!") }}

                    <nav class="mt-4">
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('filmy.index') }}" class="text-blue-500 hover:underline">
                                    {{ __('Zarządzaj filmami') }}
                                </a>
                                <br>
                                <a href="{{ route('harmonogram.index') }}" class="text-blue-500 hover:underline">
                                    {{ __('Harmonogram') }}
                                </a>
                                <br>
                                <a href="{{ route('grafik.index') }}" class="text-blue-500 hover:underline">
                                    {{ __('Grafik') }}
                                </a>
                                <br>
                                <a href="{{ route('pracownicy.index') }}" class="text-blue-500 hover:underline">
                                        {{ __('Zarządzaj pracownikami') }}
                                    </a>
                                <br>
                                <a href="{{ route('statystyki.index') }}" class="text-blue-500 hover:underline">
                                        {{ __('Statystyki seansów') }}
                                    </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
