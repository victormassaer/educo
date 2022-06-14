<x-app-layout>
    <div class="box-border">
        <div class="">
            <img src="{{ Auth::user()->picture }}" alt="profile picture">
        </div>
        <div>
            <div class="text-2xl text-tertiary font-bold">{{ $company->name}}</div>
            <div class="text-xl text-primary">{{ Auth::user()->profile->title }}</div>
        </div>
        <form action="{{route('user.detail.edit.store')}}" method="POST">
            @csrf
            <div class="inline-block drop-shadow-md">
                <select name="" id="" class="rounded border-solid border-2 border-primary">
                    <option value="-">-</option>
                    <option value="male">Mr.</option>
                    <option value="female">Ms.</option>
                    <option value="x">Mx.</option>
                </select>
            </div>

            <div class="my-3 inline-block mr-3 drop-shadow-md">
                <label for="name" class="block font-bold my-1">Name</label>
                <input type="text" name="name" id="name" class="rounded border-solid border-2 border-primary p-2" value="{{ Auth::user()->name }}">
            </div>

            <div class="my-3 inline-block mx-3 drop-shadow-md">
                <label for="email" class="block font-bold my-1">Email</label>
                <input type="email" name="email" id="email" class="rounded border-solid border-2 border-primary p-2" value="{{ Auth::user()->email }}">
            </div>

            <div>
                <div class="my-3 inline-block mr-3 drop-shadow-md">
                    <label for="age" class="block font-bold my-1">Age</label>
                    <input type="number" name="age" id="age" class="rounded border-solid border-2 border-primary p-2" value="{{ Auth::user()->age }}">
                </div>

                <div class="my-3 inline-block mx-3 drop-shadow-md">
                    <label for="country" class="block font-bold my-1">Country</label>
                    <input type="text" name="country" id="country" class="rounded border-solid border-2 border-primary p-2" value="{{ Auth::user()->country }}">
                </div>

                <div class="my-3 inline-block mx-3 drop-shadow-md">
                    <label for="degree" class="block font-bold my-1">Degree</label>
                    <input type="text" name="degree" id="degree" class="rounded border-solid border-2 border-primary p-2" value="{{ Auth::user()->degree}}">
                </div>
            </div>


            <input type="submit" value="Edit info" class="cursor-pointer bg-primary border-2 border-primary text-white font-bold rounded text-l p-1 px-2 hover:bg-tertiary hover:border-tertiary hover:border-solid hover:border-2 hover:drop-shadow-md">

        </form>
    </div>
</x-app-layout>
