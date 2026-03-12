<template>
    <v-dialog v-model="dialog" persistent max-width="650">
        <v-card>
            <v-card-title class="text-h5">
                Historial
            </v-card-title>
            <v-card-text>

                <v-timeline side="end">

                    <v-timeline-item width="100%" size="small" dot-color="green">
                        <v-date-input :display-format="format" v-model="item.fecha" density="compact" prepend-icon prepend-inner-icon="mdi-calendar" label="Fecha" max-width="330" variant="outlined" outlined small dense>
                        </v-date-input>
                        <v-textarea width="525" v-model="item.detalles" rows="2" variant="outlined" hide-details :rules="nombre_rules" class="mb-4" outlined small dense label="Detalles"></v-textarea>
                        <v-btn @click="save" class="" color="green">guardar</v-btn>
                    </v-timeline-item>

                    <v-timeline-item v-for="item in items" :key="item.id" dot-color="info" size="small">
                        <v-alert :value="true">
                            <strong>{{formatDate(item.fecha)}}</strong>
                            <br>
                            <span v-html="item.detalles"></span>
                            <br>

                            <v-icon @click="set_item(item)" size="x-small" color="blue" class="">
                                mdi-pencil
                            </v-icon>

                            <v-icon @click="delete_historial(item.id)" size="x-small" color="red">
                                mdi-delete
                            </v-icon>
                        </v-alert>
                    </v-timeline-item>
                </v-timeline>

            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue" text @click="dialog = false">
                    cerrar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {
        usuario_rules
    } from '../mixins/usuario_rules'

    import {
        historial_service
    } from '@services/historial_service.js'

    import moment from 'moment';

    import {
        useDate
    } from 'vuetify'

    export default {
        mixins: [usuario_rules],
        data() {
            return {
                adapter: useDate(),
                item: {
                    id: null,
                    cliente_servicio_id: null,
                    fecha: new Date().toISOString().substring(0, 10),
                    detalles: null,
                },
                dialog: false,
                items: [],
            }
        },

        created() {
            this.$eventBus.on('open', (data) => {
                this.item.cliente_servicio_id = data.id
                this.items = data.historial
                this.dialog = true
            })
        },

        methods: {
            format(date) {
                return moment(date).format('DD-MM-YYYY')

            },
            formatDate(date) {
                return moment(date).format('DD-MM-YYYY')
            },

            set_item(item) {
                this.item = JSON.parse(JSON.stringify(item))
            },

            delete_historial(id) {
                historial_service.delete_historial(id).then(res => {
                    let index = this.items.findIndex(x => x.id == id)
                    this.items.splice(index, 1)
                    this.$store.dispatch('success', 'Registro eliminado con exito!')

                }, res => {

                })
            },

            save() {
                historial_service.save_historial(this.item).then(res => {

                    let index = this.items.findIndex(x => x.id == res.data.id)
                    if (index > -1) {
                        this.items[index] = res.data
                    } else {
                        this.items.unshift(res.data)
                    }

                    this.item.id = null
                    this.item.fecha = new Date().toISOString().substring(0, 10)
                    this.item.detalles = null
                    this.$store.dispatch('success', 'Registro guardado con exito!')


                }, res => {

                })
            },

            confirm() {
                this.dialog = false
                this.$emit('delete')
            }
        }
    }
</script>