<template id="">
    <v-container>
        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/" icon text>
                    <v-icon small class="white--text">mdi-home</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Empleados</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <loader v-if="isloading"></loader>

                <v-row dense class="mt-0">


                    <v-col cols="12" md="5">
                        <v-row dense class="mt-4">

                            <v-col cols="12">
                                <v-text-field v-model="save_item.nombre" outlined small dense label="Nombre"></v-text-field>
                            </v-col>

                            <v-col cols="12">
                                <v-select v-model="save_item.tipo" :items="tipos" outlined small dense label="Tipo"></v-select>
                            </v-col>

                            <v-col cols="12">
                                <v-color-picker v-model="save_item.color" mode="hexa" hide-inputs></v-color-picker>

                            </v-col>


                            <v-col cols="12">
                                <v-btn @click="save_empleado" class="mt-1 mr-2 white--text" color="green">
                                    Guardar
                                </v-btn>
                                <v-btn @click="resetForm" class="mt-1 white--text" color="blue">
                                    nuevo
                                </v-btn>
                            </v-col>

                        </v-row>
                    </v-col>

                    <v-col cols="12" md="1"></v-col>

                    <v-col cols="12" md="6">
                        <v-row dense>



                            <v-col cols="12">
                                <v-data-table :headers="headers" :items="items" disable-pagination hide-default-footer item-key="key" class="elevation-1 mt-2">

                                    <template v-slot:item.nombre={item}>
                                        <v-icon class="mr-2" :color="item.color">mdi-circle</v-icon>
                                        <span>{{item.nombre}}</span>
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
        empleado_service
    } from '@services/empleado_service.js'

    import {
        headers_mixin
    } from '../mixins/servicio_headers.js'

    export default {
        mixins: [headers_mixin],

        data() {
            return {
                tipos: ['senior', 'semisenior', 'junior'],
                save_item: {
                    id: null,
                    nombre: '',
                    tipo: 'junior',
                    color: '#ffffff',
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
            save_empleado() {
                empleado_service.save_empleado(this.save_item).then(res => {
                    this.resetForm()
                    this.get_tarifas()
                }, res => {
                    this.$toast.error('Error consultando registro')
                })
            },

            resetForm() {
                this.save_item = {
                    id: null,
                    nombre: '',
                    tipo: 'junior',
                    color: '#ffffff',
                }
            },

            delete_tarifa() {
                empleado_service.delete_empleado(this.item.id).then(res => {
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
                empleado_service.get_empleados().then(res => {
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