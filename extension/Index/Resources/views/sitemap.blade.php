<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Pages -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('user-login') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('user-register') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('index-blog-all') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('pricing-index') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Pages -->
    @foreach ($pages as $page)
        <url>
            <loc>{{ route('index-page-single', ['uri' => $page->location]) }}</loc>
            <lastmod>{{ $page->updated_at ? $page->updated_at->tz('UTC')->toAtomString() : ($page->created_at ? $page->created_at->tz('UTC')->toAtomString() : date('c')) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <!-- Blogs -->
    @foreach ($blogs as $blog)
        <url>
            <loc>{{ route('index-blog-single', ['uri' => $blog->location]) }}</loc>
            <lastmod>{{ $blog->updated_at ? $blog->updated_at->tz('UTC')->toAtomString() : ($blog->created_at ? $blog->created_at->tz('UTC')->toAtomString() : date('c')) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Public User Profiles -->
    @foreach ($users as $user)
        <url>
            <loc>{{ url($user->username) }}</loc>
            <lastmod>{{ $user->updated_at ? $user->updated_at->tz('UTC')->toAtomString() : ($user->created_at ? $user->created_at->tz('UTC')->toAtomString() : date('c')) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach

</urlset>
