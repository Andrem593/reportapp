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
                    <vs-button icon="description" class="p-2" color="primary" @click="getDataTiendas">
                        nuevo
                    </vs-button>
                </template>
                <template slot="thead">
                    <vs-th>Id</vs-th>
                    <vs-th>Tienda</vs-th>
                    <vs-th>Provincia</vs-th>
                    <vs-th>Ciudad</vs-th>
                    <vs-th>Estado</vs-th>
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
        };
    },
    methods: {
        getDataTiendas() {
            this.$vs.loading();
            this.$http.get('/api/tienda').then(response => {
                this.$vs.loading.close();
                this.tiendas = response.data.data;
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
        }
    },
    mounted() {
        this.getDataTiendas();
    }
};
</script>
