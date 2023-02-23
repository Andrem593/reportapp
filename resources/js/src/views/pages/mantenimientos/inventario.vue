<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Mant.' },
            { title: 'Inventario', active: true },
        ]" />
        <vx-card class="mt-4 p-4">
            <form-wizard color="rgba(var(--vs-primary), 1)" :title="null" :subtitle="null" finishButtonText="Submit"
                @on-complete="formSubmitted">
                <tab-content title="Cargar Archivo" class="mb-5" icon="feather icon-upload">

                    <!-- tab 1 content -->
                    <div>
                        <div class="mb-8">
                            <import-excel :onSuccess="loadDataInTable" />
                        </div>
                        <div v-if="tableData.length && header.length">
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
                <tab-content title="Step 2" class="mb-5">
                    <div class="vx-row">

                    </div>
                </tab-content>

                <!-- tab 3 content -->
                <tab-content title="Step 3" class="mb-5">
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
            sheetName: ''
        };
    },
    methods: {
        loadDataInTable({ results, header, meta }) {
            this.header = header
            this.tableData = results
            this.sheetName = meta.sheetName
        }
    },
};
</script>
