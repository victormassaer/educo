<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Detail Page') }}
        </h2>
    </x-slot>
    <section class="box-border">
        <div class="py-5">
            <div class="mt-50">
                <a href="{{route('admin.userDetail.index', $user->id)}}" class="p-3 bg-white rounded text-primary font-bold text-2xl mr-8"><--</a>
                <img src="https://placekitten.com/75/75" class="rounded-full inline-block mr-2" alt="profile picture">
                <h2 class="text-xl inline-block">{{ $user->name}}</h2>
            </div>
        </div>

        <div class="my-5 mt-10">
            <h2 class="font-bold text-2xl text-primary-blue mb-4">All Activity</h2>
            <h3 class="text-xl">chapters</h3>
            @if(count($chapters) === 0)
                <p class="font-bold italic text-xl">Nothing to see here...</p>
            @endif
            @foreach($chapters as $key => $chapter)
                @foreach($chapter as $c)
                    <div class="bg-white my-2 rounded p-4 flex w-8/12 shadow-md">
                        @php
                            $course = App\Models\Course::where('id', $c->course->id)->first();
                            $participation = App\models\Participation::where([['user_id', '=', $user->id],['course_id', '=', $c->course_id]])->first();
                            echo('<p class="mr-4 font-bold text-xl">'.  $participation->updated_at->isoFormat('D/M') . ' |</p>');
                            echo('<p class="mr-4">' . '<span class="font-bold">Course: </span>' .  $course->title . '</p>');
                        @endphp
                        <p class="mr-4"><span class="font-bold">Title:</span> {{$c->title}}</p>

                        @php
                            echo('<p class="mr-4">' . '<span class="font-bold">Chapter: </span>' .  $participation->total_completed . '/' . $course->number_of_chapters. '</p>');
                        @endphp
                    </div>
                @endforeach
            @endforeach
        </div>
    </section>
</x-app-layout>
