<template id="">
    <v-container>
        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/" icon text>
                    <v-icon small class="white--text">mdi-home</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Secciones</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-row dense class="mt-0">
                    <v-col cols="12" md="4">
                        <v-text-field v-model="search" outlined small dense label="Buscar"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-btn to="/guardar-seccion" class="mt-1 white--text" color="blue">
                            nuevo
                        </v-btn>
                    </v-col>
                </v-row>

                <v-row dense>

                    <loader v-if="isloading"></loader>

                    <v-col cols="12">
                        <v-data-table :search="search" items-per-page="-1" :headers="headers" :items="items" disable-pagination hide-default-footer item-key="key" class="elevation-1 mt-2">

                            <template v-slot:item.cover="{item}">
                                <v-img height="80" class="mt-2 mb-2 mr-auto" :src="item.cover"></v-img>
                            </template>

                            <template v-slot:item.precio="{item}">
                                {{item.precio}}€
                            </template>

                            <template v-slot:item.action="{ item }">

                                <router-link :to="`/guardar-seccion?id=${item.id}`" class="action-buttons">
                                    <v-icon size="small" color="blue" class="mr-2">
                                        mdi-pencil
                                    </v-icon>
                                </router-link>

                                <v-icon @click="set_item(item)" size="small" color="red">
                                    mdi-delete
                                </v-icon>

                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>

            </v-card-text>

        </v-card>

        <v-confirm v-on:delete="delete_blog">
        </v-confirm>
    </v-container>
</template>

<script>
    import moment from 'moment';
    import {
        seccion_service
    } from '@services/seccion_service.js'

    import {
        headers_mixin
    } from '../mixins/blog_headers.js'


    export default {
        mixins: [headers_mixin],

        data() {
            return {
                search: '',
                item: {},
                items: [],
            }
        },

        created() {
            this.get_secciones()
        },

        methods: {

            delete_blog() {
                seccion_service.delete_seccion(this.item.id).then(res => {
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

            get_secciones() {
                seccion_service.get_secciones().then(res => {
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