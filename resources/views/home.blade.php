@extends('layouts.app')

@section('styles-head')
    @parent
    @livewireStyles
@endsection

@section('content')
    @livewire('practise')
@endsection

@section('js-body')
    @parent
    @livewireScripts
@endsection
