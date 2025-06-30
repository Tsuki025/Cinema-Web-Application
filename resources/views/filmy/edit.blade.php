<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edytuj film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('filmy.update', $film->FilmID) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="Tytul" :value="__('Tytuł')" />
                            <x-text-input id="Tytul" name="Tytul" type="text" class="block mt-1 w-full" value="{{ old('Tytul', $film->Tytul) }}" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="Opis" :value="__('Opis')" />
                            <textarea id="Opis" name="Opis" class="block mt-1 w-full">{{ old('Opis', $film->Opis) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="ZwiastunURL" :value="__('Zwiastun URL')" />
                            <x-text-input id="ZwiastunURL" name="ZwiastunURL" type="url" class="block mt-1 w-full" value="{{ old('ZwiastunURL', $film->ZwiastunURL) }}" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="CenaNormalna" :value="__('Cena Normalna')" />
                            <x-text-input id="CenaNormalna" name="CenaNormalna" type="number" step="0.01" class="block mt-1 w-full" value="{{ old('CenaNormalna', $film->CenaNormalna) }}" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="CenaUlgowa" :value="__('Cena Ulgowa')" />
                            <x-text-input id="CenaUlgowa" name="CenaUlgowa" type="number" step="0.01" class="block mt-1 w-full" value="{{ old('CenaUlgowa', $film->CenaUlgowa) }}" required />
                        </div>

                        
                        <div class="mt-4">
                            <x-input-label for="Plakat" :value="__('Nowy plakat filmu (opcjonalnie)')" />
                            <input id="Plakat" type="file" name="Plakat" class="block mt-1 w-full">
                            <x-input-error :messages="$errors->get('Plakat')" class="mt-2" />
                        </div>
                        
                     
                        @if($film->Plakat)
                            <div class="mt-4">
                             <p>Obecny plakat:</p>
                             <img src="{{ asset('storage/' . $film->Plakat) }}" class="w-32">
                            </div>
                        @endif
                        <div>
                            <label for="Wiek">Od ilu lat dozwolony film:</label>
                            <select name="Wiek" required>
                                <option value="3+" {{ $film->PEGI == '3+' ? 'selected' : '' }}>3+</option>
                                <option value="7+" {{ $film->PEGI == '7+' ? 'selected' : '' }}>7+</option>
                                <option value="13+" {{ $film->PEGI == '13+' ? 'selected' : '' }}>13+</option>
                                <option value="16+" {{ $film->PEGI == '16+' ? 'selected' : '' }}>16+</option>
                                <option value="18+" {{ $film->PEGI == '18+' ? 'selected' : '' }}>18+</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="OdKiedy">Od Kiedy jest dostępny film</label>
                            <input type="date" name="OdKiedy" value="{{ $film->OdKiedy }}" required>
                        </div>
                        <div>
                            <label for="DoKiedy">Do Kiedy jest dostępny film</label>
                            <input type="date" name="DoKiedy" value="{{ $film->DoKiedy }}" required>
                        </div>
                        <div>
                            <x-input-label for="Dystrybucja" :value="__('Dystrybucja')" />
                            <x-text-input id="Dystrybucja" name="Dystrybucja" type="text" class="block mt-1 w-full" value="{{ old('Dystrybucja', $film->Dystrybucja) }}" required />
                        </div>

                        <div class="mt-4">
                            <x-primary-button class="przycisk">{{ __('Zaktualizuj') }}</x-primary-button>
                            <x-nav-link :href="route('filmy.index')" class="anuluj" :active="request()->routeIs('filmy.index')">
                                {{ __('Anuluj') }}
                                </x-nav-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        
        .przycisk{
            background-color: blue; 
  color: white; 
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px; 
  transition: background 0.3s;
        }
          .anuluj{
  background-color: red; 
  color: white; 
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px; 
  transition: background 0.3s;
}
        img{
            width: 200px;  
            height: 300px; 
            object-fit: cover; 
        }
    </style> 
</x-app-layout>
