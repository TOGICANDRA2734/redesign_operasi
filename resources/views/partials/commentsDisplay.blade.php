@foreach($comments as $comment)
    
    <div class="display-comment mt-5 pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
        <div class="flex">
            <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit">
                <img alt="Midone - HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/' . $fakers[0]['photos'][1]) }}">
            </div>
            <div class="ml-3 flex-1">
                <div class="flex items-center">
                    <a href="" class="font-medium">{{ $comment->user->name }}</a>
                </div>
                <div class="text-slate-500 text-xs sm:text-sm">{{ $fakers[1]['formatted_times'][0] }}</div>
                <div class="mt-2">{{ $comment->body }}</div>
            </div>
        </div>
    </div>
@endforeach