
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="page-header">
                    <h1> {{$profileUser->name}} <small> Sine {{ $profileUser->created_at->diffForHumans() }}</small> </h1>
                </div>
                @foreach($activities as $date => $activity)
                    <br>
                    <div class="page-header">
                          <h3>
                              {{$date}}
                          </h3>

                        <hr>

                    </div>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.$record->type"))
                            @include("profiles.activities.$record->type",['activity' => $record])
                        @endif
                    @endforeach

                @endforeach
                {{--{{$threads->links()}}--}}
            </div>
        </div>
    </div>
@endsection