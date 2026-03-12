<template id="">
    <div class="container">
        <div v-if="step == 1" class="flex flex-col lg:flex-row">

            <div class="w-full lg:w-1/2">

                <div class="w-full shadow-testimonial">
                    <div class="flex mb-2">
                        <div class="w-2/12 lg:w-1/3">
                            <a @click="prev" class="cursor-pointer float-left"><svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                                </svg>
                            </a>
                        </div>
                        <div class="w-10/12 lg:w-1/3">
                            <p class="text-center text-base capitalize">{{translateMonthToSpanish(month)}}, {{year}}</p>
                        </div>
                        <div class="w-2/12 lg:w-1/3">
                            <a @click="next" class="cursor-pointer float-right"><svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                                </svg>

                            </a>
                        </div>
                    </div>
                    <ul class="calendar-header bg-primary py-2 rounded-sm text-white flex flex-row">
                        <li v-for="day in days" class="w-1/7">
                            <span class="text-center font-bold text-lg text-center block">{{day}}</span>
                        </li>
                    </ul>

                    <ul class="calendar-body flex flex-row flex-wrap">

                        <li v-for="blank in firstDayOfMonth" class="day w-1/7 py-3 px-2 text-center"></li>

                        <template v-for="date in daysInMonth">

                            <li v-if="isWeekend(date, month, year)" class="w-1/7 py-3 px-2   text-center">
                                <span class="text-gray-400 font-bold" :class="{'text-sky-500': date == initialDate && month == initialMonth && year == initialYear}">
                                    {{date}}
                                </span>
                            </li>

                            <li v-else @click="openday(date)" class=" w-1/7 py-3 px-2  text-center">
                                <span class="font-bold cursor-pointer"
                                  :class="[{'text-rose-300': date == selectedDay && month == selectedMonth && year == selectedYear}, {'text-sky-500': date == initialDate && month == initialMonth && year == initialYear}]">
                                    {{date}}
                                </span>
                            </li>
                        </template>

                    </ul>
                </div>
            </div>

            <div class="w-full lg:w-1/2 mt-8 lg:mt-0">

                <div class="px-1 lg:px-8">
                    <div class="w-full">
                        <select v-model="servicio" class="w-full block rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                            <option v-for="servicio in computed_services" :value="servicio">
                                {{servicio.nombre}}
                            </option>
                        </select>
                    </div>

                    <div class="w-full mt-4">
                        <select v-model="tarifa" class="w-full block rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                            <option v-for="tarifa in servicio.tarifa" :value="tarifa">
                                {{tarifa.tipo}} - {{tarifa.precio}}€ / {{tarifa.duracion}} min
                            </option>
                        </select>
                    </div>
                    <div class="w-full mt-4">
                        <p class="text-base">Día seleccionado: <span class="font-bold">{{format_date}}</span> </p>
                    </div>

                    <template v-if="fechas">
                        <div class="w-full flex flex-row flex-wrap mt-4">

                            <div v-for="fecha in fechas" class="w-1/2 lg:w-1/4 py-1 px-1">
                                <button @click="cita.full_date = fecha" :class="[{'bg-rose-300' : cita.full_date == fecha}]" class=" w-full py-1 rounded-lg bg-alter text-white text-base cursor-pointer">
                                    {{setHora(fecha)}}
                                </button>
                            </div>
                        </div>
                    </template>
                    <template v-if="fechas.length == 0">
                        <p class="text-sm">No se encontraron horas disponibles</p>
                    </template>


                    <div class="w-full">
                        <button :disabled="!cita.tarifa || !cita.full_date" @click="step = 2" class="mt-4 w-full py-2 rounded-lg bg-primary text-white text-base cursor-pointer">
                            Siguiente
                        </button>
                    </div>

                </div>
            </div>

        </div>
        <div v-if="step == 2" class="flex flex-col">
            <div class="w-full lg:w-6/12 mx-auto">
                <h1 class="text-2xl uppercase mb-8 text-primary font-bold text-center">
                    Confirmar cita
                </h1>

                <div class="bg-primary mb-4 rounded-lg p-4">

                    <div class="flex mb-2 flex-row">
                        <div class="w-1/3">
                            <p class="text-white  text-base font-bold">Servicio</p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-white text-base "> {{servicio.nombre}}</p>
                        </div>
                    </div>

                    <div class="flex mb-2 flex-row">
                        <div class="w-1/3">
                            <p class="text-white  text-base font-bold">Tipo</p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-white text-base ">{{tarifa.tipo}}</p>
                        </div>
                    </div>

                    <div class="flex mb-2 flex-row">
                        <div class="w-1/3">
                            <p class="text-white  text-base font-bold">Precio</p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-white text-base ">{{tarifa.precio}}€</p>
                        </div>
                    </div>

                    <div class="flex mb-2 flex-row">
                        <div class="w-1/3">
                            <p class="text-white  text-base font-bold">Duracion</p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-white text-base ">{{tarifa.duracion}} min</p>
                        </div>
                    </div>

                    <div class="flex mb-2 flex-row">
                        <div class="w-1/3">
                            <p class="text-white  text-base font-bold">Fecha</p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-white text-base ">{{format_hora(cita.full_date)}}</p>
                        </div>
                    </div>

                    <div class="flex  flex-row">
                        <div class="w-1/3">
                            <p class="text-white  text-base font-bold">Hora</p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-white text-base ">{{setHora(cita.full_date)}}</p>
                        </div>
                    </div>


                </div>
                <form class="" :action="url" method="post">

                    <input type="hidden" name="tipo_producto" value="cita">

                    <input type="hidden" name="tarifa" :value="cita.tarifa">

                    <input type="hidden" name="full_date" :value="cita.full_date">

                    <input required type="text" v-model="cita.nombre" name="nombre" placeholder="Nombre"
                      class="rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                    <br>
                    <input required type="email" v-model="cita.email" name="email" placeholder="Email"
                      class="rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                    <br>
                    <input required type="text" v-model="cita.telefono" name="telefono" placeholder="Teléfono"
                      class="rounded-lg border border-gray-400 block w-full min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                    <br>

                    <div class="w-full">
                        <button type="submit" class="mt-4 w-full py-2 rounded-lg bg-primary text-white text-base cursor-pointer">
                            Ir al pago
                        </button>
                        <button @click="step = 1" class="mt-4 w-full py-2 rounded-lg bg-alter text-white text-base cursor-pointer">
                            volver
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        props: ['url', 'item', 'tipo'],
        data() {
            return {
                step: 1,
                disabled_dates: [],
                format_date: null,
                today: moment().add(1, 'days'),
                dateContext: moment(),
                days: ['D', 'L', 'M', 'X', 'J', 'V', 'S'],
                selectedDay: null,
                selectedMonth: moment().format('MMMM'),
                selectedYear: moment().format('YYYY'),
                cita: {
                    tipo_producto: 'cita',
                    fecha: null,
                    tarifa: null,
                    full_date: null,
                    nombre: '',
                    email: '',
                    telefono: ''
                },
                servicios: [],
                servicio: {
                    tarifa: []
                },
                tarifa: {
                    tipo: null
                },
                fechas: [],
                item_json: {},
            }
        },

        watch: {
            'tarifa'(n) {
                if (n.tipo) {
                    this.cita.tarifa = n.id
                }
            },
            'cita': {
                deep: true,
                handler(n) {
                    if (n.fecha && n.tarifa) {
                        this.getHorario(n.fecha, n.tarifa)
                    }
                },
            }
        },
        created() {

            this.getTarifas()
        },

        methods: {
            medioDia(fecha) {
                return parseInt(String(fecha).substring(11, 13)) > 12;
            },
            setHora(fecha) {
                return String(fecha).substring(11, 16)
            },
            format_hora(fecha) {
                return `${ moment(fecha).format("DD-MM-YYYY")}`
            },
            openday(day) {
                this.selectedDay = day
                let month_number = moment().month(this.selectedMonth).format("MM")
                this.cita.fecha = moment(`${this.selectedYear}-${month_number}-${day}`).format('YYYY-MM-DD')
                this.format_date = moment(`${this.selectedYear}-${month_number}-${day}`).format('DD-MM-YYYY')
            },

            getTarifas() {
                axios.get('get-tarifas').then(res => {
                    this.servicios = res.data
                    this.setSelect()
                }, res => {})
            },

            setSelect() {
                if (this.item) {
                    this.item_json = JSON.parse(this.item)

                    let servicio_id = this.item_json.servicio_id

                    let servicio_index = this.servicios.findIndex(x => x.id == servicio_id)

                    if (servicio_index > -1) {
                        this.servicio = this.servicios[servicio_index]
                        let tarifa_id = this.item_json.id
                        let tarifa_index = this.servicio.tarifa.findIndex(x => x.id == tarifa_id)
                        this.tarifa = this.servicio.tarifa[tarifa_index]
                    }
                }
            },

            getHorario(fecha, tarifa_id) {
                axios.get(`get-horario/${fecha}/${tarifa_id}`).then(res => {
                    this.fechas = res.data
                }, res => {})
            },

            translateMonthToSpanish(englishMonth) {
                const months = {
                    "January": "enero",
                    "February": "febrero",
                    "March": "marzo",
                    "April": "abril",
                    "May": "mayo",
                    "June": "junio",
                    "July": "julio",
                    "August": "agosto",
                    "September": "septiembre",
                    "October": "octubre",
                    "November": "noviembre",
                    "December": "diciembre"
                };

                return months[englishMonth];
            },

            isWeekend(d, m, a) {
                let month_number = moment().month(m).format("MM")

                let date = moment(`${a}-${month_number}-${d}`);

                let is_before = date.isBefore(moment(), 'day')

                let date_f = date.format('YYYY-MM-DD')

                let is_full_day = this.disabled_dates.includes(date_f)

                let is_senior = this.tarifa.tipo == 'Senior' && date.weekday() === 5 ? true : false

                return (date.weekday() === 0 || date.weekday() === 6 || is_before || is_full_day || is_senior)
            },


            next: function() {
                this.dateContext = moment(this.dateContext).add(1, 'month')
                this.selectedMonth = moment(this.dateContext).format('MMMM')
                this.selectedYear = moment(this.dateContext).format('YYYY')
            },
            prev: function() {
                this.dateContext = moment(this.dateContext).subtract(1, 'month');
                this.selectedMonth = moment(this.dateContext).format('MMMM')
                this.selectedYear = moment(this.dateContext).format('YYYY')
            },
        },

        computed: {
            computed_services() {
                if (!this.tipo) {
                    return this.servicios
                }

                return this.servicios.map(servicio => {
                    const tarifas_junior = servicio.tarifa.filter(tarifa => {
                        return `${tarifa.tipo}`.toLowerCase() === this.tipo;
                    });

                    return {
                        ...servicio,
                        tarifa: tarifas_junior
                    }
                })
            },
            month_number() {
                return moment().month(this.month).format("MM")
            },

            year: function() {
                return this.dateContext.format('YYYY')
            },

            month: function() {
                return this.dateContext.format('MMMM')
            },

            daysInMonth: function() {
                return this.dateContext.daysInMonth()
            },

            currentDate: function() {
                return this.dateContext.get('date')
            },

            firstDayOfMonth: function() {
                let firstDay = moment(this.dateContext).subtract((this.currentDate - 1), 'days')
                return firstDay.weekday()
            },

            initialDate: function() {
                return moment().get('date')
            },

            initialMonth: function() {
                return this.today.format('MMMM')
            },

            initialYear: function() {
                return this.today.format('YYYY')
            }
        }
    }
</script>


<style media="screen">
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>