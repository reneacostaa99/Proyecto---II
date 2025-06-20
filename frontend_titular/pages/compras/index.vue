<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-end">
<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <label for="proveedorId">Número de Proveedor</label>
<select v-model="model.proveedor_id" class="form-control" id="proveedorId" @change="seleccionarProveedor">
  <option value="">Selecciona un proveedor</option>
  <option v-for="proveedor in proveedors" :value="proveedor.id">{{ proveedor.nro_ruc }}-{{ proveedor.nombre }}</option>
</select>
    </div>
  </div>
  
  <!-- Campos adicionales para mostrar la información del proveedor seleccionado -->

   <div class="col-md-2">
    <div class="form-group">
      <label for="proveedorNombre">Nombre</label>
      <input type="text" v-model="model.proveedor_nombre" class="form-control" id="proveedorNombre" readonly>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="proveedorApellido">Apellido</label>
      <input type="text" v-model="model.proveedor_apellido" class="form-control" id="proveedorApellido" readonly>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label for="proveedorDireccion">Dirección</label>
      <input type="text" v-model="model.proveedor_direccion" class="form-control" id="proveedorDireccion" readonly>
    </div>
  </div>


  <!-- Columna de Timbrado -->
  <div class="col-md-2">
    <div class="form-group">
      <label for="timbrado">Factura</label>
      <input type="text" v-model="model.timbrado" class="form-control" id="timbrado" placeholder="Ingrese el nro factura">
    </div>
  </div>

  <!-- Columna de Factura -->
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura">Timbrado</label>
      <input type="text" v-model="model.factura" class="form-control" id="factura" placeholder="Ingrese nro de timbrado">
    </div>
    
  </div>
    <div class="col-md-2">
     <label for="fecha">Fecha</label>
    <input type="date" v-model="model.fecha" id="fecha" class="form-control">
