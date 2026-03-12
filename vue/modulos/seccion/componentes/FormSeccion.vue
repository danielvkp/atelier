<template id="">
    <v-container>

        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-secciones" icon text>
                    <v-icon small class="white--text">mdi-arrow-left</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Guardar / Editar Seccion</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-form ref="form" v-model="valid" lazy-validation>

                    <v-row class="mt-2" dense>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.titulo" label="Titulo" :rules="nombre_rules"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.meta_keywords" label="Keywords"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.meta_contenido" label="Meta contenido"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.slug" disabled label="URL"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-select v-model="item.tipo" :items="tipos" outlined small dense label="Tipo"></v-select>
                        </v-col>
                    </v-row>

                    <v-row class="mt-2" dense>
                        <v-col cols="12">
                            <QuillEditor v-model:content="item.contenido" contentType="html" theme="snow" />
                        </v-col>
                    </v-row>

                    <br>
                    <br>
                    <v-row class="mt-8" dense>
                        <v-col cols="12" md="6">
                            <v-file-input variant="outlined" density="compact" color="blue" ref="fileinput" @update:modelValue="fileChange" small outlined dense accept="image/*" label="Imagen"></v-file-input>
                        </v-col>
                    </v-row>

                    <v-row dense>
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
        seccion_service
    } from '@services/seccion_service.js'


    import {
        usuario_rules
    } from '../mixins/usuario_rules'

    export default {
        mixins: [usuario_rules],

        data() {
            return {
                items: [],

                tipos: ['Coaching', 'Practicas'],

                formData: new FormData(),
                item: {
                    id: null,
                    meta_keywords: null,
                    meta_contenido: null,
                    visitas: 1,
                    titulo: null,
                    slug: null,
                    contenido: null,
                    tipo: 'Coaching'
                },
            }
        },

        created() {
            if (this.$route.query.id) {
                this.getSeccion(this.$route.query.id)
            }

        },

        methods: {

            jsonToFormData(json_object) {
                Object.keys(json_object).forEach(key => this.formData.append(key, json_object[key]))
                return this.formData
            },

            getSeccion(id) {
                seccion_service.get_seccion(id).then(res => {
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error consultando potencial')
                })
            },

            async saveServicio() {
                let status = await this.$refs.form.validate()
                if (!status.valid) {
                    this.$store.dispatch('warning', 'Error validando formulario')
                    return null
                }
                seccion_service.save_seccion(this.jsonToFormData(this.item)).then(res => {
                    this.$store.dispatch('success', 'Registro guardado con exito')
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error guardando blog')
                })
            },

            fileChange(file) {
                this.formData.append('imagen', file)
            },

            nuevo() {
                this.item = {
                    id: null,
                    meta_keywords: null,
                    meta_contenido: null,
                    titulo: null,
                    slug: null,
                    contenido: null,
                    tipo: null,
                }

                this.$refs.fileinput.reset()
                this.$refs.form.resetValidation()
                this.formData.delete('imagen');
                this.formData.delete('meta_keywords');
                this.formData.delete('meta_contenido');
                this.formData.delete('cover');
                this.formData.delete('titulo');
                this.formData.delete('contenido');
                this.formData.delete('slug');
                this.formData.delete('tipo');
                this.formData.delete('id');
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