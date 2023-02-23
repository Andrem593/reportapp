<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Mant.' },
            { title: 'Tienda', active: true },
        ]">
        </vs-breadcrumb>

        <vx-card class="mt-4 p-4">
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/3 w-full">
                    <span>Nombre de Tienda</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <vs-input class="w-full" icon-pack="feather" icon="icon-shopping-bag" v-model="tienda" />
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/3 w-full">
                    <span>Provincia</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <vs-input class="w-full" icon-pack="feather" icon="icon-map" v-model="provincia" />
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/3 w-full">
                    <span>Ciudad</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <vs-input class="w-full" icon-pack="feather" icon="icon-map-pin"  v-model="ciudad" />
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/3 w-full">
                    <span>Estado</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <vs-switch v-model="estado">
                        <span slot="on">Activo</span>
                        <span slot="off">Inactivo</span>
                    </vs-switch>
                </div>
            </div>
            <div class="vx-row mb-6">
            </div>
            <div class="vx-row">
                <div class="vx-col sm:w-2/3 w-full ml-auto">
                    <vs-button class="mr-3 mb-2" @click="validate">Guardar</vs-button>
                    <vs-button color="warning" type="border" class="mb-2"
                        @click="tienda = provincia = ciudad = ''; estado = true;">Borrar</vs-button>
                </div>
            </div>
        </vx-card>
    </div>
</template>

<script>
export default {
    name: 'TiendaForm',
    data() {
        return {
            id: '',
            tienda: '',
            provincia: '',
            ciudad: '',            
            estado: true,
        };
    },
    methods: {
        validate(){
            if(this.id == ''){
                this.nuevo();
            }else{
                this.edit();
            }
        },
        nuevo(){
            this.$vs.loading();
            this.$http.post('/api/tienda', {
                tienda: this.tienda,
                provincia: this.provincia,
                ciudad: this.ciudad,
                estado: this.estado,
            }).then(response => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Tienda',
                    text: 'Se ha guardado correctamente',
                    color: 'success',
                });
                this.$router.push({ name: 'mantenimientos-tiendas' });
            }).catch(error => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Tienda',
                    text: 'Ha ocurrido un error',
                    color: 'danger',
                });
            });
        },
        edit(){
            this.$vs.loading();
            this.$http.put('/api/tienda/'+this.id, {
                tienda: this.tienda,
                provincia: this.provincia,
                ciudad: this.ciudad,
                estado: this.estado,
            }).then(response => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Tienda',
                    text: 'Se ha guardado correctamente',
                    color: 'success',
                });
                this.$router.push({ name: 'mantenimientos-tiendas' });
            }).catch(error => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Tienda',
                    text: 'Ha ocurrido un error',
                    color: 'danger',
                });
            });
        },
        async getTienda(){
            this.$vs.loading();
            await this.$http.get('/api/tienda/'+this.id).then(response => {
                this.$vs.loading.close();
                this.tienda = response.data.tienda;
                this.provincia = response.data.provincia;
                this.ciudad = response.data.ciudad;
                this.estado = response.data.estado;
            }).catch(error => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Tienda',
                    text: 'Ha ocurrido un error',
                    color: 'danger',
                });
            });
        }
    },
    async mounted() {
    if (this.$route.params.id) {
        this.id = this.$route.params.id;   
        await this.getTienda();   
    }
  },
};
</script>



