<template>
    <div class="vx-col sm:m-0 m-4">
        <vx-card>
            <div slot="no-body" class="full-page-bg-color">
                <div class="vx-row no-gutter">
                    <div
                        class="vx-col sm:w-full md:w-full lg:w-full self-center d-theme-dark-bg"
                    >
                        <div class="px-8 pt-8 register-tabs-container">
                            <div class="vx-card__title mb-4">
                                <h4 class="mb-4">Carga Masiva</h4>
                                <p>
                                    Seleccionar archivo excel para la carga
                                    masiva.
                                </p>

                                <!-- <form id="frm_inventario"> -->
                                <vx-input-group class="mb-base">
                                    <vs-input
                                        type="file"
                                        name="file"
                                        ref="file"
                                        @change="handleFileUpload"
                                        accept=".XLSX, .XLS, .CSV"
                                    />

                                    <template slot="append">
                                        <div class="append-text btn-addon">
                                            <vs-button
                                                color="primary"
                                                type="border"
                                                
                                                @click.prevent="CargarExcel"
                                                >Cargar Archivo</vs-button
                                            >
                                        </div>
                                    </template>
                                </vx-input-group>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </vx-card>
    </div>
</template>
<script>
export default {
    components: {},
    data() {
        return {
            file: "",
        };
    },
    created() {},
    methods: {
        async CargarExcel() {
            // let datos = new FormData();
            // datos.append('archivo_excel', this.$refs.file.files[0]);

            this.$vs.loading();

            let formData = new FormData();
            formData.append("archivo_excel", this.file);

            // let $mainFormInventario = $('#frm_inventario');
            // let data = new FormData($mainFormInventario);

            this.$http
                .post("api/inventario/cargar-excel", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(async response => {
                    console.log(response);
                    this.$vs.loading.close()
                    this.$swal({
                        title: "Carga excel",
                        text: "Se cargaron los datos correctamente",
                        icon: "success",
                        confirmButtonText: "Ok",
                    });
                })
                .catch(err => {
                    this.$vs.loading.close()
                });
        },
        handleFileUpload() {
            // console.log();
            // console.log(this.$refs.file.files[0]);
            this.file = document.querySelector("input[type=file]").files[0];
        },
    },
};
</script>
