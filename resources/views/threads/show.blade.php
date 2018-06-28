@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card panel-default">
                <div class="card-header">
                   <a href="#">{{ $thread->creatorName() }}</a> Posts : {{ $thread->title}}
                </div>
                <div class="card-body">
                    {{ $thread->body }} 
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card panel-default">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @if(auth()->check())
            <div class="col-md-8" style="padding-top:20px">
                <form action="{{ $thread->path().'/replies'}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea class="form-control" name="body" id="body" rows="5" placeholder="Have something to say"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        @else
             <div class="col-md-8 text-center" style="padding-top:20px; ">
                <p>Please <a href="{{ route('login') }}">sing in</a>  to participate in this dicusstion ...</p>
            </div>
        @endif
    </div>
</div>
@endsection
