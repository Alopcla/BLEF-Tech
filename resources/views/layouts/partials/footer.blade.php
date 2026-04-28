<div class="relative z-10 bg-[#1A2E1A] border-t border-[#D9C8A1]/20 py-6 px-6">
    <div class="max-w-6xl mx-auto">
        
        {{-- Fila Principal: Logo, Nav y Redes --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-6">

            {{-- Logo compacto --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('LOGO.PNG') }}" class="w-10 brightness-110" alt="Park Zoo">
                <div>
                    <h4 class="font-parkzoo text-base font-bold text-[#D9C8A1] leading-none uppercase tracking-tight">BLR-Zoo</h4>
                    <p class="text-[9px] text-[#D9C8A1]/50 uppercase tracking-widest">Explora lo salvaje</p>
                </div>
            </div>

            {{-- Navegación compacta --}}
            <nav style="font-family: 'Outfit', sans-serif;" class="flex gap-5 text-xs font-medium text-[#D9C8A1]/70">
                <a href="{{ route('animales') }}" class="hover:text-white transition-colors">Animales</a>
                <a href="{{ route('tickets.show') }}" class="hover:text-white transition-colors">Tickets</a>
                <a href="{{ route('contacto') }}" class="hover:text-white transition-colors">Contacto</a>
                <a href="{{ route('mapa.index') }}" class="hover:text-white transition-colors">Mapa</a>
            </nav>

            {{-- Redes pequeñas --}}
            <div class="flex gap-4 text-lg text-[#D9C8A1]/80">
                <a href="#" class="hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-white transition-all"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-white transition-all"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        {{-- LÍNEA SEPARADORA Y ENLACES LEGALES (Sub-footer más fino) --}}
        <div class="border-t border-[#D9C8A1]/10 pt-4 flex flex-col md:flex-row justify-between items-center gap-3">
            <div style="font-family: 'Outfit', sans-serif;" class="flex gap-4 text-[10px] uppercase tracking-widest text-[#D9C8A1]/40">
                <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacidad</a>
                <a href="{{ route('legal-notice') }}" class="hover:text-white transition-colors">Aviso Legal</a>
                <a href="{{ route('zoo-rules') }}" class="hover:text-white transition-colors">Normas Zoo</a>
                <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terminos y Condiciones</a>
            </div>
            
            <p style="font-family: 'Outfit', sans-serif;" class="text-[9px] text-[#D9C8A1]/30">
                © {{ date('Y') }} BLR-Zoo ZOO. TFG Académico.
            </p>
        </div>

    </div>
</div>