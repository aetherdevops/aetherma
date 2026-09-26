@extends('layouts.public')

@php
    $site = config('site');
    $analytics = $site['analytics'];
    $email = $site['contact']['email'];
    $updated = \Illuminate\Support\Carbon::parse($site['privacy_updated']);
@endphp

@section('title', 'Privacy & cookies — '.$site['name'])
@section('description', 'How '.$site['name'].' handles the personal data you share through this website, and which cookies it uses.')

@section('content')
<article class="pt-28">
    <div class="container-narrow section-pad !pt-8">
        <div class="prose prose-aether mx-auto max-w-3xl">
            <h1>Privacy &amp; cookies</h1>
            <p class="lead">This page explains what personal data this website collects, why, and what control you have over it. Last updated {{ $updated->format('j F Y') }}.</p>

            <h2>Who we are</h2>
            <p>This website is run by {{ $site['name'] }} (“we”, “us”), which is responsible for the personal data described here.
                @if ($email)
                    You can reach us about privacy at any time at <a href="mailto:{{ $email }}">{{ $email }}</a>.
                @else
                    You can reach us about privacy through the <a href="{{ route('home') }}#contact">contact form</a>.
                @endif
            </p>

            <h2>What we collect and why</h2>
            <h3>When you contact us</h3>
            <p>When you send the contact form we receive your <strong>name</strong>, <strong>email address</strong> and <strong>message</strong>. We use them only to reply to you and to discuss the work you asked about. The legal basis is our legitimate interest in answering your enquiry, or taking steps at your request before entering into a contract.</p>
            <p>The message is stored in our website's database and sent to our team by email. We keep enquiries for up to 24 months after our last contact, unless they become part of a client relationship, and then delete them. You can ask us to delete yours sooner.</p>

            <h3>Technical data</h3>
            <p>Like every website, our hosting provider's servers briefly log technical data such as your IP address, browser type and the pages requested. We use it to keep the site secure and working, for example to block spam and abuse of the contact form.</p>

            <h2 id="cookies">Cookies</h2>
            <p>We use only the cookies needed for the website to work:</p>
            <ul>
                <li><strong>Session cookie</strong>: keeps the website working while you browse (for example, showing a “thank you” message after you send the form). It expires after two hours.</li>
                <li><strong>XSRF-TOKEN</strong>: protects the contact form against forged submissions. It expires with the session.</li>
            </ul>
            <p>These are strictly necessary, so they don't need your consent.</p>

            @if ($analytics['plausible_domain'])
                <h3>Analytics</h3>
                <p>We use <a href="https://plausible.io/data-policy" target="_blank" rel="noopener">Plausible Analytics</a> to count visits and see which pages are popular. Plausible uses no cookies and collects no personal data. Visits are counted anonymously and cannot be linked to you.</p>
            @endif

            @if ($analytics['ga4_id'])
                <h3>Google Analytics (only with your consent)</h3>
                <p>If you click “Accept analytics” in the cookie banner, we load Google Analytics 4, which sets cookies (<code>_ga</code>, <code>_ga_*</code>, kept up to 2 years) to measure how visitors use the site. IP addresses are anonymised. Google may process this data outside the EU under the EU–US Data Privacy Framework. If you choose “Only essential”, Google Analytics is never loaded.</p>
                <p><button type="button" onclick="window.resetCookieConsent && window.resetCookieConsent()" class="btn-primary !normal-case !tracking-normal">Change my cookie choice</button></p>
            @endif

            @if (! $analytics['plausible_domain'] && ! $analytics['ga4_id'])
                <p>We don't use analytics, advertising or social media tracking cookies.</p>
            @endif

            <p>Our fonts are hosted on our own server, so loading this site sends nothing to Google Fonts or other font services.</p>

            <h2>Who we share data with</h2>
            <p>We never sell your data. We only share it with the service providers that run this website for us: our web hosting and email providers{{ $analytics['ga4_id'] ? ', and Google if you accept analytics cookies' : '' }}. They may only use it to provide their service to us.</p>

            <h2>Your rights</h2>
            <p>Under data protection law (including the GDPR) you can ask us to:</p>
            <ul>
                <li>give you a copy of the personal data we hold about you,</li>
                <li>correct it, or delete it,</li>
                <li>restrict or object to how we use it,</li>
                <li>send it to you or another organisation in a portable format.</li>
            </ul>
            <p>To do any of this, contact us using the details above. We'll answer within one month. You also have the right to complain to your local data protection authority.</p>

            <h2>Changes to this policy</h2>
            <p>If we change how we handle personal data, we'll update this page and the date at the top.</p>
        </div>
    </div>
</article>
@endsection
