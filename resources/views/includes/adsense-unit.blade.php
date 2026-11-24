@php
    $client = config('services.adsense.client');
    $type = $type ?? 'in-feed';
    $slot = $slot ?? ($type === 'in-article'
        ? config('services.adsense.in_article_slot')
        : config('services.adsense.in_feed_slot'));
@endphp

@if (!empty($client) && !empty($slot))
    <div class="adsense-container my-3 text-center">
        @if ($type === 'in-article')
            <ins class="adsbygoogle"
                 style="display:block; text-align:center;"
                 data-ad-layout="in-article"
                 data-ad-format="fluid"
                 data-ad-client="{{ $client }}"
                 data-ad-slot="{{ $slot }}"></ins>
        @else
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $client }}"
                 data-ad-slot="{{ $slot }}"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
        @endif
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
@endif
