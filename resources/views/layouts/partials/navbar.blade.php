<header class="absolute w-full top-0 z-[100] flex justify-center pt-6 px-4">
    <div class="flex items-center gap-4 md:gap-8 bg-[#1A2E1A]/80 backdrop-blur-xl px-4 md:px-8 py-3 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.3)] border border-white/10 relative overflow-hidden">
        
        <div class="absolute -top-10 -left-10 w-20 h-20 bg-green-500/20 blur-3xl rounded-full"></div>

        <a href="/" class="relative z-10 transition-transform hover:scale-110 duration-300">
            <img src="{{ asset('LOGO.PNG') }}" class="w-12 md:w-14 drop-shadow-[0_0_8px_rgba(217,200,161,0.5)]" alt="Park Zoo">
        </a>

        <nav class="hidden lg:flex gap-2 text-sm xl:text-base font-parkzoo items-center relative z-10">
            @php
                $links = [
                    ['url' => url('/'), 'label' => 'Inicio', 'icon' => 'fa-house', 'active' => request()->is('/')],
                    ['url' => route('VistaExperiencias'), 'label' => 'Experiencias', 'icon' => 'fa-leaf', 'active' => request()->routeIs('VistaExperiencias')],
                    ['url' => route('animales'), 'label' => 'Animales', 'icon' => 'fa-paw', 'active' => request()->routeIs('animales')],
                    ['url' => route('tienda'), 'label' => 'Tienda', 'icon' => 'fa-bag-shopping', 'active' => request()->routeIs('tienda*')],
                ];
            @endphp

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
            @auth
                <a href="{{ route('dashboard') }}" class="text-[#D9C8A1] hover:text-white transition-colors p-2">
                    <i class="fa-solid fa-circle-user text-2xl"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="group flex items-center gap-2 border border-[#D9C8A1]/30 px-4 py-2 rounded-xl text-[#D9C8A1] hover:bg-[#D9C8A1] hover:text-[#1A2E1A] transition-all duration-500 text-sm font-bold">
                    <span>Iniciar Sesión</span>
                    <i class="fa-solid fa-arrow-right-to-bracket transition-transform group-hover:translate-x-1"></i>
                </a>
            @endauth
        </div>

        <button class="lg:hidden text-[#D9C8A1] p-2 hover:bg-white/10 rounded-lg transition-colors relative z-[110]" id="menu-toggle">
            <i class="fa-solid fa-bars-staggered text-2xl transition-all duration-300" id="menu-icon"></i>
        </button>
    </div>

    {{-- El menú móvil sí se mantiene fijo para que funcione correctamente al abrirse --}}
    <div id="mobile-menu" class="fixed inset-0 bg-[#1A2E1A]/95 backdrop-blur-2xl z-[90] translate-x-full transition-transform duration-500 ease-in-out lg:hidden">
        <div class="flex flex-col h-full pt-32 px-10 pb-12">
            <button id="menu-close" class="absolute top-8 right-8 w-10 h-10 flex items-center justify-center rounded-full border border-[#D9C8A1]/20 text-[#D9C8A1] hover:bg-[#D9C8A1]/10 transition-all duration-300">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <span class="text-[#D9C8A1]/20 text-[10px] uppercase tracking-[8px] font-black mb-10 text-center">Navegación</span>

            <nav class="flex flex-col gap-4">
                @foreach($links as $link)
                    <a href="{{ $link['url'] }}" class="text-3xl font-bold text-[#D9C8A1] flex items-center justify-between py-4 border-b border-white/5 active:bg-white/5 px-4 rounded-2xl transition-all">
                        <span>{{ $link['label'] }}</span>
                        <i class="fa-solid {{ $link['icon'] }} text-xl opacity-20"></i>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto">
                <a href="{{ route('login') }}" 
                class="flex items-center justify-between p-4 border border-[#D9C8A1]/20 rounded-2xl text-[#D9C8A1] hover:bg-white/5 transition-all duration-300 mb-6">
                    <span class="font-bold tracking-wide">Iniciar Sesión</span>
                    <i class="fa-solid fa-arrow-right-to-bracket opacity-50"></i>
                </a>
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