<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Profile\UpdateDetailUserRequest;
use App\Http\Requests\Dashboard\Profile\UpdateProfileRequest;
use App\Models\DetailUser;
use App\Models\ExperienceUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
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
        //
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
        $user = User::with('detailUser')->where('id', auth()->user()->id)->first();
        $userExperiences = ExperienceUser::where('detail_user_id', $user->detailUser->id)->get();
    
        return view('pages.dashboard.profile', compact('user', 'userExperiences'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $updateProfileRequest, UpdateDetailUserRequest $updateDetailUserRequest, $id)
    {
        // ubah foto
        $updateProfile = $updateProfileRequest->all();
        $updateDetailProfile = $updateDetailUserRequest->all();
        $file = $updateProfileRequest->file('photo');
        
        if($updateProfileRequest->hasFile('photo')){
            // hapus foto lama
            $user = DetailUser::where('user_id', auth()->user()->id)->first();
                
            if (Storage::exists($user->photo)){
                Storage::delete($user->photo);
            };

            // simpan foto baru
            $pathFotoBaru = $file->store('public/assets/images-user/' . $user->user_id);
            $updateProfile['photo'] = $pathFotoBaru;
        };
        
        // ubah detail user 
        $detailUser = DetailUser::find(auth()->user()->id);
        $detailUser->update($updateProfile);

        // ubah user
        $saveUser = User::find(auth()->user()->id);
        $saveUser->update($updateDetailProfile);
        
        // ubah experience
        foreach($updateDetailProfile['experience'] as $key => $item){
            if($item != null){
                $exp = ExperienceUser::find($key);
                if($exp){
                    $exp->experience = $item;
                    $exp->save();
                }
                else {
                    if ($item != null){
                        ExperienceUser::create([
                            'detail_user_id' => $detailUser->id,
                            'experience'     => $item
                        ]);
                    }
                }
            }
            else{
                ExperienceUser::destroy($key);
            }
        };
                
        toast()->success('Update Profile Has Been Success');
        return back();  
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

    public function deletePhoto()
    {
        $user = DetailUser::where('user_id', auth()->user()->id)->first();
        
        // hapus file foto
        if(Storage::exists($user->photo)){
            Storage::delete($user->photo);
        };

        // update db foto
        $user->photo = null;
        $user->save();

        toast()->success('Delete Photo Profile Has Been Success');
        return back();
    }
}
