@extends('layouts.dashboard')


@section('content')
    @include('partials.header')
    @include('partials.nav')
    <livewire:add-user-component />

@endsection
