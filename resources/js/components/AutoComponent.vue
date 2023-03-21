<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="float-start">Listado de Autos</h5>
                            </div>
                            <div class="col-6">
                                <button @click="showDialog" class="btn btn-success btn-sm float-end">
                                    Nuevo
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group rounded">
                                <input type="search" v-model="search" @input="filterData(search)"
                                    class="form-control rounded" placeholder="Search" aria-label="Search"
                                    aria-describedby="search-addon" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Placa</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Año</th>
                                    <th scope="col">Precio Alquiler</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in autos" :key="item.id">
                                    <td>{{ item.placa }}</td>
                                    <td>{{ item.tipo }}</td>
                                    <td>{{ item.marca.nombre }}</td>
                                    <td>{{ item.modelo.nombre }}</td>
                                    <td>{{ item.anio }}</td>
                                    <td>{{ item.precio_alquiler }}</td>
                                    <td>{{ item.imagen }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm"
                                            @click="showDialogEditar(item)">
                                            Editar
                                        </button>
                                        &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminar(item)">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="autoModal" tabindex="-1" aria-labelledby="autoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="autoModalLabel">
                        {{ formTitle }}
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--definiendo cuerpo del formulario modal-->
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="placa">Placa</label>
                            <input type="text" class="form-control" v-model="auto.placa" />
                        </div>
                        <div class="col-6">
                            <label for="tipo">Tipo Auto</label>
                            <select v-model="auto.tipo" class="form-control">
                                <option v-for="tipoAuto in tipos" :value="tipoAuto.value">
                                    {{ tipoAuto.text }}
                                </option>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="tipo">Marca</label>
                            <select v-model="auto.marca_id" class="form-control">
                                <option v-for="mark in marcas" :value="mark.id">
                                    {{ mark.nombre }}
                                </option>
                            </select>

                        </div>
                        <div class="col-6">
                            <label for="tipo">Modelo</label>
                            <select v-model="auto.modelo_id" class="form-control">
                                <option v-for="model in modelos" :value="model.id">
                                    {{ model.nombre }}
                                </option>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="placa">Año</label>
                            <input type="number" class="form-control" v-model="auto.anio" />
                            <span class="text-danger" v-show="autoErrors.anio">Año es requerido</span>
                        </div>
                        <div class="col-6">
                            <label for="placa">Precio Alquiler</label>
                            <input type="text" class="form-control" v-model="auto.precio_alquiler" />

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" @click="saveOrUpdate()">
                        {{ btnTitle }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            autos: [],
            auto: {
                id: null,
                placa: "",
                tipo: "",
                anio: 2000,
                precioAlquiler: null,
                imagen: "",
                estado: "",
                marca: null,
                modelo: null,
                marca_id: null,
                modelo_id: null
            },
            editedAuto: -1,
            autoErrors: {
                placa: false,
                tipo: false,
                anio: false,
                precio: false,
                marca: false,
                modelo: false
            },
            filters: [],
            search: "",
            tipos: [
                { text: "Sedan", value: "S" },
                { text: "Camioneta", value: "C" },
                { text: "Pickup", value: "P" },
                { text: "Limosina", value: "L" }
            ],
            marcas: [],
            modelos: []
        };
    },
    computed: {
        formTitle() {
            return this.auto.id == null ? "Agregar Auto" : "Actualizar Auto";
        },
        btnTitle() {
            return this.auto.id == null ? "Guardar" : "Actualizar";
        },
    },
    methods: {
        async fetchAutos() {
            let me = this;
            await this.axios.get('/autos').then(response => {
                me.autos = response.data;
            })
        },
        async fetchMarcas() {
            let me = this;
            await this.axios.get('/marcas').then(response => {
                me.marcas = response.data;
            })
        },
        async fetchModelos() {
            let me = this;
            await this.axios.get('/modelos').then(response => {
                me.modelos = response.data;
            })
        },
        showDialog() {
            this.auto = {
                id: null,
                placa: "",
                tipo: "",
                anio: 0,
                precioAlquiler: 0,
                imagen: "",
                estado: "",
                marca: null,
                modelo: null,
                modelo_id: null,
                marca_id: null,
            };
            this.autoErrors = {
                placa: false,
                tipo: false,
                anio: false,
                precio: false,
                marca: false,
                modelo: false,
            };
            $('#autoModal').modal('show');
        },
        showDialogEditar(auto) {
            let me = this;
            $('#autoModal').modal('show');
            me.editedAuto = me.autos.indexOf(auto);
            me.auto = Object.assign({}, auto);
        },
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.auto = {
                    id: null,
                    placa: "",
                    tipo: "",
                    anio: 0,
                    precioAlquiler: 0,
                    imagen: "",
                    estado: "",
                    marca: null,
                    modelo: null,
                };
            }, 300);
            $('#autoModal').modal('hide');
        },
        async saveOrUpdate() {
            let me = this;

            me.auto.placa == '' ? me.autoErrors.placa = true : me.autoErrors.placa = false;
            me.auto.tipo == '' ? me.autoErrors.tipo = true : me.autoErrors.tipo = false;
            me.auto.marca_id == null ? me.autoErrors.marca = true : me.autoErrors.marca = false;
            me.auto.modelo_id == null ? me.autoErrors.modelo = true : me.autoErrors.modelo = false;
            me.auto.precio_alquiler == null ? me.autoErrors.precio_alquiler = true : me.autoErrors.precio_alquiler = false;
            if (me.auto.placa) {
                let accion = me.auto.id == null ? "add" : "upd";

                me.auto.marca = {
                    "id": me.auto.marca_id
                };
                me.auto.modelo = {
                    "id": me.auto.modelo_id
                };
                if (accion == "add") {
                    me.auto.imagen = "none.jpg";
                    me.auto.estado = "D";
                    //peticion para guardar una marca

                    await this.axios.post('/autos', me.auto)
                        .then(response => {
                            //console.log(response.data);
                            if (response.status == 201) {
                                me.verificarAccion(
                                    response.data.data,
                                    response.status,
                                    accion)
                                me.hideDialog();

                            }
                        }).catch(errors => {
                            console.log(errors);
                        })
                } else {
                    // peticion para actualizar una marca
                    await this.axios
                        .put(`/autos/${me.auto.id}`, me.auto)
                        .then(response => {
                            if (response.status == 202) {
                                me.verificarAccion(
                                    response.data.data,
                                    response.status,
                                    accion
                                );
                                me.hideDialog();
                            }
                        }).catch((errors) => {
                            console.log(errors);
                        });
                }
            }
        },
        async eliminar(auto) {
            let me = this;
            this.$swal
                .fire({
                    title: 'Seguro/a de eliminar este registro?',
                    text: "No podras revertir la accion",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                })
                .then((result) => {
                    if (result.value) {
                        me.editedAuto = me.autos.indexOf(auto);
                        this.axios
                            .delete(`/autos/${auto.id}`)
                            .then((response) => {
                                me.verificarAccion(
                                    null,
                                    response.status,
                                    "del"
                                );
                            })
                            .catch((errors) => {
                                console.log(errors);
                            })
                    }
                })
        },
        verificarAccion(auto, statusCode, accion) {
            let me = this;
            const Toast = this.$swal.mixin({
                toast: true,
                position: "top-right",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
            switch (accion) {
                case "add":
                    //agregar el nuevo objeto al array autos
                    //me.autos.unshift(auto);

                    me.fetchAutos();
                    Toast.fire({
                        icon: 'success',
                        'title': 'Auto Registrada con Exito...!'
                    });
                    break;
                case "upd":
                    Object.assign(me.autos[me.editedAuto], auto);
                    Toast.fire({
                        icon: 'success',
                        'title': 'Auto Actualizada con Exito...!'
                    });
                    break;
                case "del":
                    if (statusCode == 200) {
                        me.autos.splice(this.editedAuto, 1);
                        //Se Lanza mensaje Final
                        Toast.fire({
                            icon: "success",
                            'title': 'Auto Eliminado...!'
                        });
                    } else {
                        Toast.fire({
                            icon: "warning",
                            'title': 'Error al eliminar auto, intente de nuevo'
                        });
                    }
                    break;
            }
        },

        mounted() {
            this.fetchAutos();
            this.fetchMarcas();
            this.fetchModelos();
        }
    }
} 
</script>
