<x-app-layout>
    <section>
        <h1>{{$course->title}}</h1>
        <h3><span>Created by: </span>{{$expert->name}}</h3>
        <div>
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
    </section>
</x-app-layout>
