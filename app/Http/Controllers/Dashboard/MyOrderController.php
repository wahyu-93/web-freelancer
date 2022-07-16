<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MyOrder\UpdateMyOrderRequest;
use App\Models\AdvantageService;
use App\Models\AdvantageUser;
use App\Models\Order;
use App\Models\Service;
use App\Models\Tagline;
use App\Models\Thumbnail;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('freelance_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
    
        return view('pages.dashboard.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $service = Service::where('id', $order->service_id)->first();
        $thumbnails = Thumbnail::where('service_id', $service->id)->get();
        $advantageServices = AdvantageService::where('service_id', $service->id)->get();
        $advantageUsers = AdvantageUser::where('service_id', $service->id)->get();
        $tagline = Tagline::where('service_id', $service->id)->get();


        return view('pages.dashboard.order.detail',compact('service', 'thumbnails', 'advantageServices', 'advantageUsers', 'tagline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('pages.dashboard.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMyOrderRequest $request, Order $order)
    {
        $path = '';
        if($request->hasFile('file')){
            $file = $request->file('file');
            $path = $file->store('public/assets/order/' . $order->id);
        };

        $order->file = $path;
        $order->note = $request->note;
        $order->update();

        toast()->success('Submit Order has been success');
        return redirect()->route('member.order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }

    public function accept(Order $order)
    {
        $order->order_status_id = 2;
        $order->save();

        toast()->success('Accept Order Has Been Success');
        return back();
    }

    public function reject(Order $order)
    {   
        $order->order_status_id = 3;
        $order->save();

        toast()->success('Reject Order Has Been Success');
        return back();
    }
}
