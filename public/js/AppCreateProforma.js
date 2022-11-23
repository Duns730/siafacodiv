Vue.component('create-proforma', {
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
        <label for="list" class="col-form-label col-md-2 col-sm-2 label-align">Lista</label>
        <div class="col-md-3 col-sm-3 ">
            <select name="list" class="form-control" 
              v-model="$store.state.list_select"
            >
            <option v-for="list in lists" >
              {{ list }}
            </option>
            </select>
        </div>

        <label for="price" class="col-form-label col-md-2 col-sm-2 label-align">Precio</label>
        <div class="col-md-3 col-sm-3 ">
            <select name="price" class="form-control" 
              v-model="$store.state.price_select"
            >
            <option
              v-for="price in prices"
              :value="price.type"
              >
              {{ price.id }}
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

        <label for="factor" class="col-form-label col-md-2 col-sm-2 label-align">Provisional</label>
        <div class="col-md-3 col-sm-3 ">
            <input name="provisional" class="form-control" type="checkbox"
              v-model="$store.state.provisional"
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
      lists: [1, 2, 3, 4, 5, 6,],
      prices: {
                1 : {id : 'A', type : 'price_a'},
                2 : {id : 'B = Lista', type : 'price_b'},
                3 : {id : 'C = B-20%', type : 'price_c'},
                4 : {id : 'D = B-15%', type : 'price_d'},
                5 : {id : 'E = B-10%', type : 'price_e'},
                6 : {id : 'F = B', type : 'price_f'},
                7 : {id : 'G', type : 'price_g'},
                8 : {id : 'H = P.E. OCT', type : 'price_h'},
                9 : {id : 'I = H-10%', type : 'price_i'},
                10 : {id : 'J = H-15%', type : 'price_j'},
                11 : {id : 'K = H-20%', type : 'price_k'},
                12 : {id : 'L = H-25%', type : 'price_l'},
                13 : {id : 'M = H-30%', type : 'price_m'},
                14 : {id : 'N = Cruceta-55%', type : 'price_n'},
                15 : {id : 'O', type : 'price_o'},
                16 : {id : 'P', type : 'price_p'},
                17 : {id : 'Q', type : 'price_q'},
                18 : {id : 'R', type : 'price_r'},
              },
    }
  },
  computed: {
    ...Vuex.mapState([
            'negotiations',
            'list_select',
            'client_select',
            'price_select',
            'factor',
            'provisional',
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
        store.state.seller_id_select = parseInt(this.proforma.seller_id)
        if ( this.proforma.provisional == 1) { store.state.provisional = true }
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
    list_select: '',
    price_select: '',
    negotiation_proforma_id: '',
    edit_product_select_index: '',
    loading: false,
    provisional: false,
    factor: 1,
    clients: {},
    sellers: {},
    negotiation_id_select: '',
    seller_id_select: '',
    control_number: 'null',
    number_invoice: '',
    date: '',
    negotiations: {
        0: {
          negotiations : {}
        }
    },
    client_select:{
      id: '',
      name: '',
    },
    products: {},
    product_select:[],
    proforma_products: [],
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
    getSellers:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'sellers/')
        .then(response => {
          state.sellers = response.data
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
      //if(state.list_select > 0 && state.price_select.includes('price')){   
      if(state.price_select.includes('price')){   
        state.loading = true
        axios
            .post(this._vm.$api_url + 'products/list/price', {
                    data: {
                      //list: state.list_select,
                      type_price: state.price_select,
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
        //valor = store.commit('roundToTwo', state.)
        //console.log(valor)
        for(item of state.proforma_products){
          //console.log(" total "+parseFloat((item.price * state.factor).toFixed(3)))
          //console.log(" total "+parseFloat((item.price * state.factor).toFixed(3)))

          //state.proforma_products[index].price_bolivar = parseFloat((item.price * state.factor).toFixed(2))
          state.proforma_products[index].price_bolivar = +(Math.round(parseFloat((item.price * state.factor).toFixed(4)) + "e+2")  + "e-2")
          state.proforma_products[index].sub_total_bolivar = parseFloat((state.proforma_products[index].price_bolivar * item.quantity).toFixed(2))
          state.proforma_products[index].sub_total_dollar = parseFloat((item.price * item.quantity).toFixed(2))
          index++
        }
        console.log(item)
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
    productsProforma:function(state) {
      if (store.state.proforma_id != '' && store.state.price_select != '') {
        state.loading = true
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
              store.dispatch('productsProforma')
            }
          })
          .finally(() => state.loading = false)
      }
      return false
    },
    postProforma(commit, action){
      if (action == 'create') {
        url = this._vm.$api_url + 'proformas/store'
      }
      if(action == 'edit'){
        url = this._vm.$api_url + 'proformas/update/edit'
      }
      if(action == 'debug'){
        url = this._vm.$api_url + 'proformas/update/debug'
      }

      if(action == 'invoicing'){
        if (store.state.seller_id_select 
        && store.state.number_invoice.length == 5
        && store.state.date ) {
          url = this._vm.$api_url + 'invoices/create'
        }
        else{
          message = {
                title: 'Advertencia',
                type: 'error',
                text: `Esta intentado facturar una proforma que no cumple los parametros mínimos. Verifique los siguiente campos:
                      <ul> 
                        <li>Vendedor</li>
                        <li>Número de Factura</li>
                        <li>Fecha</li>
                        <li>Al menos un item(producto)</li>
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
              type_price: store.state.price_select,
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
            else if(data.status == 406) {
                message = {
                  title: 'Error',
                  type: 'error',
                  text: data.message,
                }
                store.dispatch('notification', message) 
            }
          })
          .catch(error => {
            if (error.response.status == 422) {
              message = {
                title: 'Error',
                type: 'error',
                text: `Verifique el número de factura, puede ya exista en sistema o tenga algún error.`,
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
      }
      
      message = {}
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
     if (this.$store.state.seller_id_select != '') {
      this.$store.commit('getSellers')
     }
     
  }
})

