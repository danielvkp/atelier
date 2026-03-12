<template id="">
    <v-container>

        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-productos" icon text>
                    <v-icon small class="white--text">mdi-arrow-left</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Guardar / Editar PDF</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-form ref="form" v-model="valid" lazy-validation>

                    <v-row class="mt-2" dense>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.nombre" label="Titulo" :rules="nombre_rules"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.slug" disabled label="URL"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-text-field v-model="item.precio" prefix="€" label="Precio"></v-text-field>
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
                        <v-col cols="12" md="6">
                            <v-file-input variant="outlined" density="compact" color="blue" ref="fileinput" @update:modelValue="fileChangePDF" small outlined dense accept="application/pdf" label="PDF"></v-file-input>
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
        producto_service
    } from '@services/producto_service.js'

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
                    nombre: null,
                    slug: null,
                    contenido: null,
                    short_contenido: null,
                    imagen: null,
                    archivo: null,
                    precio: 0,
                    active: true,
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
                producto_service.get_producto(id).then(res => {
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
                producto_service.save_producto(this.jsonToFormData(this.item)).then(res => {
                    this.$store.dispatch('success', 'Registro guardado con exito')
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error guardando producto')
                })
            },

            fileChange(file) {
                this.formData.append('imagen', file)
            },

            fileChangePDF(file) {
                this.formData.append('archivo', file)
            },

            nuevo() {
                this.item = {
                    id: null,
                    nombre: null,
                    slug: null,
                    contenido: null,
                    short_contenido: null,
                    imagen: null,
                    archivo: null,
                    precio: 0,
                    active: true,
                }

                this.$refs.fileinput.reset()
                this.$refs.form.resetValidation()
                this.formData.delete('imagen');
                this.formData.delete('cover');
                this.formData.delete('titulo');
                this.formData.delete('autor');
                this.formData.delete('contenido');
                this.formData.delete('short_contenido');
                this.formData.delete('archivo');
                this.formData.delete('slug');
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