@php
    $site = config('site');
    $organization = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        '@id' => url('/').'#organization',
        'name' => $site['name'],
        'description' => $site['description'],
        'url' => url('/'),
        'logo' => asset('media/logo.webp'),
        'image' => asset($site['og_image']),
        'email' => $site['contact']['email'],
        'telephone' => $site['contact']['phone'],
        'address' => $site['contact']['location'],
        'sameAs' => array_values($site['social']) ?: null,
    ]);
@endphp
<script type="application/ld+json">{!! json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
