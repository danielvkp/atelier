<template>
    <div>
        <v-img class="mx-auto my-6" max-width="228" src="https://equilibrioymente.es/mente_y_equilobrio_logo_color.png"></v-img>

        <v-card class="mx-auto pa-12 pb-8" elevation="2" max-width="448" rounded="lg">
            <div class="text-subtitle-1 text-medium-emphasis">Email</div>

            <v-text-field v-model="user.email" density="compact" placeholder="Correo electronico" prepend-inner-icon="mdi-email-outline" variant="outlined"></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                Contraseña

                <router-link class="text-caption text-decoration-none text-blue" to="/recuperar-password">
                    Olvide mi contraseña
                </router-link>
            </div>

            <v-text-field v-model="user.password" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'" density="compact" placeholder="Contraseña" prepend-inner-icon="mdi-lock-outline" variant="outlined"
              @click:append-inner="visible = !visible"></v-text-field>

            <v-card v-if="login_errors.mensaje" class="mb-12" color="red" variant="tonal">
                <v-card-text class="text-medium-emphasis text-caption">
                    {{login_errors.mensaje[0]}}
                </v-card-text>
            </v-card>

            <v-btn @click="doLogin" :loading="isloading" class="mb-8" color="blue" size="large" variant="tonal" block>
                Iniciar sesion
            </v-btn>

        </v-card>
    </div>
</template>

<script>
    import auth from '../../auth/auth.js'

    export default {
        data: () => ({
            visible: false,
            user: {
                email: '',
                password: ''
            },
        }),

        methods: {
            doLogin() {
                auth.signin(this.user)
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