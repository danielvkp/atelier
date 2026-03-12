<template id="">

    <v-layout>
        <v-snackbar variant="flat" :color="snackbar.color" location="top right" @update:modelValue="cambio" v-model="snackbar.status">
            <span class="text-white">{{ snackbar.text }}</span>
        </v-snackbar>


        <lateral v-if="$route.path !== '/login' && $route.path !== '/recuperar-password'"></lateral>

        <top v-if="$route.path !== '/login' && $route.path !== '/recuperar-password'"></top>

        <v-main class="" height="">
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-layout>
</template>

<script>
    import Top from './Top.vue'
    import Lateral from './Lateral.vue'
    export default {
        components: {
            Top,
            Lateral
        },
        methods: {
            cambio(status) {
                this.$store.dispatch('close_toast')
            }
        },
        computed: {
            snackbar() {
                return this.$store.getters.get_snackbar
            },
        }
    }
</script>


<style media="screen">
    --v-theme-error:rgb(76, 175, 80)
</style>