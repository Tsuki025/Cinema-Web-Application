<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sprzedaż Biletów') }}
        </h2>
    </x-slot>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">
                        Seanse na dzień {{ \Carbon\Carbon::parse($wybranyDzien)->translatedFormat('l, d F Y') }}
                    </h1>

                   
                    <div class="mb-6">
                        <div class="flex space-x-2">
                            @foreach ($dniTygodnia as $dzien)
                            @php
                            $aktywny = $dzien['data'] === $wybranyDzien;
                            @endphp
                            <a href="{{ route('bilety.index', ['data' => $dzien['data']]) }}"
                                class="px-4 py-2 rounded {{ $aktywny ? ' text-white bg-gray-500' : 'bg-gray-300' }}">
                                {{ $dzien['nazwa'] }}<br>{{ $dzien['formatted'] }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="mt-6 p-4 bg-green-500 text-white rounded">
                            {{ session('success') }}
                        </div>
                        @endif
                    @if($daneSeansow->isEmpty())
                    <p class="text-red-500 font-bold">Nie zaplanowano jeszcze seansu na wybrany dzień.</p>
                    @else
                    @foreach ($daneSeansow as $nazwaSali => $seanse)
                    <h2 class="text-xl font-bold mb-4">{{ $nazwaSali }}</h2>
                    <table class="table-auto w-full mb-8">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Tytuł Filmu</th>
                                <th class="px-4 py-2">Rodzaj Seansu</th>
                                <th class="px-4 py-2">Godzina Rozpoczęcia</th>
                                <th class="px-4 py-2">Od Ilu Lat</th>
                                <th class="px-4 py-2">Kupione Bilety</th>
                                <th class="px-4 py-2">Wolne Miejsca</th>
                                <th class="px-4 py-2">Opcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($seanse as $dane)
                            <tr>
                                <td class="border px-4 py-2">{{ $dane['seans']->film->Tytul }}</td>
                                <td class="border px-4 py-2">{{ $dane['seans']->Publicznosc }}</td>
                                <td class="border px-4 py-2">{{ $dane['seans']->GodzinaRozpoczecia }}</td>
                                <td class="border px-4 py-2">{{ $dane['film']->Wiek }}</td>
                                <td class="border px-4 py-2">{{ $dane['kupioneBilety'] }}</td>
                                <td class="border px-4 py-2">{{ $dane['wolneMiejsca'] }}</td>

                                <td class="border px-4 py-2">

                                    @if ($dane['seans']->isAnulowany())
                                    <span class="text-red-500 font-bold">Anulowany</span>
                                    @else
                                    <form method="POST" action="{{ route('bilety.anuluj', $dane['seans']->SeansID) }}">
                                        @csrf
                                        <button type="submit" class="anuluj">
                                            Anuluj seans
                                        </button>
                                    </form>
                                    <br>

                                    <button onclick="openModal({{ $dane['seans']->SeansID }})"
                                        class="wyswietl">
                                        Wyświetl miejsca
                                    </button>
                                    @endif
                                </td>



                                <div id="modal-{{ $dane['seans']->SeansID }}"
                                    class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                                    <div class="bg-white p-6 h-[70vh] modal-content">
                                        <h2 class="text-xl font-bold mb-4">Wybierz miejsce</h2>

                                        <form method="POST" action="{{ route('bilety.kup', $dane['seans']->SeansID) }}">
                                            @csrf
                                            @php
                                            $poprzedniRzad = null;
                                            @endphp
                                            @foreach ($dane['seans']->sala->miejsca->sortBy(['Rzad', 'NumerMiejsca']) as $miejsce)
                                            @php
                                            $zajete = explode(',', $dane['seans']->ZajeteMiejsca);
                                            $czyZajete = in_array($miejsce->MiejsceID, $zajete);
                                            $rezerwowane = \App\Models\Rezerwacja::where('SeansID', $dane['seans']->SeansID)
                                            ->pluck('ZarezerwowaneMiejsca')
                                            ->filter()
                                            ->flatMap(fn($miejsca) => explode(',', $miejsca))
                                            ->toArray();
                                            $czyRezerwowane = in_array($miejsce->MiejsceID, $rezerwowane);
                                            @endphp

                                            @if ($miejsce->Rzad != $poprzedniRzad)
                                            @if ($poprzedniRzad !== null) <br> @endif
                                            <span class="font-bold">
                                                Rząd {{ $miejsce->Rzad }}:
                                                @if ($miejsce->Rzad < 10)
                                                    &nbsp;&nbsp;&nbsp;
                                                    @else
                                                    &nbsp;
                                                    @endif
                                                    </span>
                                                    @endif

                                                    <label class="inline-block text-center mx-2 my-1 border rounded seat-label 
                                            {{ $czyZajete ? 'bg-red-500 cursor-not-allowed' : ($czyRezerwowane ? 'bg-purple-500' : 'bg-green-500 cursor-pointer') }}">
                                                        <input type="checkbox" name="miejsca[]" value="{{ $miejsce->MiejsceID }}" class="hidden seat-checkbox"
                                                            {{ $czyZajete ? 'disabled' : '' }} {{ $czyRezerwowane ? 'disabled' : '' }}>
                                                        <span class="text-white">{{ $miejsce->NumerMiejsca }}</span>
                                                    </label>

                                                    @php $poprzedniRzad = $miejsce->Rzad; @endphp
                                                    @endforeach

                                                    <label for="typ_biletu" class="block font-medium text-sm text-gray-700 mt-4">Typ biletu:</label>
                                                    <select name="typ_biletu" id="typ_biletu" class="border rounded p-1 w-full">
                                                        <option value="Normalny">Normalny</option>
                                                        <option value="Ulgowy">Ulgowy</option>
                                                    </select>

                                                    <div class="flex justify-between mt-4">
                                                        <button type="submit" class="kup">
                                                            Kup Bilet
                                                        </button>
                                                        <button type="button" onclick="closeModal({{ $dane['seans']->SeansID }})"
                                                            class="anuluj">
                                                            Anuluj
                                                        </button>
                                                    </div>
                                        </form>
                                    </div>

                                    <div class="w-1/3 pl-4 bg-white p-6  h-[70vh] ">
                                        <h2 class="text-lg font-bold mb-4">Rezerwacje</h2>
                                        <input type="text" id="search-{{ $dane['seans']->SeansID }}" placeholder="Wyszukaj kod..." class="border rounded w-full p-2 mb-4">
                                        <div id="reservations-list-{{ $dane['seans']->SeansID }}" class="overflow-y-auto h-[56vh]">
                                            @forelse ($dane['rezerwacje'] as $rezerwacja)
                                            <div class="p-2 border-b ">
                                                <p><strong>Kod:</strong> {{ $rezerwacja->Kod }}</p>
                                                <p><strong>Telefon:</strong> {{ $rezerwacja->NrTelefonu }}</p>
                                                <p><strong>Miejsca:</strong></p>
                                                @php
                                                $miejsca = [];
                                                foreach (explode(',', $rezerwacja->ZarezerwowaneMiejsca) as $miejsceID) {
                                                $miejsce = \App\Models\Miejsce::find($miejsceID);
                                                if ($miejsce) {
                                                $miejsca[$miejsce->Rzad][] = $miejsce->NumerMiejsca;
                                                }
                                                }
                                                @endphp

                                                @foreach ($miejsca as $rzad => $numeryMiejsc)
                                                <p>Rząd: {{ $rzad }} Miejsca: {{ implode(',', $numeryMiejsc) }}</p>
                                                @endforeach
                                                @if($rezerwacja ?? false)
                                                <form method="POST" action="{{ route('bilety.zatwierdz', $rezerwacja->RezerwacjaID) }}" onsubmit="return validateForm(event, {{ count(explode(',', $rezerwacja->ZarezerwowaneMiejsca)) }}, {{ $rezerwacja->RezerwacjaID }});">
                                                    @csrf
                                                    <div class="mb-4">
                                                        <label for="normal_bilety_{{ $rezerwacja->RezerwacjaID }}" class="block">Liczba biletów normalnych:</label>
                                                        <input type="number" name="normal_bilety" id="normal_bilety_{{ $rezerwacja->RezerwacjaID }}" class="border rounded w-full p-2" required min="0" value="0">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="ulgowe_bilety_{{ $rezerwacja->RezerwacjaID }}" class="block">Liczba biletów ulgowych:</label>
                                                        <input type="number" name="ulgowe_bilety" id="ulgowe_bilety_{{ $rezerwacja->RezerwacjaID }}" class="border rounded w-full p-2" required min="0" value="0">
                                                    </div>

                                                    <input type="hidden" name="zarezerwowane_miejsca" value="{{ $rezerwacja->ZarezerwowaneMiejsca }}">

                                                    <div id="error-message-{{ $rezerwacja->RezerwacjaID }}" class="text-red-500 hidden mt-2">

                                                        <p>Liczba biletów normalnych i ulgowych musi wynosić {{ count(explode(',', $rezerwacja->ZarezerwowaneMiejsca)) }} (liczba zarezerwowanych miejsc).</p>
                                                    </div>

                                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2 hover:bg-green-700">
                                                        Zatwierdź miejsca
                                                    </button>
                                                </form>
                                                @else

                                                @endif
                                                <form method="POST" action="{{ route('bilety.zwolnij', $rezerwacja->RezerwacjaID) }}" onsubmit="return confirm('Czy na pewno chcesz zwolnić tę rezerwację?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded mt-2 hover:bg-red-700">
                                                        Zwolnij rezerwację
                                                    </button>
                                                </form>
                                                

                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                                

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                                                
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <script>
        function openModal(seansID) {
            document.getElementById("modal-" + seansID).classList.remove("hidden");
        }

        function closeModal(seansID) {
            document.getElementById("modal-" + seansID).classList.add("hidden");
        }


        document.querySelectorAll('input[id^="search-"]').forEach(input => {
    input.addEventListener("input", function() {
        let searchValue = this.value.toLowerCase();
        let seansID = this.id.split('-')[1];
        let reservationList = document.getElementById("reservations-list-" + seansID);
        let reservations = reservationList.getElementsByTagName("div");

        for (let res of reservations) {
            let isError = res.id.startsWith("error-message-"); 
            
            if (!isError) { 
                let kodElement = res.querySelector("p:first-child");
                if (kodElement) {
                    let kod = kodElement.textContent.toLowerCase();
                    if (kod.includes(searchValue)) {
                        res.style.display = "";
                    } else {
                        res.style.display = "none";
                    }
                }
            }
        }

       
        let errorMessage = document.getElementById(`error-message-${seansID}`);
        if (errorMessage) {
            errorMessage.classList.remove("hidden");
            errorMessage.style.display = ""; 
        }
    });
});


        function validateForm(event, totalSeats, rezerwacjaID) {

            var normalTickets = document.getElementById('normal_bilety_' + rezerwacjaID);
            var ulgoweTickets = document.getElementById('ulgowe_bilety_' + rezerwacjaID);


            if (!normalTickets || !ulgoweTickets) return true;


            var normalTicketsValue = parseInt(normalTickets.value) || 0;
            var ulgoweTicketsValue = parseInt(ulgoweTickets.value) || 0;


            var errorMessage = document.getElementById('error-message-' + rezerwacjaID);


            if (normalTicketsValue + ulgoweTicketsValue !== totalSeats) {
                errorMessage.classList.remove('hidden');
                event.preventDefault();
                return false;
            }


            errorMessage.classList.add('hidden');
            return true;
        }


        document.querySelectorAll(".seat-checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                let label = this.closest(".seat-label");
                if (this.checked) {
                    label.classList.remove("bg-green-500");
                    label.classList.add("bg-blue-500");
                } else {
                    label.classList.remove("bg-blue-500");
                    label.classList.add("bg-green-500");
                }
            });
        });
    </script>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .bg-red-500 {
            background-color: red;
        }

        .bg-purple-500 {
            background-color: purple;
        }

        .bg-green-500 {
            background-color: green;
        }

        .bg-blue-500 {
            background-color: blue;
        }

        label {
            padding: 5px;
            border-radius: 4px;
            display: inline-block;
            margin: 5px;
        }

        .anuluj {

            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;

        }

        .wyswietl {

            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;

        }

        .kup {

            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;

        }

        .seat-label {
            width: 40px;


        }

        .fixed {
            z-index: 50;
        }

        .modal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-y: auto;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 100%;
            max-height: 90%;
            overflow-y: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</x-app-layout>