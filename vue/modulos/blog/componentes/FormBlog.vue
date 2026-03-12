<template id="">
    <v-container>

        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-blogs" icon text>
                    <v-icon small class="white--text">mdi-arrow-left</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Guardar / Editar Blog</h3>
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
                            <v-select multiple v-model="item.categorias" :items="items" outlined small dense label="Categoria" item-title="nombre" item-value="id" color="green"></v-select>

                        </v-col>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.slug" disabled label="URL"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row class="mt-2" dense>
                        <v-col cols="12">
                            <QuillEditor v-model:content="item.cotenido" contentType="html" theme="snow" />
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
        blog_service
    } from '@services/blog_service.js'

    import {
        categoria_service
    } from '@services/categoria_service.js'


    import {
        usuario_rules
    } from '../mixins/usuario_rules'

    export default {
        mixins: [usuario_rules],

        data() {
            return {
                items: [],
                formData: new FormData(),
                item: {
                    id: null,
                    categoria_id: 1,
                    meta_keywords: null,
                    meta_contenido: null,
                    visitas: 1,
                    titulo: null,
                    slug: null,
                    autor: null,
                    cotenido: null,
                    categoria: [],
                    categorias: []
                },
            }
        },

        created() {
            if (this.$route.query.id) {
                this.getServicio(this.$route.query.id)
            }
            this.get_categorias()
        },

        methods: {
            get_categorias() {
                categoria_service.get_categorias().then(res => {
                    this.items = res.data
                }, res => {
                    this.$toast.error('Error consultando registro')
                })
            },
            jsonToFormData(json_object) {
                Object.keys(json_object).forEach(key => this.formData.append(key, json_object[key]))
                return this.formData
            },

            getServicio(id) {
                blog_service.get_blog(id).then(res => {
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
                blog_service.save_blog(this.jsonToFormData(this.item)).then(res => {
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
                    categoria_id: null,
                    meta_keywords: null,
                    meta_contenido: null,
                    visitas: 1,
                    titulo: null,
                    slug: null,
                    autor: null,
                    cotenido: null,
                }

                this.$refs.fileinput.reset()
                this.$refs.form.resetValidation()
                this.formData.delete('imagen');
                this.formData.delete('meta_keywords');
                this.formData.delete('categoria_id');
                this.formData.delete('meta_contenido');
                this.formData.delete('cover');
                this.formData.delete('titulo');
                this.formData.delete('autor');
                this.formData.delete('contenido');
                this.formData.delete('slug');
                this.formData.delete('visitas');
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