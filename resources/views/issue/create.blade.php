@extends('layouts.app')

@section('content')
    <div class="container">
        @include('flash::message')
        <form method="POST" action="/issue">
            @csrf
            <div class="form-group">
                <label for="exampleFormControlInput1">Scooter ID number</label>
                <input type="text" class="form-control" name="scooter_id">
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Report issue</label>
                <textarea class="form-control" name="body" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
