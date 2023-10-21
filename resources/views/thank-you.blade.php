@extends('layout/layout-common')
@section('space-work')
    <div class="container">
        <div class="text-center">
            <h3>Thanks for submit your Exam, {{ Auth::user()->name }}</h3>
            <a href="/dashboard" class="btn btn-info">go back</a>

        </div>

    </div>
@endsection