<template>
    <v-dialog v-model="dialog" persistent max-width="650">
        <v-card>
            <v-card-title class="text-h5">
                Detalles Mudanza
            </v-card-title>
            <v-card-text>

                <v-row dense>
                    <v-col cols="12" md="4">
                        <v-text-field readonly v-model="item.nombre" label="Nombre"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field readonly v-model="item.email" label="Email"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field readonly v-model="item.telefono" label="Teléfono"></v-text-field>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col cols="12" md="6">
                        <v-text-field readonly v-model="item.origen" outlined small dense label="Origen"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field readonly v-model="item.destino" outlined small dense label="Destino"></v-text-field>
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col cols="12">
                        <v-textarea readonly v-model="item.detalles" variant="outlined" outlined small dense label="Detalles"></v-textarea>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col cols="12">
                        <v-btn @click="marcarCompletado" class="" color="green">finalizar</v-btn>

                    </v-col>
                </v-row>

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
    import moment from 'moment';
    import {
        mudanza_service
    } from '@services/mudanza_service.js'
    export default {
        data() {
            return {
                item: {
                    id: null,
                    nombre: null,
                    telefono: null,
                    email: null,
                    origen: '',
                    destino: '',
                    detalles: ''
                },
                dialog: false,
            }
        },

        created() {
            this.$eventBus.on('open', (data) => {
                this.item = data
                console.log(data);
                this.dialog = true
            })
        },

        methods: {
            marcarCompletado() {
                console.log(this.item);
                mudanza_service.finalizar_mudanza(this.item.id).then(res => {
                    this.$store.dispatch('success', 'Mudanza finalizada')
                    this.item = {
                        id: null,
                        nombre: null,
                        telefono: null,
                        email: null,
                        origen: '',
                        destino: '',
                        detalles: ''
                    }
                    this.dialog = false
                    this.$emit('update_calendar')
                }, res => {
                    this.$store.dispatch('error', 'Error finalizando mudanza')
                })
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
        }
    }
</script>