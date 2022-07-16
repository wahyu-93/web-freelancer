<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\AdvantageService;
use App\Models\AdvantageUser;
use App\Models\Order;
use App\Models\Service;
use App\Models\Tagline;
use App\Models\Thumbnail;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();

        return view('pages.landing.index', compact('services'));
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
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return abort(404);
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

    public function explore()
    {
        $services = Service::orderBy('created_at', 'desc')->get();

        return view('pages.landing.explore', compact('services'));
    }

    public function detail($id)
    {
        $service = Service::where('id', $id)->first();
        $advantageUsers = AdvantageUser::where('service_id', $service->id)->get();
        $advantageServices = AdvantageService::where('service_id', $service->id)->get();
        $thumbnails = Thumbnail::where('service_id', $service->id)->get();
        $taglines = Tagline::where('service_id', $service->id)->get();

        return view('pages.landing.detail', compact('service', 'advantageUsers', 'advantageServices', 'thumbnails', 'taglines'));
    }

    public function booking(Service $service)
    {   
        if(auth()->user()->id == $service->user_id){
            toast()->warning('Sorry, you cannot booking your own service!');
            return back();
        }

        // simpan order
        $order = Order::create([
            'buyer_id'  => auth()->user()->id,
            'freelance_id'  =>$service->user_id,
            'service_id'    => $service->id,
            'file'          => null,
            'note'          => null,
            'expired'       => date('y-m-d', strtotime('+3 days')),
            'order_status_id'   => 4
        ]);

        return redirect()->route('detail.booking.landing', compact('order'));
    }

    public function detail_booking(Order $order)
    {
        return view('pages.landing.booking', compact('order'));
    }
}
