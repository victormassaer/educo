<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course dashboard') }}
        </h2>
    </x-slot>
    <h3 class="text-3xl font-bold text-primary mb-6">Competency profile</h3>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{ $skill->skill->title }}
                    </th>
                    <td class="px-6 py-4">
                        @foreach ($skill->skill->coursesHasSkill as $course)
                            @if ($course->course)
                                <a
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
</x-app-layout>
