<template>
  <div id="dashboard-analytics">
    <div class="vx-row">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line icon="UsersIcon" statistic="145.6k" statisticTitle="Ventas Actuales"
          :chartData="subscribersGained.series" type="area"></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line icon="DollarSignIcon" statistic="465.6k" statisticTitle="Ventas Año Anterior"
          :chartData="subscribersGained.series" type="area" color="warning"></statistics-card-line>
      </div>
      <div class="vx-col w-full md:w-1/2 mb-base">
        <vx-card title="Cumplimiento Pedidos">
          <template slot="actions">
            <feather-icon icon="HelpCircleIcon" svgClasses="w-6 h-6 text-grey"></feather-icon>
          </template>

          <!-- CHART -->
          <template slot="no-body">
            <div class="mt-1">
              <vue-apex-charts type="radialBar" height="200" :options="goalOverview.chartOptions"
                :series="goalOverview.series" />
            </div>
          </template>

          <!-- DATA -->
          <div class="flex justify-between text-center mt-6" slot="no-body-bottom">
            <div class="w-1/2 border border-solid d-theme-border-grey-light border-r-0 border-b-0 border-l-0">
              <p class="mt-4">Completado</p>
              <p class="mb-4 text-3xl font-semibold">786,617</p>
            </div>
            <div class="w-1/2 border border-solid d-theme-border-grey-light border-r-0 border-b-0">
              <p class="mt-4">En progreso</p>
              <p class="mb-4 text-3xl font-semibold">13,561</p>
            </div>
          </div>
        </vx-card>
      </div>
    </div>

    <div class="vx-row">
      <!-- CARD 9: DISPATCHED ORDERS -->
      <div class="vx-col w-full">
        <vx-card title="Ultimos Pedidos">
          <div slot="no-body" class="mt-4">
            <vs-table :data="dispatchedOrders" class="table-dark-inverted">
              <template slot="thead">
                <vs-th>PEDIDO NO.</vs-th>
                <vs-th>ESTADO</vs-th>
                <vs-th>VENDEDOR</vs-th>
                <vs-th>CIUDAD</vs-th>
                <vs-th>DISTANCIA</vs-th>
                <vs-th>INICIO VENTA</vs-th>
                <vs-th>FIN DE VENTA</vs-th>
              </template>

              <template slot-scope="{data}">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                  <vs-td :data="data[indextr].orderNo">
                    <span>#{{ data[indextr].orderNo }}</span>
                  </vs-td>
                  <vs-td :data="data[indextr].status">
                    <span class="flex items-center px-2 py-1 rounded">
                      <div class="h-3 w-3 rounded-full mr-2" :class="'bg-' + data[indextr].statusColor"></div>
                      {{ data[indextr].status }}
                    </span>
                  </vs-td>
                  <vs-td :data="data[indextr].orderNo">
                    <ul class="users-liked user-list">
                      <li v-for="(user, userIndex) in data[indextr].usersLiked" :key="userIndex">
                        <vx-tooltip :text="user.name" position="bottom">
                          <vs-avatar :src="user.img" size="30px"
                            class="border-2 border-white border-solid -m-1"></vs-avatar>
                        </vx-tooltip>
                      </li>
                    </ul>
                  </vs-td>
                  <vs-td :data="data[indextr].orderNo">
                    <span>{{ data[indextr].location }}</span>
                  </vs-td>
                  <vs-td :data="data[indextr].orderNo">
                    <span>{{ data[indextr].distance }}</span>
                    <vs-progress :percent="data[indextr].distPercent" :color="data[indextr].statusColor"></vs-progress>
                  </vs-td>
                  <vs-td :data="data[indextr].orderNo">
                    <span>{{ data[indextr].startDate }}</span>
                  </vs-td>
                  <vs-td :data="data[indextr].orderNo">
                    <span>{{ data[indextr].estDelDate }}</span>
                  </vs-td>
                </vs-tr>
              </template>
            </vs-table>
          </div>

        </vx-card>
      </div>
    </div>

  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue';
