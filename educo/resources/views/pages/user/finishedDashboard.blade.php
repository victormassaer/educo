<x-app-layout>
        <div class="py-3 w-3/5 max-w-3xl mx-auto flex flex-row justify-around">
            <a href="/dashboard"><p>All courses</p></a>
            <a href="{{route('dashboard.active', $user->id)}}"><p>Active</p></a>
            <a href="{{route('dashboard.obligated', $user->id)}}"><p>Obligated</p></a>
            <a href="{{route('dashboard.finished', $user->id)}}"><p class="font-semibold">Finished</p></a>
            <a href="{{route('dashboard.recommended', $user->id)}}"><p>Recommended</p></a>
        </div>
        <div class="py-5 w-5/6 max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center flex-wrap">
            @foreach($finishedCourses as $finishedCourse)
                <x-course :course="$finishedCourse" class="basis-1/3"/>
            @endforeach
        </div>
</x-app-layout>
