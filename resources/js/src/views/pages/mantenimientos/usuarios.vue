<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Usuario.' },
            { title: 'Usuarios', active: true },
        ]">
        </vs-breadcrumb>
        <vx-card class="mt-4 p-4">
            <vs-table max-items="20" pagination search stripe :data="usuarios">
                <template slot="header">
                    <vs-button icon="description" class="p-2" color="primary" :to="{ name: 'mantenimientos-usuarios' }">
                        nuevo
                    </vs-button>
                </template>
                <template slot="thead">
                    <vs-th>Id</vs-th>
                    <vs-th>Foto</vs-th>
                    <vs-th>Nombre</vs-th>
                    <vs-th>Correo</vs-th>
                    <vs-th>Estado</vs-th>
                    <vs-th>Opciones</vs-th>
                </template>
                <template slot-scope="{data}">
                    <vs-tr :key="i" v-for="(val, i) in data">

                        <vs-td :data="val.id">
                            {{ val.id }}
                        </vs-td>

                        <vs-td :data="val.urlPhoto">
                            {{ val.urlPhoto }}
                        </vs-td>

                        <vs-td :data="val.name">
                            {{ val.name }}
                        </vs-td>

                        <vs-td :data="val.email">
                            {{ val.email }}
                        </vs-td>

                        <vs-td :data="val.estado">
                            <vs-chip :color="val.estado ? 'success' : 'danger'">
                                {{ val.estado ? 'Activo' : 'Inactivo' }}
                            </vs-chip>
                        </vs-td>

                        <vs-td>
                            <div class="vx-row">
                                <vs-button icon="edit" class="p-0 m-1" color="success"
                                    :to="{ name: 'mantenimientos-usuarios', params: { id: val.id } }" />
                                <vs-button icon="delete" class="p-0 m-1" color="danger" />
                            </div>
                        </vs-td>

                    </vs-tr>
                </template>
            </vs-table>
        </vx-card>
    </div>
</template>

<script>
export default {
    name: 'ZapecUsuarios',

    data() {
        return {
            usuarios: []
        };
    },

    mounted() {
        this.getUsuarios();
    },

    methods: {
        getUsuarios() {
            this.$vs.loading();
            this.$http.get('/api/usuarios')
                .then(response => {
                    this.usuarios = response.data;
                    this.$vs.loading.close();
                })
                .catch(error => {
                    this.$vs.loading.close();
                    this.$vs.notify({
                        title: 'Error',
                        text: 'Error al obtener los usuarios',
                        color: 'danger'
                    });
                });
        }
    },
};
</script>