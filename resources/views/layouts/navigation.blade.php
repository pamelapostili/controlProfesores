<nav x-data="{ open: false }"
    class="border-b border-gray-200 shadow-md"
    style="background: #6f7e49">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            {{-- Logo y nombre de la aplicación --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 text-decoration-none">
                    {{-- <img src="{{ asset('storage/images/utp.png') }}"
                        alt="Logotipo UTP"
                        class="h-14 w-14 object-contain"> --}}

                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg leading-tight">
                            Universidad Tecnológica de Puebla
                        </span>
                        {{-- <span class="text-gray-200 text-xs">
                            Localiza a tu profesor fácilmente
                        </span> --}}
                    </div>
                </a>
            </div>

            {{-- Navegación principal --}}
            {{-- <div class="hidden sm:flex items-center gap-6">
                <x-nav-link
                    :href="route('dashboard')"
                    :active="request()->routeIs('dashboard')"
                    class="text-white hover:text-gray-200">
                    Inicio
                </x-nav-link>

                @if (Auth::user()->rol === 'alumno')
                    <x-nav-link
                        :href="route('profesores.index')"
                        :active="request()->routeIs('profesores.*')"
                        class="text-white hover:text-gray-200">
                        Profesores
                    </x-nav-link>
                @endif
            </div> --}}

            {{-- Menú del usuario --}}
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-4 py-2
                                   rounded-lg text-sm font-medium text-white
                                   hover:bg-white/10 focus:outline-none transition">

                            <span>{{ Auth::user()->name }}</span>

                            <svg class="h-4 w-4 fill-current"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- <x-dropdown-link :href="route('profile.edit')">
                            Mi perfil
                        </x-dropdown-link> --}}

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Botón para móviles --}}
            <div class="sm:hidden">
                <button
                    @click="open = !open"
                    class="p-2 rounded-lg text-white hover:bg-white/10"
                    aria-label="Abrir menú">

                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">
                        <path x-show="!open"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>

                        <path x-show="open"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú adaptable para móviles --}}
    <div x-show="open"
         x-transition
         class="sm:hidden border-t border-white/20"
         style="background-color: #35452f;">

        <div class="px-4 pt-3 pb-2 space-y-1">
            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')">
                Inicio
            </x-responsive-nav-link>

            @if (Auth::user()->rol === 'alumno')
                <x-responsive-nav-link
                    :href="route('profesores.index')"
                    :active="request()->routeIs('profesores.*')">
                    Profesores
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t border-white/20 px-4 py-4">
            <div class="text-white font-medium">
                {{ Auth::user()->name }}
            </div>

            <div class="text-gray-200 text-sm">
                {{ Auth::user()->email }}
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Mi perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>