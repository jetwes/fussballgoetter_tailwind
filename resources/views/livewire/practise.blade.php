<div  x-data="{ showDrive: @if($participation && $participation->places > 0) true @else false @endif }">
    <div class="md:w-1/2 sm:w-full sm:mx-auto md:mx-auto">
        <div class="">
            <div class="font-medium text-lg text-indigo-700 bg-brand px-3 py-2 rounded-t" x-data="{ showDrivers: false }">
                @if($practise){{ $practise->date_of_practise->format('d.m.Y H:i') }} Uhr - Treffen: <strong>{{ $practise->date_of_practise->subMinutes(15)->format('H:i') }} Uhr</strong>
                    <h2>Gespielt wird @if($practise->date_of_practise->dayName == 'monday' || $practise->date_of_practise->dayName == 'Monday' || $practise->date_of_practise->dayName == 'Montag') am Ardey @else im Jahnstadion Soest @endif
                        <a class="hover:font-bold underline" title="Route" href="https://www.google.de/maps/place/Spielverein+Westfalia+Soest/@51.5720731,8.0769372,17z/data=!3m1!4b1!4m5!3m4!1s0x47b9632b0233d907:0x4d401f967b3c66b9!8m2!3d51.5720164!4d8.079094">
                                zur Route
                            </a>
                        <br>Die Anmeldung ist bis <strong>{{ $practise->date_of_practise->subHours(3)->format('d.m.Y H:i') }} Uhr</strong> möglich.
                    </h2>
                <!--<h2>Gespielt wird im Sporthotel Maifeld
                    <a class="hover:font-bold underline" title="Route" href="https://www.google.de/maps/place/Maifeld+Sport-+und+Tagungshotel/@51.5662155,7.890459,17z/data=!3m1!5s0x47b96fead0eecab3:0xaeb0f360dce7f739!4m20!1m10!3m9!1s0x47b96fead8f42981:0x154a958252c0b248!2sMaifeld+Sport-+und+Tagungshotel!5m2!4m1!1i2!8m2!3d51.5662155!4d7.8930339!16s%2Fg%2F1tfhypk6!3m8!1s0x47b96fead8f42981:0x154a958252c0b248!5m2!4m1!1i2!8m2!3d51.5662155!4d7.8930339!16s%2Fg%2F1tfhypk6?entry=ttu">
                        zur Route
                    </a>
                    <br>Die Anmeldung ist bis <strong>{{ $practise->date_of_practise->subDays(2)->format('d.m.Y H:i') }} Uhr</strong> möglich.
                </h2>
                -->


                    <h3 class="mt-2 font-medium text-2xl">Zusagen: {{ $practise->participators->count() }}</h3>
                    <h3 class="mb-2 font-medium text-lg">Absagen: {{ $practise->cancellations->count() }}</h3>
                    <!--
                        <h3 class="mb-2 font-medium mt-2 text-2xl" @click="showDrivers = !showDrivers">Klicken um Fahrer und Plätze zu sehen: {{ $practise->participators->sum('places')-($practise->seats->count()) + $practise->participators->where('places','>',0)->count()  }} / {{ $practise->participators->sum('places') }}</h3>
                    -->
                    @if(1 === 2)
                    <div x-show="showDrivers" style="display: none">
                        <div class="overflow-x-auto">
                            <div class="table min-w-full">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider col-span-4">Name</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider col-span-4">Aktion</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider col-span-4">Plätze</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider col-span-4">Info</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($practise->participators->where('places','>',0) as $driver)
                                       <tr class="border">
                                            <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 col-span-4">
                                                {{ $driver->user->name }}
                                            </td>
                                           <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 col-span-4">
                                               @if(!($practise->seats->where('driver_id', auth()->id())->first()) && (isset($this->participation) && $this->participation->participate))
                                                   @if(!$practise->seats->where('user_id', auth()->id())->first())
                                                       <a href="#" wire:click.prevent="takeSeat({{ $driver->id }})" title="Platz beanspruchen" class="text-green-500 hover:text-green-500">
                                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                           </svg>
                                                       </a>
                                                   @else
                                                       <a href="#" wire:click.prevent="leaveSeat({{ $driver->id }})" class="text-red-500 hover:text-red-600" title="Platz freigeben">
                                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                           </svg>
                                                       </a>
                                                   @endif
                                               @endif
                                           </td>
                                            <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 col-span-4">
                                                <span class="font-bold">
                                                    {{ $driver->places - ($practise->seats->where('user_id', '!=', $driver->user_id)->count()) }} / {{ $driver->places }}
                                                </span>
                                                @foreach($practise->seats->where('driver_id', $driver->user_id)->where('user_id', '!=', $driver->user_id) as $seat)
                                                    <br>
                                                    {{ $seat->user->name }}
                                                @endforeach
                                            </td>
                                           <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 col-span-4">{{ $driver->comment }}</td>
                                       </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>

            @if(session()->has('success-message') || session()->has('error-message'))
                <div class="rounded-md @if(session()->has('error-message'))bg-yellow-50 p-4 @else bg-green-100 p-4 @endif">
                    <div class="flex">
                        @if(session()->has('error-message'))
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @else
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-yellow-800">
                                Information
                            </h3>
                            <div class="mt-2 text-sm leading-5 text-yellow-700">
                                <p>
                                    {{ session()->get('error-message').session()->get('success-message') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($birthdays->count() > 0)
                @include('partials.birthdays')
            @endif
            <div class="bg-white px-3 py-2 rounded-b">
                @if (session('status'))
                    <div class="bg-green-lightest border border-green-light text-green-dark text-sm px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif
                @if($practise)
                    <div class="mt-2">
                        <div class="justify-center text-center items-center align-content-center">
                            <a wire:click="participate(true)" role="link"><button @if(\Carbon\Carbon::now() > $practise->date_of_practise->subHours(3)) disabled @endif class="disabled:bg-gray-500 inline-flex items-center rounded-md border border-transparent bg-green-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">JA</button></a>&nbsp;
                            <a wire:click="participate(false)" role="link"><button class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">NEIN</button></a>

                            @if($practise->draw)
                                <a href="{{ route('shuffle',['id' => $practise->id]) }}"><strong><button class="bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded">Auslosung anzeigen!</button></strong></a>
                            @endif
                        </div>
                        @if(1 == 2)
                        <div class="grid grid-cols-2 mt-4">
                            @if(!$beer && isset($this->participation) && $this->participation->participate)
                                <h3 class="mb-4 col-span-1">Ich bringe Bier mit:</h3>
                                <a class="col-span-1" wire:click="setBeer(true)"><button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        JA
                                    </button></a>&nbsp;
                            @elseif($beer)
                                <h3 class="col-span-2">Danke an <strong> {{ $beer->user->name }}</strong>! {{ $beer->user->name }} bringt Bier mit!</h3>
                                @if(auth()->id() == $beer->user_id)
                                    <a class="col-span-1" wire:click="setBeer(false)"><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Oh - doch Kein Bier von mir</button></a>&nbsp;
                                @endif
                            @endif
                        </div>
                        @endif

                        @if($this->participation && $this->participation->participate && 1 === 2)
                            <div>
                                <div class="grid grid-cols-2 mt-4">
                                    <h3 class="mb-4 col-span-1 mr-4">Ich kann fahren</h3>
                                    <button x-on:click="showDrive = true" x-show="!showDrive" style="display: none"  class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex h-10 w-20">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path fill="#fff" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                        </svg>
                                        JA
                                    </button>
                                    <button x-on:click="@this.call('noDrive')" style="display: none"  x-show="showDrive" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex w-64">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-6 w-6 mr-4" viewBox="0 0 24 24" stroke="currentColor">
                                            <path fill="#fff" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                        </svg>
                                        Nein, doch nicht
                                    </button>
                                    <label x-show="showDrive" style="display: none" class="col-span-1 mr-4 mt-4" for="drive_places">Freie Plätze</label>
                                    <input x-show="showDrive" style="display: none" type="number" title="Freie Plätze" class="mt-4 form-input block w-full pr-10 sm:text-sm sm:leading-5" placeholder="0" id="showDrive" wire:model="places">
                                    <label x-show="showDrive" style="display: none" for="comment" class="mt-4">Info</label>
                                    <input x-show="showDrive" style="display: none" type="text" title="Kommentar" class="mt-4 form-input block w-full pr-10 sm:text-sm sm:leading-5" id="comment" placeholder="Info Treffpunkt/Zeit" wire:model="comment">
                                </div>
                            </div>

                        @endif

                    </div>
                @endif
            </div>
            @if($practise)
                @if((\Auth::user()->name == 'T-Man' || \Auth::user()->name == 'Übungsleiter') && !$practise->draw && (\Carbon\Carbon::now() >= $practise->date_of_practise->subHours(3)))
                    <a target="_blank" class="mt-8" wire:click.prevent="shuffle({{ $practise->id }})" href="#"><strong><button class="bg-green-500 hover:bg-grren-600 text-white font-bold py-2 px-4 rounded mt-4 mb-4">Teams losen - Achtung nur 1 mal möglich!</button></strong></a>
                @endif
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 md:hidden">
                    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg">
                        <table class="min-w-full">
                            <thead>
                            <tr class="border-b border-gray-700 grid grid-cols-5">
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider col-span-4">
                                    Name
                                </th>
                                <th class="px-4 py-3 bg-gray-50 text-left text-xs leading-4 font-bold text-black uppercase tracking-wider col-span-1">
                                    Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($practise)
                                @foreach($practise->participations as $participator)
                                    <tr class="@if($loop->even) bg-white @else bg-gray-50 @endif grid grid-cols-5">
                                        <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 col-span-4">
                                            <img alt="Bild {{ $participator->user->name }}"
                                                 src="{{ $participator->user->avatar }}"
                                                 class="h-10 w-10 rounded-full float-left mr-2"> <span class="float-left">{{ $participator->user->name }}</span></td>
                                        <td class="px-4 py-2 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 @if($participator->participate) bg-green-500 @else bg-red-500 @endif col-span-1"></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="hidden md:block">
                <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                    <div class="grid grid-cols-2 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-6 xl:gap-x-8">
                        @if($practise)
                            @foreach($practise->participations as $participator)
                                <a href="#" class="group">
                                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                        <img alt="Bild {{ $participator->user->name }}"
                                             src="{{ $participator->user->avatar }}"
                                             class="h-full w-full object-cover object-center group-hover:opacity-75">
                                    </div>
                                    <h3 class="mt-4 text-sm text-gray-700 inline-flex justify-center items-center">
                                        @if($participator->participate)
                                            {{ $loop->index + 1 }}
                                            <span class="mr-2 text-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        @else
                                            <span class="ml-r text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        @endif
                                        {{ $participator->user->name }}
                                    </h3>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
