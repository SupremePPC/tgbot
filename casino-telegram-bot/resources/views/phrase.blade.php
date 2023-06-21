@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
  
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <p>To change values, enter subject and url and hit submit.  Casino is the default.  Then prime your promos and prime your benefits.  Finally, get phrase.  Refresh to see different variations.</p>
                    {{ Form::open(array('url' => 'setup')) }}
                        <p>Enter subject: </p>
                        <input type="hidden" name="page" id="page" value="phrase">
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

                    <h4>Phrase</h4>
                    
                    {{ $phrase }}
                    <p>Visit <a href="{{ $url }}">{{ $url }}</a> to find out more.</p>

                    <br><br>

                    {{ $error }}
                    <br><br>
                    <p><a href="/phrases?subject=casino">Refresh</a>
                    <br>
                    <p><a href="/home">Home</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection