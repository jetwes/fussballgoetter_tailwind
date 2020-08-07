@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-on-white.svg" alt="Workflow">
            <h1 class="mt-2 text-center text-4xl leading-9 font-extrabold text-indigo-500">Die Fussballgötter</h1>
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                In deinem Account anmelden
            </h2>
            <p class="mt-2 text-center text-sm leading-5 text-gray-600 max-w">
                oder
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    Registriere dich jetzt!
                </a>
            </p>
        </div>

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
