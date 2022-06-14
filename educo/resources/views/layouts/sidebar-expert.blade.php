<div class="flex relative">
    <div class="h-screen w-24 flex bg-primary">
        <nav class="flex flex-col flex-grow overflow-hidden">
            <div class=" mx-auto flex justify-center flex-col my-6">
                <x-svg.navicons.logo-word />
            </div>
            <div class="flex gap-4 flex-col items-center justify-center mx-4 m-5 my-12">
                <a href="{{ route('user.detail.index') }}">
                    <img class="rounded-full h-16 w-16 object-cover" src="https://picsum.photos/id/237/200/300"
                        alt="user-image">
                </a>
            </div>
            <div class="flex-auto overflow-hidden">
                <ul class="mx-5">
                    <li class="flex justify-center flex-col my-3">
                        <a href="/expert/dashboard">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.logo />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col my-3">
                        <a href="/expert/new-course">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.layout-add class="stroke-white" />
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="mx-5">
                    <li class="flex justify-center flex-col my-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="cursor-pointer" :href="route('logout')" onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                <div class="w-full flex items-center p-3 rounded-2xl">
                                    <x-svg.navicons.logout class="stroke-red-600" />
                                </div>
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
