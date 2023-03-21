@extends('adminlte::page')

@section('title', 'Autos')

@section('content_header')
    <h1>Autos</h1>
@stop

@section('content')
        <div id="app">
            <!--<form-component :user="{{Auth::user() !=null ? Auth::user() : json_encode($user = array())}}"></form-component>-->
       <auto-component></auto-component>
    </div>
@stop

@section('css')
    <!--link rel="stylesheet" href="/css/admin_custom.css">-->
    @vite('resources/css/app.css')
@stop

@section('js')
    <!--<script> console.log('Hi!'); </script>-->
    @vite('resources/js/app.js')
@stop