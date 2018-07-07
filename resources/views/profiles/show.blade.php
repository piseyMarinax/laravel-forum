
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="page-header">
                    <h1> {{$profileUser->name}} <small> Sine {{ $profileUser->created_at->diffForHumans() }}</small> </h1>
                </div>
                @foreach($threads as $thread)
                    <div class="card panel-default">

                        <div class="card-header">
                            <div class="level">
                        <span class="flex">
                            <a href="{{route('profile',$thread->creatorName()) }}">{{ $thread->creatorName() }}</a> Posts : {{ $thread->title}}
                        </span>
                                <span>
                            {{ $thread->created_at->diffForHumans()}}
                        </span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                    <br>
                @endforeach
                {{$threads->links()}}
            </div>
        </div>

    </div>
@endsection