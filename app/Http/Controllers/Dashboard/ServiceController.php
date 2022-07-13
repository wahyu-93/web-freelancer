<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;
use App\Models\AdvantageService;
use App\Models\AdvantageUser;
use App\Models\Service;
use App\Models\Tagline;
use App\Models\Thumbnail;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->all();
       
        // ubah service
        $service->update($data);

        // ubah advantage service
        foreach($data['advantages'] as $key => $item){
            if ($item != null ){
                if($advantageService = AdvantageService::find($key)){
                    $advantageService->advantage = $item;
                    $advantageService->update();
                }
                else{
                    AdvantageService::create([
                        'service_id'    => $service->id,
                        'advantage'     => $item
                    ]);
                };
            }
            else {
                if($advantageService = AdvantageService::find($key)){
                    $advantageService->delete();
                };
            };
        };
    
        // ubah advantage user
        foreach($data['services'] as $key => $item){
            if ($item != null ){
                if($advantageUser = AdvantageUser::find($key)){
                    $advantageUser->advantage = $item;
                    $advantageUser->update();
                }
                else{
                    AdvantageUser::create([
                        'service_id'    => $service->id,
                        'advantage'     => $item
                    ]);
                };
            }
            else {
                if($advantageUser = AdvantageUser::find($key)){
                    $advantageUser->delete();
                };
            };
        };

        // ubah thumbnail
        if($request->hasFile('thumbnails')){
            foreach($data['thumbnails'] as $key => $item){
                $updateThumbnail = Thumbnail::find($key);
                if ($updateThumbnail){
                    // hapus foto lama 
                    if(Storage::exists($updateThumbnail->thumbnail)){
                        Storage::delete($updateThumbnail->thumbnail);
                    };
    
                    // simpan foto baru dan update path dbnya     
                    $newPath = $item->store('public/assets/thumbnails/' . $service->id);
                    $updateThumbnail->thumbnail = $newPath;
                    $updateThumbnail->update();
                }
                else{
                    $newPath = $item->store('public/assets/thumbnails/' . $service->id);
                    Thumbnail::create([
                        'service_id'    => $service->id,
                        'thumbnail'     => $newPath,
                    ]);
                };
            };
        };

        // ubah tagline
        foreach($data['tagline'] as $key => $item){
            if ($item != null ){
                if($tagline = Tagline::find($key)){
                    $tagline->tagline = $item;
                    $tagline->update();
                }
                else{
                    tagline::create([
                        'service_id' => $service->id,
                        'tagline'    => $item
                    ]);
                };
            }
            else {
                if($tagline = tagline::find($key)){
                    $tagline->delete();
                };
            };
        };
        
        toast()->success('Update Has Been Success');
        return redirect()->route('member.service.index');
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
