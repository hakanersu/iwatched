@extends('layouts.auth')
@section('title', 'Sign in to your account')

@section('content')
    <div>
        @include('livewire.auth.login')
    </div>
@endsection
