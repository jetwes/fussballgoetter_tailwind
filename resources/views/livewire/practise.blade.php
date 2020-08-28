<div>
    <div class="md:w-1/2 sm:w-full sm:mx-auto md:mx-auto">
        <div class="">
            <div class="font-medium text-lg text-indigo-700 bg-brand px-3 py-2 rounded-t">
                @if($practise){{ $practise->date_of_practise->subMinutes(30)->format('d.m.Y H:i') }} Uhr @endif
                <h2>Aktuell wird OPEN AIR am Meiningser Weg gespielt.</h2>
                @if($practise)<h3 class="mb-2 font-medium mt-2 text-2xl">Aktuelle Teilnehmerzahl: {{ $practise->participators->count() }}</h3> @endif
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
                        <div class="grid grid-cols-2">
                            <h3 class="mb-4 col-span-1">Meine Auswahl:</h3>
                            <div class="col-span-1">
                                <a wire:click="participate(true)"><button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">JA</button></a>&nbsp;
                                <a wire:click="participate(false)"><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">NEIN</button></a>

                                @if(\App\Draw::where('practise_id',$practise->id)->first())
                                    <a target="_blank" href="{{ route('shuffle',['id' => $practise->id]) }}"><strong><button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">Auslosung anzeigen!</button></strong></a>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 mt-4">
                            @if(!$beer)
                                <h3 class="mb-4 col-span-1">Ich bringe Bier mit:</h3>
                                <a class="col-span-1" wire:click="setBeer(true)"><button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">JA</button></a>&nbsp;
                            @else
                                <h3 class="col-span-2">Danke an <strong> {{ $beer->user->name }}</strong>! {{ $beer->user->name }} bringt Bier mit!</h3>
                                @if(auth()->id() == $beer->user_id)
                                    <a class="col-span-1" wire:click="setBeer(false)"><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Oh - doch Kein Bier von mir</button></a>&nbsp;
                                @endif
                            @endif
                        </div>

                    </div>
                @endif
            </div>
            <div>
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
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
                    @if($practise)
                        @if((\Auth::user()->name == 'T-Man' || \Auth::user()->name == 'Übungsleiter') && !\App\Draw::where('practise_id',$practise->id)->first() && (\Carbon\Carbon::now() >= $practise->date_of_practise->subHours(3)))
                            <a target="_blank" class="mt-8" href="{{ route('shuffle',['id' => $practise->id]) }}"><strong><button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">Teams losen - Achtung nur 1 mal möglich!</button></strong></a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>