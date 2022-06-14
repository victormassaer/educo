<x-app-layout>
    <section>
        <h1 class="font-bold text-primary text-2xl">Course Finished, congratulations!</h1>
        <h2 class="font-bold text-tertiary text-xl">{{$course->title}}</h2>
        <div class="my-5">
            <h2 class="font-bold text-primary text-xl">Certificates obtained</h2>
            @foreach($certificates as $certificate)
                <div class="inline-block mr-5 mt-4 text-center bg-white rounded p-6 shadow-md w-40">
                    <img src="{{asset('images/logo2color.png')}}" class="rounded w-24 border-solid border-8 p-2 border-secondary ml-2" alt="certicate image">
                    <p class="font-bold">{{$certificate->title}}</p>
                    <span>Acquired at: </span>
                    <p>{{\Carbon\Carbon::parse($certificate->date_acquired)->format('j F, Y')}}</p>
                </div>
            @endforeach
        </div>
        <div>
            <a class="px-3 py-2 bg-tertiary rounded text-white font-bold" href="{{route('dashboard')}}">back to dashboard</a>
        </div>
    </section>
</x-app-layout>
