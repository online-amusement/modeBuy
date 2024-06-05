@extends('layouts.app')

@section('content')
    <member-component v-bind:members="{{ ($members) }}"></member-component>
@endsection
