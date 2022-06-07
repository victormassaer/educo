<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expert Dashboard') }}
        </h2>
    </x-slot>
    @php
        $step = request()->step;
        if (!isset($step)) {
            $step = '1';
        }
        $course_id = request()->course_id;
    @endphp
    <div>
        <h1 class="text-5xl font-bold text-primary mb-6">Edit course</h1>
        {{-- STEP 1 --}}
        @if ($step === '1')
            <h3 class="text-3xl font-bold text-primary mb-6">Details</h3>
            <form action="/expert/course/update/{{ $course_id }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col max-w-screen-sm gap-2 items-start">
                @csrf
                <label class="mt-4" for="title">Title</label>
                <input class="rounded-md w-3/5" type="text" name="title" value="{{ $course->title }}" id="title"
                    placeholder="title">
                <label class="mt-4" for="description">Description</label>
                <textarea class="rounded-md max-h-96" name="description" id="description" cols="70" rows="10"
                    placeholder="description">{{ $course->description }}</textarea>
                <label class="mt-4" for="difficulty">Difficulty</label>
                <select class="rounded-md w-3/5" name="difficulty" id="difficulty">
                    <option {{ $course->difficulty === 'easy' ? 'selected' : null }}>easy</option>
                    <option {{ $course->difficulty === 'medium' ? 'selected' : null }}>medium</option>
                    <option {{ $course->difficulty === 'hard' ? 'selected' : null }}>hard</option>
                </select>
                <label class="mt-4" for="thumbnail">New Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail">
                <div class="flex gap-2">
                    <button type="submit"
                        class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                        Next step
                    </button>
                    <button type="button" onclick="window.location='{{ url('expert/dashboard') }}'"
                        class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-secondary text-secondary cursor-pointer">
                        Cancel
                    </button>
                </div>
            </form>
            {{-- STEP 2 --}}
        @elseif($step === '2')
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-3xl font-bold text-primary mb-6">Sections</h3>
                <div class="flex gap-2">
                    <div id="changeOrder" class="p-2 bg-primary rounded-2xl w-12 h-12 cursor-pointer">
                        <x-svg.icons.order class="stroke-white w-8 h-8" />
                    </div>
                    <div id="saveOrder"
                        class="py-2 px-4 bg-primary text-white rounded-2xl h-12 cursor-pointer flex justify-center items-center hidden">
                        Save
                    </div>
                    <a href='edit-course/new-section?course_id={{ $course_id }}'
                        class="p-2 bg-primary rounded-2xl w-12 h-12 cursor-pointer">
                        <x-svg.icons.plus class="stroke-white w-8 h-8" />
                    </a>
                </div>
            </div>
            @if (count($course->chapters) === 0)
                <p>No sections yet</p>
            @endif
            <div id="listwithHandle" class="list-group">
                @foreach ($course->chapters as $chapter)
                    <div class="mb-4 bg-white rounded-md p-4 list-group-item" id="{{ $chapter->id }}">
                        <div class="flex justify-between">
                            <div class="flex gap-4">
                                <x-svg.icons.grab class="stroke-primary w-8 h-8 cursor-move move-handle hidden" />
                                <h4 class="text-xl font-bold mb-2">
                                    {{ $chapter->title }}
                                </h4>
                            </div>
                            <div class="flex gap-2">
                                <x-svg.icons.edit
                                    onclick="window.location='{{ url('expert/edit-course/edit-section/?course_id=' . $course->id . '&section_id=' . $chapter->id) }}'"
                                    class="stroke-primary w-8 h-8 cursor-pointer" />
                                <form action="/expert/course/section/delete/{{ $chapter->id }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course_id }}">
                                    <button type="submit">
                                        <x-svg.icons.trash class="stroke-red-500 w-8 h-8 cursor-pointer" />
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div>
                            @foreach ($chapter->elements as $element)
                                <div class="bg-gray-200 p-2 rounded-md m-2">
                                    <h4 class="text-xl font-semibold">{{ $element->type }}: {{ $element->title }}
                                    </h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button onclick="window.location='{{ url('expert/dashboard') }}'"
                class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                Save
            </button>
            <button onclick="window.location='{{ url('expert/edit-course?course_id=' . $course_id . '&step=1') }}'"
                class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-secondary text-secondary cursor-pointer">
                Back
            </button>
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
            <script>
                const changeOrderButton = document.querySelector("#changeOrder");
                const saveOrderButton = document.querySelector("#saveOrder");
                const listWithHandle = document.querySelector("#listwithHandle");

                changeOrderButton.addEventListener("click", () => {
                    changeOrderButton.classList.add("hidden");
                    saveOrderButton.classList.remove("hidden");
                    document.querySelectorAll(".move-handle").forEach((handle) => handle.classList.remove("hidden"));
                });

                saveOrderButton.addEventListener("click", async () => {
                    changeOrderButton.classList.remove("hidden");
                    saveOrderButton.classList.add("hidden");
                    document.querySelectorAll(".move-handle").forEach((handle) => handle.classList.add("hidden"));

                    const order = localStorage.getItem("order-section").split(",");
                    const csrf = document.querySelector('meta[name="csrf-token"]').content;
                    const url = `http://localhost/expert/course/order/update/{{ $course_id }}`;
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
                            localStorage.setItem("order-section", order);
                        }
                    }
                });
            </script>
        @endif
    </div>
</x-app-layout>
