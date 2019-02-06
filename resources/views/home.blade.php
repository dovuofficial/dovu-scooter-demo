@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Connect your DOVU Wallet</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4></h4>
                    <a
                        role="button"
                        class="btn btn-primary"
                        href="/wallet">
                            Start earning
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
