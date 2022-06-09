<x-app-layout>
    <section>
        <h1>{{$course->title}}</h1>
        <h3><span>Created by: </span>{{$expert->name}}</h3>
        @if(!$participation)
            <div>
                <p>{{$course->description}}</p>
                <h2>Course structure</h2>
                <div>
                    @foreach($chapters as $chapter)
                        <h3>{{$chapter->title}}</h3>
                        @foreach($chapter->elements as $element)
                            <p>{{$element->title}}</p>
                        @endforeach
                    @endforeach
                </div>

                <a href="{{route('course.participation', $course->id)}}">
                    start this course
                </a>
            </div>
        @else

            <div>
                <h2><span>Current chapter: </span>{{$activeChapter->title}}</h2>
                <h3><span>Current: </span>{{$activeElement->title}}</h3>
                <p>{{$activeElement->description}}</p>
            </div>

        @if($activeElement->type == 'task')
            <div>

            </div>
        @endif

            <div>
                <a href="{{route('next.step.course', [$activeElement->id, $activeChapter->id])}}">next step</a>
            </div>
        @endif
    </section>
</x-app-layout>
