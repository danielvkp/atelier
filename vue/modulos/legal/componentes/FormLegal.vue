<template id="">
    <v-container>

        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-blogs" icon text>
                    <v-icon small class="white--text">mdi-arrow-left</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Guardar / Editar Legal</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-form ref="form" v-model="valid" lazy-validation>

                    <v-tabs v-model="tab" align-tabs="center" color="blue">
                        <v-tab value="1">Legal</v-tab>
                        <v-tab value="2">Cookies</v-tab>
                        <v-tab value="3">Privacidad</v-tab>
                    </v-tabs>

                    <v-tabs-window v-model="tab">

                        <v-tabs-window-item key="1" value="1">
                            <v-container fluid>
                                <v-row>
                                    <v-col cols="12">
                                        <QuillEditor v-model:content="item.legal" contentType="html" theme="snow" />
                                        <br>
                                        <br>
                                    </v-col>
                                </v-row>
                                <br>
                                <br>
                            </v-container>
                        </v-tabs-window-item>

                        <v-tabs-window-item key="2" value="2">
                            <v-container fluid>
                                <v-row>
                                    <v-col cols="12">
                                        <QuillEditor v-model:content="item.cookies" contentType="html" theme="snow" />

                                    </v-col>
                                </v-row>
                                <br>
                                <br>
                            </v-container>
                        </v-tabs-window-item>

                        <v-tabs-window-item key="3" value="3">
                            <v-container fluid>
                                <v-row>
                                    <v-col cols="12" class="pb-8">
                                        <QuillEditor v-model:content="item.privacidad" contentType="html" theme="snow" />

                                    </v-col>
                                </v-row>
                                <br>
                                <br>
                            </v-container>
                        </v-tabs-window-item>

                    </v-tabs-window>

                    <!--<v-tabs-window v-model="tab">
                        <v-tabs-window-item key="1" value="1">
                            <v-container fluid>
                                <v-row>
                                  <v-col cols="12">
                                      <QuillEditor v-model:content="item.cookies" contentType="html" theme="snow" />
                                  </v-col>
                                </v-row>
                            </v-container>
                        </v-tabs-window-item>
                    </v-tabs-window>-->


                    <br>
                    <br>

                    <v-row dense class="mt-4">
                        <v-col cols="12">
                            <v-btn :loading="isloading" @click="saveServicio" class="" color="green">guardar</v-btn>
                            <v-btn :loading="isloading" @click="nuevo" class="text-white ml-4" color="blue">Nuevo</v-btn>
                        </v-col>
                    </v-row>

                </v-form>

            </v-card-text>

        </v-card>

    </v-container>
</template>

<script>
    import {
        legal_service
    } from '@services/legal_service.js'

    import {
        usuario_rules
    } from '../mixins/usuario_rules'

    export default {
        mixins: [usuario_rules],

        data() {
            return {
                tab: null,
                item: {
                    id: null,
                    legal: null,
                    cookies: null,
                    privacidad: null,
                },
            }
        },

        created() {

            this.getServicio()
        },

        methods: {



            getServicio(id) {
                legal_service.get_legal(id).then(res => {
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error consultando potencial')
                })
            },

            async saveServicio() {
                legal_service.save_legal(this.item).then(res => {
                    this.$store.dispatch('success', 'Registro guardado con exito')
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error guardando blog')
                })
            },

            nuevo() {
                this.item = {
                    id: null,
                    legal: null,
                    cookies: null,
                    privacidad: null,
                }
            }
        },
        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
            errors() {
                return this.$store.getters.geterrors
            },
        }
    }
</script>