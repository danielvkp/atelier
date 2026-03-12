<template id="">
    <v-container>

        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-testimonials" icon text>
                    <v-icon small class="white--text">mdi-arrow-left</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Guardar / Editar Reseña</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-form ref="form" v-model="valid" lazy-validation>

                    <v-row class="mt-2" dense>
                        <v-col cols="12" md="3">
                            <v-text-field v-model="item.nombre" label="Nombre" :rules="nombre_rules"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-text-field  v-model="item.rating" type="number" step="1" label="Rating (1-5)" :rules="role_rules"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row class="mt-2" dense>
                        <v-col cols="12" md="6">
                            <v-textarea v-model="item.descripcion" label="Descripción" :rules="ident_rules"></v-textarea>
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
        testimonial_service
    } from '@services/testimonial_service.js'

    import {
        usuario_rules
    } from '../mixins/usuario_rules'


    export default {
        mixins: [usuario_rules],

        data() {
            return {
                item: {
                    id: null,
                    nombre: '',
                    rating:5,
                    descripcion: null,
                },
            }
        },

        created() {
            if (this.$route.query.id) {
                this.getServicio(this.$route.query.id)
            }
        },

        methods: {

            getServicio(id) {
                testimonial_service.get_testimonial(id).then(res => {
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

                testimonial_service.save_testimonial(this.item).then(res => {
                    this.$store.dispatch('success', 'Registro guardado con exito')
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error guardando testimonial')
                })
            },

            nuevo() {
                this.item = {
                    id: null,
                    nombre: '',
                    rating:5,
                    descripcion: null,
                }

                this.$refs.form.resetValidation()
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
