<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row" v-if="model">
          <div class="col-12">
            <div class="card">
              <div class="card-header pb-0">
                <div class="d-lg-flex">
                  <div>
                    <h5 class="mb-0">Datos del artículo</h5>
                  </div>
                  <div class="ms-auto my-auto mt-lg-0 mt-4">
                    <div class="ms-auto my-auto">
                      <button @click="$router.back()" class="btn bg-gradient-info btn-sm mb-0">
                        <i class="ni ni-bold-left"></i> Regresar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-lg-5 mx-auto">
                    <h3 class="mt-lg-0 mt-4">{{ model.nombre }}</h3>
                    <div class="rating">
                      <i class="fas fa-barcode" aria-hidden="true"></i>
                      {{ model.categoria.nombre }} |
                      <i class="fas fa-boxes" aria-hidden="true"></i>
                      {{ model.categoria.nombre2 }} |
                      <i class="fas fa-bookmark" aria-hidden="true"></i>
                      {{ model.marca.nombre }}
                    </div>
                    <span class="badge" :class="[model.stock <= model.stock_minimo ? 'badge-danger' : 'badge-success']">
                      <i class="fas fa-archive" aria-hidden="true"></i> {{ model.stock }} en Stock
                    </span>
                    <div class="row mt-4">
                      <div class="col-lg-12">
                        <button class="btn bg-gradient-primary mb-0 mt-lg-auto w-100" type="button" name="button" data-bs-toggle="modal" data-bs-target="#AjusteModal">
                          <i class="fas fa-cog"></i>
                          Ajustar Stock
                        </button>
                        <div class="modal fade" id="AjusteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Nuevo Ajuste</h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-group has-success">
                                      <label for="">Cantidad</label>
                                      <input type="text" placeholder="" class="form-control" v-model.number="inventario.cantidad" />
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group has-success">
                                      <label for="">Tipo de ajuste</label>
                                      <select name="" id="" class="form-control" v-model.number="inventario.tipo">
                                        <option value="1">ENTRADA</option>
                                        <option value="2">SALIDA</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="form-group has-success">
                                        <label for="Motivo">Motivo</label>
                        <select
                          name=""
                          v-model="inventario.motivo"
                          class="form-control"
                          id=""
                        >
                          <option value="Error de Factura">Error de Factura</option>
                          <option value="Articulo defectuoso">Articulo defectuoso</option>
                          <option value="Cambio de mercaderia">Cambio de mercaderia</option>
                        </select>
                                     
                                    </div>
                                  </div>

    
                                      <div class="col-12">
                                    <div class="form-group has-success">
                                                                    <label for="fecha">Fecha</label>
    <input type="date" v-model="model.fecha" id="fecha" class="form-control">
                                    </div>
                                  </div>

                                                                    <div class="col-12">
                                    <div class="form-group has-success">
                                      <label for="">Comprobante</label>
                                      <input type="text" placeholder="" class="form-control" v-model="inventario.comprobante" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal" @click="Save">Continuar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-7">
                    <h5 class="ms-1">Movimientos de stock</h5>
                    <div class="table table-responsive">
                      <table class="table align-items-center mb-0 table-sm">
                        <thead>
                          <tr>
                            <th class="text-uppercase text-left text-secondary text-xxs font-weight-bolder opacity-7 px-1">Detalle</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cantidad</th>
                            <th class="text-uppercase text-secondary text-left text-xxs font-weight-bolder opacity-7 ps-2">Fecha</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="m in paginatedInventarios" :key="m.id">
                            <td>
                              <div class="d-flex px-1 py-1">
                                <div class="text-xxs">{{ m.motivo }}</div>
                              </div>
                            </td>
                            <td>
                              <h6>
                                <span class="badge text-xxs" :class="[m.tipo == 2 ? 'badge-danger' : 'badge-success']">
                                  {{ m.cantidad }} {{ model.medida.codigo }}
                                </span>
                              </h6>
                            </td>
                            <td>
                              <div class="d-flex px-1 py-1">
                                <div class="text-xxs">{{ m.fecha }}</div>
                                <div class="text-xxs">{{ m.updated_at_formatted }}</div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                      <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="btn btn-sm btn-primary">
                        Anterior
                      </button>
                      <span>Página {{ pagination.current_page }} de {{ total_pages }}</span>
                      <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === total_pages" class="btn btn-sm btn-primary">
                        Siguiente
                      </button>
                    </div>
                  </div>
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
      load: true,
      apiUrl: "inventarios",
      page: "Inventario",
      modulo: "General",
      model: null,
      inventario: {
        tipo: 1,
        cantidad: 1,
        motivo: '',
        comprobante:'',
        fecha: '',
      },
      pagination: {
        current_page: 1,
        per_page: 10,
        total: 0,
      },
    };
  },
  computed: {
    paginatedInventarios() {
      if (!this.model || !this.model.inventarios) {
        return [];
      }
      const start = (this.pagination.current_page - 1) * this.pagination.per_page;
      const end = start + this.pagination.per_page;
      return this.model.inventarios.slice(start, end);
    },
    total_pages() {
      if (!this.model || !this.model.inventarios) {
        return 0;
      }
      return Math.ceil(this.model.inventarios.length / this.pagination.per_page);
    },
  },
  methods: {
    async GET_DATA(path) {
      const res = await this.$api.$get(path);
      return res;
    },
    async fetchData() {
      this.load = true;
      try {
        const data = await this.GET_DATA(`inventarios/kardex/${this.$route.params.id}`);
        this.model = data;
        this.pagination.total = data.inventarios.length;
      } catch (e) {
        console.log(e);
      } finally {
        this.load = false;
      }
    },
    changePage(page) {
      this.pagination.current_page = page;
    },
    async Save() {
      this.load = true;
      let self = this;
      try {
        this.inventario.articulo_id = this.model.id;
        this.inventario.compra = this.model.compra;
        this.inventario.venta = this.model.venta;

        const res = await this.$api.$post('inventarios', this.inventario);
        console.log(res);
        this.$swal.fire({
          title: "Movimiento Guardado!",
          showDenyButton: false,
          showCancelButton: false,
          confirmButtonText: "Ok",
        }).then(async (result) => {
          if (result.isConfirmed) {
            await self.fetchData();
          }
        });
      } catch (e) {
        console.log(e);
        this.$swal.fire({
          title: "Error al guardar el movimiento",
          text: e.message,
          icon: "error",
        });
      } finally {
        this.load = false;
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    }
  },
  mounted() {
    this.fetchData();
  },
};
</script>