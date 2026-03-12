<nav x-data="{ atTop: true, mobileMenu: false }" @scroll.window="atTop = (window.pageYOffset > 50) ? false : true"
    :class="atTop ? 'bg-transparent border-transparent py-6' : 'bg-white/90 backdrop-blur-md shadow-sm border-stone-200 py-4'"
    class="fixed top-0 left-0 z-50 w-full transition-all duration-300 border-b">

    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">

        <a href="{{ route('home') }}"
            class="text-2xl uppercase tracking-[0.3em] font-light transition-colors duration-300"
            :class="atTop ? 'text-white' : 'text-stone-900'">
            Atelier<span class="font-bold">Nomade</span>
        </a>

        <div class="hidden md:flex space-x-10 text-[10px] uppercase tracking-[0.2em] font-medium"
            :class="atTop ? 'text-white' : 'text-stone-600'">
            <a href="#" class="hover:opacity-60 transition">Colecciones</a>
            <a href="#" class="hover:opacity-60 transition">El Proceso</a>
            <a href="#" class="hover:text-black transition">Cita Previa</a>
        </div>

        <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 transition-colors duration-300"
            :class="atTop ? 'text-white' : 'text-stone-900'">
            <i x-show="!mobileMenu" data-feather="menu"></i>
            <i x-show="mobileMenu" data-feather="x"></i>
        </button>
    </div>

    <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        @click.away="mobileMenu = false"
        class="md:hidden bg-white border-t border-stone-100 absolute w-full left-0 py-6 px-10 shadow-xl text-stone-900">
        <ul class="flex flex-col space-y-6 text-[11px] uppercase tracking-widest font-semibold">
            <li><a @click="mobileMenu = false" href="#">Colecciones</a></li>
            <li><a @click="mobileMenu = false" href="#">El Proceso</a></li>
            <li><a @click="mobileMenu = false" href="#">Cita Previa</a></li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        feather.replace();
    });
</script>
