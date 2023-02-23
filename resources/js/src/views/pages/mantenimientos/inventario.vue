<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Mant.' },
            { title: 'Inventario', active: true },
        ]" />
        <vx-card class="mt-4 p-4">
            <form-wizard color="rgba(var(--vs-primary), 1)" :title="null" :subtitle="null" finishButtonText="Cargar"
                next-button-text="Siguiente" @on-complete="formSubmitted">
                <tab-content title="Cargar Archivo" class="mb-5" icon="feather icon-upload">

                    <!-- tab 1 content -->
                    <div>
                        <div class="mb-8" v-if="!upload">
                            <import-excel :onSuccess="loadDataInTable" />
                        </div>
                        <div v-if="tableData.length && header.length">
                            <h2>Previsualización</h2>
                            <vs-table stripe pagination :max-items="50" search :data="tableData">
                                <template slot="header">
                                    <h4>{{ sheetName }}</h4>
                                </template>

                                <template slot="thead">
                                    <vs-th :sort-key="heading" v-for="heading in header" :key="heading">{{ heading
                                    }}</vs-th>
                                </template>

                                <template slot-scope="{data}">
                                    <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
                                        <vs-td :data="col" v-for="(col, indexcol) in data[indextr]" :key="indexcol + col">
                                            {{ col }}
                                        </vs-td>
                                    </vs-tr>
                                </template>
                            </vs-table>
                        </div>
                    </div>
                </tab-content>

                <!-- tab 2 content -->
                <tab-content title="Asignación" class="mb-5" icon="feather icon-grid">
                    <div v-if="upload">
                        <div class="vx-row flex justify-around">
                            <div class="vx-col w-1/4">
                                <b>Nombre de Columnas</b>
                            </div>
                            <div class="vx-col w-1/4">
                                <b>Asignar al campo</b>
                            </div>
                        </div>
                        <div class="vx-row flex justify-around" :key="heading" v-for="heading, i in header">
                            <div class="vx-col w-1/4">
                                <p class="p-4"> <b>{{ heading }}</b></p>
                            </div>
                            <div class="vx-col w-1/4">
                                <vs-select class="p-2" v-model="select[i]" :key="i">
                                    <vs-select-item :key="j" :value="option" :text="option" v-for="option,j in selectOptions"/>
                                </vs-select>
                            </div>
                        </div>
                    </div>
                </tab-content>

                <!-- tab 3 content -->
                <tab-content title="Cargar a Base" class="mb-5" icon="feather icon-database">
                    <div class="vx-row">

                    </div>
                </tab-content>
            </form-wizard>
        </vx-card>
    </div>
</template>

<script>
import ImportExcel from '@/components/excel/ImportExcel.vue'
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

export default {
    name: 'Inventario',
    components: {
        FormWizard,
        TabContent,
        ImportExcel
    },
    data() {
        return {
            tableData: [],
            header: [],
            sheetName: '',
            upload: false,
            document: null,
            select: [],
            selectOptions: [
                'sku',
                'externo',
                'producto',
                'grupo',
                'seccion',
                'clasificacion',
                'proveedor',
                'estilo',
                'color',
                'talla',
                'marca',
                'inventario_costo',
                'inventario_venta',
                'ultimo_movimiento',
                'ultima_venta',
                'ultima_recepcion',
            ]
        };
    },
    methods: {
        loadDataInTable(data) {
            this.header = data.header
            this.tableData = data.results
            this.sheetName = data.meta.sheetName
            this.document = data.document
            this.upload = true
            this.asignarOptions()
        },
        asignarOptions() {
            this.header.map((option, i) => {
                if(this.selectOptions[i]){
                    this.select[i] = this.selectOptions[i]
                }else{
                    this.select[i] = 'NO IMPORTAR'
                }
            })
        },
        formSubmitted() {
            console.log('form submitted');
        }
    },
};
</script>
