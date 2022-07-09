@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <main class="h-full overflow-y-auto">
        <div class="container mx-auto">
            <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
                <div class="col-span-12">
                    <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                        Edit My Profile
                    </h2>
                    <p class="text-sm text-gray-400">
                        Enter your data Correctly & Properly
                    </p>
                </div>
            </div>
        </div>

        <section class="container px-6 mx-auto mt-5">
            <div class="grid gap-5 md:grid-cols-12">
                <main class="col-span-12 p-4 md:pt-0">
                    <div class="px-2 py-2 mt-2 bg-white rounded-xl">
                        
                        <form action="{{ route('member.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="">
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6">
                                            <div class="flex items-center mt-1">
                                                <span class="inline-block w-16 h-16 overflow-hidden bg-gray-100 rounded-full">
                                                    
                                                    @if($user->detailUser->photo == null)
                                                        <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                    @else
                                                        <img class="w-full h-full text-gray-300" src="{{ Storage::url($user->detailUser->photo) }}" alt="">
                                                    @endif
                                                    
                                                </span>

                                                
                                                <label for="photo" class="px-3 py-2 ml-5 text-sm font-medium leading-4 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    Choose File
                                                </label>

                                                <input type="file" name="photo" id="photo" class="hidden" accept="image/*">

                                                <a href="{{ route('member.delete.photo.profile') }}" class="px-3 py-2 ml-5 text-sm font-medium leading-4 text-red-700 bg-transparent rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    Delete
                                                </a>
                                            </div>
                                        </div>

                                        <div class="md:col-span-6 lg:col-span-3">
                                            <label for="name" class="block mb-3 font-medium text-gray-700 text-md">Full Name</label>
                                            <input 
                                                placeholder="Alex Jones" type="text" name="name" id="name" autocomplete="name" value="{{ $user->name ?? old('name') }}" 
                                                class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        </div>

                                        <div class="md:col-span-6 lg:col-span-3">
                                            <label for="role" class="block mb-3 font-medium text-gray-700 text-md">Role</label>
                                            <input 
                                                placeholder="Website Developer" 
                                                type="text" name="role" id="role" autocomplete="role" value="{{ $user->detailUser->role ?? old('role') }}"
                                                class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        </div>

                                        <div class="md:col-span-6 lg:col-span-3">
                                            <label for="email" class="block mb-3 font-medium text-gray-700 text-md">Email Address</label>
                                            <input 
                                                placeholder="Alex.jones@gmail.com" 
                                                type="text" name="email" id="email" autocomplete="email" value="{{ $user->email ?? old('email') }}"
                                                class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        </div>

                                        <div class="md:col-span-6 lg:col-span-3">
                                            <label for="contact_number" class="block mb-3 font-medium text-gray-700 text-md">Contact Number</label>
                                            <input placeholder="087721205555" type="number" name="contact_number" id="contact_number" autocomplete="contact_number" value="{{ $user->detailUser->contact_number ?? old('contact_number') }}"
                                                class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        </div>

                                        <div class="col-span-6">
                                            <label for="service-name" class="block mb-3 font-medium text-gray-700 text-md">Biografi</label>
                                            <textarea 
                                                placeholder="Enter your biography here.." 
                                                type="text" name="boigrafi" 
                                                id="boigrafi" 
                                                autocomplete="boigrafi" 
                                                class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" rows="4">{{ $user->detailUser->biografi ?? old('biografi') }}</textarea>
                                        </div>

                                        <div class="col-span-6">
                                            <label for="service-name" class="block mb-3 font-medium text-gray-700 text-md">My Experience</label>
                                        
                                            @foreach ($userExperiences as $index => $experience)
                                                <input 
                                                    placeholder="More than 9 years of experience" 
                                                    type="text" 
                                                    name="experience-{{ $index+1 }}" id="experience-{{ $index+1 }}" autocomplete="experience-{{ $index+1 }}" 
                                                    value="{{ $experience->experience }}" 
                                                    class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                            @endforeach
                                            
                                            @for ($i = $userExperiences->count(); $i < 3 ; $i++)
                                                <input 
                                                placeholder="Experience {{ $i + 1 }}" 
                                                type="text" 
                                                name="experience-{{ $i + 1 }}" id="experience-{{ $i + 1 }}" autocomplete="experience-{{ $i + 1 }}" 
                                                value="" 
                                                class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                            @endfor

                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 text-right sm:px-6">
                                    <a href="{{ route('member.dashboard.index') }}" class="inline-flex justify-center px-4 py-2 mr-4 text-sm font-medium text-gray-700 bg-white border border-gray-600 rounded-lg shadow-sm hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                                        Cancel
                                    </a>
                                    
                                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </section>
    </main>
@endsection