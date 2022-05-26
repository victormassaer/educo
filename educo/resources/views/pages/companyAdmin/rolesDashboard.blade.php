<x-app-layout>
    <section class="px-44">
        <h2 class="text-primary-blue font-bold text-3xl">Roles</h2>
        <h2 class="font-bold text-2xl text-tertiary my-5">{{$company->name}}</h2>
        @foreach($profiles as $profile)
            <div class="bg-white inline-block mr-4 rounded p-4 my-5 text-center mb-0 w-56 h-52">
                <h2 class="font-bold text-2xl text-primary-blue">{{$profile->title}}</h2>
                <h2 class="font-bold">members:</h2>
                @foreach($profile->user as $user)
                    <p>{{$user->name}}</p>
                @endforeach
                <h2 class="font-bold">mandatory skills:</h2>
                @foreach($profile->skills as $skill)
                    <div>{{$skill->title}}</div>
                @endforeach
            </div>
        @endforeach
    </section>
</x-app-layout>



