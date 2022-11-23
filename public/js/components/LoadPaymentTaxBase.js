Vue.component('load-payment-tax-base', {
  template:`
    <div>
      <div class="row">
        <div class="col-md-8 col-sm-8">
          <div class="item form-group">
            <label class="col-form-label col-md-1 col-sm-1 label-align">Cliente</label>
            <div class="col-md-11 col-sm-11 ">
              <input class="form-control" type="text" 
                disabled="" 
                v-model="$store.state.client_select.name">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-1 col-sm-1 label-align">Fecha</label>
            <div class="col-md-5 col-sm-5 ">
              <input class="form-control" type="date" 
                v-model="$store.state.date" 
                :disabled="$store.state.form_fields_disable">
            </div>
            
            <label class="col-form-label col-md-2 col-sm-2 label-align">Referencia</label>
            <div class="col-md-4 col-sm-4 form-group has-feedback">
              <input class="form-control has-feedback-right" 
                type="text" v-model="$store.state.reference" 
                :disabled="$store.state.form_fields_disable">
            </div>
            
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-1 col-sm-1 label-align">Monto</label>
            <div class="col-md-5 col-sm-5 ">
              <input class="form-control" type="number"  
              min="1" :disabled="$store.state.form_fields_disable"
              v-model="$store.state.amount_payment">
            </div>

            <label class="col-form-label col-md-2 col-sm-2 label-align">Tipo</label>
            <div class="col-md-4 col-sm-4 ">
              <select class="form-control" 
              :disabled="$store.state.form_fields_disable"
              v-model="$store.state.type_select">
                <option v-for="type of types">
                {{ type }}
                </option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label v-if="$store.state.type_select != 'nota de credito'" class="col-form-label col-md-1 col-sm-1 label-align">Banco</label>
            <div v-if="$store.state.type_select != 'nota de credito'" class="col-md-5 col-sm-5 ">
              <select class="form-control" 
              :disabled="$store.state.form_fields_disable"
              v-model="$store.state.bank_id">
                <option v-for="bank of $store.state.banks" :value="bank.id">
                {{ bank.name }}
                </option>
              </select>
            </div>

            <label v-if="$store.state.type_select == 'efectivo'" class="col-form-label col-md-2 col-sm-2 label-align">Comisión Cobranza</label>
            <div v-if=" $store.state.type_select == 'efectivo'" class="col-md-4 col-sm-4 ">
              <input class="form-control" type="number"  
              min="1" :disabled="$store.state.form_fields_disable"
              v-model="$store.state.collection_commission">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2 label-align">Concepto</label>
            <div class="col-md-10 col-sm-10 ">
              <textarea class="form-control" 
                v-model="$store.state.concept" 
                rows="3"
              ></textarea>
            </div>
          </div>
        </div>

        

        <div class="col-md-4 col-sm-4">
          <div class="table col-md-12 col-sm-12">
            <table class="table table-striped small text-right">
              <thead>
                <tr>
                  <td>Base Imp. $</td>
                  <td>{{ formatNumber($store.state.total_tax_base.dollar) }}</td>
                </tr>
                <tr>
                  <td>Base Imp. Bs</td>
                  <td>{{ formatNumber($store.state.total_tax_base.bolivar) }}</td>
                </tr>
                <tr>
                  <td>Saldo a favor</td>
                  <td>{{ formatNumber($store.state.amount_payment - $store.state.amount_charged - $store.state.collection_commission) }}</td>
                </tr>
              </thead>
            </table>
          </div>
        </div>

      </div>

        

        <div class="row">
          <div class="table">
            <table class="table table-striped jambo_table bulk_action small text-right">
              <thead>
                <tr>
                  <th style="width: 30px"></th>
                  <th>Nro. Factura</th>
                  <th>Monto a pagar</th>
                  <th>Estatus</th>
                </tr>
              </thead>
              <tbody >
              <tr v-for="(invoice, index) of $store.state.client_invoices">
                <td>
                  <input type="checkbox" :value="index" v-model="$store.state.ids_invoices_to_pay">
                </td>
                <td>{{ invoice.invoice_number }}</td>
                <td>
                  {{ formatNumber(invoice.tax_base_dollar) }}
                </td>
                <td>{{ invoice.status }}</td>
              </tr>
              </tbody>
            </table>
          </div>
      </div>



    </div>
  `,
    data: function () {
    return {
      types: ['cheque', 'deposito', 'efectivo', 'nota de credito', 'transferencia', 'zelle'],
    }
  },
  computed: {
    ...Vuex.mapState([
      'client_select',
      'client_invoices',
      'invoices_to_pay',
      'ids_invoices_to_pay',
      'bank_id',
      'type_select',
      'amount_payment',
      'banks',
      'total_iva',
      'amount_charged',
      'reference',
      'concept',
      'date',
      'form_fields_disable',
      'collection_commission',

      ]),
    ...Vuex.mapMutations([
      'calculateAmountCharged',
      ]),
  },
  methods:{
    ...Vuex.mapActions([
      'notification',
      ]),
    formatNumber(number){
      return new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(number) 
    },
    selectionInvoicesToPay(){
      amount = store.state.amount_payment - store.state.collection_commission
      store.state.invoices_to_pay = []

      for(ids_invoices of store.state.ids_invoices_to_pay){
        amount -= parseFloat(store.state.client_invoices[ids_invoices].tax_base_dollar)

        if (amount >= 0) {
          paid_out = {
            'id': store.state.client_invoices[ids_invoices].id,
            'paid_out': parseFloat(store.state.client_invoices[ids_invoices].tax_base_dollar),
          }
        }
        else{
          paid_out = {
            'id': store.state.client_invoices[ids_invoices].id,
            'paid_out':parseFloat(store.state.client_invoices[ids_invoices].tax_base_dollar) + parseFloat(amount),
          }
        }
        store.state.invoices_to_pay.push(paid_out)
        }

    },
  },
  watch:{
    '$store.state.amount_payment'(value_new, value_old){
      this.selectionInvoicesToPay()
    },
    '$store.state.type_select'(value_new, value_old){
      if (value_new != 'efectivo') {
        store.state.collection_commission = 0
      }
      if (value_new == 'nota de credito') {
        store.state.bank_id = true
      }
    },
    '$store.state.collection_commission'(value_new, value_old){

      console.log('amount_payment '+store.state.amount_payment)
      console.log('amount_charged '+store.state.amount_charged)
      console.log('collection_commission '+store.state.collection_commission)
      console.log(store.state.invoices_to_pay)
      if ((store.state.amount_payment - store.state.amount_charged - store.state.collection_commission) < 0) {
        store.state.collection_commission = 0
        data = {
              title: 'Error',
              type: 'error',
              text: `El restante del pago es inferior al monto que esta ingresando.`,
            }
            store.dispatch('notification', data)
      }
    },
    '$store.state.invoices_to_pay'(value_new, value_old){
      store.commit('calculateAmountCharged')
    },
    '$store.state.ids_invoices_to_pay'(value_new, value_old){
      if (value_new.length > value_old.length) {
        if (store.state.amount_payment > 0) {
          if ((store.state.amount_payment - store.state.amount_charged - store.state.collection_commission) > 0) {
              this.selectionInvoicesToPay()
          }
          else{
            store.state.ids_invoices_to_pay.pop()
            
            store.commit('calculateAmountCharged')
            data = {
              title: 'Error',
              type: 'error',
              text: `La suma de las facturas es superior al pago, no puede seleccionar más.`,
            }
            store.dispatch('notification', data)
          }
        }
        else if(store.state.ids_invoices_to_pay.length > 0){
          
          store.state.ids_invoices_to_pay.pop()
          data = {
                title: 'Error',
                type: 'error',
                text: `Debe colocar un monto superior a cero.`,
              }
        store.dispatch('notification', data)
        }
      }
      else{
        this.selectionInvoicesToPay()
      }
    },
  },
})