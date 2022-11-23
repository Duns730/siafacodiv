Vue.component('select-product-item', {
  template:`
    <div>
      <div class="row" @click="selectProduct" data-dismiss="modal">
        <div class="col-md-3 col-sm-3" >
            {{ product.reference }}
        </div>
        <div class="col-md-4 col-sm-4">
            {{ product.description }}
        </div>
        <div class="col-md-2 col-sm-2">
            {{ product.brand }}
        </div>
        <div v-if="product.quantity >= 0" class="col-md-2 col-sm-2">
            {{ product.quantity }}
        </div>
        <div v-else class="col-md-2 col-sm-2">
            {{ product.price }}
        </div>
        <div class="col-md-1 col-sm-1">
            {{ product.list }}
        </div>
      </div>
    </div>
  `,
    props:['product'],
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState([
          'proforma_products',          //arreglo donde se almacenan los productos de la proforma
          'factor',                     // factor de cambio para general los montos en bolivares de cada producto en la proforma
          'edit_product_select_index',  // indice (posición) donde debe incluirse el producto en al proforma
          'purchase_products_select',    //arreglo donde se almacenan los productos de la compra
          'credit_note_products',    //arreglo donde se almacenan los productos de la compra
          'list_select'    
    ]),
  },
  methods:{
    selectProduct(){
      do {
        do {
          quantity = parseInt(prompt('Cantidad'));
          if (Number.isNaN(quantity)) {
            //break;
            return false;
          }
        } while (!Number.isInteger(quantity))
      } while (quantity <= 0)


      if (store.state.proforma_products) {
        this.selectProductProforma(quantity)
      }
      else if (store.state.credit_note_products) {
        this.selectProductCreditNote(quantity)
      }
      else{
        this.selectProductPurchase(quantity)
      }
    },
    selectProductProforma(quantity){
      if (Number.isInteger(this.product.quantity)) {
        if ((this.product.quantity - quantity) < 0) {
          new PNotify({
              title: 'Error',
              text: 'La cantidad ingresada es superior a la existencia' ,
              type: 'error',
              styling: 'bootstrap3'
            });
          return false
        }
        else{
          this.product.quantity = this.product.quantity - quantity
        }
        
      }
      if (this.verifyDuplication() && this.itemCount(18) 
        && this.checkMinimumQuantity(quantity) && this.verifyList()){
        product = {
                  'id' : this.product.id,
                  'reference' : this.product.reference,
                  'description' : this.product.description,
                  'brand' : this.product.brand,
                  'price' : parseFloat(this.product.price),
                  'minimum_amount' : this.product.minimum_amount,
                  'quantity' : quantity,
                  'sub_total_dollar' : parseFloat((quantity * this.product.price).toFixed(2)),
                  //'price_bolivar' : parseFloat((store.state.factor * this.product.price).toFixed(2)),
                  'price_bolivar' : +(Math.round(parseFloat((store.state.factor * this.product.price).toFixed(4)) + "e+2")  + "e-2") ,
                  'sub_total_bolivar' : parseFloat((quantity * (store.state.factor * this.product.price)).toFixed(2)),
              }
        if (Number.isInteger(store.state.edit_product_select_index)) {
            store.state.proforma_products.splice(store.state.edit_product_select_index, 0, product)
            store.state.edit_product_select_index = ''
        }
        else{
          store.state.proforma_products.push(product)
        }

      }
    },
    selectProductPurchase(quantity){
      if (this.verifyDuplication()){
        product = {
                  'id' : this.product.id,
                  'reference' : this.product.reference,
                  'description' : this.product.description,
                  'brand' : this.product.brand,
                  'quantity' : quantity,
              }
          store.state.purchase_products_select.push(product)
      }
    },
    selectProductCreditNote(quantity){
      if (this.verifyDuplication() && this.itemCount(5)){
        product = {
                  'invoice_product_id' : this.product.id,
                  'reference' : this.product.reference,
                  'description' : this.product.description,
                  'brand' : this.product.brand,
                  'quantity' : quantity,
                  'price' : parseFloat(this.product.unit_price_dollar),
                  'sub_total_dollar' : parseFloat((quantity * this.product.unit_price_dollar).toFixed(2)),
                  'price_bolivar' : parseFloat(this.product.unit_price_bolivar),
                  'sub_total_bolivar' : parseFloat((quantity * this.product.unit_price_bolivar).toFixed(2)),
              }
        store.state.credit_note_products.push(product)
      }
    },
    itemCount(max){
      if (store.state.proforma_products) {
        products = store.state.proforma_products
      }
      else{
        products = store.state.credit_note_products
      }

      if ( products.length <= max) {
        return true
      }
      else{
        new PNotify({
              title: 'Alerta',
              text: 'Haz llegado al limite de items por proforma' ,
              type: 'warning',
              styling: 'bootstrap3'
            });
        return false
      }
    },
    verifyDuplication(){
      duplication = false
      if (store.state.proforma_products) {
        products = store.state.proforma_products
      }
      else{
        products = store.state.credit_note_products
      }

      if (products) {
        for(item of products){
          if (item.reference == this.product.reference) {
            duplication = true
          }
        }
      }

      if (store.state.purchase_products_select) {
        for(item of store.state.purchase_products_select){
          if (item.reference == this.product.reference) {
            duplication = true
          }
        }
      }
        
      if (duplication) {
        new PNotify({
            title: 'Alerta',
            text: 'El producto que intenta ingresar, ya se encuentra en la porforma' ,
            type: 'warning',
            styling: 'bootstrap3'
          });
        return false
      }
      return true
    },
    checkMinimumQuantity(quantity){
      if ((quantity % this.product.minimum_amount) == 0) {
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
    verifyList(){
      if (Number.isInteger(this.product.quantity)) {
        return true
      }
      
      if (this.product.list == store.state.list_select) {
        return true
      }
      else
        new PNotify({
              title: 'Error',
              text: 'El producto no corresponde a la lista seleccionada' ,
              type: 'error',
              styling: 'bootstrap3'
            });
        return false
    },
  },
})