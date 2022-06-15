<x-app-layout>
    <section>
        <h1 class="text-3xl font-bold text-primary-blue my-5">Expert Overview</h1>
        <section class="flex flex-row">
            @foreach($experts as $expert)
                <a href="{{route('expert.detail.index', $expert->id)}}">
                    <div class="bg-white inline-block mr-4 rounded p-4 text-center my-5 w-56 h-52 shadow-md">
                        <img src="{{asset($expert->picture)}}" class="rounded-full w-24 ml-11 mb-5" alt="profile picture">
                        <p class="font-bold">{{$expert->name}}</p>
                        <p>{{$expert->degree}}</p>
                    </div>
                </a>
            @endforeach
        </section>
    </section>
</x-app-layout>
