<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course dashboard') }}
        </h2>
    </x-slot>

        <div class="py-3 max-w-3xl mx-auto flex flex-row justify-around">
            <a href="/dashboard"><p class="font-semibold">All courses</p></a>
            <a href="{{route('dashboard.active', $user->id)}}"><p>Active</p></a>
            <a href="{{route('dashboard.obligated', $user->id)}}"><p>Obligated</p></a>
            <a href="{{route('dashboard.finished', $user->id)}}"><p>Finished</p></a>
        </div>
        <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row">
            @foreach($courses as $course)
                <x-Course :course="$course" class="basis-1/3"/>
            @endforeach
        </div>
</x-app-layout>
