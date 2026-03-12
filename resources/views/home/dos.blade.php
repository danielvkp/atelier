<section class="bg-white py-12 md:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-4 md:px-10">

        <div class="max-w-7xl mx-auto px-6 mb-16 md:mb-24 text-center">
            <span class="block text-[10px] uppercase tracking-[0.6em] text-stone-400 mb-4 font-semibold">
                Artesanía y Diseño
            </span>

            <h2 class="font-serif text-4xl md:text-5xl lg:text-6xl font-extralight text-stone-900 leading-tight">
                Descubre el <span class="italic text-stone-500">Universo</span> Atelier
            </h2>

            <div class="mt-8 flex justify-center">
                <div class="w-12 h-[1px] bg-stone-300"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">

            <div class="group relative overflow-hidden aspect-[3/4] md:aspect-[4/3] bg-stone-100">
                <a href="{{ url('/vestidos') }}" class="block h-full w-full">
                    <img src="https://cdn.millanova.com/medium_2_N9_A9024_375d7299fe.jpg" alt="Vestidos de novia"
                        class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-105">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                    <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-12 lg:p-14 text-white">
                        <h2
                            class="font-serif text-3xl md:text-4xl lg:text-5xl font-light mb-4 uppercase tracking-tight">
                            Vestidos
                        </h2>
                        <p class="text-sm md:text-base font-light max-w-xs mb-6 opacity-90">
                            Una variedad de vestidos de novia a la moda para novias contemporáneas.
                        </p>
                        <div>
                            <span
                                class="inline-block border border-white px-8 py-3 text-[10px] uppercase tracking-[0.3em] backdrop-blur-sm transition-all group-hover:bg-white group-hover:text-black">
                                Explorar
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="group relative overflow-hidden aspect-[3/4] md:aspect-[4/3] bg-stone-100">
                <a href="{{ url('/colecciones') }}" class="block h-full w-full">
                    <img src="https://cdn.millanova.com/medium_2_N9_A3076_9e7cf5886b.jpg" alt="Nuestras Colecciones"
                        class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-105">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                    <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-12 lg:p-14 text-white">
                        <h2
                            class="font-serif text-3xl md:text-4xl lg:text-5xl font-light mb-4 uppercase tracking-tight">
                            Colecciones
                        </h2>
                        <p class="text-sm md:text-base font-light max-w-xs mb-6 opacity-90">
                            Sumérjase en un mundo de belleza etérea.
                        </p>
                        <div>
                            <span
                                class="inline-block border border-white px-8 py-3 text-[10px] uppercase tracking-[0.3em] backdrop-blur-sm transition-all group-hover:bg-white group-hover:text-black">
                                Explorar
                            </span>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>
