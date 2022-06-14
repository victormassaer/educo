<x-app-layout>
    <div class="py-3 w-3/5 max-w-3xl flex flex-row justify-around">
        <a href="/dashboard"><p class="font-semibold">All courses</p></a>
        <a href="{{route('dashboard.active', $user->id)}}"><p>Active</p></a>
        <a href="{{route('dashboard.obligated', $user->id)}}"><p>Obligated</p></a>
        <a href="{{route('dashboard.finished', $user->id)}}"><p>Finished</p></a>
        <a href="{{route('dashboard.recommended', $user->id)}}"><p>Recommended</p></a>
    </div>
    <div class="py-5 w-5/6 max-w-7xl sm:px-6 lg:px-8 flex justify-center flex-wrap">
        @foreach($courses as $course)
            <x-course :course="$course" class=""/>
        @endforeach
    </div>
    {{ $courses->onEachSide(4) }}
</x-app-layout>
