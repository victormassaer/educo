<x-app-layout>
    <section class="px-44">
        <h2 class="text-primary-blue font-bold text-3xl">Profiles</h2>
        <h2 class="font-bold text-2xl text-tertiary my-5">{{$company->name}}</h2>
        <div class="flex flex-rows">
            @foreach($profiles as $profile)
                <a href="{{route('admin.profiles.detail', $profile->id)}}">
                    <div class="bg-white inline-block mr-4 rounded p-4 my-5 text-center mb-0 w-56 h-60 shadow-md">
                        <h2 class="font-bold text-2xl text-primary-blue">{{$profile->title}}</h2>
                        <h2 class="font-bold">members:</h2>
                        @foreach($profile->user as $key => $user)
                            @if($key <= 3)
                            <img src="{{$user->picture}}" class="rounded-full inline-block" alt="profile picture">
                            @endif
                        @endforeach
                        <h2 class="font-bold">mandatory skills:</h2>
                        @foreach($profile->skills as $key => $skill)
                            @if($key <= 3)
                            <div class="inline-block bg-gray-200 px-2 rounded my-1 mx-1">{{$skill->title}}</div>
                            @endif
                        @endforeach
                    </div>
                </a>
            @endforeach
        </div>

    </section>
</x-app-layout>



