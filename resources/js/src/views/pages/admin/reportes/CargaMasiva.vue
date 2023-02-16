<template>
    <div class="vx-col sm:m-0 m-4">
        <vx-card>
            <div slot="no-body" class="full-page-bg-color">
                <div class="vx-row no-gutter">
                    <div
                        class="vx-col sm:w-full md:w-full lg:w-1/2 self-center d-theme-dark-bg"
                    >
                        <div class="px-8 pt-8 register-tabs-container">
                            <div class="vx-card__title mb-4">
                                <h4 class="mb-4">Carga Masiva</h4>
                                <p>
                                    Seleccionar archivo excel para la carga
                                    masiva.
                                </p>

                                <vx-input-group class="mb-base">
                                    <vs-input v-model="input4" placeholder="Seleccionar Archivo"/>

                                    <template slot="append">
                                        <div class="append-text btn-addon">
                                            <vs-button
                                                color="primary"
                                                type="border"
                                                >Cargar Archivo</vs-button
                                            >
                                        </div>
                                    </template>
                                </vx-input-group>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </vx-card>
    </div>
</template>
