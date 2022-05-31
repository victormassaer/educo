<a href="" class="p-3 m-4 w-1/3">
    <div class="h-full w-full max-w-288 max-h-177">
        <img class="rounded-md" src="{{ asset('storage/' . $course->img) }}" alt="">
    </div>
    <div class="bg-white rounded-md pt-5">
        <div class="flex flex-col px-3">
            <H4 class="font-semibold pb-1"> {{ $course->title }}</H4>
                <div class="flex flex-row justify-between py-1">
                    <p>{{ $course->number_of_chapters }} lessons</p>
                    <p>11h 30min</p>
                </div>
        </div>
    </div>
</a>

