<template id="">
    <v-container>
        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-servicios" icon text>
                    <v-icon small class="white--text">mdi-home</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Tarifas</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>


                <v-row dense>



                    <v-col cols="12" md="6">
                        <loader v-if="isloading"></loader>
                        <v-form ref="form" v-model="valid" lazy-validation>

                            <v-row class="mt-2" dense>
                                <v-col cols="10">
                                    <v-text-field v-model="item.titulo" label="Nombre" :rules="nombre_rules"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row dense>
                                <v-col cols="12" md="4">
                                    <v-text-field prefix="€" v-model="item.precio" type="number" step="0.1" label="Precio" :rules="role_rules"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-select v-model="item.duracion" :items="duracion" outlined small dense label="Duración"></v-select>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field v-model="item.orden" type="number" step="1" label="Orden" :rules="role_rules"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row dense>
                                <v-col cols="10">
                                    <v-select v-model="item.tipo" :items="tipos" outlined small dense label="Tipo"></v-select>
                                </v-col>
                            </v-row>

                            <v-row class="mt-2" dense>
                                <v-col cols="10">
                                    <v-textarea v-model="item.contenido" label="Descripción" :rules="ident_rules"></v-textarea>
                                </v-col>
                            </v-row>

                            <v-row dense>
                                <v-col cols="12">
                                    <v-btn :loading="isloading" @click="save" class="" color="green">guardar</v-btn>
                                    <v-btn :loading="isloading" @click="nuevo" class="text-white ml-4" color="blue">Nuevo</v-btn>
                                </v-col>
                            </v-row>

                        </v-form>

                    </v-col>

                    <v-col cols="6">
                        <v-data-table :headers="headers" :items="items" disable-pagination hide-default-footer item-key="key" class="elevation-1 mt-2">


                            <template v-slot:item.precio="{item}">
                                {{item.precio}}€
                            </template>

                            <template v-slot:item.action="{ item }">

                                <v-icon @click="set_item(item)" size="small" color="blue" class="mr-2">
                                    mdi-pencil
                                </v-icon>


                                <v-icon @click="delete_tarifa(item.id)" size="small" color="red">
                                    mdi-delete
                                </v-icon>

                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>

            </v-card-text>

        </v-card>

        <v-confirm v-on:delete="delete_servicio">
        </v-confirm>
    </v-container>
</template>

<script>
    import moment from 'moment';

    import {
        tarifa_servicio_service
    } from '@services/tarifa_servicio_service.js'


    export default {


        data() {
            return {
                tipos: ['Senior', 'Semisenior', 'Junior'],
                duracion: [30, 50, 75, 90],
                item: {
                    id: null,
                    servicio_id: null,
                    titulo: null,
                    contenido: null,
                    precio: null,
                    duracion: null,
                    orden: 1
                },
                items: [],
                headers: [{
                        title: 'Titulo',
                        key: 'titulo',
                        sortable: false,
                    }, {
                        title: 'Precio',
                        key: 'precio',
                        sortable: false
                    },
                    {
                        text: 'Acciones',
                        value: 'action',
                        sortable: false
                    },
                ],
            }
        },

        created() {
            this.get_tarifas(this.$route.query.id)
        },

        methods: {

            save() {
                tarifa_servicio_service.save_tarifa(this.$route.query.id, this.item).then(res => {
                    this.$store.dispatch('success', 'Registro guardado con exito')
                    this.get_tarifas(this.$route.query.id)
                    this.nuevo()
                }, res => {
                    this.$store.dispatch('error', 'Error guardando tarifa')
                })
            },

            delete_tarifa(id) {
                tarifa_servicio_service.delete_tarifa(id).then(res => {
                    let index = this.items.findIndex(x => x.id == id)
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
            },

            get_tarifas(id) {
                tarifa_servicio_service.get_tarifas(id).then(res => {
                    this.items = res.data
                }, res => {
                    this.$toast.error('Error consultando registro')
                })
            },

            nuevo() {
                this.item = {
                    id: null,
                    servicio_id: null,
                    titulo: null,
                    contenido: null,
                    precio: null,
                    duracion: null,
                }

            }
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