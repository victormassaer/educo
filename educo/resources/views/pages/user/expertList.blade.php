<x-app-layout>
    <h1>Expert Overview</h1>
    <section class="flex flex-row">
        @foreach($experts as $expert)
            <div>
                <img src="{{$expert->picture}}" alt="profile picture">
                <h2>{{$expert->name}}</h2>
                <p>{{$expert->degree}}</p>
            </div>
        @endforeach
    </section>
</x-app-layout>
