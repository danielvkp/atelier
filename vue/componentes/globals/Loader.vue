<template>
    <v-row class="mb-3 mt-3">
        <v-col cols="12" justify="center" align="center">
            <v-progress-circular :size="40" :width="3" color="blue" indeterminate></v-progress-circular>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'loader'
    }
</script>