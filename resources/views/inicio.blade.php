@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        @if(Auth::user()->getPerfil->idPerfil == 1 )
            <admin></admin>
        @elseif(Auth::user()->getPerfil->idPerfil == 2 )
            <supervisor></supervisor>
        @else
            <revisor></revisor>
        @endif
    </div>
@endsection
