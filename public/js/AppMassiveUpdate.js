Vue.component('massive-update-products', {
  template:`
    <div>
          <h2  v-if="!$store.state.products[0]">Especificaciones del archivo a cargar:</h2>

          <div class="row" v-if="!$store.state.products[0]">
            <div class="col-3">
              <ul>
                <li>Extensión de archivo: .csv</li>
                  <li>Descargue el archivo base <a :href="$base_url+'download/products/massiveload'" class="font-weight-bold">aqui</a></li>
                <li>Precio: los decimales deben ir separador por punto (.) y no coma (,)</li>
                <li>Descargue <a :href="$base_url+'download/instructions/utf8'">aqui</a> las instrucciones para preparar el archivo antes de cargar</li>
                <li>Debe seleccionar las columnas ha actualizar</li>
              </ul>
            </div>
            <div class="col-4">
              <ul>
                <li>Nombre y orden de columnas:
                  <ul>
                    <li>reference: Referencia<span style="color:red" title="es de caracter obligatorio">(<b>*</b>)</span></li>
                    <li>description:  Descripción</li>
                    <li>brand:  Marca</li>
                    <li>list:   Lista</li>
                    <li>minimum_amount:   Cantidad de venta<span style="color:red" title="Ejemplo: Los Conectores se venden de 5 und">(<b>*</b>)</span></li>
                    <li>price_a:  Precio A</li>
                    <li>price_b:  Precio B</li>
                    <li>price_c:  Precio C</li>
                    <li>price_d:  Precio D</li>

                  </ul>
                </li>
              </ul>
            </div>
            <div class="col-5">
                <h5>Notas:</h5>
                  <ul>
                    <li>Precio D por defecto es 0.00</li>
                    <li>Precio F por defecto es Precio B para ser utilizado en la venta provisional de contenedores</li>
                    <li>Los productos marcados con una <b>X</b> seran excluidos de la cargar, debido no existen coincidencia</li>
                  </ul>
            </div>
          </div>

          <div class="row"  v-if="!$store.state.products[0]">
            <div class="col-md-12 col-sm-12">
                <h5 class=" col-md-1 col-sm-1 ">Columnas:</h5>
              <div class="input-group">
                  <div v-for="col of cols" class=" mx-3">
                    <label>
                      <input type="checkbox" :value="col" v-model="$store.state.cols_selection"> {{ col }}
                    </label>
                  </div>
              </div>
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
                      <th style="width:50px">Descripción</th>
                      <th>Marca</th>
                      <th>Lista</th>
                      <th>Cantidad</th>
                      <th>A</th>
                      <th>B</th>
                      <th>C</th>
                      <th>D</th>
                      <th>E</th>
                      <th>G</th>
                      <th>H</th>
                      <th>I</th>
                      <th>J</th>
                      <th>K</th>
                      <th>L</th>
                      <th>M</th>
                      <th>N</th>
                      <th>O</th>
                      <th>P</th>
                      <th>Q</th>
                      <th>R</th>
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
                      <td>{{ product.list }}</td>
                      <td>{{ product.minimum_amount }}</td>
                      <td>{{ product.price_a }}</td>
                      <td>{{ product.price_b }}</td>
                      <td>{{ product.price_c }}</td>
                      <td>{{ product.price_d }}</td>
                      <td>{{ product.price_e }}</td>
                      <td>{{ product.price_g }}</td>
                      <td>{{ product.price_h }}</td>
                      <td>{{ product.price_i }}</td>
                      <td>{{ product.price_j }}</td>
                      <td>{{ product.price_k }}</td>
                      <td>{{ product.price_l }}</td>
                      <td>{{ product.price_m }}</td>
                      <td>{{ product.price_n }}</td>
                      <td>{{ product.price_o }}</td>
                      <td>{{ product.price_p }}</td>
                      <td>{{ product.price_q }}</td>
                      <td>{{ product.price_r }}</td>
                      
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
                      <th>Lista</th>
                      <th>Cantidad</th>
                      <th>A</th>
                      <th>B</th>
                      <th>C</th>
                      <th>D</th>
                      <th>E</th>
                      <th>G</th>
                      <th>H</th>
                      <th>I</th>
                      <th>J</th>
                      <th>K</th>
                      <th>L</th>
                      <th>M</th>
                      <th>N</th>
                      <th>O</th>
                      <th>P</th>
                      <th>Q</th>
                      <th>R</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(product, index) in $store.state.products_not_registered">
                      <td>{{ index + 1 }}</td>
                      <td>{{ product.reference }}</td>
                      <td>{{ product.description }}</td>
                      <td>{{ product.brand }}</td>
                      <td>{{ product.list }}</td>
                      <td>{{ product.minimum_amount }}</td>
                      <td>{{ product.price_a }}</td>
                      <td>{{ product.price_b }}</td>
                      <td>{{ product.price_c }}</td>
                      <td>{{ product.price_d }}</td>
                      <td>{{ product.price_e }}</td>
                      <td>{{ product.price_g }}</td>
                      <td>{{ product.price_h }}</td>
                      <td>{{ product.price_i }}</td>
                      <td>{{ product.price_j }}</td>
                      <td>{{ product.price_k }}</td>
                      <td>{{ product.price_l }}</td>
                      <td>{{ product.price_m }}</td>
                      <td>{{ product.price_n }}</td>
                      <td>{{ product.price_o }}</td>
                      <td>{{ product.price_p }}</td>
                      <td>{{ product.price_q }}</td>
                      <td>{{ product.price_r }}</td>
                      
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
    </div>
  `,
    data: function () {
    return {
      cols: [
        'description', 
        'brand', 'list', 
        'minimum_amount', 
        'price_a', 
        'price_b', 
        'price_c', 
        'price_d', 
        'price_e', 
        'price_g', 
        'price_h', 
        'price_i', 
        'price_j', 
        'price_k', 
        'price_l', 
        'price_m',
        'price_n',
        'price_o',
        'price_p',
        'price_q',
        'price_r',
        ],
    }
  },
  computed: {
    ...Vuex.mapState(['file', 'products', 'loading', 'products_not_registered', 'cols_selection']),
    ...Vuex.mapMutations(['postFile']),
  },
  methods:{
    iniciar(){
      store.state.file = this.$refs.file.files[0]
    }
  },
  watch:{
  },
})

