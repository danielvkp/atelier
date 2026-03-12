<template>
    <div>

        <v-row dense>

            <v-col cols="12" md="6">
                <div class="d-flex">
                    <v-btn class="ma-2" variant="text" icon @click="$refs.calendar.prev()">
                        <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>

                    <v-btn class="ma-2" variant="text" icon @click="$refs.calendar.next()">
                        <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>

                    <div class="mt-4">
                        <p class="text-h5">{{ formato_fecha }}</p>
                    </div>
                </div>
            </v-col>


            <v-col cols="12" md="6" align="right">
                <div class="d-flex">
                    <v-spacer> </v-spacer>
                    <v-btn @click="openDialog" class="white--text mt-3" color="blue">crear cita</v-btn>
                    <div class="">
                        <v-select width="120px" v-model="type" :items="types" class="ma-2" density="compact"
                            label="Vista" item-title="label" item-value="type" variant="outlined"
                            hide-details></v-select>
                    </div>

                </div>

            </v-col>
        </v-row>


        <v-sheet height="600">
            <v-calendar ref="calendar" :first-interval="9" :interval-count="14" :interval-minutes="60" v-model="value"
                :event-color="getEventColor" :event-overlap-mode="mode" :event-overlap-threshold="30" :events="events"
                :type="type" :weekdays="weekday" @change="getEvents">
                <template v-slot:day-label="{ day, date }">
                    <v-btn @click="openDay(date)" :class="{ 'bg-blue': isToday(date) }" class="mt-1 " icon color="dark"
                        density="comfortable">{{ day }}</v-btn>
                </template>

                <template v-slot:event="{ day, allDay, event }">
                    <div style="height:100%;overflow:hidden;" @click="openEvent(event)" class="pl-1">
                        {{ event.hora }} - {{ event.nombre }}
                    </div>
                </template>


            </v-calendar>
        </v-sheet>
        <dialog-reserva :tarifas="tarifas" :empleados="empleados" v-on:update_calendar="getReservas"></dialog-reserva>

    </div>
</template>

<script>
import dialogReserva from './dialogReserva.vue'

import {
    reserva_service
} from '@services/reserva_service.js'

import {
    empleado_service
} from '@services/empleado_service.js'

import {
    tarifa_servicio_service
} from '@services/tarifa_servicio_service'

import {
    useDate
} from 'vuetify'

import moment from 'moment';
import 'moment/locale/es';

export default {
    components: {
        dialogReserva
    },
    data() {
        return {
            empleados: [],
            tarifas: [],
            type: 'month',
            types: [{
                type: 'month',
                label: 'Mes'
            }, {
                type: 'week',
                label: 'Semana'
            }, {
                type: 'day',
                label: 'Día'
            }],
            mode: 'stack',
            modes: ['stack', 'column'],
            weekday: [1, 2, 3, 4, 5, 6, 0],
            weekdays: [{
                title: 'Sun - Sat',
                value: [0, 1, 2, 3, 4, 5, 6]
            },
            {
                title: 'Mon - Sun',
                value: [1, 2, 3, 4, 5, 6, 0]
            },
            {
                title: 'Mon - Fri',
                value: [1, 2, 3, 4, 5]
            },
            {
                title: 'Mon, Wed, Fri',
                value: [1, 3, 5]
            },
            ],
            value: new Date().toISOString().substring(0, 10),
            events: [],
            colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey-darken-1'],
            names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
        }
    },

    created() {
        this.getReservas()
        this.get_empleados()
        this.get_tarifas()
    },

    methods: {
        get_tarifas() {
            tarifa_servicio_service.all_tarifas().then(res => {
                this.tarifas = res.data
            }, res => {
                this.$toast.error('Error consultando registro')
            })
        },
        get_empleados() {
            empleado_service.get_empleados().then(res => {
                this.empleados = res.data
            }, res => {
                this.$toast.error('Error consultando registro')
            })
        },
        openEvent(evento) {
            this.$eventBus.emit('open', evento)
        },
        openDialog() {
            this.$eventBus.emit('open', {
                id: null,
                empleado_id: null,
                nombre: null,
                telefono: null,
                email: null,
                fecha: '',
                hora: '',
                status: 'PENDIENTE',
                servicio_tarifa_id: null,
                tipo: null,
                fecha: null,
                edit: false,
            })
        },
        openDay(date) {
            this.value = date
            this.type = 'day'
        },
        getEventColor(e) {
            return e.color
        },
        getReservas(query) {
            reserva_service.get_reservas(query).then(res => {
                let map_events = res.data.map(x => {
                    return {
                        id: x.id,
                        name: x.title,
                        start: new Date(x.start.replace(/-/g, '\/').replace(/T.+/, '')),
                        end: new Date(x.end.replace(/-/g, '\/').replace(/T.+/, '')),
                        timed: true,
                        color: x.color ? x.color : '#dcdcdc',
                        allDay: x.allDay,
                        fecha: x.fecha,
                        hora: x.hora,
                        nombre: x.nombre,
                        telefono: x.telefono,
                        email: x.email,
                        status: x.status,
                        empleado_id: x.empleado_id,
                        servicio_tarifa_id: x.servicio_tarifa_id ? x.servicio_tarifa_id : null,
                        tipo: x.tipo ? x.tipo : null,
                        fecha: x.fecha,
                        edit: x.edit,
                        tipo_e: x.tipo_e ? x.tipo_e : null
                    }
                })
                this.events = map_events
                //this.events = res.data
            }, res => {

            })
        },

        isToday(day_date) {
            return day_date == new Date().toISOString().substring(0, 10)
        },
    },
    computed: {
        formato_fecha() {
            if (!this.value) return '';

            // Creamos la fecha asegurando que no haya desfase de horas
            const fecha = new Date(this.value + 'T12:00:00');

            // Usamos el formateador nativo de JS
            const opciones = { month: 'long', year: 'numeric' };
            const texto = new Intl.DateTimeFormat('es-ES', opciones).format(fecha);

            // Capitalizamos la primera letra (opcional)
            return texto.charAt(0).toUpperCase() + texto.slice(1);
        }
    }
}
</script>