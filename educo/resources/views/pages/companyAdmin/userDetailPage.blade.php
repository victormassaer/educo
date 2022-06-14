<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Detail Page') }}
        </h2>
    </x-slot>
    <section class="p-20 box-border">
        <div class="grid grid-rows-1 grid-cols-2">
            <div class="py-5 grid grid-cols-2 grid-rows-1 bg-white justify-items-center rounded shadow-md">
                <div class="mt-50 text-center">
                    <img src="{{asset($user->picture)}}" class="rounded w-36 h-36" alt="profile picture">
                    <h2 class="text-xl font-bold text-primary">{{ $user->name}}</h2>
                    <h3>{{$user->profile->title}}</h3>
                </div>
                <div class="justify-self-start">
                    <div><span class="font-bold">email: </span>{{ $user->email }}</div>
                    <div><span class="font-bold">company: </span>{{ $company->name }}</div>
                    <div><span class="font-bold">gender: </span>{{ $user->gender }}</div>
                    <div><span class="font-bold">age: </span>{{ $user->age }}</div>
                    <div><span class="font-bold">country: </span>{{ $user->country }}</div>
                    <div><span class="font-bold">degree: </span>{{ $user->degree }}</div>
                </div>
            </div>
            <div class="pl-4">
                <h2 class="font-bold text-2xl text-primary-blue mb-4">Active Courses</h2>
                @if (count($activeCourses) === 0)
                    <div>Nothing to see here...</div>
                @endif
                @foreach ($activeCourses as $key => $course)
                    @if ($key <= 1)
                        <a href="{{ route('course.detail', $course->id) }}">
                            <div class="flex flex-cols bg-white rounded mb-4 p-4 shadow-md">
                                <h3 class="mr-4"><span class="font-bold">Course:
                                    </span>{{ $course->title }}</h3>
                                <p class="mr-4"><span class="font-bold">Chapters:
                                    </span>{{ $course->number_of_chapters }}</p>
                                @php
                                    $participation = App\models\Participation::where([['user_id', '=', $user->id], ['course_id', '=', $course->id]])->first();
                                    $completed = $participation->total_completed;
                                    echo '<p class="mr-4">' . '<span class="font-bold">Total completed: </span>' . $completed . '</p>';
                                    if ($participation->mandatory === 1) {
                                        echo '<p class=" text-fuchsia-400 font-bold">#</p>';
                                    } else {
                                        echo '<p class=" text-green-400 font-bold">#</p>';
                                    }
                                @endphp
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="mt-5">
            <a href="{{ route('admin.user.competency', $user->id) }}"
                class="px-3 py-2 bg-tertiary rounded text-white font-bold">View Competency profile</a>
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Recent Activity</h2>
            <h3 class="text-xl font-bold text-tertiary">chapters</h3>
            @if (count($chapters) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach ($chapters as $key => $chapter)
                @if ($key <= 3)
                    @foreach ($chapter as $key2 => $c)
                        @if ($key2 <= 2)
                            <div class="bg-white my-2 mb-4 rounded p-4 flex w-8/12 shadow-md">
                                @php
                                    $course = App\Models\Course::where('id', $c->course->id)->first();
                                    $participation = App\Models\Participation::where([['user_id', '=', $user->id], ['course_id', '=', $c->course_id]])->first();
                                    echo '<p class="mr-4 font-bold text-xl">' . $participation->updated_at->isoFormat('D/M') . ' |</p>';
                                    echo '<p class="mr-4">' . '<span class="font-bold">Course: </span>' . $course->title . '</p>';
                                @endphp
                                <p class="mr-4"><span class="font-bold">Title:</span>
                                    {{ $c->title }}</p>

                                @php
                                    echo '<p class="mr-4">' . '<span class="font-bold">Chapter: </span>' . $participation->total_completed . '/' . $course->number_of_chapters . '</p>';
                                @endphp
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if (count($chapters) != 0)
                <a href="{{ route('admin.userDetail.allActivity', $user->id) }}"
                    class="px-3 py-2 bg-tertiary rounded text-white font-bold">View all</a>
            @endif
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Certificates</h2>
            @if (count($certificates) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach ($certificates as $certificate)
                <div class="inline-block mr-5 text-center bg-white rounded p-6 shadow-md">
                    <img src="{{ asset('images/logo2color.png') }}"
                        class="rounded w-24 border-solid border-8 p-2 border-secondary" alt="certicate image">
                    <p class="font-bold">{{ $certificate->title }}</p>
                    <span>Acquired at: </span>
                    <p>{{ \Carbon\Carbon::parse($certificate->date_acquired)->format('j F, Y') }}</p>
                </div>
            @endforeach
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Mandatory Courses</h2>
            @if (count($mandatoryCourses) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach ($mandatoryCourses as $key => $course)
                @if ($key <= 2)
                    <div class="flex flex-cols bg-white rounded mb-4 p-4 w-8/12 shadow-md">
                        <h3 class="mr-4"><span class="font-bold">Course: </span>{{ $course->title }}
                        </h3>
                        <p class="mr-4"><span class="font-bold">Chapters:
                            </span>{{ $course->number_of_chapters }}</p>
                        @php
                            $participation = App\Models\Participation::where([['user_id', '=', $user->id], ['course_id', '=', $course->id]])->first();
                            $completed = $participation->total_completed;
                            echo '<p class="mr-4">' . '<span class="font-bold">Total completed: </span>' . $completed . '</p>';
                        @endphp
                    </div>
                @endif
            @endforeach
            @if (count($mandatoryCourses) != 0)
                <a href="{{ route('admin.userDetail.allMandatoryCourses', $user->id) }}"
                    class="px-3 py-2 bg-tertiary rounded text-white font-bold">View all</a>
            @endif
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Personal Courses</h2>
            @if (count($personalCourses) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach ($personalCourses as $key => $course)
                @if ($key <= 2)
                    <div class="flex flex-cols bg-white rounded mb-4 p-4 w-8/12 shadow-md">
                        <h3 class="mr-4"><span class="font-bold">Course: </span>{{ $course->title }}
                        </h3>
                        <p class="mr-4"><span class="font-bold">Chapters:
                            </span>{{ $course->number_of_chapters }}</p>
                        @php
                            $participation = App\Models\Participation::where([['user_id', '=', $user->id], ['course_id', '=', $course->id]])->first();
                            $completed = $participation->total_completed;
                            echo '<p class="mr-4">' . '<span class="font-bold">Total completed: </span>' . $completed . '</p>';
                        @endphp
                    </div>
                @endif
            @endforeach
            @if (count($personalCourses) != 0)
                <a href="{{ route('admin.userDetail.allPersonalCourses', $user->id) }}"
                    class="px-3 py-2 bg-tertiary rounded text-white font-bold">View all</a>
            @endif
        </div>
    </section>
</x-app-layout>
