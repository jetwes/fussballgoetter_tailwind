@extends('layouts.app')

@section('content')
    <div class="md:w-1/2 sm:w-full sm:mx-auto md:mx-auto">
        <form action="{{ route('change-password') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mt-4 mx-4">
                <div>
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Profil
                        </h3>
                    </div>
                    <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                                Neues Passwort
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="password" name="password" type="password" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="password_again" class="block text-sm font-medium leading-5 text-gray-700">
                                Wiederholung neues Passwort
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="password_again" name="password_again" type="password" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                            @error('password') <span class="text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-5 mr-4">
                <div class="flex justify-end">
              <span class="inline-flex rounded-md shadow-sm">
                  <a href="/">
                    <button type="button" class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                      Zurück
                    </button>
                  </a>
              </span>
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                  Speichern
                </button>
              </span>
                </div>
            </div>
        </form>
    </div>
@endsection
