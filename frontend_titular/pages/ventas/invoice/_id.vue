<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-md-center">
          <div class="col-lg-8 mx-auto">
            <div class="card mb-4">
              <div class="card-header p-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6>Detalle de venta</h6>
                    <p class="text-sm mb-0">
                      Venta Nro. <b>{{ model.id }}</b> en fecha <b>{{ model.fecha }}</b>
                    </p>
                  </div>
                  <button @click="$router.back()" class="btn bg-gradient-info btn-sm mb-0">
                    <i class="ni ni-bold-left"></i> Regresar
                  </button>
                </div>
              </div>
              <div class="card-body p-3 pt-0">
                <hr class="horizontal dark mt-0 mb-4" />
                <div class="row">
                  <div class="col-12" v-for="m in model.venta_inventarios" :key="m.id">
                    <div class="d-flex">
                      <div>
                        <h6 class="text-lg mb-0 mt-2">{{ m.inventario.articulo.nombre }}</h6>
                        <p class="text-sm mb-3">
                          {{ Number(m.precio).toLocaleString('es') }} Gs. x {{Number(m.cantidad).toLocaleString('es')}} {{ m.inventario.articulo.medida.codigo }}
                        </p>
                        <span class="badge badge-sm bg-gradient-success">
                          <i class="fas fa-barcode"></i> {{ m.inventario.articulo.barra }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="horizontal dark mt-4 mb-4" />
                <div class="row">
                  <div class="col-lg-8 col-md-6 col-12">
                    <h6 class="mb-3 mt-4">Información</h6>
                    <ul class="list-group">
                      <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                          <h6 class="mb-3 text-sm">Detalle de venta</h6>
                          <span class="mb-2 text-xs">Cliente:
                            <span class="text-dark font-weight-bold ms-2">{{ model.cliente.nombre }} {{ model.cliente.apellido }}</span>
                          </span>
                          <span class="mb-2 text-xs">Factura:
                            <span class="text-dark font-weight-bold ms-2">001-001-00{{ model.factura }}</span>
                          </span>
                          <span class="mb-2 text-xs">Timbrado:
                            <span class="text-dark font-weight-bold ms-2">{{ model.timbrado }}</span>
                          </span>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12 ms-auto">
                    <div class="d-flex justify-content-between mt-4">
                      <span class="mb-2 text-lg"> Total: </span>
                      <span class="text-dark text-lg ms-2 font-weight-bold">{{ Number(model.total).toLocaleString('es') }} Gs.</span>
                    </div>
                  </div>
                </div>
                <hr class="horizontal dark mt-4 mb-4" />
                <div class="d-flex justify-content-between" v-if="model.estado === 3">
                  <button @click="Aceptar(model.id)" class="btn bg-gradient-success btn-sm mb-0">
                    Aceptar
                  </button>
                  <button @click="Eliminar(model.id)" class="btn bg-gradient-danger btn-sm mb-0">
                    Cancelar
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
  name: "IndexPage",
  head() {
    return {
      title: this.modulo,
    };
  },
  data() {
    return {
      load: true,
      model: {
        total: 0,
        venta_inventarios: [],
        cliente: {
          nombre: '',
          apellido: ''
        },
      },
      apiUrl: "ventas",
      page: "Ventas",
      modulo: "Invoice",
      marcas: [],
      medidas: [],
      categorias: [],
      clientes: [],
    };
  },
methods: {
  async GET_DATA(path) {
    const res = await this.$api.$get(path);
    return res;
  },
  async EliminarItem(id) {
    this.load = true;
    try {
      const res = await this.$api.$delete(this.apiUrl + "/" + id);
      console.log(res);
      await Promise.all([this.GET_DATA(this.apiUrl)]).then((v) => {
        this.list = v[0];
      });
      this.$router.back(); // Regresar después de eliminar
    } catch (e) {
      console.log(e);
    } finally {
      this.load = false;
    }
  },
  async AceptarItem(id) {
    this.load = true;
    try {
      const res = await this.$api.$put(`${this.apiUrl}/${id}`, { estado: 1 });
      console.log(`Venta con id ${id} actualizada a estado 1`);
      this.$router.back(); // Regresar después de aceptar
    } catch (error) {
      console.error(error);
    } finally {
      this.load = false;
    }
  },
  Eliminar(id) {
    let self = this;
    this.$swal
      .fire({
        title: "Deseas Eliminar?",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelarButtonText: `Cancelar`,
      })
      .then(async (result) => {
        if (result.isConfirmed) {
          await self.EliminarItem(id);
        }
      });
  },
  
  Aceptar(id) {
    let self = this;
    this.$swal
      .fire({
        title: "Deseas Aceptar?",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelarButtonText: `Cancelar`,
      })
      .then(async (result) => {
        if (result.isConfirmed) {
          await self.AceptarItem(id);
        }
      });
  },
},

  mounted() {
    this.$nextTick(async () => {
      try {
        await Promise.all([this.GET_DATA('ventas/' + this.$route.params.id)]).then((v) => {
          this.model = v[0];
        });
      } catch (e) {
        console.log(e);
      } finally {
        this.load = false;
      }
    });
  },
};
</script>
