<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col lg:max-w-4xl lg:flex-row shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg overflow-hidden bg-white dark:bg-[#161615]">

                <div class="text-[13px] leading-[20px] flex-1 p-6 lg:p-10 dark:text-[#EDEDEC]">
                    <div class="mb-6">
                        <h1 class="text-lg font-medium text-[#1b1b18] dark:text-white">Repair Tickets</h1>
                        <p class="text-[#706f6c] dark:text-[#A1A09A]">A complete list of currently active and tracked repair tickets.</p>
                    </div>

                    <div class="overflow-x-auto border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#FDFDFC] dark:bg-[#0d0d0c] border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                    <th class="p-3 font-medium text-[#706f6c] dark:text-[#A1A09A] w-16">ID</th>
                                    <th class="p-3 font-medium text-[#706f6c] dark:text-[#A1A09A]">Ticket Number</th>
                                    <th class="p-3 font-medium text-[#706f6c] dark:text-[#A1A09A]">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#e3e3e0] dark:divide-[#3E3E3A]">
                                @forelse($repairs as $repair)
                                    <tr class="hover:bg-[#FDFDFC] dark:hover:bg-[#1c1c1a] transition-colors">
                                        <td class="p-3 text-[#706f6c] dark:text-[#A1A09A]">#{{ $repair->id }}</td>
                                        <td class="p-3 font-mono font-medium text-[#f53003] dark:text-[#FF4433]">{{ $repair->ticket_number }}</td>
                                        <td class="p-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $repair->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-6 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                            No tickets found in the system.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <p class="mt-6 text-[#706f6c] dark:text-[#A1A09A]">
                        v{{ app()->version() }}
                    </p>
                </div>

            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
