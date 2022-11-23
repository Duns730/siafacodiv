Vue.component('change-product-price', {
  template:`
    <div>
      <div class="col-md-6 col-sm-6">
      	<label class="col-form-label col-md-4 col-sm-4 label-align">
      		Precio A
  		  </label>
      	<div class="col-md-8 col-sm-8  form-group has-feedback">
    			<input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_a">
    			<span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
  		  </div>

  		  <label class="col-form-label col-md-4 col-sm-4 label-align">
      		Precio B
  		  </label>
      	<div class="col-md-8 col-sm-8  form-group has-feedback">
    			<input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_b">
    			<span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
  		  </div>

  		  <label class="col-form-label col-md-4 col-sm-4 label-align">
      		Precio C
  		  </label>
      	<div class="col-md-8 col-sm-8  form-group has-feedback">
    			<input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_c">
    			<span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
    		</div>

  		  <label class="col-form-label col-md-4 col-sm-4 label-align">
      		Precio D
  		  </label>
      	<div class="col-md-8 col-sm-8  form-group has-feedback">
    			<input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_d">
    			<span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
  		  </div>

  		  <label class="col-form-label col-md-4 col-sm-4 label-align">
      		Precio E
  		  </label>
      	<div class="col-md-8 col-sm-8  form-group has-feedback">
    			<input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_e">
    			<span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
    		</div>

  		  <label class="col-form-label col-md-4 col-sm-4 label-align">
      		Precio F
  		  </label>
      	<div class="col-md-8 col-sm-8  form-group has-feedback">
    			<input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_f">
    			<span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
    		</div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio G
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_g">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio H
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_h">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio I
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_i">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>
      </div>


      <div class="col-md-6 col-sm-6">
        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio J
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_j">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio K
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_k">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio L
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_l">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          <span class="small">Precio M</span>
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_m">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio N
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_n">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio O
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_o">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio P
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_p">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio Q
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_q">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>

        <label class="col-form-label col-md-4 col-sm-4 label-align">
          Precio R
        </label>
        <div class="col-md-8 col-sm-8  form-group has-feedback">
          <input type="text" class="form-control has-feedback-right" v-model="$store.state.prices.price_r">
          <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
        </div>
      </div>

    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['id_product', 'prices']),
    getIdProduct(){
        store.state.id_product = this.product_id
    },
  },
  methods:{
  }
})

Vue.component('prices-product', {
  template:`
    <div>
    	{{ getIdProduct }}
    	 <table class="table table-bordered" style="text-align: center">
          <thead>
            <tr >
              <th>A</th>
              <th>B</th>
              <th>C</th>
              <th>D</th>
              <th>E</th>
              <th>F</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $store.state.prices.price_a }}</td>
              <td>{{ $store.state.prices.price_b }}</td>
              <td>{{ $store.state.prices.price_c }}</td>
              <td>{{ $store.state.prices.price_d }}</td>
              <td>{{ $store.state.prices.price_e }}</td>
              <td>{{ $store.state.prices.price_f }}</td>
            </tr>
            <tr>
              <th>G</th>
              <th>H</th>
              <th>I</th>
              <th>J</th>
              <th>K</th>
              <th>L</th>
            </tr>
             <tr>
              <td>{{ $store.state.prices.price_g }}</td>
              <td>{{ $store.state.prices.price_h }}</td>
              <td>{{ $store.state.prices.price_i }}</td>
              <td>{{ $store.state.prices.price_j }}</td>
              <td>{{ $store.state.prices.price_k }}</td>
              <td>{{ $store.state.prices.price_l }}</td>
            </tr>
            <tr>
              <th>M</th>
              <th>N</th>
              <th>O</th>
              <th>P</th>
              <th>Q</th>
              <th>R</th>
            </tr>
             <tr>
              <td>{{ $store.state.prices.price_m }}</td>
              <td>{{ $store.state.prices.price_n }}</td>
              <td>{{ $store.state.prices.price_o }}</td>
              <td>{{ $store.state.prices.price_p }}</td>
              <td>{{ $store.state.prices.price_q }}</td>
              <td>{{ $store.state.prices.price_r }}</td>
            </tr>
          </tbody>
        </table>
    </div>
  `,
  props:['product_id'],
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['id_product', 'prices']),
    getIdProduct(){
        store.state.id_product = this.product_id
    },
  },
  methods:{

  }
})

const store = new Vuex.Store({
  state: {
    loading: false,
  	prices: {},
  	id_product: '',
  },
  mutations:{
  	getPrices(state){
    	state.loading = true
      axios.get(this._vm.$api_url + 'prices/' + state.id_product + '/product')
        .then(response => {
          state.prices = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getPrices')
          }
        })
        .finally(() => state.loading = false)
    },
    updatePrices(state){
      state.loading = true
    	axios
      .post(this._vm.$api_url + 'prices/update', {
          data: {
            prices: state.prices,
          }
        })
        .then(response => {
          data = response.data
          if (data.status == 201) {
            new PNotify({
              title: 'Exito',
              text: 'La actualización de precios ha sido exitosa' ,
              type: 'success',
              styling: 'bootstrap3'
            });
          }
          else{
            new PNotify({
              title: 'Error ',
              text: 'No se ha podido actualizar los precios',
              type: 'error',
              styling: 'bootstrap3'
            });
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
  data:{
  },
  store,
  mounted(){ 
  	this.$store.commit('getPrices') 
  }
})