Vue.component('control-quantity', {
  template:`
    <div>
      <div class="row">
        <div class="col-12 table-responsive">
          <table>
            <tbody>
                <tr>
                  <th style="width:30%" >Título</th>
                  <td>{{ $store.state.purchases_select.title }}</td>
                </tr>
                <tr>
                  <th>Nro. de Documento</th>
                  <td>{{ $store.state.purchases_select.document_number }}</td>
                </tr>
                <tr>
                  <th>Fecha</th>
                  <td>{{ $store.state.purchases_select.date }}</td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>

      </br>
    
      <div class="row">
        <div class="col-xl-3 col-md-3 col-ms-3 table-responsive">
          <table class="table table-striped jambo_table bulk_action"
            v-if="$store.state.purchase_products[0]">
            <thead>
                <tr>
                  <th style="height: 100px;">Referencia</th>
                </tr>
                <tr>
                  <th class="px-2  py-0">Cantidad</th>
                </tr>
                
            </thead>
            <tbody class="small">
                <tr>
                  <td class="py-0"> 
                    <span style="font-size: 12px; font-weight: bold;">Restante</span>
                  </td>
                </tr>
                <tr v-for="client of $store.state.clients.clients_proformas">
                  <td>
                    {{ sliceName(client.name) }}
                  </td>
                </tr>
                <tr><td class="bg-info">Facturados</td></tr>
                <tr v-for="client of $store.state.clients.clients_invoices">
                  <td>
                    {{ sliceName(client.name) }}
                  </td>
                
                </tr>
            </tbody>
          </table>
        </div>


        <div class="col-xl-9 col-md-9 col-ms-9 table-responsive">
          <table class="table table-striped jambo_table bulk_action"
            v-if="$store.state.purchase_products[0]">
            <thead>
                <tr>
                  <th v-for="product of $store.state.purchase_products"
                     :title="product.description"
                     class="align-text-top text-center"
                     style="height: 100px; min-width:125px;max-width:125px;"
                  >
                    {{ product.reference }}
                  </th>
                </tr>
                <tr>
                  <th v-for="product of $store.state.purchase_products" class="py-0"
                    style="text-align: center;"
                  >
                    {{ product.quantity }}
                  </th>
                </tr>
            </thead>
            <tbody class="small">
                <tr>
                  <td v-for="product of $store.state.purchase_products" class="py-0"
                    style="text-align: center;"
                    v-html="remaining(product)">
                  </td>
                </tr>
                <tr v-for="client of $store.state.clients.clients_proformas">
                  <td v-for="product of $store.state.purchase_products"
                    style="text-align: center;"
                    v-html="showQuantity(product.id, client.id, 'proformas')">
                    product.quantity
                  </td>
                </tr>

                <tr><td :colspan="$store.state.purchase_products.length" class="bg-info">Facturados</td></tr>
                
                <tr v-for="client of $store.state.clients.clients_invoices">
                  <td v-for="product of $store.state.purchase_products"
                    style="text-align: center;"
                    v-html="showQuantity(product.id, client.id, 'invoices')">
                  </td>
                </tr>
            </tbody>
          </table>
        </div>

        

      </div>
      

    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['purchase_products', 'purchases_select']),
  },
  methods:{
    showQuantity(product_id, client_id, type){
      if (type == 'proformas') {
        quantity_proforma = 0
        for(product of store.state.clients.products_proformas){
          if (product_id == product.product_id && client_id == product.client) {
            quantity_proforma += product.quantity
          }
        }
        return quantity_proforma
      }
      else if(type == 'invoices'){
        quantity_invoice = 0
        for(product of store.state.clients.products_invoices){
          if (product_id == product.product_id && client_id == product.client) {
            quantity_invoice += product.quantity
          }
        }
        return quantity_invoice

      }
        
      return 0
    },
    remaining(product){
      quantity = product.quantity
      text_color = ''
      for(client_product of store.state.clients.products_proformas){
        if (client_product.product_id == product.id) {
            quantity -= client_product.quantity
        }
      }
      for(client_product of store.state.clients.products_invoices){
        if (client_product.product_id == product.id) {
            quantity -= client_product.quantity
        }
      }

      if (quantity < 0) {
        text_color = 'bg-danger text-white p-1'
      }
      return  '<span class="' + text_color + '" style="font-size: 12px; font-weight: bold;">'+quantity+'</span>'
    },
    sliceName(name){
      if (name.length > 30) {
        return name.slice(0, 30-name.length)
      }
      else{
        return name
      }
      
    },
  },
  watch:{
  },
  mounted(){
    
  }
})


const store = new Vuex.Store({
  state: {
    loading: false,
    purchases: [],
    purchase_id: '',
    purchases_select: {
      title: '',
      document_number: '',
      date: '',
    },
    purchase_products: [],
    clients: [],
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
    getClientsPurchaseProformas:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'clients/purchase/' + state.purchase_id + '/proformas')
        .then(response => {
          state.clients = response.data
          console.log(state.clients)
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getClientsPurchaseProformas')
          }
        })
        .finally(() => state.loading = false)

    },
  },
  actions: {
    getPurchaseSelect(commit){
      store.state.loading = true
      axios
        .get(this._vm.$api_url + 'purchases/' + store.state.purchase_id + '/products/controlquantity')
        .then(response => {
          store.state.purchase_products = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.dispatch('getPurchaseSelect')
          }
        })
        .finally(() => store.state.loading = false)

    },
  },
  modules: {
  }
})


new Vue({
  el:'#app',
  store,
})