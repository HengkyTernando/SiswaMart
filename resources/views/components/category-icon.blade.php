{{--
    Category Icon Component
    Usage: <x-category-icon :icon="$category->icon" class="w-5 h-5" />
    SVG icons rendered inline, sized via explicit style on the SVG element.
--}}
@props(['icon' => 'category', 'class' => 'w-5 h-5'])

@php
// Each SVG has explicit style="display:block;width:100%;height:100%" so the
// outer <span> dimensions (driven by Tailwind w-* h-*) fully control the size.
$icons = [
    'pencil'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>',
    'book'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/></svg>',
    'backpack' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M20 8h-3V6c0-1.1-.9-2-2-2H9C7.9 4 7 4.9 7 6v2H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-5 0H9V6h6v2zm-1 9h-4v1H8v-3h2v1h4v-1h2v3h-2v-1z"/></svg>',
    'laptop'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg>',
    'shirt'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M16 2.5L12 7 8 2.5 2 5l2 4 2-1v12h12V8l2 1 2-4z"/></svg>',
    'sports'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.93V15h2v1.93c-1.32.24-2.68.24-4 0v-.02c.66.06 1.32.09 2 .02zm3-2.93h-4v-4h4v4zm1 2.93c1.32-.24 2.68-.24 4 0v.02A9.88 9.88 0 0 1 15 17v-1h-1v1h.01v-.07zM4 12c0-.34.02-.67.05-1h1.86l.86 3.22C5.03 13.45 4 12.8 4 12zm1.69 4.59L7 12h10l1.31 4.59C16.12 18.11 14.12 19 12 19s-4.12-.89-6.31-2.41zM20 12c0 .8-1.03 1.45-2.77 2.22L18.09 11H19.95c.03.33.05.66.05 1z"/></svg>',
    'category' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5S15.01 22 17.5 22s4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5S16.12 15 17.5 15s2.5 1.12 2.5 2.5S18.88 20 17.5 20zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/></svg>',
    'store'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M20 4H4v2l8 5 8-5V4zm0 14H4V8l8 5 8-5v10z"/></svg>',
    'cart'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.1 14h9.45c.75 0 1.41-.41 1.75-1.03L21 7H5.21l-.94-2H1v2h2l3.6 7.59L5.25 17c-.16.28-.25.61-.25.96C5 19.1 5.9 20 7 20h14v-2H7.42c-.13 0-.25-.11-.25-.25l.03-.12.9-1.63z"/></svg>',
    'food'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-8.03C11.34 12.84 13 11.12 13 9V2h-2v7zm10-3H18V2h-2v10h2v10h2V2h-2V6z"/></svg>',
    'drink'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="display:block;width:100%;height:100%;overflow:visible"><path d="M2 21h18v-2H2v2zM20 8h-2V5h2v3zm0-5H4v10c0 2.21 1.79 4 4 4h6c2.21 0 4-1.79 4-4v-3h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 5V5h2v3h-2z"/></svg>',
];

$svg = $icons[$icon] ?? $icons['category'];
@endphp

{{-- The span must have explicit width & height; Tailwind w-*/h-* sets those via CSS. --}}
<span {{ $attributes->merge(['class' => $class]) }}
      style="display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
    {!! $svg !!}
</span>
