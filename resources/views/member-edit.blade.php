@extends('layouts.app')

@section('content')
    @if($member)
        <member-edit-component 
            :member="{{ ($member) }}"
            :input="{{ json_encode(request()->input()) }}"
            :errors= "{{ $errors }}">
        </member-edit-component >
    @else
        <member-edit-component 
            :input="{{ json_encode(request()->input()) }}"
            :errors= "{{ $errors }}">
        </member-edit-component >
    @endif
@endsection