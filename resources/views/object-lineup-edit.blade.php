@extends('layouts.app')

@section('content')
    @if($objectLineup)
    <object-lineup-edit-component 
        :object-lineup="{{ ($objectLineup) }}"
        :tag-categories="{{ ($tagCategories) }}"
        :software-categories="{{ ($softwareCategories) }}"
        :object-lineup-tag="{{ $objectLineupTag }}"
        :object-lineup-software="{{ $objectLineupSoftware }}"
        :input="{{ json_encode(request()->input()) }}"
        :errors= "{{ $errors }}">
    </object-lineup-edit-component>
    @else
    <object-lineup-edit-component 
        :tag-categories="{{ ($tagCategories) }}"
        :software-categories=" {{ ($softwareCategories) }}"
        :input="{{ json_encode(request()->input()) }}"
        :errors= "{{ $errors }}">
    </object-lineup-edit-component>
    @endif
@endsection