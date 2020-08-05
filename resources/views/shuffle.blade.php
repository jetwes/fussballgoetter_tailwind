@extends('layouts.app')

@section('nav')
@endsection

@section('body-style')
    style="background: black !important"
@endsection

@section('content')
    <div class="full">
        <div class="text-white flex">
            <div class="full">
                <h1>Die Auslosung wurde durchgeführt von {{ $draw->drawer->name }} am {{ $draw->created_at->format('d.m.Y') }} um {{ $draw->created_at->format('H:i') }}</h1>
            </div>
            <hr>
        </div>
        <div class="flex text-white">
            <div class="full">
                <h2>Team A</h2>
                @if (count($teams[0]) > 0)
                    @foreach($teams[0] as $ta)
                        {{ $ta }}<br>
                    @endforeach
                @endif
            </div>
        </div>
            <hr>
        <div class="flex text-white">
            <div class="full">
                <h2>Team B</h2>
                @if (count($teams[1]) > 0)
                    @foreach($teams[1] as $ta)
                        {{ $ta }}<br>
                    @endforeach
                @endif
            </div>
        </div>
        @if($teamC)
            <div class="flex text-white">
                <div class="full">
                    <h2>Team C</h2>
                    @if (count($teams[2]) > 0)
                        @foreach($teams[2] as $ta)
                            {{ $ta }}<br>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection