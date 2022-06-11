<x-app-layout >
    <section class="p-20 px-20 box-border">
        <div class="py-5">
            <div class="mt-50">
                <a href="{{route('admin.userDetail.index', $user->id)}}" class="p-3 bg-white rounded text-primary font-bold text-2xl mr-8"><--</a>
                <img src="https://placekitten.com/75/75" class="rounded-full inline-block mr-2" alt="profile picture">
                <h2 class="text-xl inline-block">{{ $user->name}}</h2>
            </div>
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">Mandatory Courses</h2>
            @foreach($mandatoryCourses as $key => $course)
                <div class="flex flex-cols bg-white rounded mb-4 p-4 w-8/12 shadow-md">
                    <h3 class="mr-4"><span class="font-bold">Course: </span>{{$course->title}}</h3>
                    <p class="mr-4"><span class="font-bold">Chapters: </span>{{$course->number_of_chapters}}</p>
                    @php
                        $participation = App\models\Participation::where([['user_id', '=', $user->id],['course_id', '=', $course->id]])->first();
                        $completed = $participation->total_completed;
                        echo('<p class="mr-4">' . '<span class="font-bold">Total completed: </span>' .  $completed . '</p>');
                    @endphp
                </div>
            @endforeach
            @if(count($mandatoryCourses) != 0)
                <a href="{{route('admin.userDetail.allMandatoryCourses', $user->id)}}" class="px-3 py-2 bg-tertiary rounded text-white font-bold">View all</a>
            @endif
        </div>
    </section>
</x-app-layout>
