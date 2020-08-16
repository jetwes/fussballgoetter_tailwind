@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8"  x-data="{openForgot: false}">

        <div x-show="openForgot" class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">

            <div x-show="openForgot" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="openForgot" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Passwort vergessen
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm leading-5 text-gray-500">
                                Bitte E-Mail Adresse eingeben
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form action="/user/forgot-password" method="POST">
                        @csrf
                        <div class="mt-5 sm:flex sm:items-center">
                            <div class="max-w-xs w-full">
                                <label for="email" class="sr-only">E-Mail Adresse</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input id="email" name="email" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="you@example.com" />
                                </div>
                            </div>
                            <span class="mt-3 w-ful inline-flex rounded-md shadow-sm sm:mt-0 sm:ml-3 sm:w-auto">
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-teal-700 focus:shadow-outline-indigo active:bg-teal-700 transition ease-in-out duration-150 sm:w-auto sm:text-sm sm:leading-5">
                                          Zurücksetzen
                                        </button>
                                      </span>
                            <span class="mt-3 w-ful inline-flex rounded-md shadow-sm sm:mt-0 sm:ml-3 sm:w-auto">
                                        <button type="reset" @click="openForgot = false; setTimeout(() => openForgot = false, 1000)" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:shadow-outline-gray active:bg-trf-700 transition duration-150 ease-in-out">
                                            Abbrechen
                                        </button>
                                    </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img style="height: 10rem;" class="mx-auto w-auto" src="/img/logo_fussballgoetter_mid.png" alt="Fussballgötter">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Anmeldung
            </h2>
            <p class="mt-2 text-center text-sm leading-5 text-gray-600 max-w">
                oder
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    Registriere dich jetzt!
                </a>
            </p>
        </div>
        @if(Session::has('success-message') || Session::has('error-message') || ($errors->count() > 0))
            <div class="alert @if (Session::has('success-message')) alert-success alert-alt @endif @if (Session::has('error-message')) alert-warning alert-alt @endif fade in">
                {!! Session::get('error-message').Session::get('success-message') !!}
                @foreach( $errors->all() as $message )
                    {{ $message }}
                @endforeach
            </div>
        @endif

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                            E-Mail Adresse
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="email" type="email"  name="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        {!! $errors->first('email', '<span class="text-red-500 font-medium py-2">:message</span>') !!}
                    </div>

                    <div class="mt-6">
                        <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                            Passwort
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="password" type="password" name="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        {!! $errors->first('password', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" checked>
                            <label for="remember" class="ml-2 block text-sm leading-5 text-gray-900">
                                Angemeldet bleiben?
                            </label>
                        </div>
                        <div class="text-sm leading-5">
                            <a href="#" @click="openForgot=true" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                Passwort vergessen?
                            </a>
                        </div>

                        <!--
                        <div class="text-sm leading-5">
                            <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                Passwort vergessen?
                            </a>
                        </div>
                        -->
                    </div>

                    <div class="mt-6">
                      <span class="block w-full rounded-md shadow-sm">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                          Anmelden
                        </button>
                      </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
