<?php

namespace App\Http\Controllers;

use App\Helpers\UrlShortener;
use App\Models\Link;
use App\Models\LinksUsersRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Auth::user()->links()->with(['tracking' => function ($query) {
            $query->select(['link_id', DB::Raw('COUNT(1) AS count')])
                ->groupBy('link_id');
        }])->orderBy('id', 'desc')->get();

        $data = [
            'links' => $links
        ];

        if (Session::has('shortenLink')) {
            $data['shortenLink'] = Session::get('shortenLink');
            Session::forget('shortenLink');

        }
        return view('links.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'link' => 'required|url',
        ]);

        if ($validator->fails()) {

            return redirect('links/create')
                ->withErrors($validator)
                ->withInput();
        }

        $url = trim($request->get('link'));

        $link = Link::firstOrCreate([
            'url' => $url
        ]);

        LinksUsersRelation::firstOrCreate([
            'user_id' => Auth::id(),
            'link_id' => $link->id
        ]);

//        session()->flash('shorten', url(UrlShortener::toBase($link->id)));

        Session::put('shortenLink', url(UrlShortener::toBase($link->id)));

        return redirect('links');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->links()->detach($id);

        return redirect('links');
    }
}
