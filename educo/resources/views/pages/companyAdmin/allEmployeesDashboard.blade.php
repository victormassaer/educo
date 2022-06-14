<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <section>
        <h1 class="text-3xl font-bold text-primary-blue my-5">All employees</h1>
        <h2 class="font-bold text-2xl text-tertiary">{{$company->name}}</h2>
        @foreach($employees as $employee)
            <a href="{{route('admin.userDetail.index', $employee->id)}}">
                <div class="bg-white inline-block mr-4 rounded p-4 text-center my-5 w-56 h-52 shadow-md">
                    <img src="{{asset($employee->picture)}}" class="rounded-full ml-11 mb-5 w-32" alt="profile picture">
                    <p class="font-bold">{{$employee->name}}</p>
                    <p>{{$employee->profile->title}}</p>
                </div>
            </a>
        @endforeach
    </section>
</x-app-layout>




