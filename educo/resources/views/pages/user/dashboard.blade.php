<x-app-layout>
    <div class="py-3 flex flex-row justify-center">
        <a class="px-6" href="/dashboard"><p class="font-semibold">All courses</p></a>
        <a class="px-6" href="{{route('dashboard.active', $user->id)}}"><p>Active</p></a>
        <a class="px-6" href="{{route('dashboard.obligated', $user->id)}}"><p>Obligated</p></a>
        <a class="px-6" href="{{route('dashboard.finished', $user->id)}}"><p>Finished</p></a>
        <a class="px-6" href="{{route('dashboard.recommended', $user->id)}}"><p>Recommended</p></a>
    </div>
    <div class="py-5 w-4/5 sm:px-6 flex justify-start flex-wrap">
        @foreach($courses as $course)
            <x-course :course="$course" class=""/>
        @endforeach
    </div>
    {{ $courses->onEachSide(4) }}
</x-app-layout>
