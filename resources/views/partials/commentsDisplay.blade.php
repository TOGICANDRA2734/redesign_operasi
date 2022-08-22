@foreach($comments as $comment)
    
    <div class="display-comment mt-5 pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
        <div class="flex items-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit">
                <img alt="Foto User" class="rounded-full" src="{{$comment->user->getPhotoAttribute()}}">
            </div>
            <div class="ml-3 flex-1">
                <div class="flex items-center">
                    <a href="" class="font-medium">{{ $comment->user->name }} </a>
                </div>
                <div class="text-slate-500 text-xs sm:text-xs">{{ $comment->created_at }}</div>
                <div class="mt-2">{{ $comment->body }}</div>
            </div>
        </div>
    </div>
@endforeach