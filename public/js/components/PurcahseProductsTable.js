Vue.component('purchase-products-table', {
  template:`
  <div>
      <div class="row">
          <div class="table">
            <table class="table table-striped jambo_table bulk_action small">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Referencia</th>
                  <th>Descripción</th>
                  <th>Marca</th>
                  <th>Cantidad</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in purchase_products_select">
                  <td>{{ index + 1 }}</td>
                  <td>{{ product.reference }}</td>
                  <td>{{ product.description }}</td>
                  <td>{{ product.brand }}</td>
                  <td>{{ product.quantity }}</td>
                  <td class="align-items-xl-right">
                    <div class="btn-group">
                      <div class="btn btn-outline-dark btn-sm" @click="editProduct(index, product.minimum_amount)">
                        <i class="fa fa-edit"></i>
                      </div>
                      <div class="btn btn-outline-dark btn-sm" @click="deleteProduct(index)">
                        <i class="fa fa-trash-o">
                      </i></div>
                    </div>
                  </td>
                  
                </tr>
              </tbody>
            </table>
          </div>



      </div>
  </div>
  `,
  props:['purchase_products_select'],
  data(){
    return{
    }
  },
  computed: {
    ...Vuex.mapState(['']),
    ...Vuex.mapMutations(['']),

    
  },
  methods:{
    deleteProduct(index){
      if (this.purchase_products_select.splice(index, 1).length == 1) {
        new PNotify({
          title: 'Exito',
          text: 'Eliminado correctamente' ,
          type: 'success',
          styling: 'bootstrap3'
        });
      }
      else{
        new PNotify({
          title: 'Error',
          text: 'Ha ocurrido un problema, intente de nuevo' ,
          type: 'error',
          styling: 'bootstrap3'
        });
      }
    },
    editProduct(index, minimum_amount){
      do {
        do {
          quantity = parseInt(prompt('Cantidad'));
        } while (!Number.isInteger(quantity))
      } while (quantity <= 0)
      
      this.purchase_products_select[index].quantity = quantity
    }, 
  },
  watch:{
    '$store.state.purchase_products_select'(value, oldValue){
        //store.commit('calculateSubtotales')
    }
  },
})