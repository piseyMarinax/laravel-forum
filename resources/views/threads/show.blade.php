@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card panel-default">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                           <a href="{{ route('profile',$thread->creatorName()) }}">{{ $thread->creatorName() }}</a> Posts : {{ $thread->title}}
                        </span>
                        <span>
                          @can('update',$thread)
                            <form action="{{ $thread->path()}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          @endcan
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    {{ $thread->body }} 
                </div>
            </div>
            <br>

            @foreach($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}
            <div>
                @if(auth()->check())
                    <div style="padding-top:20px">
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
        <div class="col-md-4">
            <div class="card panel-default">
                <div class="card-body">
                    <p>This is thread was publish <b>{{ $thread->created_at->diffForHumans() }}</b> </p>
                    created by <a href="{{ route('profile',$thread->creatorName()) }}">{{ $thread->creatorName() }}</a>
                    and currently has {{ $thread->replies_count }}
                    {{ str_plural('comment', $thread->replies_count) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
