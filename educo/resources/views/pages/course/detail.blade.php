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
                @php
                    $task = \App\models\Task::with(array('element', 'questions' => function ($query) {
                    $query->orderBy('order', 'ASC');
                    }))->find($activeElement->task_id);
                    $questions = $task->questions;
                @endphp
                <form action="">
                    @csrf
                    @foreach($questions as $question)
                        <div class="bg-white rounded p-3 w-1/3 my-5">
                            <h2>{{$question->question}}</h2>
                            <select name="{{$question->id}}" id="{{$question->question}}">
                                @foreach (unserialize($question->options) as $option)
                                    <option value="{{$option}}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                    <input type="submit" value="check questions" class="cursor-pointer">
                </form>
            </div>
        @else
            <div>
                @php

                @endphp
            </div>
        @endif

            <div>
                <a href="{{route('next.step.course', [$activeElement->id, $activeChapter->id])}}">next step</a>
            </div>
        @endif
    </section>

    <script>

    </script>
</x-app-layout>
