Vue.component('select-product', {
  template:`
    <div>
    {{ transfProducts }}
    	<input class="form-control" type="text" v-model="name_search" @keyup.enter="nameSearch">
      <ul class="to_do" >
          <li>
            <div class="row">
              <div class="col-md-3 col-sm-3" >
                  Referencia
              </div>
              <div class="col-md-4 col-sm-4">
                  Descripción
              </div>
              <div class="col-md-2 col-sm-2">
                  Marca
              </div>
              <div v-if="products[0].quantity >= 0" class="col-md-2 col-sm-2">
                  Cantidad
              </div>
              <div v-else class="col-md-2 col-sm-2">
                  Precio
              </div>
              <div class="col-md-1 col-sm-1">
                  Lista
              </div>
            </div>
          </li>
          <a href="#">
            <li v-for="product_item of result_products">
                <select-product-item
                :product="product_item"
                ></select-product-item>
            </li>
          </a>
        </ul>
    </div>
  `,
    data: function () {
    return {
    name_search: '',
    result_products: {
      0: {
        quantity: ''
      }
    },
    }
  },
  computed: {
    ...Vuex.mapState(['products']),
    transfProducts(){
        this.result_products = store.state.products
    }
  },
  methods:{
    nameSearch(){
        if(this.name_search.length > 3){
          this.result_products = []
          for(product of store.state.products){
            if (product.reference.includes(this.name_search.toUpperCase())) {
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
})