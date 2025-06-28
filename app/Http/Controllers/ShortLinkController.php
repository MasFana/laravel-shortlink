<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\ShortLink;

class ShortLinkController extends Controller
{
    protected array $protectedCodes = [
        'masfana',
        'lawos',
        'repo',
    ];

    protected function isProtected(string $code): bool
    {
        return in_array($code, $this->protectedCodes);
    }

    // ✅ Optimized: Uses Cache, no column limiting
    public function index()
    {
        $shortLinks = Cache::remember('short_links.all', 10, function () {
            return DB::table('short_links')->get(); // ✅ Query builder, not Eloquent
        });

        return view('index', compact('shortLinks'));
    }

    // ✅ Optimized: Fast insert, clears cache
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|alpha_dash|unique:short_links,code|max:100',
            'url' => 'required|url|unique:short_links,url|max:2048'
        ]);

        DB::table('short_links')->insert([
            'url' => $validated['url'],
            'code' => $validated['code'] ?? Str::random(6),
            'click_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cache::forget('short_links.all');

        return redirect()->back()->with('success', 'Short link generated successfully!');
    }

    // ✅ Minimal Eloquent usage for view
    public function edit(ShortLink $shortLink)
    {
        abort_if($this->isProtected($shortLink->code), 403, 'Mangsud amat le :3');
        return view('edit', compact('shortLink'));
    }

    // ✅ Fast update with DB builder, no Eloquent overhead
    public function update(Request $request, ShortLink $shortLink)
    {
        abort_if($this->isProtected($shortLink->code), 403, 'Mangsud amat le :3');

        $validated = $request->validate([
            'code' => 'required|alpha_dash|unique:short_links,code,' . $shortLink->id,
            'url' => 'required|url|max:2048'
        ]);

        DB::table('short_links')->where('id', $shortLink->id)->update([
            'code' => $validated['code'],
            'url' => $validated['url'],
            'updated_at' => now()
        ]);

        Cache::forget('short_links.all');
        Cache::forget("short_link.code.{$validated['code']}");

        return redirect()->route('shorten.link.index')->with('success', 'Short link updated successfully!');
    }

    // ✅ DB delete, no Eloquent
    public function destroy(ShortLink $shortLink)
    {
        abort_if($this->isProtected($shortLink->code), 403, 'Mangsud amat le :3');

        DB::table('short_links')->where('id', $shortLink->id)->delete();

        Cache::forget('short_links.all');
        Cache::forget("short_link.code.{$shortLink->code}");

        return redirect()->back()->with('success', 'Short link deleted successfully!');
    }

    // ✅ Fully optimized: cache lookup, raw update
    public function shortenLink(string $code)
    {
        $shortLink = Cache::remember("short_link.code.{$code}", 60, function () use ($code) {
            return DB::table('short_links')->where('code', $code)->firstOrFail();
        });

        // Raw update: no read, no Eloquent hydration
        DB::table('short_links')->where('id', $shortLink->id)->update([
            'click_count' => DB::raw('click_count + 1'),
            'updated_at' => now()
        ]);

        return redirect($shortLink->url);
    }
}
