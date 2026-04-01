<div class="mt-16 bg-[#1A2E1A] border-t-2 border-[#D9C8A1]/20 py-10 px-6">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
        
        <div class="flex items-center gap-4">
            <img src="{{ asset('LOGO.PNG') }}" class="w-12 brightness-110" alt="Park Zoo">
            <div class="h-8 w-[1px] bg-[#D9C8A1]/20 hidden md:block"></div>
            <div>
                <h4 class="font-parkzoo text-lg font-bold text-[#D9C8A1] leading-none">BLEF-TECH</h4>
                <p class="text-[11px] text-[#D9C8A1]/60 uppercase tracking-widest mt-1">Explora lo salvaje</p>
            </div>
        </div>

        <nav class="flex gap-6 text-sm font-semibold text-[#D9C8A1]/80">
            <a href="#" class="hover:text-white transition-colors">Animales</a>
            <a href="#" class="hover:text-white transition-colors">Tickets</a>
            <a href="#" class="hover:text-white transition-colors">Contacto</a>
            <a href="{{route('mapa.index')}}" class="hover:text-white transition-colors">Mapa</a>
        </nav>

        <div class="flex flex-col items-center md:items-end gap-3">
            <div class="flex gap-5 text-xl text-[#D9C8A1]">
                <a href="#" class="hover:scale-110 hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:scale-110 hover:text-white transition-all"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:scale-110 hover:text-white transition-all"><i class="fab fa-youtube"></i></a>
            </div>
            <p class="text-[10px] text-[#D9C8A1]/40 tracking-tight">
                © {{ date('Y') }} Todos los derechos reservados.
            </p>
        </div>

    </div>
</div>