</div>

 <div class="col-2">
                        <div class="form-group">
                          <label for="tipo_factura">Tipo factura</label>
                          <select name="" v-model="model.tipo_compra"  class="form-control"  id="tipo_factura">
                            <option value="Contado">Contado</option>
                            <option value="Credito">Credito</option>
                          </select>
                        </div>
                      </div>

            <div class="col-2">
                <div class="form-group">
                   <label for="forma_pago">Forma de pago</label>
                    <select name="" v-model="model.forma_pago"  class="form-control"  id="forma_pago">
                         <option value="1">Efectivo</option>
                        <option value="2">Transferencia</option>
                      </select>
                    </div>
                  </div>

    <div class="col-md-2">
    <nuxtLink :to="url_nuevo" class="btn btn-dark btn-sm w-100">
      <i class="fas fa-plus"></i> Agregar proveedor
    </nuxtLink>
  </div>
            <div class="col-2">
            <nuxtLink :to="url_nuevo2" class="btn btn-dark btn-sm w-100">
              <i class="fas fa-plus"></i> Agregar articulo
            </nuxtLink>
          </div>

  <!-- ... (código existente) ... -->
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
                            <option class="text-dark" v-for="m in marcas" :value="m.id">{{m.nombre}}</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 py-2" style="min-height: 60vh;max-height: 60vh;overflow-y: scroll;overflow-x: none;">
                <div class="row">

                  <div class="col-3"  v-for="m in articulosCategoria">
                    <PosArticulo :articulo="m" @AddCarrito="AddCarrito"></PosArticulo>
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
                            @click="categoria='all'"
                            >Todo</a
                          >
                        </li>
                        <li  v-for="m in categorias">
                          <a
                            class="dropdown-item border-radius-md"
                            href="javascript:;"
                            @click="categoria=m.id"
                            >{{m.nombre}}</a
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
                  <h1 class="text-white mt-2 mb-0"><small></small>{{Number(totalCarrito).toLocaleString('es')}} Gs.</h1>
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
                      <tr v-for="(m,i) in carrito" >
                        <td class="text-start">
                          <p class="text-xxs font-weight-bold mb-0 text-start">
                            {{m.articulo.nombre}}
                          </p>
                        </td>
                        <td class="text-start">
                          <p class="text-xxs font-weight-bold mb-0 text-start">
                            {{(m.cantidad)}}
                          </p>
                        </td>
                        <td class="text-start">
                          <p class="text-xxs font-weight-bold mb-0 text-start">
                            {{Number(m.cantidad*m.precio).toLocaleString('es')}} Gs.
                          </p>
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <button
                              class="btn btn-outline-primary mb-0 btn-sm"
                              type="button"
                              @click="[modalEdit=true,item=m]"
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
  <i class="fas fa-save mx-2"></i> REALIZAR COMPRA
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
        factura:"",
        timbrado:"",
        forma_pago:"",
        fecha: new Date().toISOString().substr(0, 10),
        tipo_compra:"",
        proveedor_id: '',
         proveedor_nombre: '',
        proveedor_apellido: '',
        proveedor_direccion: '',
        proveedor_numero: ''
    },
      modulo: "Nueva compra",
      page: "Compras",
      buscar: "",
      marca: "all",
      categoria: "all",
      proveedor: "all",
      load: true,
      modalEdit: false,
      articulos:[],
      marcas:[],
      categorias:[],
      carrito:[],
      totalCaja: 0,
      proveedors:[],
      item:{
        articulo:{
          nombre:''
        },
        cantidad:0,
        precio:0,
      },
      user:{},
      url_nuevo: "/persona/proveedors/nuevo",
       url_nuevo2: "/configuracion/articulos/nuevo",

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
        await Promise.all([this.GET_DATA('marcas'),this.GET_DATA('categorias'),this.GET_DATA('articulos'), this.GET_DATA('proveedors')]).then((v) => {
          this.marcas = v[0];
          this.categorias = v[1];
          this.articulos = v[2];
          this.proveedors = v[3];
        });
      } catch (e) {
        console.log(e);
      }
    },
    seleccionarProveedor() {
    const proveedorSeleccionado = this.proveedors.find(p => p.id === this.model.proveedor_id);
    if (proveedorSeleccionado) {
      this.model.proveedor_nombre = proveedorSeleccionado.nombre;
      this.model.proveedor_apellido = proveedorSeleccionado.apellido;
      this.model.proveedor_direccion = proveedorSeleccionado.direccion;
      this.model.proveedor_numero = proveedorSeleccionado.numero;
    } else {
      this.model.proveedor_nombre = '';
      this.model.proveedor_apellido = '';
      this.model.proveedor_direccion = '';
      this.model.proveedor_numero = '';
    }
  },
    AddCarrito(articulo){
      let id = articulo.id
      let buscarRegistro = this.carrito.filter((i)=> i.articulo.id == id)
      if(buscarRegistro.length>0){
        let indice = this.carrito.findIndex((i)=>i.articulo.id == id)
        this.carrito[indice].cantidad += 1
      }else{
        const item = {
          articulo : articulo,
          cantidad:1,
          precio:articulo.compra
        }
        this.carrito.push(item)

      }
    },
      async Proveedors() {
    try {
      const proveedors = await this.GET_DATA('proveedors');
      this.proveedors = proveedors;
    } catch (error) {
      console.error('Error al cargar proveedores:', error);
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
      this.load = true;
      let self = this
      try {
       const operacion = {
          total: this.totalCarrito,
          tipo:1,
          motivo:'',
          proveedor_id: this.model.proveedor_id,
          factura:this.model.factura,
          timbrado:this.model.timbrado,
          fecha:this.model.fecha,
          tipo_compra:this.model.tipo_compra,
          caja_id:this.user.caja_id,
          forma_pago: this.model.forma_pago,
          carrito:this.carrito
       }
        const res = await this.$api.$post('compras', operacion);
        console.log(res);
        this.$swal
          .fire({
            title: "Compra guardada !",
            showDenyButton: false,
            showCancelButton: false,
            confirmButtonText: "Ok",
          })
          .then( (result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              self.Clean()
            }
          });
      } catch (e) {
        console.log(e);
      } finally {
        this.load = false;
      }
    },
    Clean(){
      this.carrito = []
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
  .showModal{
    visibility: visible;
    display:block;
    opacity: 1 !important;
  }
</style>

