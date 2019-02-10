<?php
    $stack = [];
    $stack[] = [
        'url'   => route('product.category', [$taxon->taxonomy->slug, $taxon]),
        'label' => $taxon->name
    ];

    $parent = $taxon;
    while ($parent = $parent->parent) {
        $stack[] = [
            'url'   => route('product.category', [$parent->taxonomy->slug, $parent]),
            'label' => $parent->name
        ];
    }
    $stack[] = [
        'url'   => '#',
        'label' => $taxon->taxonomy->name
    ]
?>
@foreach(array_reverse($stack) as $item)
    <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
@endforeach
