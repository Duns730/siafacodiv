Vue.component('create-proforma-provisional', {
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
        <label for="negotiation_id" class="col-form-label col-md-2 col-sm-2 label-align">Negociación</label>
        <div class="col-md-7 col-sm-7 ">
            <select name="negotiation_id" class="form-control"
              v-model=" $store.state.negotiation_id_select"
            >
            <option
              v-for="negotiation of $store.state.negotiations[0].negotiations"
              v-if="!negotiation.invoice_date"
              :value="negotiation.id"
              >
              {{ negotiation.title }}
            </option>
            </select>
        </div>
      </div>

      <div class="item form-group">
        <label for="factor" class="col-form-label col-md-2 col-sm-2 label-align">Factor de Cambio</label>
        <div class="col-md-3 col-sm-3 ">
            <input name="factor" class="form-control" type="number"
              v-model="$store.state.factor"
              @change="$store.commit('calculateSubtotales')"
            >
        </div>
      </div>

      <div class="item form-group" data-toggle="modal"  data-target=".modalSelectProducts">
        <label for="Product" class="col-form-label col-md-1 col-sm-1 label-align">Producto</label>
          <input name="product" class="form-control" type="text" disabled="">
      </div>


      <proforma-products-table
        :proforma_products="$store.state.proforma_products"
      ></proforma-products-table>


    </div>
  `,
  props:['proforma','client'],
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState([
            'negotiations',
            'client_select',
            'factor',
            'negotiation_id_select',
            'proforma_products',
            'proforma_id',
    ]),
    ...Vuex.mapMutations([
            'getNegotiations',
            'resetProforma',
            'getProducts',
    ]),
    loadData(){
        store.state.client_select.id = this.proforma.client_id
        store.state.client_select.name = this.proforma.client_name
        store.state.negotiation_id_select = this.proforma.negotiation_id
        store.state.negotiation_proforma_id = this.proforma.negotiation_proforma_id
        store.state.price_select = this.proforma.price_select
        store.state.factor = this.proforma.factor
        store.state.proforma_id = this.proforma.id
        store.state.purchase_proforma_id = this.proforma.purchase_proforma_id
        store.state.seller_id_select = parseInt(this.proforma.seller_id)
        store.dispatch('productsProforma')
    },
  },
  methods:{
        ...Vuex.mapActions([
            'productsProforma',
        ]),
  },
  watch:{
    '$store.state.price_select'(){
      store.commit('getProducts')
      store.commit('resetProforma')
    },
    '$store.state.client_select.id'(){
      store.commit('getNegotiations')
    }
  },
   mounted(){ 
     this.loadData
  }
})

const store = new Vuex.Store({
  state: {
    proforma_id: '',
    purchase_id: '',
    purchase_proforma_id: '',
    seller_id_select: '',
    negotiation_proforma_id: '',
    negotiation_id_select: '',
    edit_product_select_index: '',
    loading: false,
    provisional: true,
    number_invoice: '',
    control_number: 'null',
    date: '',
    factor: 1,
    clients: {},
    sellers: {},
    products: {},
    purchases: [],
    product_select:[],
    proforma_products: [],
    negotiations: {
        0: {
          negotiations : {}
        }
    },
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
    getPurchases(state){
      state.loading = true
      axios
        .get(this._vm.$api_url + 'purchases/')
        .then(response => {
          state.purchases = response.data
        })
        .catch(error => {
            if (error.response.status == 500) {
              store.commit('getPurchases')
            }
        })
        .finally(() => state.loading = false)
    },
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
    getSellers:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'sellers/')
        .then(response => {
          state.sellers = response.data
          console.log(state.sellers)
        })
        .catch(error => {
            if (error.response.status == 500) {
              store.commit('getSellers')
            }
        })
        .finally(() => state.loading = false)

    },
    getNegotiations:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'clients/' + state.client_select.id + '/negotiations')
        .then(response => {
          state.negotiations = response.data
        })
        .catch(error => {
            if (error.response.status == 500) {
              store.commit('getNegotiations')
            }
        })
        .finally(() => state.loading = false)
        
    },
    getProducts:function(state) {
      store.commit('comparatePurchase')
      state.loading = true
        axios
          .get(this._vm.$api_url + 'purchases/' + state.purchase_id + '/products')
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
    comparatePurchase(state){
      if (state.purchase_id != state.purchase_proforma_id) {
        store.commit('resetProforma')
      }
    },
    resetProforma(state){
      state.subtotales.tax_base_dollar = 0
      state.subtotales.tax_base_bolivar = 0
      state.subtotales.iva_dollar = 0
      state.subtotales.iva_bolivar = 0
      state.subtotales.total_operation_dollar = 0
      state.subtotales.total_operation_bolivar = 0
      state.proforma_products = []
      return false
    },
    calculateSubtotales(state){
        index = 0
        for(item of state.proforma_products){
          state.proforma_products[index].price_bolivar = +(Math.round(parseFloat((item.price * state.factor).toFixed(4)) + "e+2")  + "e-2")
          //state.proforma_products[index].price_bolivar = parseFloat((item.price * state.factor).toFixed(2))
          state.proforma_products[index].sub_total_bolivar = parseFloat((state.proforma_products[index].price_bolivar * item.quantity).toFixed(2))
          state.proforma_products[index].sub_total_dollar = parseFloat((item.price * item.quantity).toFixed(2))
          index++
        }
        state.subtotales.tax_base_dollar = 0
        state.subtotales.tax_base_bolivar = 0

        for(item of state.proforma_products){
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
    getPurchaseSelect(commit){
      store.commit('getProducts')
    },
    productsProforma:function(commit) {
      if (store.state.proforma_id != '' && store.state.price_select != '') {
        store.state.loading = true
        axios
          .post(this._vm.$api_url + 'proformas/products', {
                  data: {
                    id: store.state.proforma_id,
                    type_price: store.state.price_select,
                  }
                })
          .then(response => {
            store.state.proforma_products = response.data
          })
          .catch(error => {
            if (error.response.status == 500) {
              store.store.dispatch('productsProforma')
            }
          })
          .finally(() => store.state.loading = false)
      }
        return false
    },
    postProforma(commit, action){
      if (action == 'create') {
        url = this._vm.$api_url + 'proformas/store/provisional'
      }
      if(action == 'edit'){
        url = this._vm.$api_url + 'proformas/update/edit/provisional'
      }
      if(action == 'debug'){
        url = this._vm.$api_url + 'proformas/update/debug/provisional'
      }

      if(action == 'invoicing'){
        if (store.state.seller_id_select
          && store.state.control_number.length == 6
          && store.state.number_invoice.length == 5
          && store.state.date ) {
          url = this._vm.$api_url + 'invoices/create'
        }
        else{
          message = {
            title: 'Error',
            type: 'error',
            text: `sta intentado facturar una proforma que no cumple los parametros mínimos. Verifique los siguiente campos:
                <ul> 
                  <li>Vendedor</li>
                  <li>Número de Factura</li>
                  <li>Número de Control</li>
                  <li>Fecha</li>
                  <li>Al menos un item (producto)</li>
                <ul>`,
          }
          store.dispatch('notification', message)
          return false
        }
      }

      if (
           store.state.client_select.id 
        && store.state.negotiation_id_select
        && store.state.price_select
        && store.state.factor > 0
        && store.state.proforma_products.length <= 19
        && store.state.proforma_products.length > 0) {
        store.state.loading = true
        axios
          .post(url, {
            data: {
              id: store.state.proforma_id,
              purchase_id: store.state.purchase_id,
              client_id: store.state.client_select.id,
              negotiation_id: store.state.negotiation_id_select,
              negotiation_proforma_id: store.state.negotiation_proforma_id,
              seller_id: store.state.seller_id_select,
              invoice_number: store.state.number_invoice,
              control_number: store.state.control_number,
              date: store.state.date,
              factor: store.state.factor,
              tax_base_dollar: store.state.subtotales.tax_base_dollar,
              tax_base_bolivar: store.state.subtotales.tax_base_bolivar,
              iva_dollar: store.state.subtotales.iva_dollar,
              iva_bolivar: store.state.subtotales.iva_bolivar,
              total_operation_dollar: store.state.subtotales.total_operation_dollar,
              total_operation_bolivar: store.state.subtotales.total_operation_bolivar,
              total_items: store.state.proforma_products.length,
              type_price: 'price_f',
              provisional: store.state.provisional,
              products: store.state.proforma_products,
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
              if (action == 'invoicing') {
                location.href = this._vm.$base_url + 'invoices/' + data.invoice_id
              }
              else{
                location.href = this._vm.$base_url + 'proformas/' + data.id
              }
            }
            else{
              if (data.status == 406) {
                message = {
                  title: 'Error',
                  type: 'error',
                  text: data.message,
                }
                store.dispatch('notification', message)
              }
            }
          })
          .catch(error => {
            if (error.response.status == 422) {
              message = {
                title: 'Error',
                type: 'error',
                text: `Verifique el número de factura, puede ya exista en sistema o tenga algun error.`,
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
          text: `Esta intentado procesar una proforma que no cumple los parametros mínimos. Verifique los siguiente campos:
                      <ul> 
                        <li>Cliente</li>
                        <li>Negociación</li>
                        <li>Factor de cambio > 0</li>
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
  mounted(){ 
     this.$store.commit('getClients')
     this.$store.commit('getPurchases')
     if (this.$store.state.seller_id_select != '') {
      this.$store.commit('getSellers')
     }
     
  }
})

