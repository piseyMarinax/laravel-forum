@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>
                    @forelse($threads as $thread)
                        <div class="card-body">
                            <article>
                                <div class="card panel-default">
                                    <div class="card-header">
                                        <div class="level">
                                            <h4 class="flex">
                                                <a href="{{ $thread->path() }}">{{ $thread->title}}</a>
                                            </h4>
                                            <strong>
                                                <a href="{{ $thread->path() }}">
                                                    {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                                                </a>
                                            </strong>

                                        </div>

                                    </div>
                                    <div class="card-body">
                                        {{ $thread->body }}
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="card-body">
                            <article>
                            <p>There are no recode</p>
                            </article>
                        </div>
                    @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
