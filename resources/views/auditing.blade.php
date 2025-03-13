@extends('layouts.dashboard')


@section('content')
    @include('partials.header')
    @include('partials.nav')
    <livewire:auditing-alert-component :id=$id />

@endsection
