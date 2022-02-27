@extends('octo::livewire.billing-portal.layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Billing Portal') }}: {{ __('Subscriptions') }}
    </h2>
@endsection

@section('content')
    @livewire('plans-slide')
@endsection
