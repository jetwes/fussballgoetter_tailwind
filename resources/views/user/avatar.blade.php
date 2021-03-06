@extends('layouts.app')

@section('content')
    <div class="md:w-1/2 sm:w-full sm:mx-auto md:mx-auto">
        <form action="{{ route('change-avatar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mt-4 mx-4">
                <div>
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Profil
                        </h3>
                    </div>
                    <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">

                        <div class="sm:col-span-6">
                            <label for="photo" class="block text-sm leading-5 font-medium text-gray-700">
                                Foto
                            </label>
                            <div class="mt-2 flex items-center">
                                <span class="h-20 w-20 rounded-full overflow-hidden bg-gray-100">
                                  <img src="{{ auth()->user()->avatar }}" class="h20 w-20 rounded-full" alt="Avatar"/>
                                </span>
                                <span class="ml-5 rounded-md shadow-sm">
                                  <input type="file" name="avatar" class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out"/>
                                </span>
                            </div>
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
