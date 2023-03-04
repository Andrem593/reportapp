<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Reportes.' },
            { title: 'Reportes Ventas', active: true },
        ]" />

        <vx-card class="my-3 p-4">
            <b>Filtros de Reporte</b>
            <div class="vx-row w-100 mt-3">
                <div class="vx-col sm:w-1/4 w-full mb-2">
                    <span>Rango de Fecha</span>
                    <div class="my-2">
                        <datepicker :language="es" placeholder="Fecha Inicio" v-model="filtros.fechaInicio"></datepicker>
                    </div>
                    <div class="my-2">
                        <datepicker :language="es" placeholder="Fecha Fin" v-model="filtros.fechaFin"></datepicker>
                    </div>
                </div>
                <div class="vx-col sm:w-1/4 w-full mb-2">
                    <span>Ciudades</span>
                    <div class="my-2">
                        <v-select multiple :closeOnSelect="false" class="w-full" v-model="filtros.ciudad"
                            :options="ciudades" label="ciudad" />
                    </div>
                </div>
                <div class="vx-col sm:w-1/4 w-full mb-2">
                    <span>Punto Operación</span>
                    <div class="my-2">
                        <v-select multiple :closeOnSelect="false" class="w-full" v-model="filtros.puntoOperacion"
                            :options="puntoOperaciones" label="punto_operacion" />
                    </div>
                </div>
                <div class="vx-col sm:w-1/4 w-full mb-2">
                    <span>Tiendas</span>
                    <div class="my-2">
                        <v-select multiple :closeOnSelect="false" class="w-full" v-model="filtros.tienda" :options="tiendas"
                            label="tienda" />
                    </div>
                </div>
            </div>

            <div class="vx-row w-100 mt-3">
                <div class="vx-col sm:w-1/4 w-full mb-2">
                    <vs-button @click="getReporteVentas" color="success" type="filled">
                        Generar Reporte
                    </vs-button>
                </div>
            </div>
            <vs-divider color="success" />

            <div>
                <vs-table max-items="20" pagination search stripe :data="data">
                    <template slot="thead">
                        <vs-th>Año</vs-th>
                        <vs-th>Tienda</vs-th>
                        <vs-th>Marca</vs-th>
                        <vs-th># Transaccion</vs-th>
                        <vs-th>Cant</vs-th>
                        <vs-th>Total</vs-th>
                        <vs-th>% Desc</vs-th>
                        <vs-th>% GM</vs-th>
                    </template>
                    <template slot-scope="{data}">
                        <vs-tr :key="i" v-for="(val, i) in data">

                            <vs-td :data="val.anio">
                                {{ val.anio }}
                            </vs-td>

                            <vs-td :data="val.tienda.tienda">
                                {{ val.tienda.tienda }}
                            </vs-td>

                            <vs-td :data="val.marca">
                                {{ val.marca }}
                            </vs-td>

                            <vs-td :data="val.transacciones_total">
                                {{ val.transacciones_total }}
                            </vs-td>
                            
                            <vs-td :data="val.cantidad">
                                {{ val.cantidad }}
                            </vs-td>
                            
                            <vs-td :data="val.total">
                                {{ '$'+val.total.toFixed(2) }}
                            </vs-td>

                            <vs-td :data="val.descuento_final">
                                {{ '%' + ((val.descuento_final / val.total) * 100).toFixed(2) }}
                            </vs-td>

                            <vs-td :data="val.sum_gm">
                                {{ val.sum_gm }}
                            </vs-td>

                        </vs-tr>
                    </template>
                </vs-table>
            </div>
        </vx-card>
    </div>
</template>
<script>
import Datepicker from "vuejs-datepicker";
import { es } from "vuejs-datepicker/dist/locale";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
    data() {
        return {
            filtros: {
                fechaInicio: "",
                fechaFin: "",
                ciudad: [],
                puntoOperacion: [],
                tienda: [],
            },
            es: es,
            ciudades: [],
            puntoOperaciones: [],
            tiendas: [],
            data: [],
        };
    },
    methods: {
        getTiendas() {
            this.$http.get('/api/tienda').then(response => {
                if (response.data.data.length > 0) {
                    this.tiendas = response.data.data;
                }
            })
        },
        getCiudades() {
            this.$http.get('/api/tienda-ciudades').then(resp => {
                this.ciudades = resp.data;
            })
        },
        getPuntoOperacion() {
            this.$http.get('/api/get-punto-operacion').then(resp => {
                this.puntoOperaciones = resp.data;
            })
        },
        getReporteVentas() {
            this.$http.post('/api/venta/reporte-ventas-marca', this.filtros).then(resp => {
                this.data = resp.data;
            }).catch(err => {
                this.$vs.notify({
                    title: 'Error',
                    text: 'Error al obtener los datos',
                    color: 'danger',
                    iconPack: 'feather',
                    icon: 'icon-alert-circle',
                    position: 'top-right'
                })
            })
        },
    },
    components: {
        Datepicker,
        "v-select": vSelect,
    },
    async mounted() {
        this.getTiendas();
        this.getCiudades();
        this.getPuntoOperacion();
    },
};
</script>
