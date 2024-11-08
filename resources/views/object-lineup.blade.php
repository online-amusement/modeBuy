@extends('layouts.app')

@section('content')
    <div id="app">
        <object-lineup-component 
            :object-lineups="{{ json_encode($objectLineups) }}"
            :input="{{ json_encode(request()->input()) }}"
            :errors= "{{ $errors }}">
        </object-lineup-component>
    </div>
@endsection