<div class="flex relative">
    <div class="h-screen w-24 flex bg-primary">
        <nav class="flex flex-col flex-grow overflow-hidden">
            <div class=" mx-auto flex justify-center flex-col my-6">
                <x-svg.navicons.logo-word />
            </div>
            <div class="flex gap-4 flex-col items-center justify-center mx-4 m-5 my-6">
                <a href="{{ route('user.detail.index') }}">
                    <img class="rounded-full h-16 w-16 object-cover" src="https://picsum.photos/id/237/200/300"
                        alt="user-image">
                </a>

            </div>
            <div class="flex-auto overflow-auto no-scrollbar" style>
                <ul class="mx-2">
                    <li class="flex justify-center flex-col ">
                        <a href="/dashboard">
                            <div class="w-10 flex items-center px-2 py-1 rounded-2xl mx-auto">
                                <x-svg.navicons.logo
                                    class="{{ Request::is('dashboard') ? 'fill-secondary' : 'fill-white' }}" />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col">
                        <a href="/expert/list">
                            <div class="w-10 flex items-center px-2 py-1 rounded-2xl mx-auto">
                                <x-svg.navicons.teach class="stroke-white"
                                    class="{{ Request::is('expert/list') ? 'stroke-secondary' : 'stroke-white' }}" />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col">
                        <a href="/competention-profile">
                            <div class="w-10 flex items-center px-2 py-1 rounded-2xl mx-auto">
                                <x-svg.navicons.radar class="stroke-white"
                                    class="{{ Request::is('competention-profile') ? 'stroke-secondary' : 'stroke-white' }}" />
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="mx-3">
                    <li class="flex justify-center flex-col my-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="cursor-pointer" :href="route('logout')" onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                <div class="w-10 flex items-center px-2 py-1 rounded-2xl mx-auto">
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
