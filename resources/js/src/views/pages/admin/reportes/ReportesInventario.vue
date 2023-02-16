<!-- =========================================================================================
    File Name: AgGridTable.vue
    Description: Ag Grid table
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div id="ag-grid-demo" class="mb-4">

        <vx-card>
            <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row no-gutter">
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 self-center d-theme-dark-bg" >
                            <div class="px-8 pt-8 register-tabs-container">
                                <div class="vx-card__title mb-4">
                                    <h4 class="mb-4">Reporte - Existencia de Inventario</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- TABLE ACTION ROW -->
            <div class="flex flex-wrap justify-between items-center">
                <!-- ITEMS PER PAGE -->
                <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
                    <vs-dropdown vs-trigger-click class="cursor-pointer">
                        <div
                            class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
                        >
                            <span class="mr-2"
                                >{{
                                    currentPage * paginationPageSize -
                                    (paginationPageSize - 1)
                                }}
                                -
                                {{
                                    contacts.length -
                                        currentPage * paginationPageSize >
                                    0
                                        ? currentPage * paginationPageSize
                                        : contacts.length
                                }}
                                de {{ contacts.length }}</span
                            >
                            <feather-icon
                                icon="ChevronDownIcon"
                                svgClasses="h-4 w-4"
                            />
                        </div>
                        <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
                        <vs-dropdown-menu>
                            <vs-dropdown-item
                                @click="gridApi.paginationSetPageSize(20)"
                            >
                                <span>20</span>
                            </vs-dropdown-item>
                            <vs-dropdown-item
                                @click="gridApi.paginationSetPageSize(50)"
                            >
                                <span>50</span>
                            </vs-dropdown-item>
                            <vs-dropdown-item
                                @click="gridApi.paginationSetPageSize(100)"
                            >
                                <span>100</span>
                            </vs-dropdown-item>
                            <vs-dropdown-item
                                @click="gridApi.paginationSetPageSize(150)"
                            >
                                <span>150</span>
                            </vs-dropdown-item>
                        </vs-dropdown-menu>
                    </vs-dropdown>
                </div>

                <!-- TABLE ACTION COL-2: SEARCH & EXPORT AS CSV -->
                <div
                    class="flex flex-wrap items-center justify-between ag-grid-table-actions-right"
                >
                    <vs-input
                        class="mb-4 md:mb-0 mr-4"
                        v-model="searchQuery"
                        @input="updateSearchQuery"
                        placeholder="Buscar..."
                    />
                    <vs-button
                        class="mb-4 md:mb-0"
                        @click="gridApi.exportDataAsCsv()"
                        >Exportar XLS</vs-button
                    >
                </div>
            </div>
            <ag-grid-vue
                ref="agGridTable"
                :gridOptions="gridOptions"
                class="ag-theme-material w-100 my-4 ag-grid-table"
                :columnDefs="columnDefs"
                :defaultColDef="defaultColDef"
                :rowData="contacts"
                rowSelection="multiple"
                colResizeDefault="shift"
                :animateRows="true"
                :floatingFilter="true"
                :pagination="true"
                :paginationPageSize="paginationPageSize"
                :suppressPaginationPanel="true"
                :enableRtl="$vs.rtl"
            >
            </ag-grid-vue>
            <vs-pagination
                :total="totalPages"
                :max="maxPageNumbers"
                v-model="currentPage"
            />
        </vx-card>
    </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import contacts from "./data.json";

import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";

export default {
    components: {
        AgGridVue,
    },
    data() {
        return {
            searchQuery: "",
            gridOptions: {},
            maxPageNumbers: 7,
            gridApi: null,
            defaultColDef: {
                sortable: true,
                editable: true,
                resizable: true,
                suppressMenu: true,
            },
            columnDefs: [
                {
                    headerName: "SKU",
                    field: "sku",
                    width: 100,
                    filter: true,
                    // checkboxSelection: true,
                    // headerCheckboxSelectionFilteredOnly: true,
                    // headerCheckboxSelection: true,
                },
                {
                    headerName: "Externo",
                    field: "externo",
                    filter: true,
                    width: 150,
                },
                {
                    headerName: "Producto",
                    field: "producto",
                    filter: true,
                    width: 250,
                    // pinned: "left",
                },
                {
                    headerName: "Grupo",
                    field: "grupo",
                    filter: true,
                    width: 150,
                },
                {
                    headerName: "Seccion",
                    field: "seccion",
                    filter: true,
                    width: 200,
                },
                {
                    headerName: "Clasificación",
                    field: "clasificacion",
                    filter: true,
                    width: 200,
                },
                {
                    headerName: "Proveedor",
                    field: "proveedor",
                    filter: true,
                    width: 150,
                },
                {
                    headerName: "Estilo",
                    field: "estilo",
                    filter: true,
                    width: 175,
                },
                {
                    headerName: "Color",
                    field: "color",
                    filter: true,
                    width: 125,
                },
                {
                    headerName: "Talla",
                    field: "talla",
                    filter: true,
                    width: 125,
                },
                {
                    headerName: "Marca",
                    field: "marca",
                    filter: true,
                    width: 125,
                },
                {
                    headerName: "Costo",
                    field: "costo",
                    filter: true,
                    width: 100,
                },
                {
                    headerName: "Venta",
                    field: "venta",
                    filter: true,
                    width: 100,
                },
                {
                    headerName: "Último Movimiento",
                    field: "ultimo-movimiento",
                    filter: true,
                    width: 175,
                },
                {
                    headerName: "Última Venta",
                    field: "ultima-venta",
                    filter: true,
                    width: 175,
                },
                {
                    headerName: "Última Recepción",
                    field: "ultima-recepcion",
                    filter: true,
                    width: 175,
                },
                {
                    headerName: "MC DETAL - DPISAR GP",
                    field: "gp",
                    filter: true,
                    width: 100,
                },
                {
                    headerName: "MC DETAL - DPISAR D",
                    field: "d",
                    filter: true,
                    width: 100,
                },
            ],
            contacts,
        };
    },
    watch: {
        "$store.state.windowWidth"(val) {
            if (val <= 576) {
                this.maxPageNumbers = 4;
                this.gridOptions.columnApi.setColumnPinned("email", null);
            } else this.gridOptions.columnApi.setColumnPinned("email", "left");
        },
    },
    computed: {
        paginationPageSize() {
            if (this.gridApi) return this.gridApi.paginationGetPageSize();
            else return 50;
        },
        totalPages() {
            if (this.gridApi) return this.gridApi.paginationGetTotalPages();
            else return 0;
        },
        currentPage: {
            get() {
                if (this.gridApi)
                    return this.gridApi.paginationGetCurrentPage() + 1;
                else return 1;
            },
            set(val) {
                this.gridApi.paginationGoToPage(val - 1);
            },
        },
    },
    methods: {
        updateSearchQuery(val) {
            this.gridApi.setQuickFilter(val);
        },
    },
    mounted() {
        this.gridApi = this.gridOptions.api;

        /* =================================================================
      NOTE:
      Header is not aligned properly in RTL version of agGrid table.
      However, we given fix to this issue. If you want more robust solution please contact them at gitHub
    ================================================================= */
        if (this.$vs.rtl) {
            const header = this.$refs.agGridTable.$el.querySelector(
                ".ag-header-container"
            );
            header.style.left = `-${String(
                Number(header.style.transform.slice(11, -3)) + 9
            )}px`;
        }
    },
};
</script>
