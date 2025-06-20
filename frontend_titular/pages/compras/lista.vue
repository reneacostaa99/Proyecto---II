<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-between">
          <div class="col-12 col-md-6">
            <div class="form-group mb-3">
              <label for="filtroNombre" class="visually-hidden">Filtrar por proveedor:</label>
              <input type="text" v-model="filtroNombre" id="filtroNombre" class="form-control" placeholder="Filtrar por proveedor">
            </div>
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="py-0 px-1">#</th>
                      <th class="py-0 px-1">FECHA</th>
                      <th class="py-0 px-1">PROVEEDOR</th>
                      <th class="py-0 px-1">TOTAL</th>
                      <th class="py-0 px-1"></th>
                      <th class="py-0 px-1">ESTADO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(m, i) in paginatedList" :key="m.id">
                      <td class="py-0 px-1">{{ (currentPage - 1) * pageSize + i + 1 }}</td>
                      <td class="py-0 px-1">{{ m.fecha }}</td>
                      <td class="py-0 px-1">{{ m.proveedor?.nombre }} {{ m.proveedor?.apellido }}</td>
                      <td class="py-0 px-0">{{ Number(m.total).toLocaleString('es') }} Gs.</td>
                      <td class="py-0 px-1">
                        <div class="btn-group">
                          <nuxtLink :to="url_editar + m.id" class="btn btn-info btn-sm py-1 px-2">
                            <i class="fas fa-eye"></i>
                          </nuxtLink>

                        </div>
                      </td>
                      <td class="py-0 px-1">
                        <span class="badge" :class="{
                          'bg-warning': m.estado === 3,
                          'bg-success': m.estado === 1
                        }">
                          {{ m.estado === 3 ? 'Pendiente' : (m.estado === 1 ? 'Concluido' : 'Otro estado') }}
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-end">
                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                      <button class="page-link" @click="goToPage(1)"><<</button>
                    </li>
                    <li class="page-item" v-for="pageNumber in totalPages" :key="pageNumber" :class="{ active: pageNumber === currentPage }">
                      <button class="page-link" @click="goToPage(pageNumber)">{{ pageNumber }}</button>
                    </li>
                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                      <button class="page-link" @click="goToPage(totalPages)">>></button>
                    </li>
                  </ul>
                </nav>
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
      list: [],
      apiUrl: "compras",
      page: "Compras",
      modulo: "Lista de compras",
      url_editar: "/compras/invoice/",
      currentPage: 1,
      pageSize: 10, // Cambia este valor según tus necesidades
      filtroNombre: '' // Nuevo filtro por proveedor
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.filteredList.length / this.pageSize);
    },
    paginatedList() {
      const start = (this.currentPage - 1) * this.pageSize;
      const end = start + this.pageSize;
      return this.filteredList.slice(start, end);
    },
    filteredList() {
      return this.list.filter(item => 
        (item.proveedor?.nombre.toLowerCase().includes(this.filtroNombre.toLowerCase()) || 
        item.proveedor?.apellido.toLowerCase().includes(this.filtroNombre.toLowerCase()))
      );
    },
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
      } catch (e) {
        console.log(e);
      } finally {
        this.load = false;
      }
    },
    Eliminar(id) {
      let self = this;
      this.$swal
        .fire({
          title: "Deseas cancelar la compra?",
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
    async marcarCompra(id) {
      try {
        const compra = this.list.find(m => m.id === id);
        await this.$api.$put(this.apiUrl + "/" + id, { pendiente: compra.pendiente });
        this.list = await this.GET_DATA(this.apiUrl);
      } catch (e) {
        console.log(e);
      }
    },
    goToPage(pageNumber) {
      this.currentPage = pageNumber;
    },
  },
  mounted() {
    this.$nextTick(async () => {
      try {
        await Promise.all([this.GET_DATA(this.apiUrl)]).then((v) => {
          this.list = v[0];
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

<style scoped>
.badge {
  display: inline-block;
  padding: 0.25em 0.4em;
  font-size: 85%;
  font-weight: 700;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: 0.25rem;
}

.bg-warning-dark {
  background-color: #d39e00 !important;
  color: #212529 !important;
}

.bg-success {
  background-color: #28a745 !important;
  color: #fff !important;
}
</style>
