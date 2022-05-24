<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-amber-‡">
                    Roles overview for admin
                </div>
            </div>
        </div>
    </div>

    <section class="px-44">
        @foreach($profiles as $profile)
            <div class="inline-block bg-white p-4 rounded mx-4 text-center">
                <h2 class="font-bold text-xl text-primary-blue">{{$profile->title}}</h2>
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



