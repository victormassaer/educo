<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-amber-‡">
                    dashboard for company Admin
                </div>
            </div>
        </div>
    </div>

    <section class="px-44">
        <div class="mb-5">
            <h2 class="font-bold text-2xl text-blue-600">Active Employees</h2>
            @foreach($activeEmployees as $employee)
                <a href="{{route('admin.userDetail.index', $employee->id)}}">
                    <div class="bg-white inline-block mr-4 rounded p-4 py-6 text-center my-5">
                        <img src="https://placekitten.com/100/100" class="rounded" alt="profile picture">
                        <p class="font-bold">{{$employee->name}}</p>
                        <p>{{$employee->profile->title}}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mb-5">
            <h2 class="font-bold text-2xl text-blue-600">Inactive Employees</h2>
            @foreach($inactiveEmployees as $employee)
                <a href="{{route('admin.userDetail.index', $employee->id)}}">
                    <div class="bg-white inline-block mr-4 rounded p-4 py-6 text-center my-5">
                        <img src="https://placekitten.com/100/100" class="rounded" alt="profile picture">
                        <p class="font-bold">{{$employee->name}}</p>
                        <p>{{$employee->profile->title}}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</x-app-layout>



