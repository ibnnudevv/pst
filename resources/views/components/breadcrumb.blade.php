@props(['breadcrumbs' => [], 'pageTitle' => ''])

<div>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            @foreach ($breadcrumbs as $index => $breadcrumb)
                <li class="inline-flex items-center">
                    @if (!$loop->last)
                        <a href="{{ $breadcrumb['url'] }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                            {{ $breadcrumb['label'] }}
                        </a>
                    @else
                        <span
                            class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $breadcrumb['label'] }}</span>
                    @endif
                </li>
                @if (!$loop->last)
                    <li>
                        <svg class="h-5 w-5 text-gray-400 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m9 5 7 7-7 7" />
                        </svg>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
    <h2 class="mt-3 text-lg font-semibold text-gray-900 dark:text-white">
        {{ $pageTitle }}
    </h2>
</div>
