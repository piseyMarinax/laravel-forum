 <div class="card-header">
     <div class="level">
         <h4 class="flex">
             <a href="#">
                 {{ $reply->owner->name }}
             </a>  said {{ $reply->created_at->diffForHumans()}}...
         </h4>
        <form method="POST" action="/replies/{{ $reply->id}}/favorites">
            {{ csrf_field()}}
        <button type="submit" class="btn btn-danger" {{ $reply->isFavorited() ? 'disabled' : ''}}>
                {{ $reply->favorites()->count()}} {{ str_plural('Favorite',$reply->favorites()->count()) }} </button>
         </form>
     </div>
 </div>
<div class="card-body">
    {{ $reply->body }} 
</div>