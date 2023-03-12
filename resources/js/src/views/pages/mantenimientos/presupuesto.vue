<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Mant.' },
            { title: 'Presupuesto', active: true },
        ]">
        </vs-breadcrumb>
        <vx-card class="my-3" title="Creación de Presupuesto" title-color="primary">
            <div class="vx-row mb-6 mt-4">
                <div class="vx-col sm:w-1/3 w-full my-auto">
                    <span>Escoger Tienda</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <v-select class="w-full" placeholder="Tiendas" v-model="tienda" :options="tiendas" label="tienda" value="id" />
                </div>
            </div>
            <div class="vx-row mb-6 mt-4">
                <div class="vx-col sm:w-1/3 w-full my-auto">
                    <span>Asignar Presupueto</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <vs-input class="w-full" type="number" icon-pack="feather" icon="icon-dollar-sign"
                        v-model="presupuesto" />
                </div>
            </div>
            <div class="vx-row mb-6 mt-4">
                <div class="vx-col sm:w-1/3 w-full my-auto">
                    <span>Duración de Presupueto</span>
                </div>
                <div class="vx-col sm:w-1/3 w-full">
                    <datepicker :language="es" placeholder="Fecha de inicio" range v-model="inicio"></datepicker>
                </div>
                <div class="vx-col sm:w-1/3 w-full">
                    <datepicker :language="es" placeholder="Fecha de finalización" range v-model="fin"></datepicker>
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col sm:w-2/3 w-full ml-auto">
                    <vs-button class="mr-3 mb-2" @click="save_presupuesto">Guardar</vs-button>
                </div>
            </div>
        </vx-card>
        <vs-divider />
        <vx-card title="Presupuestos Activos" title-color="success"
            subtitle="Presupuesto que estan dentro del rango de fecha">
            <vs-table max-items="20" pagination search stripe :data="presupuestos">
                <template slot="thead">
                    <vs-th>Tienda</vs-th>
                    <vs-th>Presupuesto</vs-th>
                    <vs-th>inicio</vs-th>
                    <vs-th>fin</vs-th>
                    <vs-th>Estado</vs-th>
                    <vs-th>Acciones</vs-th>
                </template>
                <template slot-scope="{data}">
                    <vs-tr :key="i" v-for="(val, i) in presupuestos">
                        <vs-td>{{ val.tienda.tienda }}</vs-td>
                        <vs-td>$ {{ val.presupuesto }}</vs-td>
                        <vs-td>{{ val.fecha_inicio }}</vs-td>
                        <vs-td>{{ val.fecha_fin }}</vs-td>
                        <vs-td>
                            <vs-button v-if="val.estado == 1" type="filled" color="success" size="small">Activo</vs-button>
                            <vs-button v-else type="filled" color="danger" size="small">Inactivo</vs-button>
                        </vs-td>
                        <vs-td>
                            <vs-button type="filled" color="warning" size="small" @click="getPresupuesto(val.id)">Editar</vs-button>
                            <vs-button type="filled" color="danger" size="small" @click="deletePresupuesto(val.id)">Eliminar</vs-button>
                        </vs-td>
                    </vs-tr>
                </template>
            </vs-table>
        </vx-card>
    </div>
</template>

<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Datepicker from "vuejs-datepicker";
import { es } from "vuejs-datepicker/dist/locale";

export default {
    name: 'ZapecPresupuesto',

    data() {
        return {
            es: es,
            presupuesto: '',
            id : null,
            tiendas: [],
            tienda: '',
            inicio: '',
            fin: '',
            presupuestos: [],
        };
    },

    mounted() {
        this.getTiendas();
        this.getPresupuestos();
    },
    components: {
        Datepicker,
        "v-select": vSelect,
    },
    methods: {
        getTiendas() {
            this.$http.get('/api/tienda').then(response => {
                if (response.data.data.length > 0) {
                    this.tiendas = response.data.data;
                }
            })
        },
        save_presupuesto() {
            if(this.id != null){
                this.updatePresupuesto();
            }else{                
                this.$vs.loading();
                this.$http.post('/api/presupuesto', {
                    tienda_id: this.tienda.id,
                    presupuesto: this.presupuesto,
                    fecha_inicio: this.inicio,
                    fecha_fin: this.fin,
                }).then(response => {
                    this.clearData();
                    this.getPresupuestos();
                    this.$vs.notify({
                        title: 'Presupuesto',
                        text: 'Presupuesto creado correctamente',
                        color: 'success',
                    });
                }).catch(error => {
                    this.$vs.notify({
                        title: 'Error',
                        text: error.response.data.message,
                        color: 'danger',
                    });
                }).finally(() => {
                    this.$vs.loading.close();
                });
            }
        },
        updatePresupuesto(){
            this.$vs.loading();
            this.$http.put('/api/presupuesto/' + this.id, {
                tienda_id: this.tienda.id,
                presupuesto: this.presupuesto,
                fecha_inicio: this.inicio,
                fecha_fin: this.fin,
            }).then(response => {
                this.clearData();
                this.getPresupuestos();
                this.$vs.notify({
                    title: 'Presupuesto',
                    text: 'Presupuesto actualizado correctamente',
                    color: 'success',
                });
            }).catch(error => {
                this.$vs.notify({
                    title: 'Error',
                    text: error.response.data.message,
                    color: 'danger',
                });
            }).finally(() => {
                this.$vs.loading.close();
            });
        },
        clearData() {
            this.id = null;
            this.presupuesto = '';
            this.tienda = '';
            this.inicio = '';
            this.fin = '';
        },
        getPresupuestos() {
            this.$http.get('/api/presupuesto').then(response => {
                this.presupuestos = response.data;
            })
        },
        getPresupuesto(id) {
            this.$http.get('/api/presupuesto/' + id).then(response => {
                this.id = response.data.id;
                this.tienda = response.data.tienda;
                this.presupuesto = response.data.presupuesto;
                this.inicio = response.data.fecha_inicio;
                this.fin = response.data.fecha_fin;
            })
        },
        deletePresupuesto(id) {
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
                    this.$http.delete('/api/presupuesto/' + id).then(response => {
                        this.getPresupuestos();
                        this.$vs.notify({
                            title: 'Presupuesto',
                            text: 'Presupuesto eliminado correctamente',
                            color: 'success',
                        });
                    }).catch(error => {
                        this.$vs.notify({
                            title: 'Error',
                            text: error.response.data.message,
                            color: 'danger',
                        });
                    }).finally(() => {
                        this.$vs.loading.close();
                    });
                }
            })
        }
    },
};
</script>