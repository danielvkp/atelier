<template>
    <v-dialog v-model="dialog" persistent max-width="650">
        <v-card>
            <v-toolbar flat color="blue" class="white--text">

                <v-toolbar-title>
                    <h3 class="font-weight-light">Detalles Cita</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>
                <v-row dense class="mt-4">
                    <v-col cols="12" md="4">
                        <v-text-field :readonly="item.edit" v-model="item.nombre" label="Nombre" :error-messages="errors.errors.nombre ? errors.errors.nombre[0] : null"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field :readonly="item.edit" v-model="item.email" label="Email" :error-messages="errors.errors.email ? errors.errors.email[0] : null"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field :readonly="item.edit" v-model="item.telefono" label="Teléfono" :error-messages="errors.errors.telefono ? errors.errors.telefono[0] : null"></v-text-field>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col cols="12" md="4">
                        <v-date-input v-model="item.fecha" variant="outlined" density="compact" label="Fecha" prepend-icon="" prepend-inner-icon="$calendar" max-width="368" :error-messages="errors.errors.fecha ? errors.errors.fecha[0] : null">
                        </v-date-input>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-select v-model="item.hora" :items="horas" outlined small dense label="Hora" :error-messages="errors.errors.hora ? errors.errors.hora[0] : null"></v-select>
                    </v-col>
                    <v-col cols="12" md="5">
                        <v-select v-model="item.status" :items="estados" outlined small dense label="Estado"></v-select>
                    </v-col>

                </v-row>

                <v-row dense>
                    <v-col cols="12" md="4">
                        <v-select v-model="item.empleado_id" :items="item.edit ? computed_empleados : empleados" outlined small dense label="Psicologo" item-title="nombre" item-value="id"
                          :error-messages="errors.errors.empleado_id ? errors.errors.empleado_id[0] : null"></v-select>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-select :disabled="item.edit" v-model="item.servicio_tarifa_id" :items="computed_tarifas" outlined small dense label="Servicio" item-title="servicio.nombre" item-value="id"
                          :error-messages="errors.errors.servicio_tarifa_id ? errors.errors.servicio_tarifa_id[0] : null"></v-select>
                    </v-col>
                </v-row>

            </v-card-text>
            <v-card-actions class="pb-4">
                <v-spacer></v-spacer>
                <v-btn :loading="isloading" v-if="!item.edit" color="red" variant="tonal" text @click="delete_reserva">
                    eliminar
                </v-btn>
                <v-btn :loading="isloading" :disabled="isloading" @click="updateOrCreate" class="" variant="tonal" color="green">
                    guardar cita
                </v-btn>
                <v-btn :loading="isloading" color="blue" variant="tonal" text @click="close_dialog">
                    cerrar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import moment from 'moment';

    import {
        reserva_service
    } from '@services/reserva_service.js'

    export default {
        props: ['empleados', 'tarifas'],
        data() {
            return {
                tipos: ['Junior', 'Semisenior', 'Senior'],
                estados: ['PENDIENTE', 'COMPLETADO'],
                horas: ['09:00', '10:00', '11:00', '12:00', '13:00', '16:00', '17:00', '18:00', '19:00'],
                item: {
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
                },
                selected_empleado: {
                    id: null,
                    nombre: null,
                    tipo: null,
                },
                dialog: false,
                tipo_empleado: null,
            }
        },

        watch: {
            'item.empleado_id': {
                handler(n) {
                    if (!n) {
                        return null
                    }
                    this.selected_empleado = this.empleados.find(x => x.id == n)
                    if (this.selected_empleado.tipo != this.item.tipo_e) {
                        this.item.servicio_tarifa_id = null
                    }
                    this.item.tipo_e = this.selected_empleado.tipo

                    //
                    //this.item.tipo = empleado.tipo
                }
            }
        },

        created() {
            this.$eventBus.on('open', (data) => {
                this.item = data
                this.dialog = true
            })
        },

        methods: {
            updateOrCreate() {
                if (this.item.id) {
                    this.update_reserva()
                } else {
                    this.save_reserva()
                }
            },

            delete_reserva() {
                reserva_service.delete_reserva(this.item.id).then(res => {
                    this.$store.dispatch('success', 'Cita eliminada con exito')
                    this.close_dialog()
                    this.$emit('update_calendar')
                }, res => {
                    this.$store.dispatch('error', 'Error actualizando cita')
                })
            },

            save_reserva() {
                reserva_service.save_reserva(this.item).then(res => {
                    this.$store.dispatch('success', 'Cita creada con exito')
                    this.close_dialog()
                    this.$emit('update_calendar')
                }, res => {
                    this.$store.dispatch('error', 'Error actualizando cita')
                })
            },

            update_reserva() {
                reserva_service.update_reserva(this.item).then(res => {
                    this.$store.dispatch('success', 'Cita actualizada')
                    this.close_dialog()
                    this.$emit('update_calendar')
                }, res => {
                    this.$store.dispatch('error', 'Error actualizando cita')
                })
            },
            close_dialog() {
                this.item = {
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
                    edit: true,
                }
                this.dialog = false
            },
            format(date) {
                return moment(date).format('DD-MM-YYYY')

            },
            formatDate(date) {
                return moment(date).format('DD-MM-YYYY')
            },

            confirm() {
                this.dialog = false
            }
        },

        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
            fecha_fomato() {
                return moment(this.item.start).format('DD-MM-YYYY')
            },
            computed_tarifas() {
                let tipo_filtro = !this.item.edit ? this.selected_empleado.tipo : this.item.tipo
                return this.tarifas.filter(tarifa => {
                    return `${tarifa.tipo}`.toLowerCase() == `${tipo_filtro}`.toLowerCase()
                })
            },
            computed_empleados() {
                return this.empleados.filter(empleado => {
                    return `${empleado.tipo}`.toLowerCase() == `${this.item.tipo}`.toLowerCase()
                })
            },
            errors() {
                return this.$store.getters.geterrors
            }
        }
    }
</script>