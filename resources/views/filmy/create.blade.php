<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('filmy.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="Tytul" :value="__('Tytuł')" />
                            <x-text-input id="Tytul" class="block mt-1 w-full" type="text" name="Tytul" required autofocus />
                            <x-input-error :messages="$errors->get('Tytul')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="Opis" :value="__('Opis')" />
                            <textarea id="Opis" class="block mt-1 w-full" name="Opis" rows="3"></textarea>
                            <x-input-error :messages="$errors->get('Opis')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="ZwiastunURL" :value="__('Zwiastun URL')" />
                            <x-text-input id="ZwiastunURL" class="block mt-1 w-full" type="url" name="ZwiastunURL" />
                            <x-input-error :messages="$errors->get('ZwiastunURL')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="CenaNormalna" :value="__('Cena normalna')" />
                            <x-text-input id="CenaNormalna" class="block mt-1 w-full" type="number" name="CenaNormalna" step="0.01" required />
                            <x-input-error :messages="$errors->get('CenaNormalna')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="CenaUlgowa" :value="__('Cena ulgowa')" />
                            <x-text-input id="CenaUlgowa" class="block mt-1 w-full" type="number" name="CenaUlgowa" step="0.01" required />
                            <x-input-error :messages="$errors->get('CenaUlgowa')" class="mt-2" />
                        </div>

                       
                        <div class="mt-4">
                            <x-input-label for="Plakat" :value="__('Plakat filmu')" />
                            <input id="Plakat" type="file" name="Plakat" class="block mt-1 w-full">
                            <x-input-error :messages="$errors->get('Plakat')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <label for="Wiek" class="block text-sm font-medium text-gray-700">Od ilu lat dozwolony film:</label>
                            <select name="Wiek" id="Wiek" class="mt-1 block w-full" required>
                                <option value="3+">3+</option>
                                <option value="7+">7+</option>
                                <option value="13+">13+</option>
                                <option value="16+">16+</option>
                                <option value="18+">18+</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="OdKiedy" class="block text-sm font-medium text-gray-700">Od kiedy film dostępny w kinie</label>
                            <input type="date" name="OdKiedy" id="OdKiedy" class="mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="DoKiedy" class="block text-sm font-medium text-gray-700">Do kiedy film dostępny w kinie</label>
                            <input type="date" name="DoKiedy" id="DoKiedy" class="mt-1 block w-full" required>
                        </div>
                        <div>
                            <x-input-label for="Dystrybucja" :value="__('Dystrybucja')" />
                            <x-text-input id="Dystrybucja" class="block mt-1 w-full" type="text" name="Dystrybucja" required autofocus />
                            <x-input-error :messages="$errors->get('Dystrybucja')" class="mt-2" />
                        </div>
                        <div class="mt-6">
                            <x-primary-button class="przycisk">{{ __('Dodaj film') }}</x-primary-button>
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
</style>
</x-app-layout>
