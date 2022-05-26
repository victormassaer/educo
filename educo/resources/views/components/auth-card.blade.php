<div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-primary-blue">
    <div class="my-6 ml-auto mr-5">
        <a href="{{route('login.expert')}}" class="bg-tertiary border-2 border-tertiary text-white font-bold rounded text-l p-1 px-2 hover:bg-primary-blue hover:border-tertiary hover:border-solid hover:border-2">submit a course</a>
        <a href="#" class="bg-tertiary text-white font-bold rounded border-2 border-tertiary text-l p-1 px-2 hover:bg-primary-blue hover:border-tertiary hover:border-solid hover:border-2">register your company</a>
    </div>

    <div class="w-full sm:max-w-md mt-40 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg drop-shadow-md">
        {{ $slot }}
    </div>

    <div class="my-6 ml-auto mr-5 mt-44">
        <a href="https://educo.expert" class="text-white text-l font-bold p-1 border-white border-2 border-solid rounded px-4 hover:bg-white hover:text-primary">more info</a>
    </div>
</div>
