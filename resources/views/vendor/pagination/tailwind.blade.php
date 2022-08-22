@if ($paginator->hasPages())
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
        <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="w-full sm:w-auto sm:mr-auto">
            <ul class="pagination sm:hidden">
                @if ($paginator->onFirstPage())
                    <li class="page-item">
                        <span class="page-link">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <span class="page-link">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </a>
                    </li>
                @endif
            </ul>   
                <ul class="hidden pagination sm:flex">
            
                @if ($paginator->onFirstPage())
                    <li class="page-item">
                        <span class="page-link">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                @endif

                <?php
                    $start = $paginator->currentPage() - 2; // show 3 pagination links before current
                    $end = $paginator->currentPage() + 2; // show 3 pagination links after current
                    if($start < 1) {
                        $start = 1; // reset start to 1
                        $end += 1;
                    } 
                    if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
                ?>

                @if($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url(1) }}">{{1}}</a>
                    </li>
                    @if($paginator->currentPage() != 4)
                        {{-- "Three Dots" Separator --}}
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                    @endif
                @endif
                    @for ($i = $start; $i <= $end; $i++)
                        <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $paginator->url($i) }}">{{$i}}</a>
                        </li>
                    @endfor
                @if($end < $paginator->lastPage())
                    @if($paginator->currentPage() + 3 != $paginator->lastPage())
                        {{-- "Three Dots" Separator --}}
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{$paginator->lastPage()}}</a>
                    </li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <span class="page-link">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <select id="selectPage" class="w-20 form-select box mt-3 sm:mt-0">
            <option>10</option>
            <option>25</option>
            <option>35</option>
            <option>50</option>
        </select>
    </div>
@endif
