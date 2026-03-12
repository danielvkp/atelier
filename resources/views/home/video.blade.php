<section x-data="{ scrolled: false }" @scroll.window="scrolled = window.pageYOffset > 50"
    class="relative h-screen w-full overflow-hidden bg-stone-200">

    <video autoplay muted loop playsinline
        poster="https://images.unsplash.com/photo-1594553703248-d1993657a734?auto=format&fit=crop&q=80"
        class="absolute inset-0 z-0 h-full w-full object-cover">
        <source src="{{ URL::asset('media/video/hero_atelier.mp4') }}" type="video/mp4">
        Tu navegador no soporta videos.
    </video>

    <div class="absolute inset-0 z-10 bg-black/20"></div>

    <div class="relative z-20 flex h-full flex-col items-center justify-center px-4 text-center text-white"
        x-show="!scrolled" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95">

        <span class="mb-4 text-[10px] font-bold uppercase tracking-[0.6em] text-stone-200">Alta Costura Atelier</span>

        <h1 class="font-serif text-5xl font-extralight tracking-tighter sm:text-8xl lg:text-[8rem] leading-none">
            Atelier <span class="italic opacity-80">2026</span>
        </h1>

        <div class="mt-12">
            <button
                class="border border-white/40 bg-white/5 px-12 py-4 text-[10px] uppercase tracking-[0.4em] backdrop-blur-md transition-all hover:bg-white hover:text-black">
                Explorar Colección
            </button>
        </div>
    </div>

    <div class="absolute bottom-12 left-1/2 z-20 -translate-x-1/2 opacity-50" x-show="!scrolled">
        <div class="w-[1px] h-12 bg-gradient-to-b from-white to-transparent"></div>
    </div>
</section>
