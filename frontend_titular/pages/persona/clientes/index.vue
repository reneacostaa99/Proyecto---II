<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-end">
          <div class="col-2">
            <nuxtLink :to="url_nuevo" class="btn btn-dark btn-sm w-100">
              <i class="fas fa-plus"></i> Agregar
            </nuxtLink>
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-12">
            <div class="form-group mb-3">
              <label for="filtroNombre" class="visually-hidden">Filtrar por nombre:</label>
              <input type="text" v-model="filtroNombre" id="filtroNombre" class="form-control" placeholder="Filtrar por nombre">
            </div>
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="py-0 px-0">#</th>
                      <th class="py-0 px-0"></th>
                      <th class="py-0 px-0 text-left">Tipo</th>
                      <th class="py-0 px-1 text-right">Nombre</th>
                      <th class="py-0 px-1">Apellido</th>
                      <th class="py-0 px-1">Direccion</th>
                      <th class="py-0 px-1">Distrito</th>
                      <th class="py-0 px-1">Telefono</th>
                      <th class="py-0 px-1">Celular</th>
                      <th class="py-0 px-1">Nro_ruc</th>
                      <th class="py-0 px-1">Nro_ci</th>   
                      <th class="py-0 px-1">Correo</th>
                      <th class="py-0 px-1">Clase</th>                                                                  
                      <th class="py-0 px-1"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(m, i) in paginatedList" :key="m.id">
                      <td class="py-0 px-1">{{ (currentPage - 1) * pageSize + i + 1 }}</td>
                      <td class="py-0 px-1"></td>
                      <td class="py-0 px-1">{{ m.tipo.nombre }}</td>                     
                      <td class="py-0 px-1">{{ m.nombre }}</td>
                      <td class="py-0 px-1">{{ m.apellido }}</td>  
                      <td class="py-0 px-1">{{ m.direccion }}</td>        
                      <td class="py-0 px-1">{{ m.distrito.nombre }}</td> 
                      <td class="py-0 px-1">{{ m.telefono }}</td>  
                      <td class="py-0 px-1">{{ m.celular }}</td>                                                          
                      <td class="py-0 px-1">{{ m.nro_ruc }}</td>
                      <td class="py-0 px-1">{{ m.nro_ci }}</td>
                      <td class="py-0 px-1">{{m.correo}}</td>
                      <td class="py-0 px-1">{{m.persona.nombre}}</td>
                      <td class="py-0 px-1">
                        <div class="btn-group">
                          <nuxtLink :to="url_editar + m.id" class="btn btn-info btn-sm py-1 px-2">
                            <i class="fas fa-pen"></i>
                          </nuxtLink>
                          <button type="button" @click="Eliminar(m.id)" class="btn btn-danger btn-sm py-1 px-2">
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
  head() {
    return {
      title: this.modulo,
    };
  },

  data() {
    return {
      load: true,
      list: [],
      apiUrl: "clientes",
      page: "Persona",
      modulo: "Clientes",
      url_nuevo: "/persona/clientes/nuevo",
      url_editar: "/persona/clientes/editar/",
      currentPage: 1,
      pageSize: 10, // Cambia este valor según tus necesidades
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
      return this.list.filter(item => 
        item.nombre.toLowerCase().includes(this.filtroNombre.toLowerCase()) || 
        item.apellido.toLowerCase().includes(this.filtroNombre.toLowerCase())
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
