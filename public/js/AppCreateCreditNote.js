Vue.component('create-credit-note', {
  template:`
    <div>
      <div class="item form-group">
        <label for="client_id" class="col-form-label col-md-2 col-sm-2 label-align">Cliente</label>
        <div class="col-md-7 col-sm-7 ">
            <show-select-clients
                :client="$store.state.client_select"
            ></show-select-clients>
        </div>
        <div class="col-md-2 col-sm-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modalSelectClient">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>
      </div>

      <div class="item form-group">
        <label for="date" class="col-form-label col-md-2 col-sm-2 label-align">Fecha</label>
        <div class="col-md-3 col-sm-3 ">
            <input name="date" class="form-control" type="date"
              v-model="$store.state.date"
            >
        </div>

        <label for="invoices" class="col-form-label col-md-2 col-sm-2 label-align">Facturas</label>
        <div class="col-md-3 col-sm-3 ">
            <input name="invoices" class="form-control" type="text"
              v-model="$store.state.invoices"
              @change="$store.commit('getProducts')"
              data-toggle="tooltip" data-placement="top" title data-original-title="separae las facturas con guión (-)" 
            >
        </div>
      </div>

      <div class="item form-group">
        <label for="note_number" class="col-form-label col-md-2 col-sm-2 label-align">Número de nota</label>
        <div class="col-md-3 col-sm-3 ">
            <input name="note_number" class="form-control" type="text"
              v-model="$store.state.note_number"
            >
        </div>

        <label for="control_number" class="col-form-label col-md-2 col-sm-2 label-align">Número de control</label>
        <div class="col-md-3 col-sm-3 " >
            <input name="control_number" class="form-control" type="text"
              v-model="$store.state.control_number"

            >
        </div>
      </div>

      <div class="item form-group" data-toggle="modal"  data-target=".modalSelectProducts">
        <label for="Product" class="col-form-label col-md-1 col-sm-1 label-align">Producto</label>
          <input name="product" class="form-control" type="text" disabled="">
      </div>
        

      <credit-note-products-table
        :credit_note_products="$store.state.credit_note_products"
      ></credit-note-products-table>

    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState([
      'clients',
      'date',
      'invoices',
      'note_number',
      'control_number',
      'credit_note_products',
      ]),
    ...Vuex.mapMutations([
      'getClients',
      'getProducts',
      ]),
  },
  methods:{
    ...Vuex.mapActions(['']),
  },
  watch:{
  },
  mounted(){ 
    store.commit('getClients') 
  }
})


const store = new Vuex.Store({
  state: {
    loading: false,
    date: '',
    invoices: '',
    note_number: '',
    control_number: '',
    products: {},
    clients: {},
    credit_note_products: [],
    client_select:{
      id: '',
      name: '',
    },
    subtotales: {
      tax_base_dollar: 0,
      tax_base_bolivar: 0,
      iva_dollar: 0,
      iva_bolivar: 0,
      total_operation_dollar: 0,
      total_operation_bolivar: 0,
    },
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
    getProducts:function(state) {
      state.credit_note_products = []
      invoices =  state.invoices.split('-')
      if (!state.client_select.id) {
          alert('Debe seleccionar un cliente antes de continuar')
          return false
        }

      for(invoice of invoices){
        if (invoice.length != 5 && !Number.isInteger(invoice)) {
          alert('Esto no es un múmero válido: ' + invoice)
          return false
        }
      } 
        state.loading = true
        axios
            .post(this._vm.$api_url + 'invoices/products', {
                    data: {
                      client_id: state.client_select.id,
                      invoices: invoices,
                    }
                  })
            .then(response => {
              state.products = response.data
            })
            .catch(error => {
              if (error.response.status == 500) {
                store.commit('getProducts')
              }
            })
        .finally(() => state.loading = false)
    },

    calculateSubtotales(state){
        index = 0
        for(item of state.credit_note_products){
          //state.credit_note_products[index].price_bolivar = parseFloat((item.price * state.factor).toFixed(2))
          state.credit_note_products[index].sub_total_bolivar = parseFloat((state.credit_note_products[index].price_bolivar * item.quantity).toFixed(2))
          state.credit_note_products[index].sub_total_dollar = parseFloat((item.price * item.quantity).toFixed(2))
          index++
        }
        state.subtotales.tax_base_dollar = 0
        state.subtotales.tax_base_bolivar = 0

        for(item of state.credit_note_products){
          state.subtotales.tax_base_dollar += parseFloat((item.sub_total_dollar).toFixed(2))
          state.subtotales.tax_base_bolivar += parseFloat((item.sub_total_bolivar).toFixed(2))
        }
        state.subtotales.iva_dollar =  parseFloat((state.subtotales.tax_base_dollar * 0.16).toFixed(2))
        state.subtotales.iva_bolivar = parseFloat((state.subtotales.tax_base_bolivar * 0.16).toFixed(2))

        state.subtotales.total_operation_dollar = parseFloat((state.subtotales.tax_base_dollar + state.subtotales.iva_dollar).toFixed(2))
        state.subtotales.total_operation_bolivar = parseFloat((state.subtotales.tax_base_bolivar + state.subtotales.iva_bolivar).toFixed(2))
      return false
    },
  },
  actions: {
    postCreditNote(commit){
      if (
           store.state.client_select.id 
        && store.state.date
        && store.state.invoices
        && store.state.note_number
        && store.state.note_number.length == 4
        && store.state.control_number
        && store.state.control_number.length == 6
        && store.state.credit_note_products.length <= 6
        && store.state.credit_note_products.length > 0) {
        store.state.loading = true
        axios
          .post(this._vm.$api_url + 'creditnotes/create', {
            data: {
              note_number: store.state.note_number,
              control_number: store.state.control_number,
              invoices: store.state.invoices,
              date: store.state.date,
              tax_base_dollar: store.state.subtotales.tax_base_dollar,
              tax_base_bolivar: store.state.subtotales.tax_base_bolivar,
              iva_dollar: store.state.subtotales.iva_dollar,
              iva_bolivar: store.state.subtotales.iva_bolivar,
              total_operation_dollar: store.state.subtotales.total_operation_dollar,
              total_operation_bolivar: store.state.subtotales.total_operation_bolivar,
              products: store.state.credit_note_products,
            }
          })
          .then(response => {
            data = response.data
            if (data.status == 201) {
              message = {
                  title: 'Exito',
                  type: 'success',
                  text: '',
                }
              store.dispatch('notification', message)
                location.href = this._vm.$base_url + 'creditnotes/' + data.credit_note_id
            }
            else if(data.status == 406) {
                errors = ''
                for(error in data.errors){
                  errors += '<br>*' + data.errors[error][0]
                }
                message = {
                  title: data.message,
                  type: 'error',
                  text: errors,
                }
                store.dispatch('notification', message) 
            }
          })
          .catch(error => {
            if (error.response.status == 422) {
              message = {
                title: 'Error',
                type: 'error',
                text: `catch error`,
              }
              store.dispatch('notification', message)
            }
          })
          .finally(() => store.state.loading = false)
      }
      else{
         message = {
                  title: 'Error',
                  type: 'error',
                  text: `Esta intentado procesar una nota de credito que no cumple los parametros mínimos. Verifique los siguiente campos:
                      <ul> 
                        <li>Cliente</li>
                        <li>Fecha</li>
                        <li>Facturas</li>
                        <li>Número de nota</li>
                        <li>Número de control</li>
                        <li>Al menos un item (producto)</li>
                      <ul>`,
                }
              store.dispatch('notification', message)
      }
    },
    notification(commit, data){
      new PNotify({
        title: data.title,
        text:  data.text,
        type: data.type,
        styling: 'bootstrap3'
      });
    },
  },
  modules: {
  }
})


new Vue({
  el:'#app',
  store,
  
})