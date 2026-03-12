<template>
    <v-app>
        <v-container>
            <v-calendar view-mode="month" :events="events">
                <template #day-event="{ day, event }">
                    <div style="color: red">si funciona wwwwuy</div>
                </template>
            </v-calendar>
        </v-container>
    </v-app>
</template>

<script setup>
    const events = [{
        title: 'Test Event',
        start: new Date('2025-07-03'),
        end: new Date('2025-07-03'),
    }, ]
</script>