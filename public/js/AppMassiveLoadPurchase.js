Vue.component('massive-load-products-purchase', {
  template:`
    <div>
          <h2  v-if="!$store.state.products[0]">Especificaciones del archivo a cargar:</h2>

          <div class="row" v-if="!$store.state.products[0]">
            <div class="col-3">
              <ul>
                <li>Extensión de archivo: .csv</li>
                <li>Descargue el archivo base <a :href="$base_url+'download/purchase/massiveload'">aqui</a></li>
                <li>Descargue <a :href="$base_url+'download/instructions/utf8'">aqui</a> las instrucciones para preparar el archivo antes de cargar</li>
              </ul>
            </div>
            <div class="col-4">
              <ul>
                <li>Nombre y orden de columnas:
                  <ul>
                    <li>reference:  Referencia</li>
                    <li>quantity:  Cantidad ha cargar</li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="col-5">
                <h5>Notas:</h5>
                  <ul>
                    <li>Precio F por defecto es Precio B para ser utilizado en la venta provisional de contenedores</li>
                    <li>Los productos marcados con una <b>X</b> seran excluidos de la cargar, debido a que no se encontro coincidencia.</li>
                  </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8 col-sm-8">
              <div class="input-group">
                <input type="file" id="file" class='form-control' accept='.csv' ref="file" @change="iniciar">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary" @click="$store.commit('postFile')">Cargar</button>
                </span>
              </div>
            </div>
          </div>

          <div class="row" v-if="$store.state.products[0]">
            <div class="table col-12" >
                <table class="table table-striped jambo_table bulk_action small">
                  <thead>
                    <tr>
                      <th></th>
                      <th>#</th>
                      <th>Referencia</th>
                      <th style="width:500px">Descripción</th>
                      <th>Marca</th>
                      <th>Cantidad</th>
                      <th>Precio_F</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(product, index) in $store.state.products[0]">
                      <td v-if="product.existence == 1">
                        <button  class="fa fa-check btn btn-success "></button>
                      </td>
                      <td v-else>
                        <button  class="fa fa-remove btn btn-danger" title="Referencia no existente, producto a excluir"></button>
                      </td>
                      <td>{{ index + 1 }}</td>
                      <td>{{ product.reference }}</td>
                      <td>{{ product.description }}</td>
                      <td>{{ product.brand }}</td>
                      <td>{{ product.quantity }}</td>
                      <td>{{ product.price_f }}</td>
                      
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>

          <div class="row" v-if="$store.state.products_not_registered[0]">
            <div class="table col-12" >
            <h5>Productos no registrados</h5>
                <table class="table table-striped jambo_table bulk_action small">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Referencia</th>
                      <th style="width:500px">Descripción</th>
                      <th>Marca</th>
                      <th>Cantidad</th>
                      <th>Precio_F</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(product, index) in $store.state.products_not_registered">
                      <td>{{ index + 1 }}</td>
                      <td>{{ product.reference }}</td>
                      <td>{{ product.description }}</td>
                      <td>{{ product.brand }}</td>
                      <td>{{ product.quantity }}</td>
                      <td>{{ product.price_f }}</td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
    </div>
  `,
  props: ['id_purchase'],
  data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['file', 'products', 'loading', 'products_not_registered', 'purchase_id']),
    ...Vuex.mapMutations(['postFile']),
  },
  methods:{
    iniciar(){
      store.state.file = this.$refs.file.files[0]
      store.state.purchase_id = this.id_purchase
    }
  },
  watch:{
  },
})


const store = new Vuex.Store({
  state: {
    loading: false,
    file: '',
    purchase_id: '',
    products: [],
    number_registered_products: '',
    products_not_registered: '',
  },
  mutations:{
    postFile(state){
      let formData = new FormData()
      formData.append('file', state.file)
      //console.log(formData)
      if (state.file != '') {
        state.loading = true
        axios
          .post(this._vm.$api_url + 'purchases/massive/load', 
            formData,
            {
              headers: {
                'Content-Type': 'multipart/form-data'
              },
            }
                )
          .then(response => {
            data = response.data
            if (data.status == 406) {
              formData.delete('file')
              errors = ''
              
              for(error in data.errors){
                errors += '<br>*' + data.errors[error]

              }
              message = data.message + errors
              store.dispatch('notification', {title: 'Advertencia',type: 'warning',text: message,})
            }
            else{
              state.products = response.data
            }
          })
          .catch(error => {
            if (error.response.status == 500) {
              store.commit('postFile')
            }
          })
          .finally(() => state.loading = false)
      }
      else{
        message = {
                title: 'Advertencia',
                type: 'warning',
                text: 'Debe seleccionar un archivo',
              }
        store.dispatch('notification', message)
      }
      
    },

  },
  actions: {
    notification(commit, data){
      new PNotify({
        title: data.title,
        text:  data.text,
        type: data.type,
        styling: 'bootstrap3'
      });
    },
    postProducts(commit){
      if (store.state.products.length < 1) {
        message = {
                  title: 'Error',
                  type: 'error',
                  text: 'No puede guardar sin antes haber cargado un archivo',
                }
        store.dispatch('notification', message) 
        return false
      }
      store.state.loading = true
      axios
          .post(this._vm.$api_url + 'purchases/massive/load/store', {
            data: {
              purchase_id: store.state.purchase_id,
              products: store.state.products[0],
            }
          })
          .then(response => {
            data = response.data
            if (data.status == 201) {
              store.state.products = []
              store.state.products_not_registered = data.products_not_registered
              message = {
                  title: 'Exito',
                  type: 'success',
                  text: data.number_registered_products + ' productos registrado con exito.',
              }
            }
            else{
                message = {
                  title: 'Error',
                  type: 'error',
                  text: '',
                }
            }
            store.dispatch('notification', message) 

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
  mounted(){   
  }
})