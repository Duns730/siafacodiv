Vue.component('report-charges-bydate', {
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
                  <button class="btn btn-light btn-sm" @click="getCharges()">
                    <i class="fa fa-send"></i>
                  </button>
              </div>
            </div>
          </div> 
     </div>
        <div class="table-responsive">
          <table class="table table-striped jambo_table small">
            <thead>
              <tr class="headings">
                <th class="column-title"> # </th>
                <th class="column-title"> Id </th>
                <th class="column-title" style="width: 40%"> Cliente </th>
                <th class="column-title" >Monto Pago</th>
                <th class="column-title" >A Favor  </th>
                </th>
              </tr>
            </thead class="">
            <tr v-for="(client, index) of clients">
              <td>{{ index + 1 }}</td>
              <td> {{ padStart(client.id) }}</td>
              <td> {{ client.name }}</td>
              <td> {{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(client.amount_payments)  }}</td>
              <td> {{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(client.amount_payments - client.amount_paid - client.collection_commission)  }}</td>
            </tr>

            <tbody>

            </tbody>
          </table>
        </div>
      </div>

    </div>
  `,
  props:['date_star', 'provisional'],
    data: function () {
    return {
      clients: [],
      index: 0,
    }
  },
  computed: {
    ...Vuex.mapState(['loading']),
  },
  methods:{
    padStart(id){
      return id.toString().padStart(4, '0')
    },
    getCharges(){
      store.state.loading = true
      axios.post(this.$api_url + 'reports/charges/bydate', {
          data: {
            star: this.date_star.star,
            end: this.date_star.end,
            provisional: this.provisional,
          }
        })
        .then(response => {
         this.clients = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            this.getCharges()
          }
        })
        .finally(() => store.state.loading = false)

    },
  },
  watch:{
  },
  mounted(){  
    this.getCharges()
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