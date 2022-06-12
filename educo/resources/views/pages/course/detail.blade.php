<x-app-layout>
    <section class="container mx-auto mt-6">
        <h1 class="text-primary font-bold text-3xl mt-3">{{$course->title}}</h1>
        <section class=" ml-12">
        <div class="grid grid-cols-2 mt-6">
            <div class="">
                <div class="w-3/5">
                    <h3 class="text-primary font-bold text-lg mt-4">Description</h3>
                    <p class="mt-3">{{$course->description}}</p>
                </div>
                <div>
                    <h3 class="text-primary font-bold text-lg mt-4">Skills</h3>
                    @foreach($skills as $key => $skill)
                        <div class="inline-block bg-white px-2 rounded my-2 mr-2 shadow-md">{{$skill->title}}</div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center">   
                <div class=" w-44">
                        <h3 class="mb-2 text-primary text-lg font-bold text-center">Created by</h3>
                    <div class="bg-white p-6 rounded-md my-2 mr-2 shadow-md">
                        <img class="rounded-full w-32 mx-auto" src="{{ asset('storage/' . $expert->picture) }}" alt="expert_picture">
                        <h3 class="mt-3 text-gray-700 font-semibold text-center">{{$expert->name}}</h3>
                    </div>
                </div>
            </div>
        </div>

        

        @if(!$participation)
        <h2 class="text-primary font-bold text-xl mt-4">Course structure</h2>
        <div class="">
            <div class="mt-3">
                @foreach($courseAttr->chapters as $chapter)
                <div class="bg-white p-6 rounded-md my-2 mr-2 shadow-md">
                    <h3 class=""><span class="font-bold pt-2 pb-2">Chapter {{$chapter->order}} - </span>{{$chapter->title}}</h3>
                    @foreach($chapter->elements as $element)
                        @if($element->type === "video")
                        <div class="bg-grey-200">
                            <p class="px-6 py-1 rounded-md"><span class="font-semibold ">Video - </span>{{$element->title}}</p>
                        </div>
                        @else
                        <div class="bg-grey-200">
                            <p class="px-6 py-1 rounded-md"><span class="font-semibold">Task - </span>{{$element->title}}</p>
                        </div>
                        @endif
                    @endforeach
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center">
                <a  href="{{route('course.participation', $course->id)}}">
                    <button class="bg-secondary rounded-md my-2 mr-2 shadow-md text-white p-4">start this course</button>
                </a>
            </div>

        </div>
        @else

            <div class="bg-white p-6 rounded-md my-2 mr-2 shadow-md">
                <h2><span>Current chapter: </span>{{$activeChapter->title}}</h2>
                <h3><span>Current: </span>{{$activeElement->title}}</h3>
                <p>{{$activeElement->description}}</p>
            </div>

        @if($activeElement->type == 'task')
            <div>
                @php
                    $task = \App\Models\Task::with(array('element', 'questions' => function ($query) {
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
        
    </section>

    <script>

    </script>
</x-app-layout>
