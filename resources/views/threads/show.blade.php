@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card panel-default">
                <div class="card-header">{{ $thread->title}}</div>
                <div class="card-body">
                    {{ $thread->body }} 
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card panel-default">
                @foreach($thread->replies as $reply)
                <div class="card-header">
                    <a href="#">
                        {{ $reply->owner->name }}
                    </a>  said {{ $reply->created_at->diffForHumans()}}...</div>
                <div class="card-body">
                    {{ $reply->body }} 
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
