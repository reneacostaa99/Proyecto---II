<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-end">
<div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="clienteId">Número de Cliente</label>
                <select v-model="model.cliente_id" class="form-control" id="clienteId" @change="clienteSeleccionado()">
                  <option value="">Selecciona un cliente</option>
                  <option v-for="cliente in clientes" :value="cliente.id">{{ cliente.nro_ruc }}-{{ cliente.nombre }}</option>
                </select>
              </div>
            </div>

            <!-- Campos adicionales para nombre, dirección y número de celular -->
            <div class="col-md-1">
              <div class="form-group">
                <label for="nombreCliente">Nombre</label>
                <input type="text" class="form-control" id="nombreCliente" v-model="nombreCliente" disabled>
              </div>
            </div>
              <div class="col-md-1">
              <div class="form-group">
                <label for="apellidoCliente">Apellido</label>
                <input type="text" class="form-control" id="apellidoCliente" v-model="apellidoCliente" disabled>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="direccionCliente">Dirección</label>
                <input type="text" class="form-control" id="direccionCliente" v-model="direccionCliente" disabled>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="celularCliente">Número de Celular</label>
                <input type="text" class="form-control" id="celularCliente" v-model="celularCliente" disabled>
              </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                   <label for="forma_pagov">Forma de pago</label>
                    <select name="" v-model="model.forma_pagov"  class="form-control"  id="forma_pagov">
                         <option value="1">Efectivo</option>
                        <option value="2">Transferencia</option>
                      </select>
                    </div>
                  </div>

                          <div class="col-md-2">
              <nuxtLink :to="url_nuevo" class="btn btn-dark btn-sm w-100">
                <i class="fas fa-plus"></i> Agregar Clientes
              </nuxtLink>
            </div>
          </div>


          <div class="col-12 col-sm-7">
            <div class="row">
              <div class="col-12">
                <div class="card bg-gradient-dark">
                  <div class="card-header bg-transparent py-2 px-3">
                    <div class="row">
                      <div class="col-lg-4 col-md-6 col-12">
                        <div class="input-group input-group-lg">
                          <span
                            class="input-group-text text-white bg-transparent border-0"
                          >
                            <i
                              class="ni ni-archive-2 text-lg"
                              aria-hidden="true"
                            ></i>
                          </span>
                          <input
                            type="text"
                            class="form-control bg-transparent border-0 text-white"
                            placeholder="Buscar..."
                            v-model="buscar"
                            @keyup.enter="Codebar()"
                          />
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-12 my-auto ms-auto">
                        <div class="input-group input-group-lg">
                          <span
                            class="input-group-text text-white bg-transparent border-0"
                          >
                            <i
                              class="ni ni-box-2 text-lg"
                              aria-hidden="true"
                            ></i>
                          </span>
                          <select
                            name=""
                            id=""
                            class="form-control bg-transparent border-0 text-white"
                            v-model="marca"
                          >
                            <option value="all" class="text-dark">
                              Todas las marcas
                            </option>
                            <option
                              class="text-dark"
                              v-for="m in marcas"
                              :value="m.id"
                            >
                              {{ m.nombre }}
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="d-flex mb-3">
                        <div class="form-check form-switch ms-auto">
                          <input
                            v-model="image"
                            class="form-check-input"
                            checked=""
                            type="checkbox"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="col-12 py-2"
                style="
                  min-height: 60vh;
                  max-height: 60vh;
                  overflow-y: scroll;
                  overflow-x: none;
                "
              >
                <div class="row">
                  <div class="col-3" v-for="m in articulosCategoria">
                    <PosArticulo-venta
                      v-if="image == true"
                      :articulo="m"
                      @AddCarrito="AddCarrito"
                    ></PosArticulo-venta>
                    <PosArticulo-venta-image
                      v-else
                      :articulo="m"
                      @AddCarrito="AddCarrito"
                    ></PosArticulo-venta-image>
                  </div>
                </div>
              </div>
              <div class="col-xl-12">
                <div class="card">
                  <div class="card-body d-flex p-3">
                    <h6 class="my-auto">Categoría</h6>
                    <div class="nav-wrapper position-relative ms-auto w-50">
                      <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item active" role="presentation">
                          <a
                            class="nav-link mb-0 px-0 py-1"
                            data-bs-toggle="tab"
                            href="#cam1"
                            role="tab"
                            aria-controls="cam1"
                            aria-selected="true"
                          >
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="dropdown pt-2">
                      <a
                        href="javascript:;"
                        class="text-secondary ps-4"
                        id="dropdownCam"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        <i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                      </a>
                      <ul
                        class="dropdown-menu dropdown-menu-end me-sm-n4 px-2 py-3"
                        aria-labelledby="dropdownCam"
                        style=""
                      >
                        <li>
                          <a
                            class="dropdown-item border-radius-md"
                            href="javascript:;"
                            @click="categoria = 'all'"
                            >Todo</a
                          >
                        </li>
                        <li v-for="m in categorias">
                          <a
                            class="dropdown-item border-radius-md"
                            href="javascript:;"
                            @click="categoria = m.id"
                            >{{ m.nombre }}</a
                          >
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="card card-pricing">
              <div
                class="card-header bg-gradient-dark text-center pt-4 pb-5 position-relative"
              >
                <div class="z-index-1 position-relative">
                  <h1 class="text-white mt-2 mb-0">
                    <small></small
                    >{{ Number(totalCarrito).toLocaleString('es') }} Gs.
                  </h1>
                  <h6 class="text-white">Total</h6>
                </div>
              </div>
              <div class="position-relative mt-n5" style="height: 50px">
                <div class="position-absolute w-100">
                  <svg
                    class="waves waves-sm"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 24 150 40"
                    preserveAspectRatio="none"
                    shape-rendering="auto"
                  >
                    <defs>
                      <path
                        id="card-wave"
                        d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"
                      ></path>
                    </defs>
                    <g class="moving-waves">
                      <use
                        xlink:href="#card-wave"
                        x="48"
                        y="-1"
                        fill="rgba(255,255,255,0.30"
                      ></use>
                      <use
                        xlink:href="#card-wave"
                        x="48"
                        y="3"
                        fill="rgba(255,255,255,0.35)"
                      ></use>
                      <use
                        xlink:href="#card-wave"
                        x="48"
                        y="5"
                        fill="rgba(255,255,255,0.25)"
                      ></use>
                      <use
                        xlink:href="#card-wave"
                        x="48"
                        y="8"
                        fill="rgba(255,255,255,0.20)"
                      ></use>
                      <use
                        xlink:href="#card-wave"
                        x="48"
                        y="13"
                        fill="rgba(255,255,255,0.15)"
                      ></use>
                      <use
                        xlink:href="#card-wave"
                        x="48"
                        y="16"
                        fill="rgba(255,255,255,0.99)"
                      ></use>
                    </g>
                  </svg>
                </div>
              </div>
              <div class="card-body text-center p-3">
                <div class="d-flex align-items-center px-2">
                  <h6>CARRITO</h6>
                  <button
                    type="button"
                    class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    @click="Clean()"
                  >
                    <i class="fas fa-trash" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="table-responsive p-0" style="min-height: 30vh">
                  <table
                    class="table align-items-center justify-content-center mb-0"
                  >
                    <thead>
                      <tr>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-start"
                        >
                          Artículo
                        </th>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-start"
                        >
                          Cantidad
                        </th>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-start"
                        >
                          Total
                        </th>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                        ></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(m, i) in carrito">
                        <td class="text-start">
                          <p class="text-xxs font-weight-bold mb-0 text-start">
                            {{ m.articulo.nombre }}
                          </p>
                        </td>
                        <td class="text-start">
                          <p class="text-xxs font-weight-bold mb-0 text-start">
                            {{ m.cantidad }}
                          </p>
                        </td>
                        <td class="text-start">
                          <p class="text-xxs font-weight-bold mb-0 text-start">
                            {{
                              Number(m.cantidad * m.precio).toLocaleString('es')
                            }}
                            Gs.
                          </p>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <button
                              class="btn btn-outline-primary mb-0 btn-sm"
                              type="button"
                              @click="[(modalEdit = true), (item = m)]"
                            >
                              <i class="fas fa-pen"></i>
                            </button>
                            <button
                              class="btn btn-outline-danger mb-0 btn-sm"
                              type="button"
                              @click="EliminarItem(i)"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <button
  class="btn bg-gradient-dark w-100 mt-4 mb-0"
  @click="Save"
  :disabled="!caja || caja.estadocaja === 0"
