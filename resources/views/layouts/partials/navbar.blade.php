<header class="absolute w-full top-0 z-[100] flex justify-center pt-6 px-4">
    <div class="flex items-center gap-4 md:gap-8 bg-[#1A2E1A]/80 backdrop-blur-xl px-4 md:px-8 py-3 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.3)] border border-white/10 relative">
        
        <div class="absolute -top-10 -left-10 w-20 h-20 bg-green-500/20 blur-3xl rounded-full"></div>

        @php
            $authUser = Auth::guard('employee')->user() ?? Auth::guard('web')->user();
            $links = [
                ['url' => url('/'), 'label' => 'Inicio', 'icon' => 'fa-house', 'active' => request()->is('/')],
                ['url' => route('VistaExperiencias'), 'label' => 'Experiencias', 'icon' => 'fa-leaf', 'active' => request()->routeIs('VistaExperiencias')],
                ['url' => route('animales'), 'label' => 'Animales', 'icon' => 'fa-paw', 'active' => request()->routeIs('animales')],
                ['url' => route('tienda'), 'label' => 'Tienda', 'icon' => 'fa-bag-shopping', 'active' => request()->routeIs('tienda*')],
            ];
        @endphp

        <a href="/" class="relative z-10 transition-transform hover:scale-110 duration-300">
            <img src="{{ asset('LOGO.PNG') }}" class="w-12 md:w-14 drop-shadow-[0_0_8px_rgba(217,200,161,0.5)]" alt="Park Zoo">
        </a>

        <nav class="hidden lg:flex gap-2 text-sm xl:text-base font-parkzoo items-center relative z-10">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}"
                   class="group flex items-center gap-2 px-4 py-2 rounded-xl transition-all duration-300 
                   {{ $link['active'] ? 'bg-[#D9C8A1] text-[#1A2E1A] shadow-md' : 'text-[#D9C8A1] hover:bg-white/10' }}">
                    <i class="fa-solid {{ $link['icon'] }} text-xs opacity-70 group-hover:rotate-12 transition-transform"></i>
                    <span class="font-bold tracking-wide">{{ $link['label'] }}</span>
                </a>
            @endforeach

            <div class="h-6 w-[1px] bg-white/20 mx-2"></div>

            <a href="{{ route('payment.show') }}"
               class="flex items-center gap-2 bg-gradient-to-r from-[#F2C94C] to-[#F2994A] text-[#1A2E1A] px-5 py-2 rounded-xl font-black uppercase text-xs tracking-tighter hover:shadow-[0_0_20px_rgba(242,201,76,0.4)] hover:-translate-y-0.5 transition-all duration-300">
                <i class="fa-solid fa-ticket"></i>
                Tickets
            </a>
        </nav>

        <div class="hidden md:flex items-center gap-3 relative z-10">
            @if($authUser)
                <div class="relative group">
                    <button class="text-[#D9C8A1] hover:text-white transition-colors p-2 flex items-center gap-2 outline-none">
                        <i class="fa-solid fa-circle-user text-2xl"></i>
                        <i class="fa-solid fa-chevron-down text-[10px] opacity-50 group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>

                    <div class="absolute right-0 top-full mt-2 w-52 bg-[#1A2E1A] border border-white/10 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] py-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[150] backdrop-blur-xl">
                        <div class="px-5 py-2 mb-2">
                            <p class="text-[10px] text-[#D9C8A1]/40 uppercase font-black tracking-[2px]">Usuario</p>
                            <p class="text-[#D9C8A1] text-sm truncate font-bold">{{ $authUser->name }}</p>
                        </div>
                        <div class="h-[1px] bg-white/5 mx-4 mb-2"></div>
                        @if(Auth::guard('employee')->check())
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-[#D9C8A1] hover:bg-white/5 transition-colors text-sm font-bold">
                                <i class="fa-solid fa-chart-line opacity-70 w-5"></i>
                                Panel Control
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-red-400 hover:bg-red-500/10 transition-colors text-sm font-bold text-left">
                                <i class="fa-solid fa-right-from-bracket opacity-70 w-5"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="group flex items-center gap-2 border border-[#D9C8A1]/30 px-4 py-2 rounded-xl text-[#D9C8A1] hover:bg-[#D9C8A1] hover:text-[#1A2E1A] transition-all duration-500 text-sm font-bold">
                    <span>Iniciar Sesión</span>
                    <i class="fa-solid fa-arrow-right-to-bracket transition-transform group-hover:translate-x-1"></i>
                </a>
            @endif
        </div>

        <button class="lg:hidden text-[#D9C8A1] p-2 hover:bg-white/10 rounded-lg transition-colors relative z-[110]" id="menu-toggle">
            <i class="fa-solid fa-bars-staggered text-2xl transition-all duration-300" id="menu-icon"></i>
        </button>
    </div>

    <div id="mobile-menu" class="fixed inset-0 bg-[#1A2E1A]/95 backdrop-blur-2xl z-[90] translate-x-full transition-transform duration-500 ease-in-out lg:hidden">
        <div class="flex flex-col h-full pt-32 px-10 pb-12">
            <button id="menu-close" class="absolute top-8 right-8 w-10 h-10 flex items-center justify-center rounded-full border border-[#D9C8A1]/20 text-[#D9C8A1] hover:bg-[#D9C8A1]/10 transition-all duration-300">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <nav class="flex flex-col gap-4">
                @foreach($links as $link)
                    <a href="{{ $link['url'] }}" class="text-3xl font-bold text-[#D9C8A1] flex items-center justify-between py-4 border-b border-white/5">
                        <span>{{ $link['label'] }}</span>
                        <i class="fa-solid {{ $link['icon'] }} text-xl opacity-20"></i>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto space-y-4">
                @if($authUser)
                    <div class="grid grid-cols-1 gap-3">
@if(Auth::guard('employee')->check())
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center justify-between p-4 border border-[#D9C8A1]/20 rounded-2xl text-[#D9C8A1] active:bg-white/5 transition-all">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-chart-line opacity-70"></i>
                        <span class="font-bold tracking-wide text-lg">Panel Control</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs opacity-30"></i>
                </a>
            @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-between p-4 border border-red-500/20 rounded-2xl text-red-400 active:bg-red-500/5 transition-all">
                                <span class="font-bold tracking-wide">Cerrar Sesión</span>
                                <i class="fa-solid fa-right-from-bracket opacity-50"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="flex items-center justify-between p-4 border border-[#D9C8A1]/20 rounded-2xl text-[#D9C8A1] active:bg-white/5 transition-all mb-2">
                        <span class="font-bold tracking-wide text-lg">Iniciar Sesión</span>
                        <i class="fa-solid fa-arrow-right-to-bracket opacity-50"></i>
                    </a>
                @endif
                
                <a href="{{ route('payment.show') }}" class="w-full py-5 bg-gradient-to-r from-[#F2C94C] to-[#F2994A] text-[#1A2E1A] rounded-2xl font-black text-center block text-lg uppercase tracking-widest shadow-xl">
                    Tickets
                </a>
            </div>
        </div>
    </div>
</header>

<div class="h-20 md:h-19"></div>

@push('scripts')
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const menuClose  = document.getElementById('menu-close');
    const menuIcon   = document.getElementById('menu-icon');
    const mobileMenu = document.getElementById('mobile-menu');

    function openMenu() {
        mobileMenu.classList.remove('translate-x-full');
        menuIcon.classList.replace('fa-bars-staggered', 'fa-xmark');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        mobileMenu.classList.add('translate-x-full');
        menuIcon.classList.replace('fa-xmark', 'fa-bars-staggered');
        document.body.style.overflow = 'auto';
    }

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.contains('translate-x-full') ? openMenu() : closeMenu();
    });

    menuClose.addEventListener('click', closeMenu);

    mobileMenu.addEventListener('click', (e) => {
        if (e.target === mobileMenu) closeMenu();
    });
</script>
@endpush