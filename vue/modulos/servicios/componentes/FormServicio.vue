<template id="">
    <v-container>

        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-servicios" icon text>
                    <v-icon small class="white--text">mdi-arrow-left</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Guardar / Editar Servicio</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-form ref="form" v-model="valid" lazy-validation>

                    <v-row class="mt-2" dense>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.nombre" label="Nombre" :rules="nombre_rules"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-text-field v-model="item.slug" disabled label="URL"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select v-model="item.menu" :items="menus" outlined small dense label="Menu"></v-select>
                        </v-col>
                    </v-row>

                    <v-row class="mt-2" dense>
                        <v-col cols="12">
                            <v-textarea v-model="item.descripcion" label="Descripción corta" :rules="ident_rules"></v-textarea>
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
        servicio_service
    } from '@services/servicio_service.js'

    import {
        usuario_rules
    } from '../mixins/usuario_rules'


    export default {
        mixins: [usuario_rules],

        data() {
            return {
                menus: ['servicios', 'especiales'],
                formData: new FormData(),
                item: {
                    id: null,
                    nombre: '',
                    precio: 1,
                    descripcion: null,
                    contenido: null,
                    slug: null,
                    menu: '',
                },
            }
        },

        created() {
            if (this.$route.query.id) {
                this.getServicio(this.$route.query.id)
            }
        },

        methods: {
            jsonToFormData(json_object) {
                Object.keys(json_object).forEach(key => this.formData.append(key, json_object[key]))
                return this.formData
            },

            getServicio(id) {
                servicio_service.get_servicio(id).then(res => {
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
                servicio_service.save_servicio(this.jsonToFormData(this.item)).then(res => {
                    this.$store.dispatch('success', 'Registro guardado con exito')
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error guardando servicio')
                })
            },

            fileChange(file) {
                this.formData.append('imagen', file)
            },

            nuevo() {
                this.item = {
                    id: null,
                    nombre: '',
                    precio: 0,
                    descripcion: null,
                    imagen: null,
                    cover: null,
                    contenido: null,
                    slug: null,
                    menu: ''
                }

                this.$refs.fileinput.reset()
                this.$refs.form.resetValidation()
                this.formData.delete('imagen');
                this.formData.delete('nombre');
                this.formData.delete('precio');
                this.formData.delete('descripcion');
                this.formData.delete('cover');
                this.formData.delete('id');
                this.formData.delete('menu');
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