<template id="">
    <v-container>
        <v-card>
            <v-toolbar flat color="blue" class="white--text">
                <v-btn to="/" icon text>
                    <v-icon small class="white--text">mdi-home</v-icon>
                </v-btn>
                <v-toolbar-title>
                    <h3 class="font-weight-light">Mudanzas</h3>
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>

                <v-row dense>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="query.search" color="blue" density="compact" variant="outlined" hide-details outlined small dense label="Busqueda"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-select v-model="query.comercial_id" :items="comerciales" outlined small dense label="Comercial" item-title="name" item-value="id"></v-select>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-select v-model="query.status" :items="estado_mudanza" outlined small dense label="Estado" hide-details></v-select>
                    </v-col>



                </v-row>

                <v-row dense class="mt-0">
                    <v-col cols="12" md="4">
                        <v-btn to="/guardar-cliente" class="mt-1 white--text" color="blue">
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

                            <template v-slot:item.comercial="{ item }">
                                <v-chip v-if="!item.comercial" color="red">N/A</v-chip>
                                <span v-else>{{item.comercial}}</span>

                            </template>

                            <template v-slot:item.id="{ item }">
                                <span :class="toUpper(item.seguimiento) == 'NUEVO' ? 'text-green' : 'text-grey-darken-1'">
                                    <strong>{{item.id}}</strong>
                                </span>
                            </template>


                            <template v-slot:item.fecha_mudanza="{ item }">
                                <span>
                                    {{ formatDate(item.fecha_mudanza)}}
                                </span>
                            </template>


                            <template v-slot:item.active="{item}">
                                <v-chip size="small" variant="flat" :color="item.active ? 'green' : 'red lighten-1'">
                                    {{item.active ? 'Activo' : 'inactivo'}}
                                </v-chip>
                            </template>

                            <template #item.action="{ item }">

                                <router-link :to="`/guardar-cliente?id=${item.cliente_id}`" class="action-buttons">
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
    import moment from 'moment'

    import {
        user_service
    } from '@services/user_service.js'

    import {
        mudanza_service
    } from '@services/mudanza_service.js'

    import {
        headers_mixin
    } from '../mixins/mudanza_headers.js'

    import {
        pagination_mixin
    } from '@mixins/pagination_mixin.js'

    import {
        status_mixin
    } from '@mixins/status_mixin.js'

    import debounce from 'lodash/debounce'

    import omit from 'lodash/omit'

    export default {
        mixins: [pagination_mixin, headers_mixin, status_mixin],
        data() {
            return {
                comerciales: [],
                item: {},
                items: [],
                query: {
                    search: null,
                    status: 'Pendiente',
                    comercial_id: null
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

        created() {
            this.seguimiento.unshift('')
            this.getUsersByRole('comercial')
        },

        methods: {
            formatDate(date) {
                return moment(date).format('DD-MM-YYYY')
            },

            toUpper(seguimiento) {
                return `${seguimiento}`.toUpperCase()
            },

            next(page) {
                this.search_users(page, this.query)
            },
            getUsersByRole(role) {
                user_service.get_users_by_role(role).then(res => {
                    this.comerciales = res.data
                    this.comerciales.unshift({
                        name: '',
                        id: null
                    })
                }, res => {
                    this.$store.dispatch('error', 'Error cargando comerciales')
                })
            },

            /*  delete_user() {
                  potencial_service.delete_potencial(this.item.id).then(res => {
                      let index = this.items.findIndex(x => x.id == this.item.id)
                      if (index > -1) {
                          this.items.splice(index, 1)
                      }
                      this.$store.dispatch('success', 'Cliente eliminado con exito!')
                  }, res => {
                      if (res.response.status == 301) {
                          return this.$store.dispatch('warning', res.response.data)
                      }
                  })
              },*/

            set_item(item) {
                this.item = item
                this.$eventBus.emit('open', item)
            },

            search_mudanzas(page, query) {
                mudanza_service.search_mudanzas(page, query).then(res => {
                    this.items = res.data.data
                    this.pagination = res.data.meta
                }, res => {
                    this.$toast.error('Error consultando registro')
                })
            },



            debounceQuery: debounce(function(query) {
                this.search_mudanzas(1, query)
                /*^3.8.11*/
            }, 800),
        },

        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
        }
    }
</script>