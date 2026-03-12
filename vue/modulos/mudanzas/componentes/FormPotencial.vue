<template id="">
    <v-container>

        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-potenciales" icon text>
                    <v-icon small class="white--text">mdi-arrow-left</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Guardar / Editar Cliente Potencial</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-form ref="form" v-model="valid" lazy-validation>

                    <v-row class="mt-2" dense>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="item.nombre" label="Nombre" :rules="nombre_rules"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="item.email" label="Email" :rules="email_rules"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="item.telefono" label="Teléfono"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12" md="3">
                            <v-select v-model="item.tipo_medio" :items="tipo_medio" label="Canal / medio"></v-select>
                        </v-col>

                        <v-col cols="12" md="3">
                            <v-select v-model="item.medio" :items="medios" label="Canal / medio"></v-select>
                        </v-col>

                        <v-col cols="12" md="3">
                            <v-select v-model="item.seguimiento" :items="seguimiento" label="Status"></v-select>
                        </v-col>

                        <v-col cols="12" md="3">
                            <v-text-field v-model="item.ultimo_servicio.fecha_mudanza" label="Fecha estimada" type="date" :rules="nombre_rules"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="item.ultimo_servicio.origen" outlined small dense label="Origen"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="item.ultimo_servicio.destino" outlined small dense label="Destino"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12" md="4">
                            <v-select v-model="item.ultimo_servicio.tamano" :items="tamanos" outlined small dense label="Tamaño"></v-select>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-text-field v-model="item.ultimo_servicio.costo_estimado" outlined small dense label="Costo estimado"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-select v-model="item.ultimo_servicio.comercial_id" :items="comerciales" outlined small dense label="Comercial asignado" item-title="name" item-value="id"></v-select>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12">
                            <v-textarea v-model="item.ultimo_servicio.detalles" variant="outlined" outlined small dense label="Detalles"></v-textarea>
                        </v-col>
                    </v-row>


                    <v-row dense>
                        <v-col cols="12">
                            <v-btn :loading="isloading" @click="savePotencial" class="" color="green">guardar</v-btn>
                            <v-btn :loading="isloading" @click="nuevo" class=" ml-4" color="blue">nuevo</v-btn>
                            <v-btn :loading="isloading" class="text-white ml-4" color="orange">historial</v-btn>
                            <v-btn :loading="isloading" class="text-white ml-4" color="purple">Presupuesto</v-btn>
                        </v-col>
                    </v-row>

                </v-form>


            </v-card-text>


        </v-card>

    </v-container>
</template>

<script>
    import {
        user_service
    } from '@services/user_service.js'

    import {
        potencial_service
    } from '@services/potencial_service.js'

    import {
        usuario_rules
    } from '../mixins/usuario_rules'

    import {
        status_mixin
    } from '@mixins/status_mixin.js'

    export default {
        mixins: [usuario_rules, status_mixin],
        data() {
            return {
                comerciales: [],
                item: {
                    id: null,
                    comercial_id: null,
                    nombre: '',
                    telefono: '',
                    email: '',
                    status: 'potencial',
                    seguimiento: 'Nuevo',
                    medio: '',
                    tipo_medio: 'interno',
                    ultimo_servicio: {
                        id: null,
                        cliente_id: null,
                        destino: null,
                        origen: null,
                        fecha_mudanza: null,
                        tamano: null,
                        detalles: null,
                        costo_estimado: 0,
                        comercial_id: null,
                        historial: []
                    }
                },
            }
        },

        created() {
            if (this.$route.query.id) {
                this.getPotencial(this.$route.query.id)
            }
            this.getUsersByRole('comercial')
        },

        methods: {
            getUsersByRole(role) {
                user_service.get_users_by_role(role).then(res => {
                    this.comerciales = res.data
                    this.comerciales.unshift({
                        name: '',
                        id: null
                    })
                }, res => {
                    this.$store.dispatch('error', 'Error cargando comerciales')
                })
            },

            getPotencial(id) {
                potencial_service.get_potencial(id).then(res => {
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error consultando potencial')

                })
            },

            async savePotencial() {
                let status = await this.$refs.form.validate()
                if (!status.valid) {
                    this.$store.dispatch('warning', 'Error validando formulario')
                    return null
                }
                potencial_service.save_cliente(this.item).then(res => {
                    this.$store.dispatch('success', 'Registro guardado con exito')
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error guardando usuario')
                })
            },

            nuevo() {
                this.$refs.form.resetValidation()
                this.item = {
                    id: null,
                    comercial_id: null,
                    nombre: '',
                    telefono: '',
                    email: '',
                    status: 'potencial',
                    seguimiento: 'Nuevo',
                    medio: 'Email',
                    ultimo_servicio: {
                        id: null,
                        cliente_id: null,
                        destino: null,
                        origen: null,
                        fecha_mudanza: null,
                        tamano: null,
                        detalles: null,
                        costo_estimado: 0,
                        comercial_id: null
                    }
                }
            }
        },
        computed: {
            isloading() {
                return false
                //return this.$store.getters.getloading
            },
            errors() {
                return this.$store.getters.geterrors
            },
        }
    }
</script>