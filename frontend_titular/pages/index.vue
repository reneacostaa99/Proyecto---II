
 <template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">
                        Articulos
                      </p>
                      <h5 class="font-weight-bolder mb-0">
                        {{ dashboard.articulos }}
                        <span
                          class="text-success text-sm font-weight-bolder"
                        ></span>
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div
                      class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md"
                    >
                      <i
                        class="ni ni-money-coins text-lg opacity-10"
                        aria-hidden="true"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">
                        Usuarios
                      </p>
                      <h5 class="font-weight-bolder mb-0">
                        {{ dashboard.usuarios }}
                        <span
                          class="text-success text-sm font-weight-bolder"
                        ></span>
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div
                      class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md"
                    >
                      <i
                        class="ni ni-world text-lg opacity-10"
                        aria-hidden="true"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">
                        Total ventas
                      </p>
                      <h5 class="font-weight-bolder mb-0">
                        {{ Number(dashboard.compras).toLocaleString("es") }}
                        <span
                          class="text-danger text-sm font-weight-bolder"
                        ></span>
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div
                      class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md"
                    >
                      <i
                        class="ni ni-paper-diploma text-lg opacity-10"
                        aria-hidden="true"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">
                        Total compras
                      </p>
                      <h5 class="font-weight-bolder mb-0">
                        {{ Number(dashboard.ventas).toLocaleString("es") }}
                        <span
                          class="text-success text-sm font-weight-bolder"
                        ></span>
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div
                      class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md"
                    >
                      <i
                        class="ni ni-cart text-lg opacity-10"
                        aria-hidden="true"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<div class="row my-4">
  <!-- Gráfico: Ventas de los últimos 3 meses -->
  <div class="col-md-6">
    <div class="card z-index-2">
      <div class="card-header pb-0">
        <h6>Ventas de los últimos 3 meses</h6>
        <p class="text-sm">
          <i class="fa fa-arrow-up text-success"></i>
          <span class="font-weight-bold">Resumen gráfico</span>
        </p>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Tabla: Top 5 artículos más vendidos -->
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">Top 5 artículos más vendidos</h6>
      </div>
      <div class="card-body p-3">
        <table class="table table-sm table-striped mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Artículo</th>
              <th>Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in dashboard.mas_vendidos" :key="item.id">
              <td>{{ index + 1 }}</td>
              <td>{{ item.nombre }}</td>
              <td>{{ item.cantidad }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
    <!-- Tabla: Artículos críticos más vendidos -->
  <div class="col-md-6">
    <div class="card shadow h-100 py-2" style="background-color: transparent;">
     <div class="card-header bg-transparent text-dark">
        <h6 class="mb-0">Artículos críticos más vendidos (3 meses)</h6>
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Artículo</th>
              <th>Vendido</th>
              <th>Stock</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in dashboard.criticos_vendidos" :key="item.id">
              <td>{{ index + 1 }}</td>
              <td>{{ item.nombre }}</td>
              <td>{{ item.cantidad }}</td>
              <td>{{ item.stock }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Gráfico: Proveedores vs Clientes -->
<div class="col-md-6">
  <div class="card">
    <div class="card-header">
      <h6 class="mb-0">Proveedores vs Clientes</h6>
    </div>
    <div class="card-body p-3" style="height: 220px;">
      <canvas id="chart-pie" style="height: 100%; max-height: 180px;"></canvas>
    </div>
  </div>
</div>
</div>

<div class="row">



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
      title: "Index",
    };
  },
  data() {
    return {
      user: {},
      page: "Dashboard",
      modulo: "Dashboard",
      load: false,
      dashboard: {
        meses: [],
         mas_vendidos: [],
          criticos_vendidos: [],
           proveedores_clientes: {}
      },
    };
  },
  methods: {
    async GET_DATA(path) {
      const res = await this.$api.$get(path);
      return res;
    },
  },
mounted() {
  this.$nextTick(() => {
    let user = localStorage.getItem("userAuth");
    this.user = JSON.parse(user);
    this.$nextTick(async () => {
      let self = this;
      this.load = true;

      try {
     await Promise.all([this.GET_DATA("dashboard")]).then((v) => {
  this.dashboard = v[0];
  this.dashboard.proveedores_clientes = v[0].proveedores_clientes;
  this.dashboard.meses = this.dashboard.meses.slice(-3); // seguridad: limitar a 3 meses
        });
      } catch (e) {
        console.error(e);
      } finally {
        this.load = false;

        var ctx2 = document.getElementById("chart-line").getContext("2d");
        var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
        gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
        gradientStroke1.addColorStop(0, "rgba(203,12,159,0)");

        new Chart(ctx2, {
          type: "line",
          data: {
            labels: self.dashboard.meses.map((m) => m.mes),
            datasets: [
              {
                label: "Ventas",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#cb0c9f",
                borderWidth: 3,
                backgroundColor: gradientStroke1,
                fill: true,
                data: self.dashboard.meses.map((m) => m.total),
                maxBarThickness: 6,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false,
              },
            },
            interaction: {
              intersect: false,
              mode: "index",
            },
            scales: {
              y: {
                grid: {
                  drawBorder: false,
                  display: true,
                  drawOnChartArea: true,
                  drawTicks: false,
                  borderDash: [5, 5],
                },
                ticks: {
                  display: true,
                  padding: 10,
                  color: "#b2b9bf",
                  font: {
                    size: 11,
                    family: "Open Sans",
                    style: "normal",
                    lineHeight: 2,
                  },
                },
              },
              x: {
                grid: {
                  drawBorder: false,
                  display: false,
                  drawOnChartArea: false,
                  drawTicks: false,
                },
                ticks: {
                  display: true,
                  color: "#b2b9bf",
                  padding: 20,
                  font: {
                    size: 11,
                    family: "Open Sans",
                    style: "normal",
                    lineHeight: 2,
                  },
                },
              },
            },
          },
        });
        var ctxPie = document.getElementById("chart-pie").getContext("2d");

new Chart(ctxPie, {
  type: "pie",
  data: {
    labels: ["Proveedores", "Clientes"],
    datasets: [{
      data: [
        this.dashboard.proveedores_clientes.proveedores,
        this.dashboard.proveedores_clientes.clientes
      ],
      backgroundColor: ["#f5365c", "#2dce89"],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom',
        labels: {
          color: "#344767"
        }
      }
    }
  }
});

      }
    });
  });
},

};
</script>
 