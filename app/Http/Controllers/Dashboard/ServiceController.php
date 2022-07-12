<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Models\AdvantageService;
use App\Models\AdvantageUser;
use App\Models\Service;
use App\Models\Tagline;
use App\Models\Thumbnail;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return view('pages.dashboard.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $storeService = $request->all();

        // simpan service
        $storeService['user_id'] = auth()->user()->id;
        $service = Service::create($storeService);
        
        // simpan advantages Service
        foreach($storeService['advantages'] as $key => $item){
            if($item != null){
                $saveService[] = [
                    'service_id'    => $service->id,
                    'advantage'     => $item,
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
            };
        
        };

        AdvantageService::insert($saveService);

        // simpan advantages user
        foreach($storeService['services'] as $key => $item){
            if($item != null){
                $saveAdvantageUser[] = [
                    'service_id'    => $service->id,
                    'advantage'     => $item,
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
            };
        };

        AdvantageUser::insert($saveAdvantageUser);

        // save thumbnail
        foreach($storeService['thumbnails'] as $key => $item ){
            if($item != null){
                $path = $item->store('public/assets/thumbnails/' . $service->id);
                
                $saveThumbnails[] = [
                    'service_id'    => $service->id, 
                    'thumbnail'     => $path,
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
            };
        };

        Thumbnail::insert($saveThumbnails);

        // save tagline
        foreach($storeService['tagline'] as $key => $item){
            if($item != null){
                $saveTagline[] = [
                    'service_id'    => $service->id,
                    'tagline'       => $item,
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
            };
        };

        Tagline::insert($saveTagline);
        
        toast()->success('Save Has Been Success');
        return redirect()->route('member.service.index');
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
    public function edit(Service $service)
    {
        $advantageUsers = AdvantageUser::where('service_id', $service->id)->get();
        $advantageServices = AdvantageService::where('service_id', $service->id)->get();
        $thumbnails = Thumbnail::where('service_id', $service->id)->get();
        $taglines = Tagline::where('service_id', $service->id)->get();

        return view('pages.dashboard.service.edit', compact('service', 'advantageUsers', 'advantageServices', 'thumbnails', 'taglines'));
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
        dd($request);
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
}
