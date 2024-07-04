<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>title</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
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
    </div>
    <style lang="scss">
        #app {
            display: flex;
            justify-content: center;
        }
    </style>
</body>