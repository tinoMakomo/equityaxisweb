<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSubscriberRequest;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemsPerPage = auth()->user()->preferences->items_per_page;
        $subscribers = Subscriber::paginate($itemsPerPage);
        return view('admin.subscribers.index')->withSubscribers($subscribers);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $subscriber = Subscriber::find($id);
        return view('admin.subscribers.show')->withSubscriber($subscriber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscriberRequest  $request
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriberRequest $request, int $id)
    {
        $subscriber = Subscriber::find($id);
        $subscriber->update($request->except('_token'));

        return redirect()->route('admin_subscribers.index')->with(['success-message' => "Subscriber updated successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $subscriber = Subscriber::destroy($id);
        return redirect()->route('admin_subscribers.index')->with(['success-message' => "Subscriber deleted successfully."]);
    }
}
