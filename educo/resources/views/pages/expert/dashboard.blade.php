<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expert Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <h1 class="text-5xl font-bold text-primary mb-6">Dashboard</h1>

        <section>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-primary ">My courses</h3>
                <a href='new-course' class="p-2 bg-primary rounded-2xl w-12 h-12 cursor-pointer">
                    <x-svg.icons.plus class="stroke-white w-8 h-8" />
                </a>
            </div>
            <div class="grid gap-4 grid-cols-4">
                @if (count($courses) === 0)
                    <p>No courses yet</p>
                @endif
                @foreach ($courses as $course)
                    <div class="bg-white rounded-md flex-1 flex items-center flex-col p-6 gap-4">
                        <h4 class="text-2xl font-bold">{{ $course->title }}</h4>
                        <img class="rounded-md" src="{{ asset('storage/' . $course->img) }}"
                            alt=" course thumbnail">
                        <p class="text-lg">50 Students</p>
                        <div class="flex gap-4">
                            <button
                                class="whitespace-nowrap flex-1 py-2 px-4 border-2 rounded-md border-tertiary text-tertiary cursor-pointer">
                                Stats
                            </button>
                            <button
                                class="whitespace-nowrap flex-1 py-2 px-4 border-2 rounded-md border-secundary text-secundary cursor-pointer">
                                Edit course
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
