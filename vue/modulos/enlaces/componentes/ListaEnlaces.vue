<template id="">
    <v-container>
        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/" icon text>
                    <v-icon small class="white--text">mdi-home</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Enlaces de pago</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-row dense class="mt-0">

                    <v-col cols="12" md="3">
                        <v-text-field hide-details v-model="save_item.titulo" outlined small dense label="Titulo"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field hide-details v-model="save_item.precio" type="number" step="0.1" outlined small dense label="Precio"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-select hide-details v-model="save_item.tipo" :items="tipos" outlined small dense label="Tipo"></v-select>
                    </v-col>

                    <v-col cols="12">
                        <v-btn @click="save_enlace" class=" mr-2 white--text" color="green">
                            Guardar
                        </v-btn>
                        <v-btn @click="resetForm" class=" white--text" color="blue">
                            nuevo
                        </v-btn>
                    </v-col>

                </v-row>

                <v-row dense class="mt-4">

                    <loader v-if="isloading"></loader>

                    <v-col cols="12">
                        <v-data-table :headers="headers" :items="items" disable-pagination hide-default-footer item-key="key" class="elevation-1 mt-2">

                            <template v-slot:item.precio="{item}">
                                {{item.precio}}€
                            </template>

                            <template v-slot:item.action="{ item }">

                                <v-icon @click="set_e_item(item)" size="small" color="blue" class="mr-2">
                                    mdi-pencil
                                </v-icon>

                                <v-icon @click="set_item(item)" size="small" color="red">
                                    mdi-delete
                                </v-icon>

                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>

            </v-card-text>

        </v-card>

        <v-confirm v-on:delete="delete_tarifa">
        </v-confirm>
    </v-container>
</template>

<script>
    import moment from 'moment';
    import {
        enlace_service
    } from '@services/enlace_service.js'

    import {
        headers_mixin
    } from '../mixins/servicio_headers.js'


    export default {
        mixins: [headers_mixin],

        data() {
            return {
                tipos: ['junior', 'semisenior', 'senior'],
                save_item: {
                    id: null,
                    titulo: '',
                    precio: 0
                },
                item: {},
                items: [],
            }
        },

        created() {
            this.get_tarifas()
        },

        methods: {
            set_e_item(item) {
                this.save_item = item
            },
            save_enlace() {
                enlace_service.save_enlace(this.save_item).then(res => {
                    this.resetForm()
                    this.get_tarifas()
                }, res => {
                    this.$toast.error('Error consultando registro')
                })
            },

            resetForm() {
                this.save_item = {
                    id: null,
                    titulo: '',
                    precio: 0
                }
            },

            delete_tarifa() {
                enlace_service.delete_enlace(this.item.id).then(res => {
                    let index = this.items.findIndex(x => x.id == this.item.id)
                    if (index > -1) {
                        this.items.splice(index, 1)
                    }
                    this.$store.dispatch('success', 'Servicio eliminado con exito!')
                }, res => {
                    if (res.response.status == 301) {
                        return this.$store.dispatch('warning', res.response.data)
                    }
                })
            },

            set_item(item) {
                this.item = item
                this.$eventBus.emit('open', item)
            },

            get_tarifas() {
                enlace_service.get_enlaces().then(res => {
                    this.items = res.data
                }, res => {
                    this.$toast.error('Error consultando registro')
                })
            },
        },

        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
        }
    }
</script>

<style media="screen">
    .v-img__img,
    .v-img__picture,
    .v-img__gradient,
    .v-img__placeholder,
    .v-img__error {
        width: auto !important;
    }
</style>