<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Detail Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="">
            <img src="{{ Auth::user()->picture }}" alt="profile picture">
        </div>
        <div>
            <h2>{{ Auth::user()->name }}</h2>
            <div>{{ Auth::user()->email }}</div>
            <div>{{$company->name}}</div>
            <div>{{$profile->title}}</div>
            <div>{{ Auth::user()->gender }}</div>
            <div>{{ Auth::user()->age }}</div>
            <div>{{ Auth::user()->country }}</div>
            <div>{{ Auth::user()->degree }}</div>
        </div>
    </div>

    <div>
        <a href="{{route('user.detail.edit.index')}}">edit profile</a>
    </div>
    <div>
        <a href="{{route('user.detail.complete.index')}}">complete profile information</a>
    </div>

    <div>
        <h2>recent activity</h2>
        UPDATED_AT TOEVOEGEN AAN CHAPTERS OM TE ZIEN WANNEER LAATST AAN GEWERKT
        @foreach($chapters as $key => $chapter)
            @foreach($chapter as $c)
                <div>
                    {{$c->title}}
                </div>
            @endforeach
        @endforeach
    </div>

    <div>
        <h2>certificates</h2>
        @foreach($certificates as $certificate)
            <div>
                <img src="{{$certificate->img}}" alt="certicate image">
                <h2>{{$certificate->title}}</h2>
            </div>
        @endforeach
    </div>

    <div>
        <h2>mandatory courses</h2>
        @foreach($mandatoryCourses as $course)
            @if($course->mandatory === 1)
            <div>
                <h3>course: {{$course->title}}</h3>
                <p>number of chapter: {{$course->number_of_chapters}}</p>
            </div>
            @endif
        @endforeach
    </div>

    <div>
        <h2>personal courses</h2>
        @foreach($personalCourses as $course)
            @if($course->mandatory === 0)
                <div>
                    <h3>course: {{$course->title}}</h3>
                    <p>number of chapter: {{$course->number_of_chapters}}</p>
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
