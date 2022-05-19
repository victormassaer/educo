<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Detail Page') }}
        </h2>
    </x-slot>
    <section class="p-20 px-44 box-border">
        <div class="grid grid-rows-1 grid-cols-3">
            <div class="py-5 grid grid-cols-2 grid-rows-1 bg-white justify-items-center rounded col-span-2">
                <div class="mt-50 text-center">
                    <img src="https://placekitten.com/150/150" class="rounded" alt="profile picture">
                    <h2 class="text-xl">{{ $user->name}}</h2>
                </div>
                <div class="justify-self-start">
                    <div><span class="font-bold">email: </span>{{ $user->email }}</div>
                    <div><span class="font-bold">company: </span>{{$company->name}}</div>
                    <div><span class="font-bold">profile: </span>{{$profile->title}}</div>
                    <div><span class="font-bold">gender: </span>{{ $user->gender }}</div>
                    <div><span class="font-bold">age: </span>{{ $user->age }}</div>
                    <div><span class="font-bold">country: </span>{{ $user->country }}</div>
                    <div><span class="font-bold">degree: </span>{{ $user->degree }}</div>
                </div>
            </div>
            <div>
                active courses
            </div>
        </div>

        <div class="mt-4">
            <h2 class="font-bold text-2xl">recent activity</h2>
            UPDATED_AT TOEVOEGEN AAN CHAPTERS OM TE ZIEN WANNEER LAATST AAN GEWERKT
            @foreach($chapters as $key => $chapter)
                @foreach($chapter as $c)
                    <div>
                        {{$c->title}}
                    </div>
                @endforeach
            @endforeach
        </div>

        <div class="mt-4">
            <h2 class="font-bold text-2xl">certificates</h2>
            @foreach($certificates as $certificate)
                <div class="inline-block mr-5 text-center bg-white rounded p-6">
                    <img src="https://placekitten.com/120/120" class="rounded" alt="certicate image">
                    <p class="font-bold">{{$certificate->title}}</p>
                    <span>Acquired at: </span>
                    <p>{{\Carbon\Carbon::parse($certificate->date_acquired)->format('j F, Y')}}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <h2 class="font-bold text-2xl">mandatory courses</h2>
            @foreach($mandatoryCourses as $course)
                @if($course->mandatory === 1)
                    <div>
                        <h3>course: {{$course->title}}</h3>
                        <p>number of chapter: {{$course->number_of_chapters}}</p>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-4">
            <h2 class="font-bold text-2xl">personal courses</h2>
            @foreach($personalCourses as $course)
                @if($course->mandatory === 0)
                    <div>
                        <h3>course: {{$course->title}}</h3>
                        <p>number of chapter: {{$course->number_of_chapters}}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
</x-app-layout>
