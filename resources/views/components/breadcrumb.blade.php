@props(['items' => []])

@if (count($items) > 0)
    <nav class="da-breadcrumb" aria-label="Breadcrumb">
        @foreach ($items as $item)
            @if (! $loop->first)<span aria-hidden="true">/</span>@endif

            @if (! $loop->last && isset($item['url']))
                <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
            @else
                <span @if ($loop->last) aria-current="page" @endif>{{ $item['label'] }}</span>
            @endif
        @endforeach
    </nav>
@endif
