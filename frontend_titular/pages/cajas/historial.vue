<template>
  <div>
    <JcLoader :load="load" />
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card shadow-sm border-0">
              <!-- Encabezado oscuro -->
              <div class="card-header bg-dark text-white text-center rounded-top">
  <h5 class="mb-0">
    <i class="fas fa-clipboard-list me-2"></i> Historial de Cajas
  </h5>
</div>

              <!-- Cuerpo claro -->
              <div class="card-body bg-light">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                      <tr class="text-dark text-center">
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(m, i) in paginatedList" :key="i" class="text-center">
                        <td>{{ (currentPage - 1) * pageSize + i + 1 }}</td>
                        <td>{{ m.fecha }}</td>
                        <td>{{ m.user.nombre }}</td>
                        <td>{{ Number(m.total).toLocaleString('es') }} Gs.</td>
                        <td>
                          <nuxtLink
                            :to="url_editar + m.id"
                            class="btn btn-outline-primary btn-sm"
                          >
                            <i class="fas fa-eye"></i> Ver
                          </nuxtLink>
                        </td>
                      </tr>
                      <tr v-if="paginatedList.length === 0">
                        <td colspan="5" class="text-center text-muted py-3">
                          <i class="fas fa-info-circle me-2"></i>No hay registros disponibles.
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Paginación -->
                <nav aria-label="Navegación de páginas" class="mt-3">
                  <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                      <button class="page-link" @click="goToPage(1)">
                        &laquo;
                      </button>
                    </li>
                    <li
                      class="page-item"
                      v-for="pageNumber in totalPages"
                      :key="pageNumber"
                      :class="{ active: pageNumber === currentPage }"
                    >
                      <button class="page-link" @click="goToPage(pageNumber)">
                        {{ pageNumber }}
                      </button>
                    </li>
                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                      <button class="page-link" @click="goToPage(totalPages)">
                        &raquo;
                      </button>
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
      apiUrl: "cajas",
      page: "Caja",
      modulo: "Lista de Cajas",
      url_editar: "/cajas/invoice/",
      currentPage: 1,
      pageSize: 10, // Puedes ajustar esto para mostrar más o menos filas por página
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.list.length / this.pageSize);
    },
    paginatedList() {
      const start = (this.currentPage - 1) * this.pageSize;
      return this.list.slice(start, start + this.pageSize);
    },
  },
  methods: {
    async GET_DATA(path) {
      try {
        return await this.$api.$get(path);
      } catch (error) {
        console.error("Error al obtener datos:", error);
        return [];
      }
    },
    async fetchData() {
      this.load = true;
      try {
        this.list = await this.GET_DATA(this.apiUrl);
      } catch (error) {
        console.error("Error en fetchData:", error);
      } finally {
        this.load = false;
      }
    },
    goToPage(pageNumber) {
      if (pageNumber >= 1 && pageNumber <= this.totalPages) {
        this.currentPage = pageNumber;
      }
    },
  },
  mounted() {
    this.$nextTick(this.fetchData);
  },
};
</script>
<style scoped>
.card-header {
  background-color: #343a40; /* gris oscuro elegante */
  color: white;
  border-bottom: 1px solid #dee2e6;
}
.card-header.bg-dark h5 {
  color: #ffffff;
}

.card-body {
  background-color: #f8f9fa; /* gris humo muy claro */
}

.table th,
.table td {
  vertical-align: middle;
}

.table-hover tbody tr:hover {
  background-color: #e9ecef;
}

.page-link {
  border-radius: 0.3rem;
  color: #495057;
}

.page-item.active .page-link {
  background-color: #495057;
  border-color: #495057;
  color: #fff;
}

.btn-outline-primary {
  border-color: #495057;
  color: #495057;
}

.btn-outline-primary:hover {
  background-color: #495057;
  color: #fff;
}
</style>




