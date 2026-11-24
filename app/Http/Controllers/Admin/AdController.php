<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use App\Utilities\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemsPerPage = auth()->user()->preferences->items_per_page;
        $ads = Ad::paginate($itemsPerPage);
        return view('admin.ads.index')->withAds($ads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdRequest $request)
    {
        $ad = Ad::create([
            'description' => $request->input('description'),
            'link' => $request->input('link'),
            'preset' => $request->input('preset'),
        ]);

        if ($request->hasFile('advert')) {
            $ad->clearMediaCollection('featured');
            $ad->addMediaFromRequest('advert')
                ->toMediaCollection('featured');
        }

        Helper::clearSiteCache();

        return redirect()->route('admin_ads.index')->with(['success-message' => "Ad created successfully."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $ad = Ad::findOrFail($id);
        return view('admin.ads.show')->withAd($ad);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdRequest  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdRequest $request, int $id)
    {
        $ad = Ad::findOrFail($id);

        $ad->update([
            'description' => $request->input('description'),
            'link' => $request->input('link'),
            'preset' => $request->input('preset'),
        ]);

        if ($request->hasFile('advert')) {
            $ad->clearMediaCollection('featured');
            $ad->addMediaFromRequest('advert')
                ->toMediaCollection('featured');
        }

        Helper::clearSiteCache();

        return redirect()->route('admin_ads.index')->with(['success-message' => "Ad updated successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $ad = Ad::findOrFail($id);
        $ad->clearMediaCollection();
        Ad::destroy($id);
        Helper::clearSiteCache();
        return redirect()->route('admin_ads.index')->with(['success-message' => "Ad deleted successfully."]);
    }
}
