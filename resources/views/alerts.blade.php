@extends('layouts.dashboard')

@section('content')
    @include('partials.header')
    @include('partials.nav')

    <div class="max-w-6xl mx-auto px-7 py-4 sm:mt-16 mt-4">
        <livewire:auditor-database-component />

    </div>

@endsection
