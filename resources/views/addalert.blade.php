@extends('layouts.dashboard')


@section('content')
    @include('partials.header')
    @include('partials.nav')
    <livewire:add-alert-component />

@endsection
