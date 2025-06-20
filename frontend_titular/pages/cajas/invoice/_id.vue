<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-end">
          <div class="col-12">
            <div class="card shadow border-0">
              <div class="card-body" v-if="caja && caja.user">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <h3 class="text-dark">Detalle de Caja</h3>
                  <button
                    @click="$router.back()"
                    class="btn bg-gradient-info btn-sm mb-0"
                  >
                    <i class="ni ni-bold-left"></i> Regresar
                  </button>
                </div>

                <div class="mb-3">
                  <p class="mb-1">📅 <strong>Fecha:</strong> {{ caja.fecha }}</p>
                  <p class="mb-1 text-dark">💰 <strong>Total Ventas:</strong> {{ Number(caja.ventas).toLocaleString('es') }} Gs.</p>
                  <p class="mb-1 text-dark">🛒 <strong>Total Compras:</strong> {{ Number(caja.compras).toLocaleString('es') }} Gs.</p>
                  <p class="mb-1 text-dark">📥 <strong>Total Ingresos:</strong> {{ Number(caja.ingresos).toLocaleString('es') }} Gs.</p>
                  <p class="mb-1 text-dark">📤 <strong>Total Salidas:</strong> {{ Number(caja.salidas).toLocaleString('es') }} Gs.</p>
                  <p class="mb-1 text-dark">🧾 <strong>Total Caja:</strong> {{ Number(caja.total).toLocaleString('es') }} Gs.</p>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="bg-dark text-white">
                      <tr>
                        <th>#</th>
                        <th>Detalle</th>
                        <th>Monto</th>
                        <th>Tipo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(venta, index) in caja.ventas_detalle" :key="'venta-' + venta.id">
                        <td>{{ index + 1 }}</td>
                        <td>00100111{{ venta.factu }}</td>
                        <td class="text-success">{{ Number(venta.monto).toLocaleString('es') }} Gs.</td>
                        <td><span class="badge bg-success">Venta</span></td>
                      </tr>
                      <tr v-for="(compra, index) in caja.compras_detalle" :key="'compra-' + compra.id">
                        <td>{{ caja.ventas_detalle.length + index + 1 }}</td>
                        <td>{{ compra.factur }}</td>
                        <td class="text-danger">-{{ Number(compra.monto).toLocaleString('es') }} Gs.</td>
                        <td><span class="badge bg-danger">Compra</span></td>
                      </tr>
                      <tr v-for="(movimiento, index) in caja.movimientos" :key="'movimiento-' + movimiento.id">
                        <td>{{ caja.ventas_detalle.length + caja.compras_detalle.length + index + 1 }}</td>
                        <td>{{ movimiento.compobante }}</td>
                        <td :class="{'text-success': movimiento.tipo === 1, 'text-danger': movimiento.tipo === 2}">
                          {{ movimiento.tipo === 1 ? '' : '-' }}{{ Number(movimiento.monto).toLocaleString('es') }} Gs.
                        </td>
                        <td>
                          <span :class="{'badge bg-primary': movimiento.tipo === 1, 'badge bg-warning text-dark': movimiento.tipo === 2}">
                            {{ movimiento.tipo === 1 ? 'Ingreso' : 'Salida' }}
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div v-else>
                <p>Cargando información de la caja...</p>
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
  data() {
    return {
      load: true,
      caja: {
        user: {},
        ventas_detalle: [],
        compras_detalle: [],
        movimientos: [],
        compras: {
          timbrado: '',
        }
      },
      apiUrl: "cajas",
      page: "Detalle de Caja",
      modulo: "Caja",
    };
  },
  methods: {
    async GET_DATA(id) {
      const res = await this.$api.$get(`${this.apiUrl}/${id}`);
      return res;
    },
    async EliminarItem(id) {
      this.load = true;
      try {
        const res = await this.$api.$delete(`${this.apiUrl}/${id}`);
        console.log(res);
        this.$router.push('/cajas');
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
          title: "¿Deseas eliminar?",
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
  },
  async mounted() {
    this.load = true;
    try {
      const cajaId = this.$route.params.id;
      const cajaData = await this.GET_DATA(cajaId);
      this.caja = cajaData;
    } catch (e) {
      console.log(e);
    } finally {
      this.load = false;
    }
  },
};
</script>

<style scoped>
.texto-rojo {
  color: red;
}
</style>