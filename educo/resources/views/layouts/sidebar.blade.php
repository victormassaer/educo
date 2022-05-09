<div class="flex relative">
    <div class="h-screen w-28 flex bg-primary">
        <nav class="flex flex-col flex-grow overflow-hidden">
            <div class=" mx-5 flex justify-center flex-col my-6">
                <x-svg.navicons.logo-word />
            </div>
            <div class="flex gap-4 flex-col items-center justify-center mx-4 m-5 my-12">
                <image class="rounded-full h-16 w-16 object-cover" src="https://picsum.photos/id/237/200/300" alt="user-image">
            </div>
            <div class="flex-auto overflow-hidden">
                <ul class="mx-5">
                    <li class="flex justify-center flex-col my-3">
                        <a href="/dashboard">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.logo />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col my-3">
                        <a href="/my-courses">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.layout class="stroke-white" />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col my-3">
                        <a href="/new-courses">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.layout-add class="stroke-white" />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col my-3">
                        <a href="/experts">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.teach class="stroke-white" />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col my-3">
                        <a href="/competention-profile">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.radar class="stroke-white" />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col my-3">
                        <a href="/certificates">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.certificate class="stroke-white" />
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="mx-5">
                    <li class="flex justify-center flex-col my-3">
                        <a href="/dashboard">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.settings class="stroke-white" />
                            </div>
                        </a>
                    </li>
                    <li class="flex justify-center flex-col my-3">
                        <a href="/my-courses">
                            <div class="w-full flex items-center p-3 rounded-2xl">
                                <x-svg.navicons.logout class="stroke-white" />
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>