<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expert Dashboard') }}
        </h2>
    </x-slot>
    @php
        $course_id = request()->course_id;
    @endphp
    <div>
        <h1 class="text-5xl font-bold text-primary mb-6">New course</h1>
        <h3 class="text-3xl font-bold text-primary mb-6">Details</h3>
        <form action="/expert/new-course/create" method="POST" enctype="multipart/form-data"
            class="flex flex-col max-w-screen-sm gap-2 items-start">
            @csrf
            <label class="mt-4" for="title">Title</label>
            <input class="rounded-md w-3/5" type="text" name="title" id="title" placeholder="title">
            <label class="mt-4" for="description">Description</label>
            <textarea class="rounded-md max-h-96" name="description" id="description" cols="70" rows="10"
                placeholder="description"></textarea>
            <label class="mt-4" for="difficulty">Difficulty</label>
            <select class="rounded-md w-3/5" name="difficulty" id="difficulty">
                <option>easy</option>
                <option>medium</option>
                <option>hard</option>
            </select>
            <label class="mt-4" for="thumbnail">Thumbnail</label>
            <input type="file" id="thumbnail" name="thumbnail">
            <div class="flex gap-2">
                <button type="submit"
                    class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                    Save
                </button>
                <button type="button" onclick="window.location='{{ url('expert/dashboard') }}'"
                    class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-secondary text-secondary cursor-pointer">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
