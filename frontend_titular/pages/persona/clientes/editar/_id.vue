<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-center">
          <div class="col-sm-8 col-12">
            <div class="card">
              <div class="card-header">
                <h3>Actualizar</h3>
              </div>
              <div class="card-body">
                <CrudUpdate :model="model" :apiUrl="apiUrl">
                  <div slot="body" class="row">
                  <div class="form-group col-3">
                      <label for="">tipo_id</label>
                     <select name="" id="" class="form-control" v-model="model.tipo_id">
                      <option v-for="m in tipos" :value="m.id">{{m.nombre}}</option>
                     </select>
                    </div>
                    
                      <div class="form-group col-4">
                      <label for="">Nombre</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.nombre"
                        class="form-control"
                        id=""
                      />
                    </div>
                   <div class="form-group col-4">
                      <label for="">apellido</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.apellido"
                        class="form-control"
                        id=""
                      />
                    </div>

                 <div class="form-group col-6">
                      <label for="">direccion</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.direccion"
                        class="form-control"
                        id=""
                      />
                    </div>
                               <div class="form-group col-6">
                      <label for="">Distrito</label>
                     <select name="" id="" class="form-control" v-model="model.distrito_id">
                      <option v-for="m in distritos" :value="m.id">{{m.nombre}}</option>
                     </select>
                    </div>
                  <div class="form-group col-3">
                      <label for="">telefono</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.telefono"
                        class="form-control"
                        id=""
                      />
                    </div>
                <div class="form-group col-3">
                      <label for="">celular</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.celular"
                        class="form-control"
                        id=""
                      />
                    </div>
                             <div class="form-group col-3">
                      <label for="">nro_ruc</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.nro_ruc"
                        class="form-control"
                        id=""
                      />
                    </div>

                    
                    <div class="form-group col-3">
                      <label for="">nro_ci</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.nro_ci"
                        class="form-control"
                        id=""
                      />
                    </div>

                       <div class="form-group col-5">
                      <label for="">correo</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.correo"
                        class="form-control"
                        id=""
                      />
                    </div>

                        <div class="form-group col-3">
                        <label for="">Persona_id</label>
                      <select name="" id="" class="form-control" v-model="model.persona_id">
                        <option v-for="m in personas" :value="m.id">{{m.nombre}}</option>
                      </select>
                      </div>

                  </div>
                </CrudUpdate>
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
        tipo_id: '',
        nombre: "",
        apellido: "",
        direccion: "",
        distrito_id: '',
        telefono: "",
        celular: "",
        nro_ruc:"",
        nro_ci:"",
        correo:"",
        persona_id:'',
      },
      apiUrl: "clientes",
      page: "Persona",
      modulo: "Clientes",
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
        await Promise.all([
          this.GET_DATA(this.apiUrl + "/" + this.$route.params.id),this.GET_DATA('tipos'),this.GET_DATA('distritos'),this.GET_DATA('personas')
        ]).then((v) => {
          this.model = v[0];
          this.tipos = v[1];
          this.distritos = v[2];
          this.personas = v[3];
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
        this.load = false;
      }
    });
  },
};
</script>