const store = new Vuex.Store({
  state: {
    products: [],
    loading: false,
    cols_selection: [],
    file: '',
    
    number_registered_products: '',
    products_not_registered: '',
  },
  mutations:{
    postFile(state){
      /*
      * Envio del archivo excel
      */
      console.log(state.cols_selection)

      let formData = new FormData()
      formData.append('file', state.file)
      formData.append('cols', JSON.stringify(state.cols_selection))
      if (state.file != '' && state.cols_selection.length > 0) {
        state.loading = true
        axios
          .post(this._vm.$api_url + 'products/massive/update', 
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
        data = {
                title: 'Advertencia',
                type: 'warning',
                text: 'Debe seleccionar un archivo y al menos una columna para actualizar',
              }
        store.dispatch('notification', data)
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
        data = {
                  title: 'Error',
                  type: 'error',
                  text: 'No puede guardar sin antes haber cargado un archivo',
                }
        store.dispatch('notification', data) 
        return false
      }
      store.state.loading = true
      axios
          .post(this._vm.$api_url + 'products/massive/update/store', {
            data: {
              products: store.state.products[0],
              cols: store.state.cols_selection,
            }
          })
          .then(response => {
            data = response.data
            if (data.status == 201) {
              store.state.products = []
              store.state.products_not_registered = data.products_not_registered
              data = {
                  title: 'Exito',
                  type: 'success',
                  text: data.number_registered_products + ' productos registrado con exito.',
              }
            }
            else{
                data = {
                  title: 'Error',
                  type: 'error',
                  text: '',
                }
            }
            store.dispatch('notification', data) 

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