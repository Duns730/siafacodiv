Vue.component('load-payment', {
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

            <label class="col-form-label col-md-2 col-sm-2 label-align">Retención</label>
            <div class="col-md-4 col-sm-4 form-group has-feedback">
              <input class="form-control has-feedback-right" 
              disabled="" min="0" max="100" 
              type="number" 
              v-model="$store.state.withholding_tax">
              <span class="form-control-feedback right" aria-hidden="true">%</span>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-1 col-sm-1 label-align">Tipo</label>
            <div class="col-md-5 col-sm-5 ">
              <select class="form-control" 
              :disabled="$store.state.form_fields_disable"
              v-model="$store.state.type_select">
                <option v-for="type of types">
                {{ type }}
                </option>
              </select>
            </div>

            <label class="col-form-label col-md-2 col-sm-2 label-align">Banco</label>
            <div class="col-md-4 col-sm-4 ">
              <select class="form-control" 
              :disabled="$store.state.form_fields_disable"
              v-model="$store.state.bank_id">
                <option v-for="bank of $store.state.banks" :value="bank.id">
                {{ bank.name }}
                </option>
              </select>
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
                  <td>IVA $</td>
                  <td>{{ formatNumber($store.state.total_iva.dollar) }}</td>
                </tr>
                <tr>
                  <td>IVA Bs</td>
                  <td>{{ formatNumber($store.state.total_iva.bolivar) }}</td>
                </tr>
                <tr>
                  <td>Saldo a favor</td>
                  <td>{{ formatNumber($store.state.amount_payment - $store.state.amount_charged) }}</td>
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
                  <th>IVA Bs.</th>
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
                  {{ formatNumber(invoice.iva_bolivar) }}</td>
                <td>
                  {{ formatNumber(invoice.to_pay_bolivar) }}</td>
                <td></td>
              </tr>
              </tbody>
            </table>
          </div>
      </div>



    </div>
  `,
    data: function () {
    return {
      types: ['deposito', 'cheque', 'efectivo', 'transferencia', 'zelle'],
    }
  },
  computed: {
    ...Vuex.mapState([
      'client_select',
      'client_invoices',
      'withholding_tax',
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

      ]),
    ...Vuex.mapMutations([
      'calculateIva',
      'calculateAmountCharged',
      ]),
  },
  methods:{
    ...Vuex.mapActions([
      'notification',
      ]),
    formatNumber(number){
      return new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2}).format(number) 
    },
    selectionInvoicesToPay(){
      amount = store.state.amount_payment
      store.state.invoices_to_pay = []

      for(ids_invoices of store.state.ids_invoices_to_pay){
        amount -= store.state.client_invoices[ids_invoices].to_pay_bolivar

        if (amount >= 0) {
          paid_out = {
            'id': store.state.client_invoices[ids_invoices].id,
            'paid_out': store.state.client_invoices[ids_invoices].to_pay_bolivar,
          }
        }
        else{
          paid_out = {
            'id': store.state.client_invoices[ids_invoices].id,
            'paid_out':store.state.client_invoices[ids_invoices].to_pay_bolivar + amount,
          }
        }
        store.state.invoices_to_pay.push(paid_out)
        }

    },
  },
  watch:{
    '$store.state.withholding_tax'(){
      store.commit('calculateIva')
      this.selectionInvoicesToPay()
    },
    '$store.state.amount_payment'(value_new, value_old){
      this.selectionInvoicesToPay()
      //this.$forceUpdate()
    },
    '$store.state.invoices_to_pay'(value_new, value_old){
      store.commit('calculateAmountCharged')
    },
/*
    '$store.state.client_invoices': {
      deep: true,
      handler: (value_new, value_old) => {
      //alert('$store.state.client_invoices')
      }
    },
*/
    '$store.state.ids_invoices_to_pay'(value_new, value_old){
      if (value_new.length > value_old.length) {
        if (store.state.amount_payment > 0) {
          if ((store.state.amount_payment - store.state.amount_charged) > 0) {
              this.selectionInvoicesToPay()
          }
          else{
            store.state.ids_invoices_to_pay.pop()
            
            store.commit('calculateAmountCharged')
            data = {
              title: 'Error',
              type: 'error',
              text: `La suma de los ivas es superior al pago, no puede seleccionar más facturas.`,
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