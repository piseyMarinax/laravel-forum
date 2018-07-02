@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>
                    @foreach($threads as $thread)
                        <div class="card-body">
                            <article>
                                <div class="card panel-default">
                                    <div class="card-header">
                                        <a href="{{ $thread->path() }}">{{ $thread->title}}</a>
                                    </div>
                                    <div class="card-body">
                                        {{ $thread->body }}
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
