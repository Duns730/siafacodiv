Vue.component('app-process-payments-tax-base', {
  template:`
    <div>
      <div class="x_panel">
        <div class="x_title">
          <ul class="nav navbar-right panel_toolbox">
                  <li data-toggle="modal" data-target=".modalProcessPayment">
                    <a href="#" data-toggle="tooltip" data-placement="top" title data-original-title="Procesar pago de Factura">
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
                        <th>Base Imponible Bs.</th>
                        <th>Base Imponible $</th>
                        <th>Factor</th>
                        <th>Estatus</th>
                      </tr>
                    </thead>
                    <tbody class="text-right">
                    <tr v-for="invoice of $store.state.client_invoices">
                      <td>{{ invoice.id }}</td>
                      <td v-html="formatDate(invoice.date)"></td>
                      <td>{{ invoice.invoice_number }}</td>
                      <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(invoice.tax_base_bolivar) }}</td>
                      <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(invoice.tax_base_dollar) }}</td>
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
    ...Vuex.mapMutations(['getClients', 'formatNumber', 'getBanks', 'calculateTaxBase',]),
  },
  methods:{
    formatDate(date){
      return date.split("-").reverse().join("-")
    },
  },
  watch:{
    '$store.state.client_invoices'(value_new, value_old){
      store.commit('calculateTaxBase')
    },
    '$store.state.provisional'(value_new, value_old){
      if (!value_new) {
        store.state.provisional = 0
      }
    }
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
    loading: false,
    bank_id: 0, // id del banco seleccionado
    clients: {}, // lista de clientes registrados
    client_invoices: {}, // facturas del cliente seleccionado
    banks: [], // lista de bancos activos
    invoices_to_pay: [], // id y monto a pagar de las facturas seleccionadas
    ids_invoices_to_pay: [], //index se las facturas seleccionadas
    client_select: { // datos basicos del cliente seleccionado
      id: '',
      name: '',
    },
    total_tax_base: { //IVA total en dolares y bolivares solo para ser mostrado
      dollar: 0,
      bolivar: 0,
    },
    form_fields_disable: false, 
    provisional: 0, 
    type_select: '', // unos de estos valores: 'deposito', 'cheque', 'efectivo', 'transferencia', 'zelle'
    reference: '', // referencia del pago
    concept: '', // concepto del pago
    date: '',  // fecha del pago
    collection_commission: 0, // comisión por cobranza cuando se trata de efectivo
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
        }).catch(error => {
            if (error.response.status == 500) {
              store.commit('getClients')
            }
          })
        .finally(() => state.loading = false)
    },
    getInvoicesPayment:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'clients/' + state.client_select.id + '/payment/taxbase/'+ state.provisional)
        .then(response => {
          state.client_invoices = response.data
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
        .get(this._vm.$api_url + 'banks/dollar')
        .then(response => {
          state.banks = response.data
        }).catch(error => {
            if (error.response.status == 500) {
              store.commit('getBanks')
            }
          })
        .finally(() => state.loading = false)
    },
    calculateTaxBase:function(state) {
      index = 0
      state.total_tax_base.bolivar = 0
      state.total_tax_base.dollar = 0
      for(invoice of state.client_invoices){
        state.total_tax_base.bolivar += parseFloat(state.client_invoices[index].tax_base_bolivar)
        state.total_tax_base.dollar += parseFloat(state.client_invoices[index].tax_base_dollar)
        index++
      }
    },
    calculateAmountCharged:function(state){
      state.amount_charged = 0
      for(ids_invoices of state.ids_invoices_to_pay){
        state.amount_charged += parseFloat(state.client_invoices[ids_invoices].tax_base_dollar, 2)
          console.log(parseFloat(state.client_invoices[ids_invoices].tax_base_dollar))
          console.log(state.amount_charged)
      }
      state.amount_charged = state.amount_charged.toFixed(2)
    },
    formatNumber:function(state, number){
      return new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(number) 
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
        store.dispatch('notification', data)
        return false
      }

      if (store.state.type_select != 'efectivo') {
        store.state.collection_commission = 0
      }
      store.state.loading = true
      axios
          .post(this._vm.$api_url + 'payments/process', {
            data: {
              bank_id: store.state.bank_id,
              type: store.state.type_select,
              reference: store.state.reference,
              concept: store.state.concept,
              amount_payment: store.state.amount_payment,
              date: store.state.date,
              collection_commission: store.state.collection_commission,
              invoices_to_pay: store.state.invoices_to_pay,
              payment: 'tax_base',
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
      store.state.bank_id = 0 
      store.state.client_invoices = {} 
      store.state.invoices_to_pay = [] 
      store.state.ids_invoices_to_pay = [] 
      store.state.client_select = { 
        id: '',
        name: '',
      }
      store.state.total_tax_base = { 
        dollar: 0,
        bolivar: 0,
      }
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