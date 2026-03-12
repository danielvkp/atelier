<template>
    <v-dialog v-model="dialog" persistent max-width="290">
        <v-card>
            <v-card-title class="text-h5">
                Confirmacion
            </v-card-title>
            <v-card-text>¿Desea eliminar el registro?.</v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="confirm">
                    eliminar
                </v-btn>
                <v-btn color="blue" text @click="dialog = false">
                    cerrar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: 'v-confirm',
        data() {
            return {
                dialog: false
            }
        },

        created() {
            this.$eventBus.on('open', () => {
                this.dialog = true
            })
        },

        methods: {
            confirm() {
                this.dialog = false
                this.$emit('delete')
            }
        }
    }
</script>