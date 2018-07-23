<div id="reply-{{$reply->id}}" class="card panel-default">
    <div class="card-header">
        <div class="level">
                <h4 class="flex">
                    <a href="{{ route('profile',$reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a>  said {{ $reply->created_at->diffForHumans()}}...
                </h4>

                <form method="POST" action="/replies/{{ $reply->id}}/favorites">
                    {{ csrf_field()}}
                    <button type="submit" class="btn btn-info" {{ $reply->isFavorited() ? 'disabled' : ''}}>
                    {{ $reply->favorites_count }} {{ str_plural('Favorite',$reply->favorites_count) }} </button>
                 </form>

             </div>
         </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>

    @can('update',$reply)

        <div class="card footer">
            <form method="POST" action="/replies/{{ $reply->id }}">
                {{ csrf_field()}}
                {{ method_field("DELETE") }}
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    @endcan
</div>