<template>
    <div>
        <vs-breadcrumb :items="[
            { title: 'Home', url: '/' },
            { title: 'Usuario.' },
            { title: 'Usuario', active: true },
        ]">
        </vs-breadcrumb>

        <vx-card class="mt-4 p-4" title="Registro de Usuario">
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/3 w-full">
                    <span>Foto</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <div class="vx-row">
                        <vs-avatar size="100px" :src="urlImage" />
                        <vs-button class="ml-2 mt-2" @click="popupActivo = true" icon-pack="feather" icon="icon-camera" />
                        <vs-button class="ml-2 mt-2" icon-pack="feather" icon="icon-trash" color="danger"
                            @click="deleteImage" />
                    </div>
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/3 w-full">
                    <span>Nombre de Usuario</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <vs-input class="w-full" icon-pack="feather" icon="icon-user" v-model="name" />
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/3 w-full">
                    <span>Email</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <vs-input type="email" class="w-full" icon-pack="feather" icon="icon-mail" v-model="email" />
                </div>
            </div>
            <div class="vx-row mb-6">
                <div class="vx-col sm:w-1/3 w-full">
                    <span>Contraseña</span>
                </div>
                <div class="vx-col sm:w-2/3 w-full">
                    <vs-input type="password" class="w-full" icon-pack="feather" icon="icon-lock" v-model="password" />
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
                        @click="name = email = password = ''; estado = true;">Borrar</vs-button>
                </div>
            </div>
        </vx-card>
        <vs-popup title="Cargar Imagen" :active.sync="popupActivo" background-color-popup="primary">
            <div>
                <vs-input type="file" class="w-full" label="Seleccionar Imagen" @change="previewFile" accept="image/*" />
            </div>
        </vs-popup>
    </div>
</template>

<script>
export default {
    name: 'ZapecUsuarioForm',

    data() {
        return {
            id: null,
            name: '',
            email: '',
            image: [],
            password: '',
            estado: true,
            urlImage: this.$http.defaults.baseURL + '/images/sin_imagen.jfif',
            popupActivo: false,
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
        previewFile(event) {
            this.image = event.target.files[0];
            this.urlImage = URL.createObjectURL(this.image);
            this.popupActivo = false;
        },
        deleteImage() {
            this.urlImage = this.$http.defaults.baseURL + '/images/sin_imagen.jfif';
            this.image = null;
        },
        nuevo() {
            this.$vs.loading();
            this.$http.post('/api/user/create', {
                name: this.name,
                email: this.email,
                password: this.password,
                estado: this.estado,
                image: this.image,
            }).then(response => {
                this.$vs.loading.close();
                if (response.data.status == 'error') {
                    this.$vs.notify({
                        title: 'Usuario',
                        text: response.data.message,
                        color: 'danger',
                    });
                    return;
                }
                this.$vs.notify({
                    title: 'Usuario',
                    text: 'Usuario registrado correctamente',
                    color: 'success',
                });
                this.name = this.email = this.password = '';
                this.estado = true;
                this.urlImage = this.$http.defaults.baseURL + '/images/sin_imagen.jfif';
                this.image = null;
                this.$router.push({ name: 'usuarios-lista-usuarios' })
            }).catch(error => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Usuario',
                    text: 'Error al registrar el usuario',
                    color: 'danger',
                });
            });
        },
        edit(){
            this.$vs.loading();
            this.$http.put('/api/user/' + this.id, {
                name: this.name,
                email: this.email,
                password: this.password,
                estado: this.estado,
                image: this.image,
            }).then(response => {
                this.$vs.loading.close();
                if (response.data.status == 'error') {
                    this.$vs.notify({
                        title: 'Usuario',
                        text: response.data.message,
                        color: 'danger',
                    });
                    return;
                }
                this.$vs.notify({
                    title: 'Usuario',
                    text: 'Usuario actualizado correctamente',
                    color: 'success',
                });
                this.name = this.email = this.password = '';
                this.estado = true;
                this.urlImage = this.$http.defaults.baseURL + '/images/sin_imagen.jfif';
                this.image = null;
                this.$router.push({ name: 'usuarios-lista-usuarios' })
            }).catch(error => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Usuario',
                    text: 'Error al actualizar el usuario',
                    color: 'danger',
                });
            });
        },
        async getUser(){
            this.$vs.loading();
            await this.$http.get('/api/user/' + this.id).then(response => {
                this.$vs.loading.close();
                if (response.data.status == 'error') {
                    this.$vs.notify({
                        title: 'Usuario',
                        text: response.data.message,
                        color: 'danger',
                    });
                    return;
                }                
                this.name = response.data.name;
                this.email = response.data.email;
                this.estado = response.data.estado;
                // this.urlImage = this.$http.defaults.baseURL + '/images/' + response.data.data.image;
            }).catch(error => {
                this.$vs.loading.close();
                this.$vs.notify({
                    title: 'Usuario',
                    text: 'Error al obtener el usuario',
                    color: 'danger',
                });
            });
        }
    },
    async mounted() {
        if (this.$route.params.id) {
            this.id = this.$route.params.id;
            await this.getUser();
        }
    },
};
</script>