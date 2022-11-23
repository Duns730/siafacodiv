//.js
Vue.component('report-clients-collection-commission-bydate', {
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
                  <button class="btn btn-light btn-sm" @click="getCollectionCommission()">
                    <i class="fa fa-send"></i>
                  </button>
              </div>
            </div>
          </div> 
     </div>
        <div class="table-responsive">
          <table class="table table-striped jambo_table">
            <thead>
              <tr class="headings">
                <th class="column-title"> Id </th>
                <th class="column-title" style="width: 60%"> Cliente </th>
                <th class="column-title" >Fecha</th>
                <th class="column-title text-right" >Comisión</th>
                </th>
              </tr>
            </thead>
            <tbody>
	            <tr v-for="client of clients">
	              <td> {{   index++}}</td>
	              <td> {{ client.name }}</td>
	              <td> {{ client.date }}</td>
	              <td class="text-right"> 
	              	
	              </td>
	            </tr>
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
      total_amount: 0,
      index: 1,
    }
  },
  computed: {
    ...Vuex.mapState(['loading']),
  },
  methods:{
  	totalAmount(collection_commission){
    	this.total_amount += parseFloat(collection_commission)
    	//console.log(this.index+' '+this.total_amount)
    	this.index++
  	},
    padStart(id){
     	return id.toString().padStart(4, '0')
    },
    getCollectionCommission(){
      store.state.loading = true
      axios.post(this.$api_url + 'reports/clients/collection/commission', {
          data: {
            star: this.date_star.star,
            end: this.date_star.end,
            provisional: this.provisional,
          }
        })
        .then(response => {
         this.clients = response.data
          //console.log(response.data)
         
        })
        .catch(error => {
          if (error.response.status == 500) {
            this.getCollectionCommission()
          }
        })
        .finally(() => store.state.loading = false)

    },
  },
  watch:{
  },
  mounted(){  
    this.getCollectionCommission()
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