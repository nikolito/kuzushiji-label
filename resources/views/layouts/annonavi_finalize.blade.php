<nav x-data="{ open: false }" class="border-b border-white-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('finalize_list') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('finalize_list')" :active="request()->routeIs('finalize_list')">
                        <b> {{ __('Return to Finalization List') }}</b>
                    </x-nav-link>
                    <x-nav-link :href="route('help')" :active="request()->routeIs('help')">
                        {{ __('Help') }}
                    </x-nav-link>
                    <x-dropdown align="right">
                        <x-slot name="trigger">
                            <button class="mt-6 w-30 h-6 flex items-center text-sm font-medium text-white-500 hover:text-white-700 hover:border-white-300 focus:outline-none focus:text-white-700 focus:border-white-300 transition duration-150 ease-in-out">
                                <div>{{ __('Links') }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <a href="https://crch.dl.saga-u.ac.jp/nikki/" target="_blank" class="p-2 text-sm text-black important">小城藩日記データベース</a>
                            <a href="http://codh.rois.ac.jp/char-shape/search/" target="_blank" class="p-2 text-sm text-black important">CODHくずし字検索</a>
                        </x-slot>
                    </x-dropdown>
                    <x-nav-link>
                        {{ basename(str_replace('/info.json', '', $target_task->image->image_url)) }}を表示中
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-white-500 hover:text-white-700 hover:border-white-300 focus:outline-none focus:text-white-700 focus:border-white-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}<x-role /></div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white-400 hover:text-white-500 hover:bg-white-100 focus:outline-none focus:bg-white-100 focus:text-white-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link>
                {{ basename(str_replace('/info.json', '', $target_task->image->image_url)) }}を表示中
            </x-responsive-nav-link>
            {{-- <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link> --}}
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white-200">
            <div class="px-4">
                <div class="font-medium text-base text-white-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white-500">{{ Auth::user()->email }}</div>
                <div class="font-medium text-sm text-white-500">*一番上のロゴをクリックすると清書リストに戻れます*</div>            </div>

            {{-- <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div> --}}
        </div>
    </div>
</nav>