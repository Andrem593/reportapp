<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Mant.' },
            { title: 'Inventario', active: true },
        ]" />
        <vx-card class="my-3 p-4">
            <div class="flex justify-between">
                <div class="my-auto">
                    <b>Formato de Carga</b>
                </div>
                <div>
                    <vs-button type="filled" color="primary">
                        Descargar Formato
                    </vs-button>
                </div>
            </div>
        </vx-card>        
        <vx-card class="mt-4 p-4">
            <form-wizard color="rgba(var(--vs-primary), 1)" :title="null" :subtitle="null" finishButtonText="Finalizar"
                next-button-text="Siguiente" back-button-text="Atras" @on-complete="formSubmitted" @on-change="cargarData">
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

                <!-- tab 3 content -->
                <tab-content title="Cargar a Base" class="mb-5" icon="feather icon-database">
                    <div class="vx-row flex justify-center p-4">
                        <div class="vx-col w-1/2 p-2 mb-4 mt-4" v-if="charge">
                            <b>Importando datos</b>
                            <vs-progress indeterminate color="primary">primary</vs-progress>
                        </div>

                        <div class="vx-col w-1/2 p-2 mb-4 mt-4" v-else>
                            <statistics-card-line v-if="!error" hideChart class="p-4" icon="CheckIcon"
                                statisticTitle="Se Importó el archivo correctamente" statistic="Carga Completada"
                                color="success" />

                            <statistics-card-line v-else hideChart class="p-4" icon="AlertTriangleIcon"
                                statisticTitle="Ocurrió un error al importar el archivo" statistic="Carga Fallida"
                                color="danger" />
                        </div>
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
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'

export default {
    name: 'Inventario',
    components: {
        FormWizard,
        TabContent,
        ImportExcel,
        StatisticsCardLine
    },
    data() {
        return {
            tableData: [],
            header: [],
            sheetName: '',
            upload: false,
            charge: true,
            document: null,
            error: false,
        };
    },
    methods: {
        loadDataInTable(data) {
            this.header = data.header
            this.tableData = data.results
            this.sheetName = data.meta.sheetName
            this.document = data.document
            this.upload = true
        },
        cargarData() {
            if (this.document != null) {
                this.charge = true
                let formData = new FormData();
                formData.append("archivo_excel", this.document);
                this.$http.post('/api/inventario/carga', formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    }
                })
                    .then(response => {
                        this.charge = false
                        if(response.status == 500){
                            this.error = true
                        }
                    })
                    .catch(error => {
                        this.charge = false
                        this.error = true
                        console.log(error);
                    });
            }
        },
        formSubmitted() {
            this.tableData = [],
                this.header = [],
                this.sheetName = '',
                this.upload = false,
                this.document = null,
                this.$router.push({ name: 'home' })
        }
    },
};
</script>
