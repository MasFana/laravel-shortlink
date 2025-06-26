<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ShortLink;

class ShortLinkController extends Controller
{
    protected $protectedCodes = [
        'masfana',
        'lawos',
        'repoini',
    ];

    protected function Jaga(string $code)
    {
        if (in_array($code, $this->protectedCodes)) {
            return redirect()->back()->with('error', 'Mangsud amat le :3');
        }
        return false;
    }

    public function index()
    {
        $shortLinks = ShortLink::latest()->get();
        return view('index', compact('shortLinks'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'code' => 'nullable|unique:short_links,code',
            'url' => 'required|url|unique:short_links,url|max:2048'
        ]);

        ShortLink::create([
            'url' => $request->url,
            'code' => $request->code ?? Str::random(6),
            'click_count' => 0
        ]);

        return redirect()->back()->with('success', 'Short link generated successfully!');
    }

    public function edit(ShortLink $shortLink)
    {
        $check = $this->Jaga($shortLink->code);
        if ($check) {
            return $check;
        }

        return view('edit', compact('shortLink'));

    }

    public function update(Request $request, ShortLink $shortLink)
    {

        $check = $this->Jaga($shortLink->code);
        if ($check) {
            return $check;
        }

        $request->validate([
            'code' => 'required|unique:short_links,code',
            'url' => 'required|url|max:2048'
        ]);

        $shortLink->update([
            'url' => $request->url,
            'code' => $request->code
        ]);

        return redirect()->route('shorten.link.index')->with('success', 'Short link updated successfully!');
    }

    public function destroy(ShortLink $shortLink)
    {
        $check = $this->Jaga($shortLink->code);
        if ($check) {
            return $check;
        }

        $shortLink->delete();
        return redirect()->back()->with('success', 'Short link deleted successfully!');
    }

    public function shortenLink($code)
    {
        $shortLink = ShortLink::where('code', $code)->firstOrFail();
        $shortLink->increment('click_count');
        return redirect($shortLink->url);
    }
}
