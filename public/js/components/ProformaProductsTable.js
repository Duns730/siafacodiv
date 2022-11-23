Vue.component('proforma-products-table', {
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
                  <th>Prec. Unit. $</th>
                  <th>Subtotal $</th>
                  <th>Prec. Unit. Bs.</th>
                  <th>Subtotal Bs.</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in proforma_products">
                  <td>{{ index + 1 }}</td>
                  <td>{{ product.reference }}</td>
                  <td>{{ product.description }}</td>
                  <td>{{ product.brand }}</td>
                  <td>{{ product.quantity }}</td>
                  <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(product.price) }}</td>
                  <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(product.sub_total_dollar) }}</td>
                  <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(product.price_bolivar) }}</td>
                  <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format(product.sub_total_bolivar) }}</td>
                  <td class="align-items-xl-right">
                    <div class="btn-group">
                      <div class="btn btn-outline-dark  btn-sm" data-toggle="modal"  data-target=".modalSelectProducts" 
                        @click="$store.state.edit_product_select_index = index" 
                      >
                        <i class="fa fa-level-up"></i>
                      </div>
                      <div class="btn btn-outline-dark  btn-sm" @click="editProduct(index, product.minimum_amount)">
                        <i class="fa fa-edit"></i>
                      </div>
                      <div class="btn btn-outline-dark  btn-sm" @click="deleteProduct(index)">
                        <i class="fa fa-trash-o">
                      </i></div>
                    </div>
                  </td>
                  
                </tr>
              </tbody>
            </table>
          </div>


          <div class="col-md-5 offset-7">
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <th style="width:50%">Base Imponible:</th>
                    <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format($store.state.subtotales.tax_base_dollar) }}</td>
                    <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format($store.state.subtotales.tax_base_bolivar) }}</td>
                  </tr>
                  <tr>
                    <th>IVA (16%)</th>
                    <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format($store.state.subtotales.iva_dollar) }}</td>
                    <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format($store.state.subtotales.iva_bolivar) }}</td>
                  </tr>
                  <tr>
                    <th>Total de Operación:</th>
                    <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format($store.state.subtotales.total_operation_dollar) }}</td>
                    <td>{{ new Intl.NumberFormat("es-ES", {maximumFractionDigits: 2, minimumFractionDigits: 2}).format($store.state.subtotales.total_operation_bolivar) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>


      </div>
  </div>
  `,
  props:['proforma_products'],
  data(){
    return{
    }
  },
  computed: {
    ...Vuex.mapState(['subtotales', 'edit_product_select_index', 'products']),
    ...Vuex.mapMutations(['calculateSubtotales']),

    
  },
  methods:{
    deleteProduct(index){
      product_index = store.state.products.findIndex( product => product.id === this.proforma_products[index].id );
      quantity = this.proforma_products[index].quantity
      if (this.proforma_products.splice(index, 1).length == 1) {
        store.state.products[product_index].quantity += quantity

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

      if (this.checkMinimumQuantity(quantity, minimum_amount)) {
        //console.log(store.state.products[0].quantity)
        if (Number.isInteger(store.state.products[0].quantity)) {
          product_index = store.state.products.findIndex( product => product.id === this.proforma_products[index].id );
          console.log(Number.isInteger(store.state.products[0].quantity))
          if ((store.state.products[product_index].quantity + this.proforma_products[index].quantity - quantity) < 0) {
            new PNotify({
                title: 'Error',
                text: 'La cantidad ingresada es superior a la existencia' ,
                type: 'error',
                styling: 'bootstrap3'
              });
            return false
          }
          else{
            store.state.products[product_index].quantity = store.state.products[product_index].quantity + this.proforma_products[index].quantity - quantity
          }
        }

        this.proforma_products[index].quantity = quantity
            store.commit('calculateSubtotales')
             new PNotify({
                  title: 'Exito',
                  text: 'Cantidad Actualizada correctamente' ,
                  type: 'success',
                  styling: 'bootstrap3'
                });
        //console.log(product_index)
        //console.log(store.state.products[product_index])
      }


    },
    checkMinimumQuantity(quantity, minimum_amount){
      if ((quantity % minimum_amount) == 0) {
        return true
      }
      else{
        new PNotify({
              title: 'Error',
              text: 'La cantidad ingresada no cumple con la cantidad mínima configurada' ,
              type: 'error',
              styling: 'bootstrap3'
            });
        return false
      }
      
    }, 
  },
  watch:{
    '$store.state.proforma_products'(value, oldValue){
        store.commit('calculateSubtotales')
    }
  },
})