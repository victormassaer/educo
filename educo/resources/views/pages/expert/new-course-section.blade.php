<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expert Dashboard') }}
        </h2>
    </x-slot>
    @php
        $course_id = $course->id;
        $section_id = $chapter->id;
    @endphp
    <div>
        <h1 class="text-5xl font-bold text-primary mb-6">New Section</h1>
        <form action="/expert/edit-course/new-section/create" method="POST" class=" items-start">
            @csrf
            <input type="hidden" name="section_id" value={{ $section_id }}>
            <input type="hidden" name="course_id" value={{ $course_id }}>
            <div class=" flex flex-col gap-2 max-w-screen-sm">
                <label class="mt-4" for="title">Title</label>
                <input class="rounded-md w-3/5" type="text" name="title" id="title" placeholder="title"
                    value='{{ $chapter->title }}'>
            </div>


            <div class="flex justify-between items-center mt-4 mb-4 w-full">
                <h3 class="text-3xl font-bold text-primary mb-6">Content</h3>
                <a href='/expert/edit-course/edit-section/new-element?course_id={{ $course_id }}&section_id={{ $section_id }}'
                    class="p-2 bg-primary rounded-2xl w-12 h-12 cursor-pointer">
                    <x-svg.icons.plus class="stroke-white w-8 h-8" />
                </a>
            </div>
            <div class="flex flex-col gap-4">
                @foreach ($chapter->elements as $element)
                    <div class="flex bg-white rounded-md p-6">
                        <h4 class="text-xl font-semibold">{{ $element->type }}: {{ $element->title }}</h1>

                    </div>
                @endforeach
            </div>
            <button type="submit"
                class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                Save section
            </button>
        </form>
    </div>
</x-app-layout>
