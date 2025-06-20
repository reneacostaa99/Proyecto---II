<template>
  <div>

    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-center">
          <div class="col-sm-8 col-12">
            <div class="card">
              <div class="card-header">
                <h3>Agregar</h3>
              </div>
              <div class="card-body">
                <CrudCreate :model="model" :apiUrl="apiUrl">
                  <div slot="body" class="row">

                   <div class="form-group col-3">
                      <label for="">Tipo Proveedor</label>
                     <select name="" id="" class="form-control" v-model="model.tipo_id">
                      <option v-for="m in tipos" :value="m.id">{{m.nombre}}</option>
                     </select>
                    </div>

                    <div class="form-group col-5">
                      <label for="">Nombre</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.nombre"
                        class="form-control"
                        id=""
                      />
                    </div>
                    <div class="form-group col-5">
                      <label for="">Apellido</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.apellido"
                        class="form-control"
                        id=""
                      />
                    </div>
                    <div class="form-group col-6">
                      <label for="">Direccion</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.direccion"
                        class="form-control"
                        id=""
                      />
                    </div>
                    <div class="form-group col-3">
                      <label for="">Distrito</label>
                     <select name="" id="" class="form-control" v-model="model.distrito_id">
                      <option v-for="m in distritos" :value="m.id">{{m.nombre}}</option>
                     </select>
                    </div>

                    <div class="form-group col-3">
                      <label for="">Telefono</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.telefono"
                        class="form-control"
                        id=""
                      />
                    </div>

                    <div class="form-group col-3">
                      <label for="">Celular</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.celular"
                        class="form-control"
                        id=""
                      />
                    </div>
 
                    <div class="form-group col-3">
                      <label for="">Nro_ruc</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.nro_ruc"
                        class="form-control"
                        id=""
                      />
                    </div>

 
                    <div class="form-group col-3">
                      <label for="">Nro_ci</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.nro_ci"
                        class="form-control"
                        id=""
                      />
                    </div>

 
                    <div class="form-group col-5">
                      <label for="">Correo</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.correo"
                        class="form-control"
                        id=""
                      />
                    </div>

                    <div class="form-group col-3">
                      <label for="">Tipo persona</label>
                     <select name="" id="" class="form-control" v-model="model.persona_id">
                      <option v-for="m in personas" :value="m.id">{{m.nombre}}</option>
                     </select>
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
      apiUrl: "proveedors",
      page: "Persona",
      modulo: "Proveedors",
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
