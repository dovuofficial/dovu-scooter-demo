@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
        {{ session('status') }}
        </div>
    @endif
    <h2>Your Account</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    <hr>

    @if($valid_dovu_token)
        <a
        role="button"
        class="btn btn-primary"
        href="/issue/create">
        Survey
        </a>
        <hr>
        <a
        role="button"
        class="btn btn-primary"
        href="/marketplace">
        Marketplace
        </a>
    @else
        <p>Connect your DOVU wallet</p>          
        <a
        role="button"
        class="btn btn-primary"
        href="/wallet">
        Start earning
        </a>
    @endif
</div>
@endsection
