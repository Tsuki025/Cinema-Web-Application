<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj Grafik Pracownika') }}
        </h2>
    </x-slot>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Dodaj do grafiku</h1>
                    @if($errors->any())
    <div class="alert alert-danger ">
        <ul>
            @foreach($errors->all() as $error)
                <li class="error-message">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    
                    <form method="POST" action="{{ route('grafik.store') }}">
                        @csrf

                        <label for="data" class="block font-medium text-sm text-gray-700">Data:</label>
                        <input type="date" id="data" name="data" value="{{ $data }}" class="border rounded p-2 w-full mb-4">

                        <label for="PracownikID" class="block font-medium text-sm text-gray-700">Wybierz pracownika:</label>
                        <select id="PracownikID" name="PracownikID" class="border rounded p-2 w-full mb-4">
                            @foreach ($pracownicy as $pracownik)
                                <option value="{{ $pracownik->PracownikID }}">
                                    {{ $pracownik->Imie }} {{ $pracownik->Nazwisko }} - {{ $pracownik->Rola }}
                                </option>
                            @endforeach
                        </select>

                        <label for="zmiana" class="block font-medium text-sm text-gray-700">Wybierz zmianę:</label>
                            <select id="zmiana" name="zmiana" class="border rounded p-2 w-full mb-4">
                            <option value="1">Zmiana 1 (08:00 - 16:00)</option>
                            <option value="2">Zmiana 2 (16:00 - 00:00)</option>
                            </select>


                        <div class="flex justify-between">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Zapisz grafik</button>
                            <a href="{{ route('grafik.index', ['data' => $data]) }}" class="bg-red-500 text-white px-4 py-2 rounded">Anuluj</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <style>
    .error-message {
        color: red;
    }
</style>
</x-app-layout>
