<template id="">
    <v-container>
        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/" icon text>
                    <v-icon small class="white--text">mdi-home</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Usuarios</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-row dense>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="query.search" color="blue" density="compact" variant="outlined" hide-details outlined small dense label="Nombre / Email"></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-btn to="/guardar-usuario" class="mt-1 white--text" color="blue">
                            nuevo
                        </v-btn>
                    </v-col>

                </v-row>

                <v-row dense>

                    <v-col cols="12">
                        <v-pagination rounded="circle" @update:modelValue="next" v-model="pagination.current_page" :length="pagination.last_page" color="blue" density="compact"></v-pagination>
                    </v-col>

                    <loader v-if="isloading"></loader>

                    <v-col cols="12">
                        <v-data-table :headers="headers" :items="items" disable-pagination hide-default-footer item-key="key" class="elevation-1 mt-2">

                            <template v-slot:item.last_login="{ item }">

                                <v-tooltip text="Tooltip" location="top">
                                    <template v-slot:activator="{ props }">
                                        <span v-bind="props">{{item.last_login}}</span>
                                    </template>
                                    <span>ip: {{item.ip}}</span>
                                </v-tooltip>
                            </template>

                            <template v-slot:item.active="{item}">
                                <v-chip size="small" variant="flat" :color="item.active ? 'green' : 'red lighten-1'">
                                    {{item.active ? 'Activo' : 'inactivo'}}
                                </v-chip>
                            </template>

                            <template v-slot:item.action="{ item }">

                                <router-link :to="`/guardar-usuario?id=${item.id}`" class="action-buttons">
                                    <v-icon size="small" color="blue" class="mr-2">
                                        mdi-pencil
                                    </v-icon>
                                </router-link>

                                <v-icon @click="set_item(item)" size="small" color="red">
                                    mdi-delete
                                </v-icon>

                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>

            </v-card-text>

        </v-card>

        <v-confirm v-on:delete="delete_user">
        </v-confirm>
    </v-container>
</template>

<script>
    import {
        user_service
    } from '@services/user_service.js'

    import {
        headers_mixin
    } from '../mixins/usuarios_headers.js'

    import {
        pagination_mixin
    } from '@mixins/pagination_mixin.js'

    import debounce from 'lodash/debounce'

    import omit from 'lodash/omit'

    export default {
        mixins: [pagination_mixin, headers_mixin],
        data() {
            return {
                item: {},
                items: [],
                query: {
                    search: null,
                },
            }
        },

        watch: {
            query: {
                immediate: true,
                deep: true,
                handler(query) {
                    this.debounceQuery(query)
                }
            }
        },

        created() {},

        methods: {
            next(page) {
                this.search_users(page, this.query)
            },

            delete_user() {
                user_service.delete_user(this.item.id).then(res => {
                    let index = this.items.findIndex(x => x.id == this.item.id)
                    if (index > -1) {
                        this.items.splice(index, 1)
                    }
                    this.$store.dispatch('success', 'Usuario eliminado con exito!')
                }, res => {
                    if (res.response.status == 301) {
                        return this.$store.dispatch('warning', res.response.data)
                    }
                })
            },

            set_item(item) {
                this.item = item
                this.$eventBus.emit('open', item)
            },

            search_users(page, query) {
                user_service.search_user(page, query).then(res => {
                    this.items = res.data.data
                    this.pagination = omit(res.data, 'data')
                }, res => {
                    this.$toast.error('Error consultando registro')
                })
            },

            debounceQuery: debounce(function(query) {
                this.search_users(1, query)
            }, 800),
        },

        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
        }
    }
</script>