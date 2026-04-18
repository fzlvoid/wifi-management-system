@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
    {{-- Mobile: simple previous / next --}}
    <div class="flex items-center justify-between w-full sm:hidden">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-300 bg-white border border-slate-100 rounded-md">&laquo; Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50">&laquo; Sebelumnya</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50">Berikutnya &raquo;</a>
        @else
            <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-300 bg-white border border-slate-100 rounded-md">Berikutnya &raquo;</span>
        @endif
    </div>

    {{-- Desktop: full pagination --}}
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between w-full">
        <div>
            <p class="text-sm text-slate-500">Menampilkan halaman <span class="font-medium text-slate-700">{{ $paginator->currentPage() }}</span> dari <span class="font-medium text-slate-700">{{ $paginator->lastPage() }}</span></p>
        </div>

        <div>
            <ul class="inline-flex -space-x-px items-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li><span aria-disabled="true" aria-label="Previous" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-300 bg-white border border-slate-100 rounded-l-md">&laquo;</span></li>
                @else
                    <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-l-md hover:bg-slate-50">&laquo;</a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li><span class="px-3 py-1.5 text-sm text-slate-400 bg-white border border-slate-100">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><span aria-current="page" class="px-3 py-1.5 text-sm font-semibold text-slate-900 bg-white border border-slate-300">{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $url }}" class="px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 hover:bg-slate-50">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-r-md hover:bg-slate-50">&raquo;</a></li>
                @else
                    <li><span aria-disabled="true" aria-label="Next" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-300 bg-white border border-slate-100 rounded-r-md">&raquo;</span></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@endif
