@extends('base')
@section('title', 'Contacto | Centro de Psicología equilibrio y mente')
@section('main')

<div class="bg-alter w-full py-[120px] lg:py-[140px]">
    <div class="container">
        <h1 class="text-3xl font-bold uppercase text-white text-center">Contactanos</h1>
    </div>
</div>

<div class="-mt-20 container ">
    <div class="w-12/12 lg:7/12 mx-auto bg-white rounded-lg py-1 lg:py-8">
        <div class="px-2 lg:px-8">

            <div class="flex flex-col lg:flex-row">

                <div class="w-full my-16 lg:my-0 order-2 lg:order-1  lg:w-1/2">
                    <div class="px-4">

                        <h2 class="text-2xl text-alter font-bold mb-4">¿Tienes dudas?</h2>

                        <p class="text-base text-alter mb-8">
                            ¿Estás listo para transformar tu vida y alcanzar tu bienestar emocional? En nuestro centro, te ofrecemos un espacio seguro, confidencial y acogedor, donde nuestros profesionales altamente capacitados te acompañarán en tu
                            proceso de crecimiento personal.
                            <br>
                            <br>
                            Ya sea que enfrentes ansiedad, depresión, estrés, dificultades en las relaciones o simplemente desees conocerte mejor, estamos aquí para apoyarte en cada paso del camino. Contamos con una variedad de servicios, incluyendo
                            terapia individual, de pareja, familiar y talleres especializados, diseñados para responder a tus necesidades particulares.
                        </p>

                        <div class="flex flex-col">
                            <div class="w-full  mb-8 lg:mb-4">
                                <div class="flex items-center  flex-row">
                                    <svg class="min-w-[32px] min-h-[32px] text-alter" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                                    </svg>
                                    <h3 class="ml-2 text-lg  text-alter"> <a href="tel:+34648585622">+34 648 585 622</a> </h3>
                                </div>
                            </div>

                               <div class="w-full  mb-8 lg:mb-4">
                                <div class="flex items-center flex-row">
                                    <svg class="min-w-[32px] min-h-[32px] text-alter" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                          d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                          clip-rule="evenodd" />
                                    </svg>

                                    <h3 class="ml-2 text-lg text-alter">
                                        <a target="_blank" href="https://ul.waze.com/ul?place=ChIJ0SEjeeooQg0RGmQA9CLwD10&ll=40.43681920%2C-3.68272050&navigate=yes&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location">Calle
                                            velazquez 124, 5 izquierda. 28006, Madrid</a>
                                    </h3>
                                </div>
                            </div>

                            <div class="w-full  mb-8 lg:mb-4">
                                <div class="flex items-center flex-row">
                                    <svg class="min-w-[32px] min-h-[32px] text-alter" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                    </svg>

                                    <h3 class="ml-2 text-lg  text-alter"> <a href="mailto:info@equilibrioymente.es">info@equilibrioymente.es</a> </h3>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="w-full order-1 lg:order-2  lg:w-1/3 mx-auto p-2">

                    <div class="">
                        @if(Session::has('mensaje'))
                        <h1 class="mt-4 text-center text-2xl font-bold text-green-500 uppercase">
                            ¡Email enviado con exito!
                        </h1>

                        <!-- Google tag (gtag.js) -->
                        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-773577421"></script>
                        <script>
                            window.dataLayer = window.dataLayer || [];

                            function gtag() {
                                dataLayer.push(arguments);
                            }
                            gtag('js', new Date());

                            gtag('config', 'AW-773577421');
                        </script>

                        @endif

                        <form id="demo-form" class="mt-4" action="{{route('enviar.contacto')}}" method="post">
                            @csrf
                            <x-honeypot />
                            <input required type="text" value="{{old('nombre')}}" name="nombre"
                              class="rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" placeholder="Indicanos tu nombre">
                            <br>

                            <input required type="email" value="{{old('email')}}" name="email"
                              class="rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" placeholder="Email">
                            <br>

                            <input required type="text" value="{{old('telefono')}}" name="telefono"
                              class="rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" placeholder="Teléfono">
                            <br>

                            <textarea name="mensaje" rows="4" placeholder="Mensaje"
                              class="rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">{{old('mensaje')}}</textarea>
                            <br>

                            <img src="{{ captcha_src() }}" alt="captcha">

                            @if(Session::has('message'))
                            <p class="text-red-500">Captcha invalido</p>
                            @endif

                            <div class="mt-2"></div>

                            <input required type="text" name="captcha" class="rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                              placeholder="Captcha">
                            <br>

                            <div class="mb-[22px]">
                                <input type="checkbox" name="politicas"> He leido y acepto los <a class="text-blue-500" href="{{route('condiciones')}}">términos y condiciones</a> y la <a class="text-blue-500" href="{{route('privacidad')}}">política
                                    de privacidad</a>
                                <br>
                                <br>
                                @error('politicas')
                                <span class="text-rose-500">* Debe aceptar la politica de privacidad</span>
                                @enderror
                            </div>

                            <div class="flex">
                                <button type="submit" class="mt-4 mr-2 text-center px-4 py-2 bg-primary text-white text-base uppercase  rounded-full focus:outline-none">
                                    enviar
                                </button>
                            </div>
                        </form>

                        <br>
                    </div>


                </div>
            </div>

        </div>
    </div>

</div>




@endsection
