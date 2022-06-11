<x-app-layout>
    <section class="p-20 px-20 box-border">
        <div class="grid grid-rows-1 grid-cols-2">
            <div class="py-5 grid grid-cols-2 grid-rows-1 bg-white justify-items-center rounded shadow-md">
                <div class="mt-50 text-center">
                    <img src="https://placekitten.com/150/150" class="rounded" alt="profile picture">
                    <h2 class="text-xl font-bold text-primary">{{ $expert->name}}</h2>
                </div>
                <div class="justify-self-start">
                    <div><span class="font-bold">email: </span>{{ $expert->email }}</div>
                    <div><span class="font-bold">gender: </span>{{ $expert->gender }}</div>
                    <div><span class="font-bold">age: </span>{{ $expert->age }}</div>
                    <div><span class="font-bold">country: </span>{{ $expert->country }}</div>
                    <div><span class="font-bold">degree: </span>{{ $expert->degree }}</div>
                </div>
            </div>
        </div>
        <div class="my-5">
            <h3 class="text-primary text-xl font-bold"><span>Number of courses: </span>{{count($courses)}}</h3>
            <div class="flex flex-rows">
                @foreach($courses as $course)
                    <div>
                        <x-course :course="$course" class="basis-1/3"/>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
