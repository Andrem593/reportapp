<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Reportes.' },
            { title: 'Reportes Ventas', active: true },
        ]" />
        <vx-card class="my-3 p-4" title="Reporte de Ventas Por Punto de Operación " title-color="primary">
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
                    <vs-button @click="getReporteVentas" color="primary" type="filled">
                        Generar Reporte
                    </vs-button>
                </div>
            </div>
            <vs-divider color="primary" />

            <div class="vx-row w-full" v-if="data.length > 0 && anios.length > 0">
                <div class="w-full" v-for="anio in anios">
                    <vs-card class="w-full">
                        <div slot="header">
                            <b> {{ anio.year }}</b>
                        </div>
                        <vs-table stripe :data="data">
                            <template slot="thead" class="bg-cyan-500">
                                <vs-th>Tienda</vs-th>
                                <vs-th>Punto Operación</vs-th>
                                <vs-th># Transaccion</vs-th>
                                <vs-th>Cant</vs-th>
                                <vs-th>Total</vs-th>
                                <vs-th>% Desc</vs-th>
                                <vs-th>% GM</vs-th>
                                <vs-th>Ticket Promedio</vs-th>
                            </template>
                            <template slot-scope="{data}">
                                <vs-tr :key="i" v-for="(val, i) in data" v-if="data[i].year == anio.year">

                                    <vs-td :data="val.tienda.tienda">
                                        {{ val.tienda.tienda }}
                                    </vs-td>

                                    <vs-td :data="val.punto_operacion">
                                        {{ val.punto_operacion }}
                                    </vs-td>

                                    <vs-td :data="val.transacciones_total">
                                        {{ val.transacciones_total }}
                                    </vs-td>

                                    <vs-td :data="val.cantidad">
                                        {{ val.cantidad }}
                                    </vs-td>

                                    <vs-td :data="val.total">
                                        {{ '$ ' + val.total.toFixed(2) }}
                                    </vs-td>

                                    <vs-td :data="val.descuento_final">
                                        {{ ((val.descuento_final / val.total) * 100).toFixed(2) + '%' }}
                                    </vs-td>

                                    <vs-td :data="val.prom_gm">
                                        {{ (val.prom_gm * 100).toFixed(2) + '%' }}
                                    </vs-td>

                                    <vs-td>
                                        {{ '$ ' + (val.total / val.transacciones_total).toFixed(2) }}
                                    </vs-td>

                                </vs-tr>
                            </template>
                        </vs-table>
                    </vs-card>
                </div>
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
    name: 'ZapecReportesVentasOperacion',

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
            anios: [],
        };
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
            this.$vs.loading();
            this.$http.post('/api/venta/reporte-ventas-operacion', this.filtros).then(resp => {
                this.$vs.loading.close();
                this.anios = resp.data.anios;
                this.data = resp.data.ventas;
            })
                .catch(err => {
                    this.$vs.loading.close();
                    this.$vs.notify({
                        title: 'Error',
                        text: 'Error al obtener los datos',
                        color: 'danger',
                        iconPack: 'feather',
                        icon: 'icon-alert-circle',
                        position: 'top-right'
                    })
                })
        }
    },
};
</script>
