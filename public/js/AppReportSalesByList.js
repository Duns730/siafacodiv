Vue.component('report-sales-bylist', {
  template:`
    <div>
      <div class="x_content">
          <div class="item form-group">
            <div class="col-form-label col-md-2 col-sm-2 label-align">
              Fecha
            </div>
            <div class="col-md-3 col-sm-3 ">
              <input type="date" class="form-control" v-model="date_star.star">
            </div> 

            <div class="col-md-3 col-sm-3 ">
              <input type="date" class="form-control" v-model="date_star.end">
            </div> 

            <div class="col-md-1 col-sm-1 ">
              <div class="btn-group">
                  <button class="btn btn-light btn-sm" @click="getSales()">
                    <i class="fa fa-send"></i>
                  </button>
              </div>
            </div>
          </div> 
      </div>
      <div class="col-md-3 col-sm-8 ">
        <div class="table-responsive">
          <table class="table table-striped jambo_table">
            <thead>
              <tr class="headings">
                <th class="column-title"> Lista </th>
                <th class="column-title"> Monto </th>
                </th>
              </tr>
            </thead class="">
            <tr v-for="list of lists">
              <td> {{ list.list }}</td>
              <td class=" text-right"> 
                {{new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(list.products[0].amout)  }}
              </td>
            </tr>

            <tbody>

            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-7 col-sm-12 ">
        <canvas :id="graph_id"></canvas>
      </div>
    </div>
  `,
  props:['date_star', 'provisional'],
    data: function () {
    return {
      lists: [],
      graph_id: 'listGraph',
    }
  },
  computed: {
     ...Vuex.mapState(['loading']),
  },
  methods:{
    getSales(){
      store.state.loading = true
      axios.post(this.$api_url + 'reports/sales/bylist', {
          data: {
            star: this.date_star.star,
            end: this.date_star.end,
            provisional: this.provisional,
          }
        })
        .then(response => {
         this.lists = response.data
         getListGraph(this.lists, this.graph_id)
        })
        .catch(error => {
          if (error.response.status == 500) {
            this.getSales()
          }
        })
        .finally(() => store.state.loading = false)
    },
  },
  watch:{
  },
  mounted(){  
    this.graph_id = this.graph_id + '_' + this.provisional
    this.getSales()
  }
})

const store = new Vuex.Store({
  state: {
    loading: false,
  },
  mutations:{
  },
  actions: {
  },
  modules: {
  }
})

new Vue({
  el:'#app',
  store,
})