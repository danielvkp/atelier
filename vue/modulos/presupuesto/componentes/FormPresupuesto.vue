<template id="">
    <v-container>

        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/lista-servicios" icon text>
                    <v-icon small class="white--text">mdi-arrow-left</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Guardar / Editar Presupuesto</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-form ref="form" v-model="valid" lazy-validation>

                    <v-row class="mt-2" dense>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="item.cliente.nombre" label="Cliente" disabled :rules="nombre_rules"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="item.cliente.email" label="Email" disabled :rules="email_rules"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="item.cliente.telefono" disabled label="Teléfono"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="item.valido_desde" label="Válido desde" type="date" :rules="nombre_rules"></v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field v-model="item.valido_hasta" label="Válido hasta" type="date" :rules="nombre_rules"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12" md="8">
                            <v-select chips v-model="select" :items="servicios" variant="outlined" label="Servicios" multiple></v-select>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12" md="8">
                            <v-data-table :headers="headers" :items="item.items" disable-pagination hide-default-footer item-key="key" class="elevation-1 mt-2">

                                <template v-slot:item.precio="{ item }">
                                    <span>
                                        {{item.precio}}€
                                    </span>
                                </template>


                            </v-data-table>

                            <div class="block">

                                <v-chip size="large" class="my-3 float-right" color="blue" label>

                                    Total: {{format_double(total)}}
                                </v-chip>
                            </div>
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
        potencial_service
    } from '@services/potencial_service.js'

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

                select: [],
                servicios: [],
                items: [],
                item: {
                    id: null,
                    cliente_id: null,
                    valido_desde: new Date().toISOString().substring(0, 10),
                    valido_hasta: new Date().toISOString().substring(0, 10),
                    cliente: {
                        id: null,
                        nombre: '',
                        telefono: '',
                        email: '',
                    },
                    items: []
                },
                headers: [{
                        title: 'Nombre',
                        key: 'nombre',
                        sortable: false
                    },
                    {
                        title: 'Precio',
                        key: 'precio',
                        sortable: false,
                        align: 'end'
                    },
                ],
            }
        },

        watch: {
            select(select_of_sevices, o) {
                this.item.items = []
                select_of_sevices.forEach((service_name, i) => {
                    let index = this.items.findIndex(x => x.nombre == service_name)
                    this.item.items.push(this.items[index])
                })
            }
        },

        created() {
            if (this.$route.query.id) {
                this.getServicio(this.$route.query.id)
            }
            this.getCliente(this.$route.query.cliente_id)
            this.get_servicios()
        },

        methods: {
            format_double(total) {

                return new Intl.NumberFormat("de-DE", {
                    style: "currency",
                    currency: "EUR"
                }).format(
                    total,
                )
            },

            getCliente(id) {
                potencial_service.get_potencial(id).then(res => {
                    this.item.cliente_id = res.data.id
                    this.item.cliente = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error consultando potencial')
                })
            },

            get_servicios() {
                servicio_service.get_servicios().then(res => {
                    this.items = res.data
                    this.servicios = res.data.map(x => x.nombre)
                }, res => {
                    this.$toast.error('Error consultando registro')
                })
            },

            async saveServicio() {
                let status = await this.$refs.form.validate()
                if (!status.valid) {
                    this.$store.dispatch('warning', 'Error validando formulario')
                    return null
                }
                servicio_service.save_servicio(this.item).then(res => {
                    this.$store.dispatch('success', 'Registro guardado con exito')
                    this.item = res.data
                }, res => {
                    this.$store.dispatch('error', 'Error guardando servicio')
                })
            },

            nuevo() {

                this.item = {
                    id: null,
                    nombre: '',
                    precio: 0,
                    active: true,
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
            total() {
                return this.item.items.reduce((acc, element) => {
                    return acc + element.precio
                }, 0)
            }
        }
    }
</script>