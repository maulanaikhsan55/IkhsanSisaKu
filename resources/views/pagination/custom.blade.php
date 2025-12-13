@if ($paginator->hasPages())
    <nav class="flex items-center justify-between" aria-label="Pagination Navigation">
        <div class="flex flex-1 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    Selanjutnya
                    <i class="fas fa-chevron-right ml-2"></i>
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                    Selanjutnya
                    <i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-center">
            <div class="flex items-center gap-2">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-sm text-green-700 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $maxPages = 5;
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();

                    // Calculate start and end pages to show
                    $start = max(1, $currentPage - floor($maxPages / 2));
                    $end = min($lastPage, $start + $maxPages - 1);

                    // Adjust start if we're near the end
                    if ($end - $start + 1 < $maxPages) {
                        $start = max(1, $end - $maxPages + 1);
                    }

                    $pagesToShow = range($start, $end);
                @endphp

                {{-- Show first page and ellipsis if needed --}}
                @if($start > 1)
                    <a href="{{ $paginator->url(1) }}" class="px-3 py-2 text-sm text-green-700 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">1</a>
                    @if($start > 2)
                        <span class="px-3 py-2 text-sm text-gray-400">...</span>
                    @endif
                @endif

                {{-- Show pages around current page --}}
                @foreach($pagesToShow as $page)
                    @if ($page == $currentPage)
                        <span class="px-3 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($page) }}" class="px-3 py-2 text-sm text-green-700 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Show last page and ellipsis if needed --}}
                @if($end < $lastPage)
                    @if($end < $lastPage - 1)
                        <span class="px-3 py-2 text-sm text-gray-400">...</span>
                    @endif
                    <a href="{{ $paginator->url($lastPage) }}" class="px-3 py-2 text-sm text-green-700 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">{{ $lastPage }}</a>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm text-green-700 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="px-3 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
