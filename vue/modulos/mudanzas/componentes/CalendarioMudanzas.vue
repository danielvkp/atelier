<template>
    <div>
        <v-row dense>
            <v-col cols="12" md="3">
                <v-select v-model="type" :items="types" class="" density="compact" label="Tipo" variant="outlined" hide-details item-title="title" item-value="value"></v-select>
            </v-col>
            <v-col cols="12" md="3">
                <v-select v-model="query.comercial_id" :items="comerciales" class="" density="compact" label="Comercial" variant="outlined" hide-details item-title="name" item-value="id"></v-select>
            </v-col>
            <v-col cols="12" md="3">
                <v-select v-model="query.status" :items="status" class="" density="compact" label="Tipo" variant="outlined" hide-details></v-select>
            </v-col>
        </v-row>
        <v-sheet>
            <v-calendar ref="calendar" v-model="value" :events="events" :view-mode="type">
                <template v-slot:day-event="{ day, allDay, event }">
                    <v-chip @click="openEvent(event)" class="my-1 mx-2" :color="event.color" label>
                        <v-icon icon="mdi-account-circle-outline" start></v-icon>
                        {{event.title}}
                    </v-chip>
                </template>

                <template v-slot:day-title="{ title }">
                    <v-btn @click="setDayType(title)" :class="{ 'bg-blue': isToday(title) }" class="mt-1 " icon color="dark" density="comfortable">{{title}}</v-btn>
                </template>

            </v-calendar>
        </v-sheet>
        <dialog-mudanza v-on:update_calendar="getMudanzas(query)"></dialog-mudanza>
    </div>
</template>

<script>
    import dialogMudanza from './dialogMudanza.vue'
    import {
        mudanza_service
    } from '@services/mudanza_service.js'
    import {
        user_service
    } from '@services/user_service.js'
    import {
        useDate
    } from 'vuetify'

    export default {
        components: {
            dialogMudanza
        },
        data: () => ({
            type: 'month',
            types: [{
                title: 'Mes',
                value: 'month'
            }, {
                title: 'Día',
                value: 'day'
            }],

            status: ['', 'pendiente', 'completado'],

            comerciales: [],

            query: {
                comercial_id: null,
                status: 'pendiente',
            },

            value: [new Date()],
            events: [],
            colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
            titles: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
            adapter: useDate()
        }),

        watch: {
            query: {
                immediate: true,
                deep: true,
                handler(query) {
                    this.getMudanzas(query)
                }
            }
        },

        created() {
            this.getUsersByRole('comercial')
        },

        methods: {
            getUsersByRole(role) {
                user_service.get_users_by_role(role).then(res => {
                    this.comerciales = res.data
                    this.comerciales.unshift({
                        name: '',
                        id: null
                    })
                }, res => {
                    this.$store.dispatch('error', 'Error cargando comerciales')
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

            getMudanzas(query) {

                mudanza_service.get_mudanzas(query).then(res => {

                    let map_events = res.data.map(x => {
                        return {
                            id: x.id,
                            title: x.title,
                            start: new Date(x.start.replace(/-/g, '\/').replace(/T.+/, '')),
                            end: new Date(x.end.replace(/-/g, '\/').replace(/T.+/, '')),
                            color: x.color,
                            allDay: x.allDay,
                            origen: x.origen,
                            destino: x.destino,
                            detalles: x.detalles,
                            nombre: x.nombre,
                            telefono: x.telefono,
                            email: x.email
                        }

                    })
                    this.events = map_events
                    console.log(map_events);
                }, res => {
                    console.log('error')
                })
            }
        },
    }
</script>

<style media="screen">
    .v-calendar-weekly__day-alldayevents-container {
        padding: 5px;
    }

    .v-calendar-weekly__day-alldayevents-container {
        display: none;
    }
</style>