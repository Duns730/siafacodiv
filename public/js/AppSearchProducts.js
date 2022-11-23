Vue.component('app-search-products', {
  template:`
    <div>
      {{ deliverProducts }}
        <input class="form-control" type="text" v-model="name_search" @keyup.enter="nameSearch">
        <ul class="to_do" >
            <a v-for="item of result_products"  :href="$base_url+'products/'+item.id">
              <li>
                <div class="row">
                  <div class="col-md-3 col-sm-3">{{ item.reference }}</div>
                  <div class="col-md-7 col-sm-7">{{ item.description }}</div>
                  <div class="col-md-2 col-sm-2">{{ item.brand }}</div>
                </div>
              </li>
            </a>
          </ul>
    </div>
  `,
    data: function () {
    return {
      name_search: '',
      result_products: [],
    }
  },
  computed: {
    ...Vuex.mapState(['products', 'url']),
    ...Vuex.mapMutations(['getproducts']),
    deliverProducts() {
      this.result_products = store.state.products
    },
  },
  methods:{
    nameSearch(){
        if(this.name_search.length > 2){
          this.result_products = []
          for(product of store.state.products){
            if (product.brand == null) {product.brand = ''}
            if (product.description == null) {product.description = ''}
              
            if (product.reference.includes(this.name_search.toUpperCase())
                || product.description.includes(this.name_search.toUpperCase())
                || product.brand.includes(this.name_search.toUpperCase())) {
              this.result_products.push(product)
            }
          }
        }
    },
  },
  watch:{
    'name_search'(old_val, new_val){
      this.nameSearch()
    }
  },
  mounted(){
    store.commit('getproducts') 
  }
})

const store = new Vuex.Store({
  state: {
    data_target: '.modalSearchProducts',
    loading: false,
    products:[],
  },
  mutations:{
    getproducts:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'products/')
        .then(response => {
          state.products = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getproducts')
          }
        })
        .finally(() => state.loading = false)
    },
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