Vue.component('app-process-payments-iva', {
  template:`
    <div>
      <div class="x_panel">
        <div class="x_title">
          <ul class="nav navbar-right panel_toolbox">
                  <li data-toggle="modal" data-target=".modalProcessPayment">
                    <a href="#" data-toggle="tooltip" data-placement="top" title data-original-title="Procesar pago de IVA">
                      <i class="fa fa-plus-square"></i> Cargar
                    </a>
                  </li>
                </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />

          <div class="item form-group">
              <label for="client_id" class="col-form-label col-md-1 col-sm-1 label-align">Cliente</label>
              <div class="col-md-7 col-sm-7 ">
                  <show-select-clients
                      :client="$store.state.client_select"
                  ></show-select-clients>
              </div>
              <div class="col-md-1 col-sm-1">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modalSelectClient">
                      <i class="fa fa-plus-square"></i>
                  </button>
              </div>


              <label for="provisional" class="col-form-label col-md-1 col-sm-1 label-align">Provisional</label>
              <div class="col-md-1 col-sm-1">
                <input type="checkbox" v-model="$store.state.provisional" class="form-control"/>
              </div>
            </div>


            <div class="row">
                <div class="table">
                  <table class="table table-striped jambo_table bulk_action small text-right">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Nro. Factura</th>
                        <th>IVA Bs.</th>
                        <th>IVA $</th>
                        <th>Factor</th>
                        <th>Estatus</th>
                      </tr>
                    </thead>
                    <tbody class="text-right">
                    <tr v-for="invoice of $store.state.client_invoices">
                      <td>{{ invoice.id }}</td>
                      <td v-html="formatDate(invoice.date)"></td>
                      <td>{{ invoice.invoice_number }}</td>
                      <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(invoice.iva_bolivar) }}</td>
                      <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(invoice.iva_dollar) }}</td>
                      <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(invoice.factor) }}</td>
                      <td>{{ invoice.status }}</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
            </div>

          <div class="ln_solid"></div>

          
        </div>
      </div>
    </div>
  `,
  props: ['payment'],
    data: function () {
    return {
      
    }
  },
  computed: {
    ...Vuex.mapState([
        'client_select', 
        'client_invoices', 
        'invoices_to_pay', 
        'form_fields_disable', 
        'bank_id',
        'type_select',
        'reference',
        'concept',
        'date',
        'amount_payment',
        'provisional',
      ]),
    ...Vuex.mapMutations(['getClients', 'formatNumber', 'getBanks']),
  },
  methods:{
    formatDate(date){
      return date.split("-").reverse().join("-")
    },
  },
  watch:{
    
  },
  mounted(){
    store.commit('getClients')
    store.commit('getBanks')
    if (this.payment.positive_balance > 0) {
      store.state.form_fields_disable = true
      store.state.amount_payment = this.payment.positive_balance
      store.state.concept = this.payment.concept
      store.state.reference = this.payment.reference
      store.state.date = this.payment.date
      store.state.type_select = this.payment.type
      store.state.bank_id = this.payment.bank
    }
  },
})


