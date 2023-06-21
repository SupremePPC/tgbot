@extends('layout')

<?php

if (!isset($subject)) {
    $subject = 'casino';
    //echo $subject;
} else {
    //echo $subject;
}

if (!isset($url)) {
    $url = '';
}

if (!isset($message)) {
    $message = '';
}

?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Enter a subject and url and hit submit.  Casino is the default.  Then prime your promos and prime your benefits.  Finally, get phrase.  Refresh to see different variations.</p>
                    {{ Form::open(array('url' => 'setup')) }}
                        <p>Enter subject: </p>
                        <input type="hidden" name="page" id="page" value="home">
                        <input type='text' name='subject' id='subject' value='{{ $subject }}'><br><br>
                        <p>Enter URL: </p>
                        <input type='text' name='url' id='url' value='{{ $url }}'><br><br>
                        <input type='submit' name='submit' value='Submit'>
                    {{ Form::close() }}
                    <br><br>
                    <ul>
                        <li><a href='/promos?subject={{ $subject }}'>Prime Promos</a></li>
                        <li><a href='/benefits?subject={{ $subject }}'>Prime Benefits</a></li>
                        <li><a href='/phrases?subject={{ $subject }}'>Get Phrase</a></li>
                    </ul>

                    <br><br>
                    {{ $message }}
                    <br><br>
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
