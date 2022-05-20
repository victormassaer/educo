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
        <h1 class="text-5xl font-bold text-primary mb-6">New course</h1>
        {{-- STEP 1 --}}
        @if ($step === '1')
            <h3 class="text-3xl font-bold text-primary mb-6">Details</h3>
            <form action="/expert/new-course/create" method="POST"
                class="flex flex-col max-w-screen-sm gap-2 items-start">
                @csrf
                <label class="mt-4" for="title">Title</label>
                <input class="rounded-md w-3/5" type="text" name="title" id="title" placeholder="title">
                <label class="mt-4" for="description">Description</label>
                <textarea class="rounded-md max-h-96" name="description" id="description" cols="70" rows="10"
                    placeholder="description"></textarea>
                <label class="mt-4" for="">Difficulty</label>
                <select class="rounded-md w-3/5" name="difficulty" id="difficulty">
                    <option>easy</option>
                    <option>medium</option>
                    <option>hard</option>
                </select>
                <button type="submit"
                    class="mt-4 whitespace-nowrap py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                    Next step
                </button>
            </form>
            {{-- STEP 2 --}}
        @elseif($step === '2')
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-3xl font-bold text-primary mb-6">Sections</h3>
                <a href='new-course/new-section?course_id={{ $course_id }}'
                    class="p-2 bg-primary rounded-2xl w-12 h-12 cursor-pointer">
                    <x-svg.icons.plus class="stroke-white w-8 h-8" />
                </a>
            </div>
            @foreach ($course->chapters as $chapter)
                <div class="mb-4">
                    <div class="flex bg-white rounded-md p-2">
                        <h4 class="text-xl font-bold">Section {{ $loop->index + 1 }}: {{ $chapter->title }}</h4>
                    </div>
                    <div>
                        @foreach ($chapter->elements as $element)
                            <div>{{ $element->type }}</div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
