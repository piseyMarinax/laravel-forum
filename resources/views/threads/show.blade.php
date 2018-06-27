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
    </div>
</div>
@endsection
