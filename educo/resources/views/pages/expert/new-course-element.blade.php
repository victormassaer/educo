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
    </div>
</x-app-layout>
