Vue.component('report-sales', {
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
                  <button class="btn btn-light btn-sm" @click="downSales()">
                    <i class="fa fa-file-pdf-o"></i>
                  </button>
              </div>
            </div>
          </div> 
     </div>
        <div class="table-responsive">
          <table class="table table-striped jambo_table small">
            <thead>
              <tr class="headings">
                <th class="column-title" style="width: 9%">Fecha</th>
                <th class="column-title" style="width: 8%">Factura</th>
                <th class="column-title" style="width: 8%">Id</th>
                <th class="column-title" style="width: 40%"> Cliente </th>
                <th class="column-title" >Base Imponible  </th>
                <th class="column-title" >IVA  </th>
                <th class="column-title" >Total  </th>
                <th class="column-title">Factor de Cambio </th>
                <th class="column-title">Estatus </th>
                <th class="column-title" style="width:30px">Acciones </th>
                </th>
              </tr>
            </thead class="">
            <tr v-for="sale of sales">
              <td v-html="formatDate(sale.date)"> </td>
              <td> {{ sale.invoice_number }}</td>
              <td> {{ sale.client.id }}</td>
              <td> {{ sale.client.name }}</td>
              <td> {{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(sale.tax_base_dollar)    }}</td>
              <td> {{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(sale.iva_dollar)    }}</td>
              <td> {{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(sale.total_operation_dollar)    }}</td>
              <td> {{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(sale.factor)    }}</td>
              <td> {{ sale.status }}</td>
              <td>
                <a :href="urlShowInvoice(sale.id)" class="btn btn-primary btn-sm">
                 <i class="success fa fa-eye"></i>
                </a>
              </td>

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
      sales: [],
    }
  },
  computed: {
    ...Vuex.mapState(['loading']),
  },
  methods:{
    formatDate(date){
      return date.split("-").reverse().join("-")
    },
    urlShowInvoice(id){
      return this.$base_url + 'invoices/' + id 
    },  
    getSales(){
      store.state.loading = true
      axios.post(this.$api_url + 'reports/sales', {
          data: {
            star: this.date_star.star,
            end: this.date_star.end,
            provisional: this.provisional,
          }
        })
        .then(response => {
         this.sales = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            this.getSales()
          }
        })
        .finally(() => store.state.loading = false)
    },
    downSales(){
      window.open(this.$api_url + 'reports/sales/down/'+this.date_star.star+'/'+this.date_star.end+'/'+this.provisional, 'Reporte', 'width=800,height=800')
    }
    
  },
  watch:{
  },
  mounted(){  
    this.getSales()
  }
})

const store = new Vuex.Store({
  state: {
    loading: false,
    data_target: '.modalSearchInvoice',
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