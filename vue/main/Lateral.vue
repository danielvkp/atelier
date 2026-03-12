<template id="">
    <v-navigation-drawer app color="#1E88E5" dark>

        <v-list-item @click.stop="mini = !mini">
            <v-list-item-title>admin@admin.com</v-list-item-title>
        </v-list-item>

        <v-divider></v-divider>
        <v-list nav>
            <v-list-item to="/" link title="Inicio" prepend-icon="mdi-home"></v-list-item>
            <v-list-item to="/calendario-citas" link title="Citas" prepend-icon="mdi-calendar"></v-list-item>
            <v-list-item to="/lista-empleados" link title="Empleados" prepend-icon="mdi-account-switch"></v-list-item>
            <v-list-item to="/lista-compras" link title="Compras" prepend-icon="mdi-check-circle"></v-list-item>
            <v-list-item to="/lista-servicios" link title="Servicios" prepend-icon="mdi-shape-plus"></v-list-item>
            <v-list-item to="/lista-tarifas" link title="Tarifas" prepend-icon="mdi-collage"></v-list-item>
            <v-list-item to="/lista-productos" link title="PDF" prepend-icon="mdi-package-variant"></v-list-item>
            <v-list-item to="/lista-enlaces" link title="Links de pago" prepend-icon="mdi-link"></v-list-item>
            <v-list-item to="/lista-review" link title="Reseñas" prepend-icon="mdi-star"></v-list-item>
            <v-list-item to="/lista-categorias" link title="Categorias" prepend-icon="mdi-file-document-edit-outline"></v-list-item>
            <v-list-item to="/lista-blogs" link title="Blog" prepend-icon="mdi-folder-plus"></v-list-item>
            <v-list-item to="/lista-secciones" link title="Paginas" prepend-icon="mdi-file-document-edit-outline"></v-list-item>
            <v-list-item to="/legal" link title="Legal" prepend-icon="mdi-shield-check"></v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>


<script>
    export default {
        data() {
            return {
                mini: false,
                local_drawer: true,
            }
        },
    }
</script>

<style media="screen">
    .v-list-item--nav .v-list-item-title {
        font-size: 1rem;
    }
</style>