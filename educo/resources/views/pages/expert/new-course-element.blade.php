<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expert Dashboard') }}
        </h2>
    </x-slot>
    @php
        $course_id = request()->course_id;
        $section_id = request()->section_id;
        $step = request()->step;
        if (!isset($step)) {
            $step = '1';
        }
        $element_id = request()->element_id;
    @endphp
    <div>
        <h1 class="text-5xl font-bold text-primary mb-6">New Element</h1>
        @if ($step === '1')
            <h3 class="text-3xl font-bold text-primary mb-6">Details</h3>
            <form action="/expert/new-course/new-section/new-element/create" method="POST"
                class="flex flex-col max-w-screen-sm gap-2 items-start">

                @csrf
                <label class="mt-4" for="title">Title</label>
                <input type="hidden" name="course_id" id="course_id" value={{ $course_id }}>
                <input type="hidden" name="chapter_id" id="chapter_id" value={{ $section_id }}>
                <input class="rounded-md w-3/5" type="text" name="title" id="title" placeholder="title">
                <label class="mt-4" for="description">Description</label>
                <textarea class="rounded-md max-h-96" name="description" id="description" cols="70" rows="10"
                    placeholder="description"></textarea>
                <label class="mt-4" for="">Type</label>
                <select class="rounded-md w-3/5" name="type" id="type">
                    <option value="video">Video</option>
                    <option value="task">Task</option>
                </select>
                <button type="submit"
                    class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                    Next step
                </button>
            </form>
        @elseif($step === '2')
            @php
                $type = null;
                if (request()->video_id) {
                    $type = 'video';
                } elseif (request()->task_id) {
                    $type = 'task';
                }
            @endphp
            @if ($type === 'video')
                <form action="/expert/new-course/new-section/new-element/video/create" enctype="multipart/form-data"
                    method="POST" class="flex flex-col max-w-screen-sm gap-2 items-start">
                    @csrf
                    <label class="mt-4" for="video">Upload video</label>
                    <input type="hidden" id="course_id" name="course_id" value={{ $course_id }}>
                    <input type="hidden" id="element_id" name="element_id" value={{ $element_id }}>
                    <input type="hidden" id="section_id" name="section_id" value={{ $section_id }}>
                    <input type="file" id="video" name="video" accept=".mp4">
                    <button type="submit"
                        class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                        Upload
                    </button>
                </form>
            @elseif($type === 'task')
                <h3 class="text-3xl font-bold text-primary mb-6">Task</h3>
                <h3 class="text-3xl font-bold text-primary mb-6">Questions</h3>
                <div id="questionsList" class="flex flex-col gap-4">
                    @if (count($task->questions) !== 0)
                        @foreach ($task->questions as $question)
                            <div class="bg-white rounded-md p-6">
                                <h4 class="text-xl font-semibold">{{ $question->question }}</h4>
                                <div class="flex flex-col gap-2 ">
                                    @foreach (unserialize($question->options) as $option)
                                        <div class="flex gap-2 items-center bg-gray-200 rounded-md p-2">
                                            @if ($loop->index === $question->answer)
                                                <x-svg.icons.check class="w-7 h-7 stroke-green-500" />
                                            @endif
                                            {{ $option }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-xl font-bold mb-6">No Questions yet</h4>
                    @endif

                </div>
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-2 mt-4">Add question</h3>
                    <div class="flex flex-col max-w-screen-sm gap-2 items-start">
                        <label class="mt-2" for="question">Question</label>
                        <input required type="text" id="question" name="question">
                        <label class="mt-2" for="">Options</label>
                        <div class="options flex flex-col gap-2">
                            <div class=" flex gap-4 items-center text-2xl">
                                <label for="">1:</label><input required type="text" id="option1" name="option1">
                            </div>
                            <div class="flex gap-4 items-center text-2xl">
                                <label for="">2:</label><input required type="text" id="option2" name="option2">
                            </div>
                        </div>
                        <p id="addOptionButton" class="bg-white rounded-md cursor-pointer  mt-2">
                            <x-svg.icons.plus class="w-10 h-10 p-1 stroke-primary" />
                        </p>
                        <label class="mt-2" for="question">Answer (number)</label>
                        <input id="answer" type="number">
                        <p id="errorMessage" class="text-red-600 my-2"></p>
                        <button id="submitQuestionButton"
                            class=" mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                            Add Question
                        </button>
                    </div>
                </div>
            @endif
        @elseif($step === '3')
            <div class="max-w-3xl">
                <iframe src={{ $video['body']['player_embed_url'] }} width="100%" height="100%" class="max-w-4xl h-96"
                    frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <h3 class="text-3xl font-bold mt-4 mb-4">{{ $element->title }}</h3>
                <p>{{ $element->description }}</p>
                <script src="https://player.vimeo.com/api/player.js"></script>
                <button
                    onclick="window.location='{{ url('expert/new-course/new-section?course_id=' . $course_id . '&section_id=' . $section_id) }}'"
                    class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                    Save
                </button>
            </div>
        @endif
        <script>
            const options = document.querySelector('.options');
            const addOptionButton = document.querySelector('#addOptionButton');
            const submitQuestionButton = document.querySelector('#submitQuestionButton');

            addOptionButton.addEventListener('click', addOption);
            submitQuestionButton.addEventListener('click', submitQuestion);

            function addOption() {
                const count = options.childElementCount;
                const wrapper = document.createElement("div");
                wrapper.setAttribute('class', 'flex gap-4 items-center text-2xl')

                wrapper.innerHTML =
                    `<label for="">${count +1}:</label><input required type="text" id="option${count +1}" name="${count +1}">`
                options.appendChild(wrapper);
            }

            async function submitQuestion(e) {
                e.preventDefault();
                const question = document.querySelector("#question");
                const answer = document.querySelector("#answer");
                const questionValue = question.value
                const answerValue = answer.value

                const children = options.children;
                if (answerValue <= 0 || answerValue >= children.length) {
                    document.querySelector("#errorMessage").innerHTML = "Please provide a correct answer"
                }
                const values = [];
                for (let i = 0; i < children.length; i++) {
                    const input = children[i];
                    values.push(input.children[1].value);
                    input.value = "";
                }
                question.value = "";
                const csrf = document.querySelector('meta[name="csrf-token"]').content;
                const url = 'http://localhost/expert/new-course/new-section/new-element/task/create';

                const response = await fetch(url, {
                    method: "POST",
                    mode: 'same-origin',
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        task_id: {{ request()->task_id }},
                        question: questionValue,
                        answer: answerValue - 1,
                        values
                    })
                })
                location.reload();
            }
        </script>
    </div>
</x-app-layout>
