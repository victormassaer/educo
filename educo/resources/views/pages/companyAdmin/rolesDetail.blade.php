<x-app-layout>
    <section class="px-44">
        <a href="{{ url()->previous() }}" class="p-3 bg-white rounded text-primary font-bold text-2xl mr-5 mb-3"><--</a>
        <h2 class="text-primary-blue font-bold text-3xl inline-block">{{$profile->title}}</h2>
        <h3 class="text-tertiary font-bold text-2xl mt-3">Skills</h3>
        @foreach($profile->skills as $key => $skill)
            <div class="inline-block bg-gray-200 px-2 rounded my-2 mr-2 shadow-md">{{$skill->title}}</div>
        @endforeach

        <h3 class="text-tertiary font-bold text-2xl mt-3">Employees</h3>
        @foreach($profile->user as $key => $user)
            <a href="{{route('admin.userDetail.index', $user->id)}}">
                <div class="bg-white rounded p-2 my-2 w-8/12 shadow-md">
                    <img src="{{asset($user->picture)}}" class="rounded-full inline-block" alt="profile picture">
                    <h3 class="font-bold text-xl inline-block">{{$user->name}}</h3>
                </div>
            </a>
        @endforeach
    </section>
</x-app-layout>



