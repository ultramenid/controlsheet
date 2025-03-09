@extends('layouts.dashboard')


@section('content')
    @include('partials.header')
    @include('partials.nav')
    <livewire:edit-user-component :id=$id />

@endsection
