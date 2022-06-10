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
        <h1 class="text-5xl font-bold text-primary mb-6">Edit Element</h1>
        @if ($step === '1')
            <h3 class="text-3xl font-bold text-primary mb-6">Details</h3>
            <form action="/expert/course/section/element/update/{{ $element->id }}" method="POST"
                class="flex flex-col max-w-screen-sm gap-2 items-start">
                @csrf
                <label class="mt-4" for="title">Title</label>
                <input type="hidden" name="course_id" id="course_id" value={{ $course_id }}>
                <input type="hidden" name="chapter_id" id="chapter_id" value={{ $section_id }}>
                <input class="rounded-md w-3/5" type="text" name="title" value={{ $element->title }} id="title"
                    placeholder="title">
                <label class="mt-4" for="description">Description</label>
                <textarea class="rounded-md max-h-96" name="description" id="description" cols="70" rows="10" placeholder="description">{{ $element->description }}</textarea>
                <div class="flex gap-2">
                    <button type="submit"
                        class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                        Next step
                    </button>
                    <button type="button"
                        onclick="window.location='{{ url('expert/edit-course/edit-section?course_id=' . $course_id . '&section_id=' . $section_id) }}'"
                        class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-secondary text-secondary cursor-pointer">
                        Cancel
                    </button>
                </div>
            </form>
        @elseif($step === '2')
            @php
                $type = null;
                $video_id = request()->video_id;
                $element_id = request()->element_id;
                if (isset($video_id)) {
                    $type = 'video';
                } elseif (request()->task_id) {
                    $type = 'task';
                }
            @endphp
            @if ($type === 'video')
                <iframe src={{ $video_element['body']['player_embed_url'] }} class="max-w-4xl h-96" frameborder="0"
                    webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <form action="/expert/course/section/element/video/update/{{ $video_id }}"
                    enctype="multipart/form-data" method="POST" class="flex flex-col max-w-screen-sm gap-2 items-start">
                    @csrf

                    <label class="mt-4" for="video">Upload new video</label>
                    <input type="hidden" id="course_id" name="course_id" value={{ $course_id }}>
                    <input type="hidden" id="element_id" name="element_id" value={{ $element_id }}>
                    <input type="hidden" id="section_id" name="section_id" value={{ $section_id }}>
                    <input type="file" id="video" name="video" accept=".mp4">
                    <button type="submit"
                        class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                        Upload
                    </button>
                </form>
                <button
                    onclick="window.location='{{ url('expert/edit-course/edit-section/edit-element?course_id=' . $course_id . '&section_id=' . $section_id . '&element_id=' . $element_id . '&video_id=' . $video_id . '&step=3') }}'"
                    class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                    Next Step
                </button>
                <script src="https://player.vimeo.com/api/player.js"></script>
            @elseif($type === 'task')
                <h3 class="text-3xl font-bold text-primary mb-6">Task</h3>
                <div class="flex justify-between">
                    <h3 class="text-3xl font-bold text-primary mb-6">Questions</h3>
                    <div class="flex gap2">
                        <div id="changeOrder" class="p-2 bg-primary rounded-2xl w-12 h-12 cursor-pointer">
                            <x-svg.icons.order class="stroke-white w-8 h-8" />
                        </div>
                        <div id="saveOrder"
                            class="py-2 px-4 bg-primary text-white rounded-2xl h-12 cursor-pointer flex justify-center items-center hidden">
                            Save
                        </div>
                    </div>
                </div>
                <div id="questionsList" class="flex flex-col gap-4 list-group">
                    @if (count($task->questions) !== 0)
                        @foreach ($task->questions as $question)
                            <div class="bg-white rounded-md p-6 list-group-item" id="{{ $question->id }}">
                                <div class="flex justify-between">
                                    <div class="flex gap-4 mb-2">
                                        <x-svg.icons.grab
                                            class="stroke-primary w-8 h-8 cursor-move move-handle hidden" />
                                        <h4 class="text-xl font-semibold">{{ $question->question }}</h4>
                                    </div>
                                    <form
                                        action="/expert/course/section/element/task/question/delete/{{ $question->id }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course_id }}">
                                        <input type="hidden" name="section_id" value="{{ $section_id }}">
                                        <input type="hidden" name="element_id" value="{{ $element_id }}">
                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                        <button type="submit">
                                            <x-svg.icons.trash class="stroke-red-500 w-8 h-8 cursor-pointer" />
                                        </button>
                                    </form>
                                </div>
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
                            class="mt-2 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                            Add Question
                        </button>
                    </div>
                    <button
                        onclick="window.location='{{ url('expert/edit-course/edit-section?course_id=' . $course_id . '&section_id=' . $section_id) }}'"
                        class=" mt-8 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                        Save task
                    </button>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
                <script>
                    const changeOrderButton = document.querySelector("#changeOrder");
                    const saveOrderButton = document.querySelector("#saveOrder");
                    const listWithHandle = document.querySelector("#questionsList");

                    changeOrderButton.addEventListener("click", () => {
                        changeOrderButton.classList.add("hidden");
                        saveOrderButton.classList.remove("hidden");
                        document.querySelectorAll(".move-handle").forEach((handle) => handle.classList.remove("hidden"));
                    });

                    saveOrderButton.addEventListener("click", async () => {
                        changeOrderButton.classList.remove("hidden");
                        saveOrderButton.classList.add("hidden");
                        document.querySelectorAll(".move-handle").forEach((handle) => handle.classList.add("hidden"));

                        const order = localStorage.getItem("order-questions").split(",");
                        const csrf = document.querySelector('meta[name="csrf-token"]').content;
                        const url = "{{ url('expert/course/section/element/task/order/update/' . request()->task_id) }}";
                        const response = await fetch(url, {
                            method: "POST",
                            mode: 'same-origin',
                            headers: {
                                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                order
                            })
                        })

                        console.log(response)

                    });

                    Sortable.create(listWithHandle, {
                        handle: '.move-handle',
                        animation: 150,
                        dataIdAttr: 'id',
                        onEnd: (evt) => {},
                        store: {
                            /**
                             * Save the order of elements. Called onEnd (when the item is dropped).
                             * @param {Sortable}  sortable
                             */
                            set: function(sortable) {
                                var order = sortable.toArray();
                                console.log(order);
                                localStorage.setItem("order-questions", order);
                            }
                        }
                    });
                </script>
            @endif
        @elseif($step === '3')
            <div class="max-w-3xl">
                <iframe src={{ $video_element['body']['player_embed_url'] }} class="max-w-4xl h-96" frameborder="0"
                    webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <h3 class="text-3xl font-bold mt-4 mb-4">{{ $element->title }}</h3>
                <p>{{ $element->description }}</p>
                <script src="https://player.vimeo.com/api/player.js"></script>
                <button
                    onclick="window.location='{{ url('expert/edit-course/edit-section?course_id=' . $course_id . '&section_id=' . $section_id) }}'"
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
                if (answerValue <= 0 || answerValue > children.length) {
                    document.querySelector("#errorMessage").innerHTML = "Please provide a correct answer"
                }
                const values = [];
                for (let i = 0; i < children.length; i++) {
                    const input = children[i];
                    if (input.children[1].value !== "") {
                        values.push(input.children[1].value);

                    }
                }

                const csrf = document.querySelector('meta[name="csrf-token"]').content;
                const url = "{{ url('/expert/edit-course/edit-section/new-element/task/create') }}";

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
