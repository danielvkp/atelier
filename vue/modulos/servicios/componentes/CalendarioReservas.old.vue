<template>
    <div>
        <v-sheet>
            <v-calendar ref="calendar" v-model="value" :event-overlap-mode="mode" :event-overlap-threshold="30" :events="events" :type="type" :weekdays="weekday" @change="getEvents"></v-calendar>
            <!--<v-calendar ref="calendar" v-model="value" :events="events" :view-mode="type">
             <template v-slot:day-event="{ day, allDay, event }">
                    <v-chip @click="openEvent(event)" class="my-1 mx-2" :color="event.color" label>
                        {{event.title}}
                    </v-chip>
                </template>

                <template v-slot:day-title="{ title }">
                    <v-btn @click="type = 'day'" :class="{ 'bg-blue': isToday(title) }" class="mt-1 " icon color="dark" density="comfortable">{{title}}</v-btn>
                </template>

            </v-calendar>-->
        </v-sheet>
        <dialog-reserva :empleados="empleados" v-on:update_calendar="getReservas"></dialog-reserva>
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
        useDate
    } from 'vuetify'

    export default {
        components: {
            dialogReserva
        },

        data: () => ({
            empleados: [],
            type: 'month',
            types: [{
                title: 'Mes',
                value: 'month'
            }, {
                title: 'Día',
                value: 'day'
            }],

            mode: 'stack',
            modes: ['stack', 'column'],

            status: ['', 'pendiente', 'completado'],

            value: [new Date()],
            events: [],
            adapter: useDate()
        }),

        /*watch: {
            query: {
                immediate: true,
                deep: true,
                handler(query) {
                    this.getReservas(query)
                }
            }
        },*/

        created() {
            this.getReservas()
            this.get_empleados()
        },

        methods: {
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

            setDayType(day_number) {
                this.value[0].setDate(day_number)
                this.type = 'day'
            },

            isToday(day_number) {
                return day_number == new Date(this.value[0]).getDate()
            },

            getReservas(query) {

                reserva_service.get_reservas(query).then(res => {

                    let map_events = res.data.map(x => {
                        return {
                            id: x.id,
                            title: x.title,
                            start: new Date(x.start.replace(/-/g, '\/').replace(/T.+/, '')),
                            end: new Date(x.end.replace(/-/g, '\/').replace(/T.+/, '')),
                            color: x.color,
                            allDay: x.allDay,
                            fecha: x.fecha,
                            hora: x.hora,
                            nombre: x.nombre,
                            telefono: x.telefono,
                            email: x.email,
                            status: x.status,
                            empleado_id: x.empleado_id,
                            empleado: x.empleado ?? 'N/A'
                        }
                    })
                    this.events = map_events
                }, res => {

                })
            }
        },
    }
</script>

<style media="screen" scoped="true">
    .v-calendar-weekly__day-alldayevents-container {
        padding: 5px;
    }

    .v-calendar-weekly__day-alldayevents-container {
        display: none;
    }

    .v-chip {
        max-width: 90%
    }
</style>