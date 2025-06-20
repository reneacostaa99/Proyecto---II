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
                    <h6>Detalle de compra</h6>
                    <p class="text-sm mb-0">
                      Compra Nro. <b> {{model.id}}</b> en fecha <b>{{model.fecha}} </b>
                    </p>
                  </div>
                  <button
                    @click="$router.back()"
                    class="btn bg-gradient-info btn-sm mb-0"
                  >
                    <i class="ni ni-bold-left"></i> Regresar
                  </button>
                </div>
              </div>
              <div class="card-body p-3 pt-0">
                <hr class="horizontal dark mt-0 mb-4" />
                <div class="row">
                  <div class="col-12" v-for="m in model.compra_inventarios" :key="m.id">
                    <div class="d-flex">
                      <div>
                        <h6 class="text-lg mb-0 mt-2">{{m.inventario.articulo.nombre}}</h6>
                        <p class="text-sm mb-3">
                          {{Number(m.precio).toLocaleString('es')}} Gs. x {{Number(m.cantidad).toLocaleString('es')}} {{m.inventario.articulo.medida.codigo}}
                        </p>
                        <span class="badge badge-sm bg-gradient-success">
                          <i class="fas fa-barcode"></i> {{m.inventario.articulo.barra}}
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
                          <h6 class="mb-3 text-sm">Detalle de compra</h6>
                          <span class="mb-2 text-xs">Proveedor:
                            <span class="text-dark font-weight-bold ms-2">{{model.proveedor.nombre}} {{model.proveedor.apellido}}</span>
                          </span>
                          <span class="mb-2 text-xs">Factura:
                            <span class="text-dark font-weight-bold ms-2">{{model.timbrado}}</span>
                          </span>
                          <span class="mb-2 text-xs">Timbrado:
                            <span class="text-dark font-weight-bold ms-2">{{model.factura}}</span>
                          </span>
                          <span class="mb-2 text-xs">Fecha:
                            <span class="text-dark font-weight-bold ms-2">{{model.fecha}}</span>
                          </span>
                          <span class="mb-2 text-xs">Tipo Factura:
                            <span class="text-dark font-weight-bold ms-2">{{model.tipo_compra}}</span>
                          </span>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12 ms-auto">
                    <div class="d-flex justify-content-between mt-4">
                      <span class="mb-2 text-lg"> Total: </span>
                      <span class="text-dark text-lg ms-2 font-weight-bold">{{Number(model.total).toLocaleString('es')}} Gs.</span>
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
        compra_inventarios: [],
        proveedor: {
          nombre: '',
          apellido: ''
        },
      },
      apiUrl: "compras",
      page: "Compras",
      modulo: "Invoice",
      marcas: [],
      medidas: [],
      categorias: [],
      proveedors: [],
      totalCaja: 0,
      carrito: [],
    };
  },
  computed: {
    totalCarrito() {
      return this.carrito.reduce((total, item) => total + (item.cantidad * item.precio), 0);
    }
  },
  methods: {
    async GET_DATA(path) {
      const res = await this.$api.$get(path);
      return res;
    },
    async CargarCaja() {
      try {
        const cajaData = await this.GET_DATA("cajas/" + this.user.caja_id);
        this.totalCaja = cajaData.ingresos - cajaData.salidas;
      } catch (e) {
        console.log(e);
      }
    },
    async Aceptar(id) {
      this.load = true;
      try {
        // Recalcular el total del carrito antes de la validación
        this.model.total = this.totalCarrito;

        // Calcular el saldo final después de la compra
        const saldoFinal = this.totalCaja - this.model.total;

        // Validar que el saldo final no sea negativo
        if (saldoFinal < 0) {
          // Mostrar alerta y detener el proceso de guardado
          await this.$swal.fire({
            title: "Error",
            text: "La compra no puede completarse porque dejaría un saldo negativo en caja.",
            icon: "error",
            confirmButtonText: "Aceptar"
          });
          this.load = false; // Asegura que la carga se detenga
          return; // Salir del método sin continuar el guardado
        }

        // Si pasa la validación, realizar el guardado
        const res = await this.$api.$put(`${this.apiUrl}/${id}`, { estado: 1 });
        console.log(`Compra con id ${id} actualizada a estado 1`);
        this.$router.back();
      } catch (error) {
        console.error(error);
      } finally {
        this.load = false;
      }
    },
    async Eliminar(id) {
      const confirmDelete = await this.$swal.fire({
        title: "¿Estás seguro de que deseas cancelar esta compra?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, cancelar",
        cancelButtonText: "No, regresar"
      });

      if (confirmDelete.isConfirmed) {
        this.load = true;
        try {
          const res = await this.$api.$delete(`${this.apiUrl}/${id}`);
          console.log(`Compra con id ${id} eliminada.`);
          this.$swal.fire({
            title: "Compra cancelada",
            icon: "success"
          });
          this.$router.back();
        } catch (error) {
          console.error(error);
          this.$swal.fire({
            title: "Error al cancelar la compra",
            icon: "error"
          });
        } finally {
          this.load = false;
        }
      }
    },
  },
  mounted() {
    this.$nextTick(async () => {
      try {
        await Promise.all([this.GET_DATA('compras/' + this.$route.params.id)]).then((v) => {
          this.model = v[0];
        });
        await this.CargarCaja();
      } catch (e) {
        console.log(e);
      } finally {
        this.load = false;
      }
    });
  },
};
</script>

