<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.index')->withPages(\App\Page::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = \App\Page::create($request->all() + ['user_id' => \Auth::user()->id]);

        return \Redirect::route('pages.edit', $page['id'])->with('message', 'Page created!');
    }

    /**
     * @param \App\Page $page
     * @return mixed
     */
    public function show(Page $page)
    {
        return view('pages.show')->withPage($page)->withSlug('page/'.$page['slug']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('pages.edit')->withPage($page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Page $page
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $data = $request->all();
        if (isset($data['active']) == false) {
            $data['active'] = false;
        }

        $page->update($data);

        return \Redirect::route('pages.edit', $page['id'])->with('message', 'Page updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->destroy($page['id']);

        return \Redirect::route('pages.index')->with('message', 'Page deleted!');
    }
}