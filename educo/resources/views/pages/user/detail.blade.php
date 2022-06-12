<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Detail Page') }}
        </h2>
    </x-slot>
    <section class="p-20 px-20 box-border">
        <div class="grid grid-rows-1 grid-cols-2">
            <div class="py-5 grid grid-cols-2 grid-rows-1 bg-white justify-items-center rounded">
                <div class="mt-50 text-center">
                    <img src="{{asset($employee->picture)}}" class="rounded w-36" alt="profile picture">
                    <h2 class="text-xl font-bold text-primary">{{ Auth::user()->name}}</h2>
                    <h3>{{ Auth::user()->profile->title}}</h3>
                </div>
                <div class="justify-self-start">
                    <div><span class="font-bold">email: </span>{{ Auth::user()->email }}</div>
                    <div><span class="font-bold">company: </span>{{ $company->name }}</div>
                    <div><span class="font-bold">gender: </span>{{ Auth::user()->gender }}</div>
                    <div><span class="font-bold">age: </span>{{ Auth::user()->age }}</div>
                    <div><span class="font-bold">country: </span>{{ Auth::user()->country }}</div>
                    <div><span class="font-bold">degree: </span>{{ Auth::user()->degree }}</div>
                </div>
            </div>
            <div class="pl-4">
                <h2 class="font-bold text-2xl text-primary-blue mb-4">Active Courses</h2>
                @if(count($activeCourses) === 0)
                    <div>Nothing to see here...</div>
                @endif
                @foreach($activeCourses as $key => $course)
                    @if($key <= 1)
                    <div class="flex flex-cols bg-white rounded mb-4 p-4">
                        <h3 class="mr-4"><span class="font-bold">Course: </span>{{$course->title}}</h3>
                        <p class="mr-4"><span class="font-bold">Chapters: </span>{{$course->number_of_chapters}}</p>
                        @php
                            $participation = App\models\Participation::where([['user_id', '=', auth()->user()->id],['course_id', '=', $course->id]])->first();
                            $completed = $participation->total_completed;
                            echo('<p class="mr-4">' . '<span class="font-bold">Total completed: </span>' .  $completed . '</p>');
                            if($participation->mandatory === 1){
                                echo('<p class=" text-fuchsia-400 font-bold">#</p>');
                            }else{
                                echo('<p class=" text-green-400 font-bold">#</p>');
                            }
                        @endphp
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            <a class="px-3 py-2 bg-primary-blue rounded text-white font-bold" href="{{route('user.detail.edit.index')}}">edit profile</a>
            <a class="px-3 py-2 bg-secondary rounded text-white font-bold" href="{{route('user.detail.complete.index')}}">complete profile information</a>
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Recent Activity</h2>
            <h3 class="text-xl">chapters</h3>
            @if(count($chapters) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach($chapters as $key => $chapter)
                @if($key <= 3)
                @foreach($chapter as $c)
                    <div class="bg-white my-2 rounded p-4 flex w-8/12">
                        @php
                            $course = App\Models\Course::where('id', $c->course->id)->first();
                            $participation = App\models\Participation::where([['user_id', '=', auth()->user()->id],['course_id', '=', $c->course_id]])->first();
                            echo('<p class="mr-4 font-bold text-xl">'.  $participation->updated_at->isoFormat('D/M') . ' |</p>');
                            echo('<p class="mr-4">' . '<span class="font-bold">Course: </span>' .  $course->title . '</p>');
                        @endphp
                        <p class="mr-4"><span class="font-bold">Title:</span> {{$c->title}}</p>

                        @php
                            echo('<p class="mr-4">' . '<span class="font-bold">Chapter: </span>' .  $participation->total_completed . '/' . $course->number_of_chapters. '</p>');
                        @endphp
                    </div>
                @endforeach
                @endif
            @endforeach
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Certificates</h2>
            @if(count($certificates) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach($certificates as $certificate)
                <div class="inline-block mr-5 text-center bg-white rounded p-6">
                    <img src="https://placekitten.com/120/120" class="rounded" alt="certicate image">
                    <p class="font-bold">{{$certificate->title}}</p>
                    <span>Acquired at: </span>
                    <p>{{\Carbon\Carbon::parse($certificate->date_acquired)->format('j F, Y')}}</p>
                </div>
            @endforeach
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Mandatory Courses</h2>
            @if(count($mandatoryCourses) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach($mandatoryCourses as $course)
                <div class="flex flex-cols bg-white rounded mb-4 p-4 w-8/12">
                    <h3 class="mr-4"><span class="font-bold">Course: </span>{{$course->title}}</h3>
                    <p class="mr-4"><span class="font-bold">Chapters: </span>{{$course->number_of_chapters}}</p>
                    @php
                        $participation = App\models\Participation::where([['user_id', '=', auth()->user()->id],['course_id', '=', $course->id]])->first();
                        $completed = $participation->total_completed;
                        echo('<p class="mr-4">' . '<span class="font-bold">Total completed: </span>' .  $completed . '</p>');
                    @endphp
                </div>
            @endforeach
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Personal Courses</h2>
            @if(count($personalCourses) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach($personalCourses as $course)
                <div class="flex flex-cols bg-white rounded mb-4 p-4 w-8/12">
                    <h3 class="mr-4"><span class="font-bold">Course: </span>{{$course->title}}</h3>
                    <p class="mr-4"><span class="font-bold">Chapters: </span>{{$course->number_of_chapters}}</p>
                    @php
                        $participation = App\models\Participation::where([['user_id', '=', auth()->user()->id],['course_id', '=', $course->id]])->first();
                        $completed = $participation->total_completed;
                        echo('<p class="mr-4">' . '<span class="font-bold">Total completed: </span>' .  $completed . '</p>');
                    @endphp
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
