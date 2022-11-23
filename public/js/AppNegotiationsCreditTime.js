Vue.component('report-negotiations-credit-time', {
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
                <th class="column-title" style="width: 30%"> Cliente </th>
                <th class="column-title" style="width: 15%" >Negociación</th>
                <th class="column-title text-right" >Fecha Entrega  </th>
                <th class="column-title text-center" style="width: 30%" >Transcurrido  </th>
                <th class="column-title text-right" >Fecha Cobro  </th>
                </th>
              </tr>
            </thead class="">
            <tr v-for="(negotiation, index) of negotiations">
              <td>{{ index + 1 }}</td>
              <td > {{ padStart(negotiation.client_id) }}</td>
              <td> {{ negotiation.name }}</td>
              <td> {{ negotiation.title }}</td>
              <td > {{ negotiation.deliver_date }}</td>
              <td v-html="progress(negotiation)">  </td>
              <td> {{ negotiation.payment_date }}</td>
            </tr>

            <tbody>

            </tbody>
          </table>
        </div>
      </div>

    </div>
  `,
  props:['date_star'],
    data: function () {
    return {
      negotiations: [],
      index: 0,
       state:{
        1:{bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-success', width: 'width: 10%', title: 'Pago Completo'},
        1:{bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-success', width: 'width: 20%', title: 'Pago Completo'},
        2: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-secondary',width: 'width: 14.5%',  title: 'Proformado'},
        3: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-danger',  width: 'width: 24%',  title: 'Almacén(Selección)'},
        5: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-warning', width: 'width: 43%',  title: 'Facturado'},
        7: {bg: 'progress-bar title progress-bar-striped progress-bar-animated ',           width: 'width: 62%',  title: 'Almacén(Embalaje)'},
        9: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-primary',           width: 'width: 81%',  title: 'Pedido Despachado'},
      },
      state_default:{
        bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-white',
        title: '',
      },
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
      axios.post(this.$api_url + 'reports/negotiations/credit/time', {
          data: {
            star: this.date_star.star,
            end: this.date_star.end,
          }
        })
        .then(response => {
         this.negotiations = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            this.getCharges()
          }
        })
        .finally(() => store.state.loading = false)
    },
    progress(negotiation){
      progress = "<div class='progress'>"
      progress += "<div role='progressbar' aria-valuenow='' aria-valuemin='0'"
      progress += "aria-valuemax='100' style='width:" + negotiation.progress_percentage + "%'"

      if (negotiation.progress_percentage <= 25) {
        progress += "class='progress-bar title progress-bar-striped progress-bar-animated bg-success'"
      }
      else if(negotiation.progress_percentage >= 26 && negotiation.progress_percentage <= 50){
        progress += "class='progress-bar title progress-bar-striped progress-bar-animated primary'"
      }
      else if(negotiation.progress_percentage >= 51 && negotiation.progress_percentage <= 70){
        progress += "class='progress-bar title progress-bar-striped progress-bar-animated'"
      }
      else if(negotiation.progress_percentage >= 71 && negotiation.progress_percentage <= 95){
        progress += "class='progress-bar title progress-bar-striped progress-bar-animated bg-warning'"
      }
      else{
        progress += "class='progress-bar title progress-bar-striped progress-bar-animated bg-danger'"

      }
      progress += "> </div></div>"
      return progress
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