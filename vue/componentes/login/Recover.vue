<template>
    <div>
        <v-img class="mx-auto my-6" max-width="228" src="http://triangulocreativove.com/triangulo_logo.png"></v-img>

        <v-card class="mx-auto pa-12 pb-8" elevation="0" max-width="720" rounded="lg">
            <v-stepper hide-actions v-model="value" :items="items">

                <template v-slot:item.1>
                    <v-row class="mt-4" dense>
                        <v-col class="mx-auto" cols="12" md="6">
                            <v-text-field v-model="user.email" density="compact" placeholder="Correo electronico" prepend-inner-icon="mdi-email-outline" variant="outlined"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col class="mx-auto" cols="12" md="6">
                            <v-btn @click="recover" :loading="isloading" class="mb-1" color="blue" size="large" variant="tonal" block>
                                Solicitar codigo
                            </v-btn>
                        </v-col>
                    </v-row>
                </template>

                <template v-slot:item.2>
                    <v-row class="mt-4" dense>
                        <v-col class="mx-auto" cols="12" md="6">
                            <v-text-field v-model="user.codigo" density="compact" placeholder="Código" variant="outlined"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col class="mx-auto" cols="12" md="6">
                            <v-btn @click="verify" :loading="isloading" class="mb-1" color="blue" size="large" variant="tonal" block>
                                Verificar código
                            </v-btn>
                        </v-col>
                    </v-row>
                </template>

                <template v-slot:item.3>

                    <v-row class="mt-4" dense>
                        <v-col class="mx-auto" cols="12" md="6">
                            <v-text-field v-model="user.password" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'" density="compact" placeholder="Contraseña" prepend-inner-icon="mdi-lock-outline"
                              variant="outlined" @click:append-inner="visible = !visible"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col class="mx-auto" cols="12" md="6">
                            <v-btn @click="set_password" :loading="isloading" class="mb-1" color="blue" size="large" variant="tonal" block>
                                Reestablecer contraseña
                            </v-btn>
                        </v-col>
                    </v-row>
                </template>
            </v-stepper>

        </v-card>
    </div>
</template>

<script>
    import {
        auth_service
    } from '@services/auth_service.js'
    import auth from '../../auth/auth.js'

    export default {
        data: () => ({
            items: ['Solicitar codigo', 'Verificar código', '  Reestablecer contraseña'],
            visible: false,
            step: 0,
            value: 0,
            token: null,
            user: {
                email: '',
                codigo: '',
                password: null
            },
        }),

        methods: {
            recover() {
                auth_service.send_code(this.user).then(res => {
                    this.$store.dispatch('success', 'Código enviado con exito')
                    this.value = 2
                }, res => {
                    if (res.response.status == 301) {
                        return this.$store.dispatch('warning', res.response.data)
                    }
                    this.$store.dispatch('error', 'Algo ha salido mal')
                })
            },

            verify() {
                auth_service.verify_code(this.user).then(res => {
                    this.$store.dispatch('success', 'Código validado con exito')
                    this.value = 3
                    this.token = res.data.access_token
                }, res => {
                    this.$store.dispatch('error', 'Error validando código')
                })
            },

            set_password() {
                auth_service.set_password(this.user, this.token).then(res => {
                    this.$store.dispatch('success', 'Contraseña reestablecida con exito')
                    this.$router.push('/login')
                }, res => {
                    this.$store.dispatch('error', 'Error validando código')
                })
            }
        },

        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
            login_errors: function() {
                return this.$store.getters.get_login_errors
            },
        }
    }
</script>
