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
    <script>
        window.livewire.onError(statusCode => {
            if (statusCode === 419) {
                //alert('Es gibt neue Inhalte - du wirst auf die aktuelle Version geleitet.')
                confirm("Die Seite hat neue Inhalte.\nSoll die Seite neu geladen werden?")
                && window.location.reload();
                return false;
            }
        });
    </script>
@endsection
