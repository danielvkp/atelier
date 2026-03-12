<template>

    <v-app-bar :elevation="1">

        <template v-slot:prepend>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
        </template>
        <v-app-bar-title></v-app-bar-title>

        <!--<v-btn icon @click="setTheme">
            <v-icon>mdi-white-balance-sunny</v-icon>
        </v-btn>-->

        <template v-slot:append>
            <v-btn @click="doLogout" icon="mdi-login-variant"></v-btn>
        </template>


    </v-app-bar>
</template>

<script>
    import auth from '../auth/auth.js'

    /*  import {
          useTheme
      } from 'vuetify'

      const theme = useTheme()*/

    export default {
        mounted() {
            let dark = localStorage.getItem('dark') == 'true' ? true : false
            //theme.global.name.value = dark ? 'dark' : 'light'
        },

        methods: {
            toggleDrawer() {
                this.$emit('toggleDrawer')
            },
            doLogout() {
                auth.logout()
            },
            setTheme() {
                //  theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
                localStorage.setItem('dark', theme.global.name.value)
            }
        },
    }
</script>