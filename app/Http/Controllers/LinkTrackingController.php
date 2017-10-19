<?php

namespace App\Http\Controllers;

use App\Helpers\UrlShortener;
use App\Models\Link;
use App\Models\LinkTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkTrackingController extends Controller
{

    public function redirectToLink($shortenKey, Request $request)
    {
        $link = Link::where('id', UrlShortener::toBase10($shortenKey))
            ->with('users')->first();

        if (!$link) {
            abort(404);
        }

        if ($link->users->first()->id != Auth::Id()) {
            $linkTracking = new LinkTracking();

            $linkTracking->link_id = $link->id;
            $linkTracking->ip = $request->ip();
            $linkTracking->save();
        }

        return redirect()->to($link->url);
    }

}
