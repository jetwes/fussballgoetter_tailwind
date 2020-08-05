@extends('layouts.app')

@section('nav')
    @parent
@endsection

@section('content')
    <div class="md:w-1/2 sm:w-full sm:mx-auto md:mx-auto">
        <div class="">
            <div class="font-medium text-lg text-gray bg-brand px-3 py-2 rounded-t">
                @if($practise){{ $practise->date_of_practise->subMinutes(30)->format('d.m.Y H:i') }} Uhr @endif
                <h2>Aktuell wird OPEN AIR am Meiningser Weg gespielt.</h2>
                <h3 class="mb-2 font-medium mt-2 text-2xl">Aktuelle Teilnehmerzahl: {{ $practise->participators->count() }}</h3>
            </div>

            @if($birthdays->count() > 0)
                <div class="rounded-md bg-yellow-50 py-2">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-yellow-800">
                                Achtung - Geburtstag
                            </h3>
                            <div class="mt-2 text-sm leading-5 text-yellow-700">
                                @foreach($birthdays as $birthday)
                                    <p>
                                        <strong>{{ $birthday->name }} - {{ $birthday->birthday->format('d.m.Y') }}</strong>
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="bg-white px-3 py-2 rounded-b">
                @if (session('status'))
                    <div class="bg-green-lightest border border-green-light text-green-dark text-sm px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif



                @if($practise)
                    <div class="mt-2">
                        <h3 class="mb-4">Meine Auswahl: <a href="{{ route('participate',['id' => $practise->id,'participate' => 1]) }}"><button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">JA</button></a>&nbsp;
                        <a href="{{ route('participate',['id' => $practise->id,'participate' => 0]) }}"><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">NEIN</button></a>

                            @if(\App\Draw::where('practise_id',$practise->id)->first())
                                <a target="_blank" href="{{ route('shuffle',['id' => $practise->id]) }}"><strong><button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">Auslosung anzeigen!</button></strong></a>
                            @endif

                        </h3>
                    </div>
                @endif
            </div>
            <div>
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg">
                        <table class="min-w-full">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Ja
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Nein
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($practise)
                                @foreach($practise->participations as $participator)
                                    <tr class="@if($loop->even) bg-white @else bg-gray-50 @endif">
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">{{ $participator->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">@if($participator->participate) X @endif</td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">@if(!$participator->participate) X @endif</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if((\Auth::user()->name == 'T-Man' || \Auth::user()->name == 'Übungsleiter') && !\App\Draw::where('practise_id',$practise->id)->first() && (\Carbon\Carbon::now() >= $practise->date_of_practise->subHours(3)))
                        <a target="_blank" class="mt-8" href="{{ route('shuffle',['id' => $practise->id]) }}"><strong><button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">Teams losen - Achtung nur 1 mal möglich!</button></strong></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