const store = new Vuex.Store({
  state: {
    bank_id: '', // id del banco seleccionado
    clients: {}, // lista de clientes registrados
    client_invoices: {}, // facturas del cliente seleccionado
    banks: [], // lista de bancos activos
    invoices_to_pay: [], // id y monto a pagar de las facturas seleccionadas
    ids_invoices_to_pay: [], //index se las facturas seleccionadas
    client_select: { // datos basicos del cliente seleccionado
      id: '',
      name: '',
    },
    total_iva: { //IVA total en dolares y bolivares solo para ser mostrado
      dollar: 0,
      bolivar: 0,
    },
    form_fields_disable: false, 
    provisional: 0, 
    loading: false,
    withholding_tax: '', // porcentaje de retencion que debe ser aplicado a las factuturas, viene dado por el cliente
    type_select: '', // unos de estos valores: 'deposito', 'cheque', 'efectivo', 'transferencia', 'zelle'
    reference: '', // referencia del pago
    concept: '', // concepto del pago
    date: '',  // fecha del pago
    amount_payment: 0, // monto del pago a procesar
    amount_charged: 0, // suma de los IVAs de las facturas seleccionadas
  },
  mutations:{
    getClients:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'clients/')
        .then(response => {
          state.clients = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getClients')
          }
        })
        .finally(() => state.loading = false)
    },
    getInvoicesPayment:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'clients/' + state.client_select.id + '/payment/iva/'+ state.provisional)
        .then(response => {
          state.client_invoices = response.data
          state.withholding_tax = state.client_invoices[0].withholding_tax
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getInvoicesPayment')
          }
        })
        .finally(() => state.loading = false)
    },
    getBanks: function(state){
      state.loading = true
      axios
        .get(this._vm.$api_url + 'banks/bolivar')
        .then(response => {
          state.banks = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getBanks')
          }
        })
        .finally(() => state.loading = false)
    },
    calculateIva:function(state) {
      index = 0
      state.total_iva.bolivar = 0
      state.total_iva.dollar = 0
      for(invoice of state.client_invoices){
        
        //state.client_invoices[index].to_pay_bolivar = parseFloat((invoice.iva_bolivar * (1 - state.withholding_tax / 100)).toFixed(2))
        //state.client_invoices[index].to_pay_dollar = parseFloat((invoice.iva_dollar * (1 - state.withholding_tax / 100)).toFixed(2))
        
        state.total_iva.bolivar += state.client_invoices[index].to_pay_bolivar
        state.total_iva.dollar += state.client_invoices[index].to_pay_dollar

        index++
      }
    },
    calculateAmountCharged:function(state){
      state.amount_charged = 0

      for(ids_invoices of state.ids_invoices_to_pay){
        state.amount_charged += state.client_invoices[ids_invoices].to_pay_bolivar
      }
    },
    formatNumber:function(state, number){
      return new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2}).format(number) 
    },
  },
  actions: {
    postPayment(commit){
      if (store.state.date != ''
        && store.state.bank_id
        && store.state.type_select 
        && store.state.reference 
        && store.state.concept 
        && store.state.amount_payment > 0
        && store.state.invoices_to_pay.length > 0
        ) {
        data = {
          title: '',
          type: 'success',
          text: `Procesando pago...`,
        }
        store.dispatch('notification',data)
      }
      else{
        data = {
          title: 'Error',
          type: 'error',
          text: `Debe ingresar todos los datos que se solicita para poder procesar el pago.`,
        }
        store.dispatch('notification',data)
        return false
      }
      store.state.loading = true
      axios
          .post(this._vm.$api_url + 'payments/process', {
            data: {
              bank_id: store.state.bank_id,
              type: store.state.type_select,
              reference: store.state.reference,
              concept: store.state.concept,
              withholding_tax: store.state.withholding_tax,
              amount_payment: store.state.amount_payment,
              date: store.state.date,
              collection_commission: 0,
              invoices_to_pay: store.state.invoices_to_pay,
              payment: 'iva',
            }
          })
          .then(response => {
            data = response.data
            if (data.status == 201) {
              data = {
                title: 'Exito',
                type: 'success',
                text: data.message,
              }
            store.dispatch('resetValues')
            }
            else if(data.status == 406) {
              data = {
                title: 'Error',
                type: 'error',
                text: data.message,
              }
            }
            store.dispatch('notification',data)
          })
          .finally(() => store.state.loading = false)

    },
    notification(commit, data){
      new PNotify({
        title: data.title,
        text:  data.text,
        type: data.type,
        styling: 'bootstrap3'
      });
    },
    resetValues(commit){
      store.state.bank_id = '' 
      store.state.client_invoices = {} 
      store.state.invoices_to_pay = [] 
      store.state.ids_invoices_to_pay = [] 
      store.state.client_select = { 
        id: '',
        name: '',
      }
      store.state.total_iva = { 
        dollar: 0,
        bolivar: 0,
      }
      store.state.withholding_tax = '' 
      store.state.type_select = '' 
      store.state.reference = '' 
      store.state.concept = '' 
      store.state.date = ''  
      store.state.amount_payment = 0 
      store.state.amount_charged = 0 
    },

  },
  modules: {
  }
})


new Vue({
  el:'#app',
  store,
  })