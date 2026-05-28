<nav x-data="{ open: false }" class="sticky top-0 z-40 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100/80 dark:border-gray-800/40 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-10">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group focus:outline-none transition-transform duration-200 active:scale-95">
                        <x-application-logo class="block h-6 w-auto text-gray-900 dark:text-gray-100 transition-colors group-hover:text-indigo-600 dark:group-hover:text-indigo-400" />
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:gap-1">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('repairs.index')" :active="request()->routeIs('repairs.index')">
                        {{ __('Repairs') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 text-[13px] font-medium rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/40 focus:outline-none transition-all duration-200 group">
                            <div class="h-6 w-6 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[11px] font-bold text-gray-700 dark:text-gray-300 tracking-wider group-hover:bg-gray-200/70 dark:group-hover:bg-gray-700 transition-colors">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="opacity-40 group-hover:opacity-100 transition-opacity duration-200">
                                <svg class="h-3 w-3 transition-transform duration-200 group-hover:translate-y-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-1 py-1 space-y-0.5">
                            <x-dropdown-link :href="route('profile.edit')" class="text-xs rounded-md py-2 flex items-center gap-2 font-medium">
                                <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-100 dark:border-gray-800 my-1 mx-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="text-xs rounded-md py-2 flex items-center gap-2 font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20">
                                    <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/60 focus:outline-none transition-all">
                    <svg class="h-5 w-5 transition-transform duration-200" :class="{'rotate-90': open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100 dark:border-gray-800/60 bg-white/90 dark:bg-gray-900/90 backdrop-blur-lg">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="rounded-xl text-[13px] font-medium py-2.5 px-4 block border-l-2 transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-50/60 border-indigo-600 text-indigo-600 dark:bg-indigo-950/30 dark:border-indigo-400 dark:text-indigo-400 font-semibold' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/40' }}">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('repairs.index')" :active="request()->routeIs('repairs.index')"
                class="rounded-xl text-[13px] font-medium py-2.5 px-4 block border-l-2 transition-all duration-150 {{ request()->routeIs('repairs.index') ? 'bg-indigo-50/60 border-indigo-600 text-indigo-600 dark:bg-indigo-950/30 dark:border-indigo-400 dark:text-indigo-400 font-semibold' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/40' }}">
                {{ __('Repairs') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-3 border-t border-gray-100 dark:border-gray-800/80 px-3">
            <div class="flex items-center gap-3 px-4 mb-4">
                <div class="h-9 w-9 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs font-bold text-gray-700 dark:text-gray-300">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <div class="font-semibold text-sm text-gray-900 dark:text-gray-100 tracking-tight leading-none">{{ Auth::user()->name }}</div>
                    <div class="text-xs font-medium text-gray-400 mt-1.5 leading-none">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1 px-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl text-[13px] font-medium py-2.5 px-4 flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800/40 border-0">
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="rounded-xl text-[13px] font-medium py-2.5 px-4 text-red-600 dark:text-red-400 flex items-center gap-2 hover:bg-red-50 dark:hover:bg-red-950/20 border-0">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
