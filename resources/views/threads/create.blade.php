@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new threads</div>
                <div class="card-body">
                    <form action="/threads" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="title">Channel</label>
                            <select class="form-control" name="channel_id" id="channel_id">
                                <?php 
                                    echo $channels;

                                ?>
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}">
                                        {{ $channel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" name="body" id="body" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Public</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
