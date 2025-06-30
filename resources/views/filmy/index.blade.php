<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zarządzaj filmami') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Lista filmów') }}</h3>


                    <form method="GET" action="{{ route('filmy.index') }}" class="mb-4">
                        <input type="text" name="search" value="{{ old('search', $search) }}" class="" placeholder="Szukaj po tytule filmu" />
                        <button type="submit" class="szukaj">
                            {{ __('Szukaj') }}
                        </button>
                        <select name="okres" class="ml-4">
                            <option value="wszystkie" {{ $selectedOkres == 'wszystkie' ? 'selected' : '' }}>{{ __('Wszystkie') }}</option>
                            <option value="aktualne" {{ $selectedOkres == 'aktualne' ? 'selected' : '' }}>{{ __('Aktualne') }}</option>
                            <option value="ostatni_rok" {{ $selectedOkres == 'ostatni_rok' ? 'selected' : '' }}>{{ __('Sprzed roku') }}</option>
                        </select>

                        <button type="submit" class="szukaj ml-4">
                            {{ __('Filtruj') }}
                        </button>
                        <br>
                        <label class="ml-4">
                            <input type="checkbox" id="togglePosters" class="cursor-pointer">
                            {{ __('Ukryj plakaty') }}
                        </label>

                    </form>

                    <a href="{{ route('filmy.create') }}" class="dodaj">
                        {{ __('Dodaj film') }}
                    </a>


                    @if (session('success'))
                    <div class="alert alert-success" style="padding: 10px; background-color: green; color: white; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                    @endif
                    <br><br>
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Tytuł') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Dystrybucja') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Cena Normalna') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Cena Ulgowa') }}</th>
                               
                                <th class="border border-gray-300 px-4 py-2 text-left poster-column">{{ __('Plakat') }}</th>
                               
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Od ilu lat') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Od kiedy ważny') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Do kiedy ważny') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Akcje') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($filmy as $film)
                            <tr class="{{ $film->DoKiedy < now() ? 'bg-gray-300' : '' }}">
                                <td class="border border-gray-300 px-4 py-2">{{ $film->Tytul }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $film->Dystrybucja }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ number_format($film->CenaNormalna, 2) }} zł</td>
                                <td class="border border-gray-300 px-4 py-2">{{ number_format($film->CenaUlgowa, 2) }} zł</td>
                                @if (!request('hide_posters'))
                                <td class="border border-gray-300 px-4 py-2 poster-column">
                                    @if ($film->Plakat)
                                    <img src="{{ asset('storage/' . $film->Plakat) }}" class="w-32">
                                    @else
                                    {{ __('Brak plakatu') }}
                                    @endif
                                </td>
                                @endif
                                <td class="border border-gray-300 px-4 py-2">{{ $film->Wiek }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $film->OdKiedy }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $film->DoKiedy }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('filmy.edit', $film->FilmID) }}" class="edytuj">{{ __('Edytuj') }}</a>
                                    @if ($film->seanse()->exists())

                                    @else
                                    <br><br>

                                    <form action="{{ route('filmy.destroy', $film->FilmID) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="usun" onclick="return confirm('Czy na pewno chcesz usunąć ten film?')">
                                            {{ __('Usuń') }}
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">
                                    {{ __('Brak filmów do wyświetlenia.') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        img {
            width: 100px;
            height: 150px;
            object-fit: cover;
        }

        .usun {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .edytuj {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .szukaj {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .dodaj {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
    .bg-gray-300 {
        background-color: #e5e7eb; 
    }


    </style>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const togglePostersCheckbox = document.getElementById('togglePosters');
        const posterColumns = document.querySelectorAll('.poster-column');

        togglePostersCheckbox.addEventListener('change', () => {
            posterColumns.forEach(column => {
                if (togglePostersCheckbox.checked) {
                    column.style.display = 'none'; 
                } else {
                    column.style.display = ''; 
                }
            });
        });
    });
</script>

</x-app-layout>