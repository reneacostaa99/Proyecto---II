<template>
  <div>

    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-center">
          <div class="col-sm-8 col-12">
            <div class="card">
              <div class="card-header">
                <h3>Talonario</h3>
              </div>
              <div class="card-body">
                <CrudCreate :model="model" :apiUrl="apiUrl" >
                  <div slot="body" class="row" style="margin-top: 30px;">
                    

<div slot="body" class="row g-3">

  <div class="col-md-6">
    <label for="timbrado" class="form-label">Timbrado</label>
    <input
      type="text"
      class="form-control"
      id="timbrado"
      v-model="model.timbrado"
      required
    />
  </div>

  <div class="col-md-6">
    <label for="establecimiento" class="form-label">Código de establecimiento</label>
    <input
      type="text"
      class="form-control"
      id="establecimiento"
      v-model="model.establecimiento"
      required
    />
  </div>

  <div class="col-md-6">
    <label for="punto" class="form-label">Punto de expedición</label>
    <input
      type="text"
      class="form-control"
      id="punto"
      v-model="model.punto"
      required
    />
  </div>

  <div class="col-md-6">
    <label for="desde" class="form-label">Nro. desde</label>
    <input
      type="text"
      class="form-control"
      id="desde"
      v-model="model.nro_desde"
      required
    />
  </div>

  <div class="col-md-6">
    <label for="hasta" class="form-label">Nro. hasta</label>
    <input
      type="text"
      class="form-control"
      id="hasta"
      v-model="model.nro_hasta"
      required
    />
  </div>

  <div class="col-md-6">
    <label for="fecha" class="form-label">Fecha de vencimiento</label>
    <input
      type="date"
      class="form-control"
      id="fecha"
      v-model="model.vencimiento"
      required
    />
  </div>

</div>

                  </div>
                </CrudCreate>
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
      title: this.modulo
    };
  },
  data() {
    return {
 model: {
  timbrado: "",
  factura: "",
  total: 0,
  pago: 0,
  cambio: 0,
  tipo: "",
  cliente_id: "",
  motivo: "",
  forma_pagov: "",
  // otros si es necesario
},
      apiUrl: "clientes",
      page: "Factura",
      modulo: "Facturas",
      tipos:[],
      distritos:[],
      personas:[],
    };
  },
  methods: {
    async GET_DATA(path) {
      const res = await this.$api.$get(path);
      return res;
    },

  },
  mounted() {
    this.$nextTick(async () => {
      try {
        await Promise.all([this.GET_DATA('tipos'),this.GET_DATA('distritos'),this.GET_DATA('personas')]).then((v) => {
          this.tipos = v[0];
          this.distritos = v[1];
          this.personas = v[2];
          if(this.tipos.length){
            this.model.tipo_id = this.tipos[0].id
          }
          if(this.distritos.length){
            this.model.distrito_id = this.distritos[0].id
          }
          if(this.personas.length){
            this.model.persona_id = this.personas[0].id
          }
        });
      } catch (e) {
        console.log(e);
      } finally {
        this.load=false
      }
    });
  },
};
</script>