>
  <i class="fas fa-save mx-2"></i> REGISTRAR VENTA
</button>
              </div>
            </div>
          </div>

          <div
            class="modal fade"
            :class="modalEdit ? 'showModal' : ''"
            id="AjusteModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    Editar artículo
                  </h5>
                  <button
                    type="button"
                    class="btn-close text-dark"
                    @click="modalEdit = false"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group has-success">
                        <label for="">Articulo</label>
                        <input
                          type="text"
                          placeholder=""
                          disabled
                          class="form-control"
                          :value="item.articulo.nombre"
                        />
                      </div>
                    </div>

              
                    <div class="col-6">
                      <div class="form-group has-success">
                        <label for="">Cantidad</label>
                        <input
                          type="text"
                          placeholder=""
                          class="form-control"
                          v-model.number="item.cantidad"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    @click="modalEdit = false"
                    class="btn bg-gradient-secondary w-100"
                    data-bs-dismiss="modal"
                  >
                    Cerrar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AdminTemplate>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: this.modulo,
    };
  },

  data() {
    return {
      list: [],
      caja: null,
      model: {
        cliente_id: '',
        factura: "",
        timbrado:"",
        forma_pagov:"",
      },
      modulo: "Nueva venta",
      page: "Ventas",
      buscar: "",
      marca: "all",
      categoria: "all",
      cliente: "all",
      load: true,
      image: true,
      modalEdit: false,
      articulos:[],
      marcas:[],
      categorias:[],
      carrito:[],
      clientes: [],
      //sucursals:[],
      item:{
        articulo:{
          nombre:''
        },
        cantidad:0,
        precio:0,
      },
      sucursal:{},
      user:{},
      url_nuevo: "/persona/clientes/nuevo",
      numeroFactura: 3859,
      nombreCliente: '',
      apellidoCliente:'',
      direccionCliente: '',
      celularCliente: '',
    };
  },

  computed:{
    articulosFilter(){
      let buscar = this.buscar
      if(buscar!=''){
        return this.articulos.filter((a)=>{
          let nombre = a.nombre!=null?a.nombre:''
          let barra = a.barra!=null?a.barra:''
          return nombre.toLowerCase().indexOf(buscar.toLowerCase())!=-1 || barra.toLowerCase().indexOf(buscar.toLowerCase())!=-1
        })
      }
      return this.articulos
    },
    articulosMarca(){
      let marca = this.marca
      if(marca!='all'){
        return this.articulosFilter.filter((a)=>{
          return a.marca_id == marca
        })
      }
      return this.articulosFilter
    },
    articulosCategoria(){
      let categoria = this.categoria
      if(categoria!='all'){
        return this.articulosMarca.filter((a)=>{
          return a.categoria_id == categoria
        })
      }
      return this.articulosMarca
    },
    totalCarrito(){
      return this.carrito.reduce((a,b)=> a+(b.cantidad*b.precio),0)
    }
  },

  methods: {
    async GET_DATA(path) {
      const res = await this.$api.$get(path);
      return res;
    },

    async Datos() {
      try {
        await Promise.all([this.GET_DATA('marcas'),this.GET_DATA('categorias'),this.GET_DATA('inventarios'),this.GET_DATA('clientes'),this.GET_DATA('sucursals')]).then((v) => {
          this.marcas = v[0];
          this.categorias = v[1];
          this.articulos = v[2];
          this.clientes = v[3];
          //this.sucursals = v[4];
          //if (this.sucursals.length > 0) {
            //this.sucursal = this.sucursals[0];
          //}
        });
      } catch (e) {
        console.log(e);
      }
    },

    async Clientes() {
      try {
        const clientes = await this.GET_DATA('clientes');
        this.clientes = clientes;
      } catch (error) {
        console.error('Error al cargar clientes:', error);
      }
    },

    async clienteSeleccionado() {
      if (this.model.cliente_id) {
        // Obtener detalles del cliente seleccionado
        const clienteSeleccionado = this.clientes.find(cliente => cliente.id === this.model.cliente_id);

        // Actualizar campos adicionales con la información del cliente
        this.nombreCliente = clienteSeleccionado.nombre;
        this.direccionCliente = clienteSeleccionado.direccion;
        this.apellidoCliente = clienteSeleccionado.apellido;
        this.celularCliente = clienteSeleccionado.celular;
      } else {
        // Limpiar campos adicionales si no se selecciona ningún cliente
        this.nombreCliente = '';
        this.direccionCliente = '';
        this.celularCliente = '';
        this.apellidoCliente
      }
    },

    async AddCarrito(articulo){
      let id = articulo.id
      let buscarRegistro = this.carrito.filter((i)=> i.articulo.id == id)
      if(buscarRegistro.length>0){
        let indice = this.carrito.findIndex((i)=>i.articulo.id == id)
        if(this.carrito[indice].cantidad+1>this.carrito[indice].stock){
          return false;
        }else{
          this.carrito[indice].cantidad += 1
        }
      }else{
        const item = {
          articulo : articulo,
          cantidad:1,
          stock:articulo.stock,
          precio:articulo.venta
        }
        this.carrito.push(item)
      }
    },

    EliminarItem(i){
      this.carrito.splice(i,1)
    },

    Codebar(){
      let code = this.buscar
      let buscarRegistro = this.articulosCategoria.filter((i)=> i.barra == code)
      if(buscarRegistro.length>0){
        this.AddCarrito(buscarRegistro[0])
        this.buscar = ''
      }
    },

    async Save() {
      if (!this.caja || this.caja.estadocaja === 0) {
        this.$swal.fire("Caja cerrada", "No se puede realizar la venta", "warning");
        return;
      }
      this.load = true;
      let self = this;
      try {
        const operacion = {
          total: this.totalCarrito,
          tipo: 1,
          pago: 0,
          cambio: 0,
          motivo: '',
          timbrado:17794383,
          factura: this.numeroFactura,
          cliente_id: this.model.cliente_id,
          carrito: this.carrito,
          forma_pagov: this.model.forma_pagov,
          caja_id:this.user.caja_id
        };
        this.numeroFactura += 1;

        const res = await this.$api.$post('ventas', operacion);
        console.log(res);
        this.$swal.fire({
          title: 'Venta Guardada !',
          confirmButtonText: 'Ok'
        }).then(async (result) => {
          if (result.isConfirmed) {
            window.open(res.url_pdf, '_blank');
            self.Clean();
            self.load = true;
            await self.Datos();
            self.load = false;
          }
        });
      } catch (e) {
        console.log(e);
        this.$swal.fire("Error", "No se pudo guardar la venta", "error");
      } finally {
        this.load = false;
      }
    },
  
    async ImprimirVenta(venta) {
      let sucursal = this.sucursal;
      sucursal.venta = venta
      const res = await this.$printer.$post(sucursal.impresora_url+"venta",sucursal);
      console.log(res)
    }
  },
  mounted() {
  const storedUser = localStorage.getItem("userAuth");

  if (!storedUser) return;

  this.user = JSON.parse(storedUser);

  this.$nextTick(async () => {
    try {
      await this.Datos(); // ya lo usás para cargar marcas, categorías, etc.

      // 🔥 Cargar datos de caja activa si hay caja_id
      if (this.user.caja_id) {
        try {
          this.caja = await this.GET_DATA("cajas/" + this.user.caja_id);
        } catch (e) {
          console.error("No se pudo cargar la caja:", e);
          this.caja = null;
        }
      }
    } catch (e) {
      console.log(e);
    } finally {
      this.load = false;
    }
  });
},
};
</script>
<style>
.showModal {
  visibility: visible;
  display: block;
  opacity: 1 !important;
}
</style>