export default {
  name: 'ZapecHome',

  data() {
    return {
      checkpointReward: {},
      subscribersGained: {},
      ordersRecevied: {},
      dispatchedOrders: [],
      img: require('./avatar-s-1.jpg'),
      analyticsData: {},
      goalOverview: {},
    };
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser
    },
  },

  mounted() {

  },
  created() {
    this.subscribersGained = {
      series: [{
        name: 'Subscribers',
        data: [28, 40, 36, 52, 38, 60, 55]
      }],
      chartOptions: {
        grid: {
          show: false,
          padding: {
            left: 0,
            right: 0
          }
        },
        chart: {
          toolbar: {
            show: false
          },
          sparkline: {
            enabled: true
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth',
          width: 2.5
        },
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
          }
        },
        xaxis: {
          type: 'numeric',
          lines: {
            show: false
          },
          axisBorder: {
            show: false
          },
          labels: {
            show: false
          }
        },
        yaxis: [{
          y: 0,
          offsetX: 0,
          offsetY: 0,
          padding: {
            left: 0,
            right: 0
          }
        }],
        tooltip: {
          x: {
            show: false
          }
        }
      }
    }

    this.dispatchedOrders = [{
      orderNo: 879985,
      status: 'Moving',
      statusColor: 'success',
      operator: 'Cinar Knowles',
      operatorImg: this.img,
      usersLiked: [{
        name: 'Vennie Mostowy',
        img: this.img
      }, {
        name: 'Elicia Rieske',
        img: this.img
      }, {
        name: 'Julee Rossignol',
        img: this.img
      }, {
        name: 'Darcey Nooner',
        img: this.img
      }],
      location: 'Anniston, Alabama',
      distance: '130 km',
      distPercent: 80,
      startDate: '26/07/2018',
      estDelDate: '28/07/2018'
    }, {
      orderNo: 156897,
      status: 'Pending',
      statusColor: 'warning',
      operator: 'Britany Ryder',
      operatorImg: this.img,
      usersLiked: [{
        name: 'Trina Lynes',
        img: this.img
      }, {
        name: 'Lilian Nenez',
        img: this.img
      }, {
        name: 'Alberto Glotzbach',
        img: this.img
      }],
      location: 'Cordova, Alaska',
      distance: '234 km',
      distPercent: 60,
      startDate: '26/07/2018',
      estDelDate: '28/07/2018'
    }, {
      orderNo: 568975,
      status: 'Moving',
      statusColor: 'success',
      operator: 'Kishan Ashton',
      operatorImg: this.img,
      usersLiked: [{
        name: 'Lai Lewandowski',
        img: this.img
      }, {
        name: 'Elicia Rieske',
        img: this.img
      }, {
        name: 'Darcey Nooner',
        img: this.img
      }, {
        name: 'Julee Rossignol',
        img: this.img
      }, {
        name: 'Jeffrey Gerondale',
        img: this.img
      }],
      location: 'Florence, Alabama',
      distance: '168 km',
      distPercent: 70,
      startDate: '26/07/2018',
      estDelDate: '28/07/2018'
    }, {
      orderNo: 245689,
      status: 'Canceled',
      statusColor: 'danger',
      operator: 'Anabella Elliott',
      operatorImg: this.img,
      usersLiked: [{
        name: 'Vennie Mostowy',
        img: this.img
      }, {
        name: 'Elicia Rieske',
        img: this.img
      }],
      location: 'Clifton, Arizona',
      distance: '125 km',
      distPercent: 95,
      startDate: '26/07/2018',
      estDelDate: '28/07/2018'
    }]

    this.analyticsData = {
      goalOverviewRadialBar: {
        analyticsData: {
          completed: 786617,
          inProgress: 13561
        },
        series: [83]
      },
    }

    this.goalOverview = {
      series: [83],
      chartOptions: {
        plotOptions: {
          radialBar: {
            size: 110,
            startAngle: -150,
            endAngle: 150,
            hollow: {
              size: '77%'
            },
            track: {
              background: '#bfc5cc',
              strokeWidth: '50%'
            },
            dataLabels: {
              name: {
                show: false
              },
              value: {
                offsetY: 18,
                color: '#99a2ac',
                fontSize: '4rem'
              }
            }
          }
        },
        colors: ['#00db89'],
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#00b5b5'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
          }
        },
        stroke: {
          lineCap: 'round'
        },
        chart: {
          sparkline: {
            enabled: true
          },
          dropShadow: {
            enabled: true,
            blur: 3,
            left: 1,
            top: 1,
            opacity: 0.1
          }
        }
      }
    }
  },
  methods: {
  },
};
</script>
