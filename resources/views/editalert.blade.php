@extends('layouts.dashboard')


@section('content')
    @include('partials.header')
    @include('partials.nav')
    <livewire:edit-alert-component :id=$id />

@endsection
