<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-between">
          <div class="col-12 col-md-6"> <!-- Nueva columna -->
            <div class="form-group mb-3"> <!-- Ajuste de espacio -->
              <label for="filtroNombre" class="visually-hidden">Filtrar por nombre:</label>
              <input type="text" v-model="filtroNombre" id="filtroNombre" class="form-control" placeholder="Filtrar por nombre"> <!-- Cambiado el ancho del input -->
            </div>
          </div>
          <div class="col-12 col-md-4"> <!-- Nueva columna para el botón "Agregar" -->
            <nuxt-link :to="url_nuevo" class="btn btn-dark btn-sm w-50">
              <i class="fas fa-plus"></i> Agregar
            </nuxt-link>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <th class="py-0 px-1">#</th>
                    <th class="py-0 px-1">NOMBRE</th>
                    <th class="py-0 px-1"></th>
                  </thead>
                  <tbody>
                    <tr v-for="(m, i) in paginatedList" :key="m.id">
                      <td class="py-0 px-1">{{ (currentPage - 1) * pageSize + i + 1 }}</td>
                      <td class="py-0 px-1">{{ m.nombre }}</td>
                      <td class="py-0 px-1">
                        <div class="btn-group">
                          <nuxt-link :to="`${url_editar}${m.id}`" class="btn btn-info btn-sm py-1 px-2">
                            <i class="fas fa-pen"></i>
                          </nuxt-link>
                          <button type="button" @click="eliminarItem(m.id)" class="btn btn-danger btn-sm py-1 px-2">
                            <i class="fas fa-trash"></i>
                          </button>
                        </div>
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
  name: "IndexPage",
  data() {
    return {
      load: true,
      list: [],
      apiUrl: 'marcas',
      page: 'Configuracion',
      modulo: 'Marcas',
      url_nuevo: '/configuracion/marcas/nuevo',
      url_editar: '/configuracion/marcas/editar/',
      currentPage: 1,
      pageSize: 10, // Change this value according to your needs
      filtroNombre: '' // Nuevo filtro por nombre
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
      return this.list.filter(item => item.nombre.toLowerCase().includes(this.filtroNombre.toLowerCase()));
    },
  },
  methods: {
    async getData(path) {
      const res = await this.$api.$get(path);
      return res;
    },
    async eliminarItem(id) {
      this.load = true;
      try {
        const res = await this.$api.$delete(`${this.apiUrl}/${id}`);
        console.log(res);
        await this.getData(this.apiUrl).then((data) => {
          this.list = data;
          this.load = false;
        });
      } catch (e) {
        console.log(e);
        this.load = false;
      }
    },
    goToPage(pageNumber) {
      this.currentPage = pageNumber;
    },
  },
  mounted() {
    this.$nextTick(async () => {
      try {
        await this.getData(this.apiUrl).then((data) => {
          this.list = data;
          this.load = false;
        });
      } catch (e) {
        console.log(e);
        this.load = false;
      }
    });
  },
};
</script>
