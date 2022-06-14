<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course dashboard') }}
        </h2>
    </x-slot>
    <h3 class="text-3xl font-bold text-primary mb-6">Competency profile</h3>
    <h3 class="text-2xl font-bold text-primary mb-6">Skills</h3>
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-white uppercase bg-primary">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Skill
                </th>
                <th scope="col" class="px-6 py-3">
                    Courses
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Since
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->userHasSkills as $skill)
                <tr class="bg-white border-b ">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  whitespace-nowrap">
                        {{ $skill->skill->title }}
                    </th>
                    <td class="px-6 py-4">
                        @foreach ($skill->skill->coursesHasSkills as $course)
                            @php
                                $hasParticipation = false;
                                foreach ($user->participation as $key => $participation) {
                                    if ($participation->course_id === $course->course_id) {
                                        $hasParticipation = true;
                                    }
                                }
                            @endphp
                            @if ($course->course && $hasParticipation)
                                <a target="_blank"
                                    href="{{ url('/course/detail/' . $course->course->id) }}">{{ $course->course->title }}</a>
                            @endif
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-right">
                        {{ $skill->created_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3 class="text-2xl font-bold text-primary mb-6 mt-4">Certificates</h3>
    {{-- {{ dd($certificates) }} --}}

    <div class="grid gap-4 grid-cols-4">
        @if (count($certificates) === 0)
            <p>No certificates yet</p>
        @endif

        @foreach ($certificates as $certificate)
            <div class="flex flex-col items-center text-center bg-white rounded p-6 shadow-md">
                <img src="{{ asset('images/logo2color.png') }}"
                    class="rounded w-24 border-solid border-8 p-2 border-secondary" alt="certicate image">
                <p class="font-bold">{{ $certificate->certificate->title }}</p>
                <span>Acquired at: </span>
                <p>{{ \Carbon\Carbon::parse($certificate->date_acquired)->format('j F, Y') }}</p>
            </div>
        @endforeach
    </div>
</x-app-layout>
