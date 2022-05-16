<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Info Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="">
            <img src="{{ Auth::user()->picture }}" alt="profile picture">
        </div>
        <div>
            <h2></h2>
            <div>company weergeven met relations</div>
            <div>profile weergeven met relations</div>
            <div>{{ Auth::user()->gender }}</div>
            <div>{{ Auth::user()->age }}</div>
            <div>{{ Auth::user()->country }}</div>
            <div>{{ Auth::user()->degree }}</div>
        </div>
        <form action="{{route('user.detail.edit.store')}}" method="POST">
            @csrf
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}">
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}">
            </div>

            <input type="submit" value="Edit info" class="cursor-pointer">
        </form>
    </div>
</x-app-layout>
