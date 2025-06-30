<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Sprzedawcy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Witaj, sprzedawco!") }}

                    <nav class="mt-4">
                        <ul class="space-y-2">
                            <li>

                                <a href="{{ route('bilety.index') }}" class="text-blue-500 hover:underline">
                                    {{ __('Sprzedawaj bilety') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('sprzedawca.index') }}" class="text-blue-500 hover:underline">
                                    {{ __('Grafik') }}
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>