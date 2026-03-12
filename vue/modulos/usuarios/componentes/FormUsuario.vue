<template id="">
    <v-container>
        <v-row dense>
            <v-col cols="12" md="6">
                <v-card>
                    <v-toolbar flat color="blue" class="white--text">
                        <v-btn to="/lista-usuarios" icon text>
                            <v-icon small class="white--text">mdi-arrow-left</v-icon>
                        </v-btn>
                        <v-toolbar-title>
                            <h3 class="font-weight-light">Guardar / Editar usuario</h3>
                        </v-toolbar-title>
                    </v-toolbar>

                    <v-card-text>

                        <v-form ref="form" v-model="valid" lazy-validation>

                            <v-row class="mt-2" dense>
                                <v-col cols="12">
                                    <v-text-field v-model="item.name" label="Nombre" :rules="nombre_rules"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="mt-2" dense>
                                <v-col cols="12">
                                    <v-text-field v-model="item.email" label="Email" :rules="email_rules"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="mt-2" v-if="item.id">
                                <v-col cols="12">
                                    <v-text-field small dense v-model="item.password" type="password" outlined label="Contraseña" :rules="password_rules"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="mt-2" v-else dense>
                                <v-col cols="12">
                                    <v-text-field small dense v-model="item.password" type="password" outlined label="Contraseña" :rules="dumb_password_rules"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="mt-2" dense>
                                <v-col cols="12" md="6">
                                    <v-select outlined small dense v-model="item.role" :rules="role_rules" :items="roles" label="Tipo"></v-select>
                                </v-col>
                            </v-row>

                            <v-row class="" dense>
                                <v-col cols="12" md="6">
                                    <v-checkbox v-model="item.active" color="primary" label="Activo"></v-checkbox>
                                </v-col>
                            </v-row>

                            <v-row dense>
                                <v-col cols="12">
                                    <v-btn :loading="isloading" @click="saveUser" class="white--text" color="green">guardar</v-btn>
                                    <v-btn :loading="isloading" @click="nuevo" class="white--text ml-4" color="blue">nuevo</v-btn>
                                </v-col>
                            </v-row>

                        </v-form>


                    </v-card-text>


                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {
        user_service
    } from '@services/user_service.js'

    import {
        usuario_rules
    } from '../mixins/usuario_rules'

    export default {
        mixins: [usuario_rules],
        data() {
            return {
                item: {
                    id: null,
                    name: null,
                    email: null,
                    active: true,
                    last_login: null,
                    ip: null,
                    password: 'dummy-password',
                    role: 'comercial',
                },
                roles: ['comercial', 'operario'],
            }
        },

        created() {
            if (this.$route.query.id) {
                this.getUser(this.$route.query.id)
            }
        },

        methods: {
            getUser(id) {
                user_service.get_user(id).then(res => {
                    this.item = res.data
                    this.item.password = 'dummy-password'
                }, res => {
                    console.log('error..')
                })
            },

            async saveUser() {
                let status = await this.$refs.form.validate()
                if (!status.valid) {
                    this.$store.dispatch('warning', 'Error validando formulario')
                    return null
                }
                user_service.save_user(this.item).then(res => {
                    this.$store.dispatch('success', 'Usuario guardado con exito')
                    this.item = res.data
                    this.item.password = 'dummy-password'
                }, res => {
                    this.$store.dispatch('error', 'Error guardando usuario')
                })
            },

            nuevo() {
                this.$refs.form.resetValidation()
                this.item = {
                    id: null,
                    name: null,
                    email: null,
                    password: 'dummy-password',
                    role: 'comercial',
                    active: true,
                    last_login: null,
                    ip: null
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