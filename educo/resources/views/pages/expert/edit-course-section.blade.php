<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expert Dashboard') }}
        </h2>
    </x-slot>
    @php
        $editpage = false;
        if (isset($edit)) {
            $editpage = true;
        }
        $course_id = $course->id;
        $section_id = $chapter->id;
    @endphp
    <div>
        <h1 class="text-5xl font-bold text-primary mb-6">{{ $editpage === true ? 'Edit' : 'New' }} Section</h1>
        <form id="update-section" action="/expert/course/section/update/{{ $section_id }}" method="POST"
            class="items-start">
            @csrf
            <input type="hidden" name="course_id" value={{ $course_id }}>
            <div class=" flex flex-col gap-2 max-w-screen-sm">
                <label class="mt-4" for="title">Title</label>
                <input class="rounded-md w-3/5" type="text" name="title" id="title" placeholder="title"
                    value='{{ $chapter->title }}' required>
            </div>

        </form>
        <div class="flex justify-between items-center mt-4 mb-4 w-full">
            <h3 class="text-3xl font-bold text-primary mb-6">Content</h3>
            <div class="flex gap-2">
                <div id="changeOrder" class="p-2 bg-primary rounded-2xl w-12 h-12 cursor-pointer">
                    <x-svg.icons.order class="stroke-white w-8 h-8" />
                </div>
                <div id="saveOrder"
                    class="py-2 px-4 bg-primary text-white rounded-2xl h-12 cursor-pointer flex justify-center items-center hidden">
                    Save
                </div>
                <a href='/expert/edit-course/edit-section/new-element?course_id={{ $course_id }}&section_id={{ $section_id }}&edit=true'
                    class="p-2 bg-primary rounded-2xl w-12 h-12 cursor-pointer">
                    <x-svg.icons.plus class="stroke-white w-8 h-8" />
                </a>
            </div>
        </div>
        <div class="flex flex-col gap-4 list-group" id="listwithHandle">
            @foreach ($chapter->elements as $element)
                <div class="flex justify-between bg-white rounded-md p-6 list-group-item" id="{{ $element->id }}">
                    <div class="flex gap-4">
                        <x-svg.icons.grab class="stroke-primary w-8 h-8 cursor-move move-handle hidden" />
                        <h4 class="text-xl font-semibold">{{ $element->type }}: {{ $element->title }}</h4>
                    </div>
                    <div class="flex gap-2">
                        <x-svg.icons.edit
                            onclick="window.location='{{ url('expert/edit-course/edit-section/edit-element/?course_id=' . $course->id . '&section_id=' . $chapter->id . '&element_id=' . $element->id) }}'"
                            class="stroke-primary w-8 h-8 cursor-pointer" />
                        <form action="/expert/course/section/element/delete/{{ $element->id }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course_id }}">
                            <input type="hidden" name="section_id" value="{{ $section_id }}">
                            <button type="submit">
                                <x-svg.icons.trash class="stroke-red-500 w-8 h-8 cursor-pointer" />
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" form="update-section"
            class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
            Save section
        </button>
        <button type="button"
            onclick="window.location='{{ url('expert/edit-course?course_id=' . $course_id . '&step=2') }}'"
            class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-secondary text-secondary cursor-pointer">
            Back
        </button>

    </div>
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

            const order = localStorage.getItem("order-element").split(",");
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const url = "{{ url('/expert/course/section/order/update/' . $section_id) }}";
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
                    localStorage.setItem("order-element", order);
                }
            }
        });
    </script>
</x-app-layout>
