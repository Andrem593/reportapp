<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Reportes.' },
            { title: 'Reportes Ventas', active: true },
        ]" />

        <vx-card class="my-3 p-4" title="Reporte de Inventario" title-color="primary">
            <b>Filtros de Reporte</b>
            <div class="vx-row w-100 mt-3">
                <div class="vx-col sm:w-1/4 w-full mb-2">
                    <span>Ciudades</span>
                    <div class="my-2">
                        <v-select multiple :closeOnSelect="false" class="w-full" v-model="filtros.ciudad"
                            :options="ciudades" label="ciudad" />
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
                    <vs-button @click="getInventario" color="primary" type="filled">
                        Generar Reporte
                    </vs-button>
                </div>
            </div>
            <vs-divider color="primary" />

            <div v-if="visible">
                <vs-table max-items="20" pagination search stripe :data="data">
                    <template slot="thead">                       
                            <th class="text-center">Marca</th>
                            <th class="text-center" v-for="(val, i) in headersTable"  :key="i">
                                {{val}}
                            </th>
                            <th class="text-center">Costo Total</th>
                    </template>
                    <template slot-scope="{data}">
                        <vs-tr :key="i" v-for="(val, i) in data">
                            <vs-td class="text-center" :data="val.marca">
                                {{ val.marca }}
                            </vs-td>                            
                            <vs-td class="text-center" :data="val[val2]" v-for="(val2, i2) in headersTable" :key="i2">
                                {{ val[val2] }}
                            </vs-td>
                            <vs-td class="text-center" :data="val.costo_total">
                                {{ '$ '+ val.costo_total.toFixed(2) }}
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
    name: 'ZapecReportesInventario',

    data() {
        return {
            filtros: {
                ciudad: [],
                tienda: [],
            },
            es: es,
            ciudades: [],
            tiendas: [],
            data: [],
            visible: false,
            headersTable : [],
            marcas: [],
        };
    },
    components: {
        Datepicker,
        "v-select": vSelect,
    },
    async mounted() {
        this.getTiendas();
        this.getCiudades();
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
        getInventario(){
            this.$http.post('/api/inventario/reporte-existencias', this.filtros).then(resp => {
                this.processData(resp.data);
                this.visible = true;
            })
        },
        processData(data) {            
            let tiendas = [];
            let marcas = [];
            let newData = [];
            data.map((val, i) => {
                if (tiendas.indexOf(val.nombre_tienda) == -1){
                    tiendas.push(val.nombre_tienda);
                }
            });
            
            data.map((val, i) => {
                if (marcas.indexOf(val.marca) == -1){
                    marcas.push(val.marca);
                }
            });

            marcas.map((val, i) => {
                let obj = {
                    marca: val,         
                    costo_total: 0,           
                };
                tiendas.map((val2, i2) => {
                    data.map((val3, i3) => {
                        if (val3.marca == val && val3.nombre_tienda == val2){
                            obj[val2] = val3.cantidad;
                            obj.costo_total = val3.costo;
                        }
                    });
                });
                newData.push(obj);
            });

            
            this.data = newData;
            this.marcas = marcas;
            this.headersTable = tiendas;
        },
    },
};
</script>