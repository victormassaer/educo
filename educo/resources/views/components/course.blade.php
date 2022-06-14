<a href="{{route('course.detail', $course->id)}}" class="m-4 w-1/4 w-288 h-177 shadow-md rounded-md">
<img class="w-fit m-0 rounded-md " src="{{ asset('storage/' . $course->img) }}" alt="">
    <div class="bg-white pt-4 pb-1 m-0 rounded-md">
        <div class="flex flex-col px-3">
        <H4 class="font-semibold pb-1"> {{ $course->title }}</H4>
            <div class="flex flex-row justify-between py-1">
                <p>{{ $course->number_of_chapters }} lessons</p>

                <p>{{ $course->duration }}</p>
            </div>
        </div>
    </div>
</a>

