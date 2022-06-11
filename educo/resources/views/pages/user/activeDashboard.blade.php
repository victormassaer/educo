<x-app-layout class="">
    <div class="mx-auto">
        <div class="py-3 w-3/5 max-w-3xl mx-auto flex flex-row justify-around">
            <a href="/dashboard"><p>All courses</p></a>
            <a href="{{route('dashboard.active', $user->id)}}"><p class="font-semibold">Active</p></a>
            <a href="{{route('dashboard.obligated', $user->id)}}"><p>Obligated</p></a>
            <a href="{{route('dashboard.finished', $user->id)}}"><p>Finished</p></a>
            <a href="{{route('dashboard.recommended', $user->id)}}"><p>Recommended</p></a>
        </div>
        <div class="py-5 w-5/6 mx-auto sm:px-6 lg:px-8 flex justify-center flex-wrap">
            @foreach($activeCourses as $activeCourse)
                <x-course :course="$activeCourse" class=""/>
            @endforeach
        </div>
    </div>

</x-app-layout>
