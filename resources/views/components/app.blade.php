<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @hasSection('title')
            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="bg-gray-100">
<div id="app">
  <nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <x-logo style="width: 40px;fill:white;"/>
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline">
                <a href="/dashboard" class="px-3 py-2 rounded-md text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700{{ request()->is('dashboard*') ? ' bg-gray-900 text-white' : ' text-gray-300 hover:text-white hover:bg-gray-700' }}">Dashboard</a>
                <a href="/movies"  class="ml-4 px-3 py-2 rounded-md text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700{{ request()->is('movies*') ? ' bg-gray-900 text-white' : ' text-gray-300 hover:text-white hover:bg-gray-700' }}">Movies</a>
                <a href="/series" class="ml-4 px-3 py-2 rounded-md text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700{{ request()->is('series*') ? ' bg-gray-900 text-white' : ' text-gray-300 hover:text-white hover:bg-gray-700' }}">Series</a>
                <a href="/watched" class="ml-4 px-3 py-2 rounded-md text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700{{ request()->is('watched*') ? ' bg-gray-900 text-white' : ' text-gray-300 hover:text-white hover:bg-gray-700' }}">Watched</a>
                <a href="/reports" class="ml-4 px-3 py-2 rounded-md text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700{{ request()->is('reports*') ? ' bg-gray-900 text-white' : ' text-gray-300 hover:text-white hover:bg-gray-700' }}">Reports</a>
            </div>
          </div>
        </div>
          <div class="flex flex-1">
          <div class="search flex-1 ml-10">
             <search />
          </div>
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <button class="p-1 border-2 border-transparent text-gray-400 rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700" aria-label="Notifications">
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
            </button>

            <!-- Profile dropdown -->
            <div class="ml-3 relative" @click="open=true">
              <div>
                <button class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid" id="user-menu" aria-label="User menu" aria-haspopup="true" @click="open = true">
                  <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                </button>
              </div>
              <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg"  v-show="open">
                <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</a>
                  <form id="logout-form" action="{{ url('logout') }}" method="POST">
                    @csrf
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
          </div>
        <div class="-mr-2 flex md:hidden">
          <!-- Mobile menu button -->
          <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
            <!-- Menu open: "hidden", Menu closed: "block" -->
            <svg class="block h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <!-- Menu open: "block", Menu closed: "hidden" -->
            <svg class="hidden h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!--
      Mobile menu, toggle classes based on menu state.

      Open: "block", closed: "hidden"
    -->
    <div class="hidden md:hidden">
      <div class="px-2 pt-2 pb-3 sm:px-3">
        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700">Dashboard</a>
        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Movies</a>
        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Series</a>
        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Watched</a>
        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Reports</a>
      </div>
      <div class="pt-4 pb-3 border-t border-gray-700">
        <div class="flex items-center px-5">
          <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium leading-none text-white">Tom Cook</div>
            <div class="mt-1 text-sm font-medium leading-none text-gray-400">tom@example.com</div>
          </div>
        </div>
        <div class="mt-3 px-2">
          <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Your Profile</a>
          <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Settings</a>
          <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Sign out</a>
        </div>
      </div>
    </div>
  </nav>

  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
      <h1 class="text-3xl font-bold leading-tight text-gray-900">
        {{ $title ?? env('APP_NAME')}}
      </h1>
    </div>
  </header>
  <main class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    {{ $slot }}
    </div>
  </main>
</div>
    </body>
</html>
