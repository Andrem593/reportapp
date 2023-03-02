<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Mant.' },
            { title: 'Tiendas', active: true },
        ]">
        </vs-breadcrumb>

        <vx-card class="mt-4 p-4">
            <vs-table max-items="20" pagination search stripe :data="tiendas">
                <template slot="header">
                    <vs-button icon="description" class="p-2" color="primary" :to="{ name: 'mantenimientos-tienda' }">
                        nuevo
                    </vs-button>
                </template>
                <template slot="thead">
                    <vs-th>Id</vs-th>
                    <vs-th>Tienda</vs-th>
                    <vs-th>Provincia</vs-th>
                    <vs-th>Ciudad</vs-th>
                    <vs-th>Estado</vs-th>
                    <vs-th>Opciones</vs-th>
                </template>
                <template slot-scope="{data}">
                    <vs-tr :key="i" v-for="(val, i) in data">

                        <vs-td :data="val.id">
                            {{ val.id }}
                        </vs-td>

                        <vs-td :data="val.tienda">
                            {{ val.tienda }}
                        </vs-td>

                        <vs-td :data="val.provincia">
                            {{ val.provincia }}
                        </vs-td>

                        <vs-td :data="val.ciudad">
                            {{ val.ciudad }}
                        </vs-td>

                        <vs-td :data="val.estado">
                            <vs-chip :color="val.estado ? 'success' : 'danger'">
                                {{ val.estado ? 'Activo' : 'Inactivo' }}
                            </vs-chip>
                        </vs-td>

                        <vs-td>
                            <div class="vx-row">
                                <vs-button icon="edit" class="p-0 m-1" color="success"
                                    :to="{ name: 'mantenimientos-tienda', params: { id: val.id } }" />
                                <vs-button icon="delete" class="p-0 m-1" color="danger" @click="deleteTienda(val.id)" />
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
    name: "Tiendas",

    data() {
        return {
            tiendas: [],
            modalTienda: false
        };
    },
    methods: {
        getDataTiendas() {
            this.$vs.loading();
            this.$http.get('/api/tienda').then(response => {
                if (response.data.data.length > 0) {                
                    this.tiendas = response.data.data;
                }
                this.$vs.loading.close();
            }).catch(error => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Error',
                    text: 'Error al cargar los datos',
                    color: 'danger',
                    iconPack: 'feather',
                    icon: 'icon-alert-circle'
                });
            });
        },
        deleteTienda(id) {
            this.$swal.fire({
                title: 'Estas Seguro de Eliminar',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7367F0',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$vs.loading();
                    this.$http.delete('/api/tienda/' + id).then(response => {
                        this.$vs.loading.close();
                        this.$vs.notify({
                            title: 'Exito',
                            text: 'Tienda eliminada',
                            color: 'success',
                            iconPack: 'feather',
                            icon: 'icon-check'
                        });
                        this.getDataTiendas();
                    }).catch(error => {
                        this.$vs.loading.close();
                        this.$vs.notify({
                            title: 'Error',
                            text: 'Error al eliminar la tienda',
                            color: 'danger',
                            iconPack: 'feather',
                            icon: 'icon-alert-circle'
                        });
                    });
                }
            })
        }
    },
    mounted() {
        this.getDataTiendas();
    }
};
</script>
