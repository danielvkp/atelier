<section class="bg-white pb-20 md:pb-32">
    <div class="max-w-[1440px] mx-auto px-4 md:px-10">

        <div class="group relative overflow-hidden aspect-[3/4] md:aspect-[25/9] bg-stone-100 shadow-2xl">

            <video autoplay muted loop playsinline
                class="absolute inset-0 z-0 h-full w-full object-cover grayscale-[30%] transition-transform duration-[3s] group-hover:scale-110">
                <source src="{{ asset('media/video/hero_cuatro.mp4') }}" type="video/mp4">
            </video>

            <div class="absolute inset-0 z-10 bg-gradient-to-r from-black/60 via-black/20 to-transparent"></div>

            <div class="relative z-20 flex h-full flex-col justify-center p-8 md:p-20 lg:p-32 text-white">

                <div class="max-w-xl space-y-6">
                    <div class="flex items-center space-x-4 mb-2">
                        <div class="w-8 h-[1px] bg-white/60"></div>
                        <span class="text-[10px] uppercase tracking-[0.6em] font-light">The Masterpiece</span>
                    </div>

                    <h2 class="font-serif text-4xl md:text-6xl lg:text-7xl font-light leading-[1.1] tracking-tighter">
                        La Esencia del <br>
                        <span class="italic font-extralight pl-8 md:pl-16 text-stone-300">Savoir-Faire</span>
                    </h2>

                    <p class="text-sm md:text-base font-light leading-relaxed opacity-80 max-w-sm">
                        Cada puntada cuenta una historia de dedicación. Descubra nuestro atelier donde la tradición se
                        encuentra con la visión contemporánea.
                    </p>

                    <div class="pt-6">
                        <a href="#"
                            class="group relative inline-flex items-center space-x-6 text-[10px] uppercase tracking-[0.5em]">
                            <span>Ver el proceso</span>
                            <div class="w-10 h-[1px] bg-white transition-all duration-500 group-hover:w-20"></div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="absolute top-10 right-10 z-20 hidden lg:block">
                <span class="font-serif text-8xl font-black opacity-10 select-none text-white">04</span>
            </div>
        </div>

    </div>
</section>
