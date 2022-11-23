Vue.component('load-products', {
  template:`
    <div>
        <div class="item form-group" data-toggle="modal"  data-target=".modalSelectProducts">
          <label for="Product" class="col-form-label col-md-1 col-sm-1 label-align">Producto</label>
          <input name="product" class="form-control" type="text" disabled="">
        </div>

        <purchase-products-table 
          :purchase_products_select="$store.state.purchase_products_select"
        > </purchase-products-table>
    </div>
  `,
  props:['id_purchase'],
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['purchase_id',]),
    ...Vuex.mapMutations(['getProducts','purchase_products_select',]),
  },
  methods:{
  },
  watch:{
  },
  mounted(){  
    store.commit('getProducts')
    store.state.purchase_id = this.id_purchase
    store.commit('getProductsPurchase')
  }
})


const store = new Vuex.Store({
  state: {
    loading: false,
    purchase_id: 0,
    products: [],
    purchase_products_select: [],

  },
  mutations:{
     getProducts:function(state) {
        state.loading = true
        axios
        .get(this._vm.$api_url + 'products/')
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
    getProductsPurchase:function(state) {
        state.loading = true
        axios
        .get(this._vm.$api_url + 'purchases/' + state.purchase_id + '/products')
        .then(response => {
          for(item of response.data ){
            product = {
                'id' : item.id,
                'reference' : item.reference,
                'description' : item.description,
                'brand' : item.brand,
                'quantity' : item.quantity,
            }
            state.purchase_products_select.push(product)
          }
        })
        .catch(error => {
          console.log(error)
          if (error.response.status == 500) {
            store.commit('getProductsPurchase')
          }
        })
        .finally(() => state.loading = false)
    },
  },
  actions: {
    postPurchase(commit, action){
        
      if (store.state.purchase_products_select.length <= 0) {
          new PNotify({
            title: 'Error',
            text:  'No puede guardar o totalizar una compra vacia.',
            type: 'error',
            styling: 'bootstrap3'
          });
        return false
      }
      if (action == 'save') {
        url = this._vm.$api_url + 'purchases/save'
      }
      else{
        url = this._vm.$api_url + 'purchases/totalize'
      }
      store.state.loading = true
      axios
          .post(url, {
            data: {
              purchase_id: store.state.purchase_id,
              products: store.state.purchase_products_select,
            }
          })
          .then(response => {
            data = response.data
            if (data.status == 201) {
                location.href = this._vm.$base_url + 'purchases/' + store.state.purchase_id
            }
            else{
                  title = 'Error'
                  type = 'error'
                  message = 'Hubo algun error. por favor intente de nuevo.'
            }
            new PNotify({
                  title: title,
                  text:  message,
                  type: type,
                  styling: 'bootstrap3'
                });
          })
        .catch(error => {
          console.log(error.response)
        })
        .finally(() => store.state.loading = false)
        
    }
  },
  modules: {
  }
})


new Vue({
  el:'#app',
  store,
  
})