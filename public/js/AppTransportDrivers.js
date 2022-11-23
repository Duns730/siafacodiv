//AppTransportDrivers
Vue.component('app-transport-drivers', {
  template:`
    <div>
        <table class="table table-striped jambo_table">
		  <thead>
		    <tr class="headings">
		      <th class="column-title">Id </th>
		      <th class="column-title" style="">Cedula Identidad </th>
		      <th class="column-title">Nombre y Apellido </th>
		      <th class="column-title">Acciones </th>
		      </th>
		    </tr>
		  </thead>

		  <tbody>

		  </tbody>
		</table>
    </div>
  `,
  props: ['id_transport'],
  data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['transport_id']),
    ...Vuex.mapMutations(['getDrivers']),
  },
  methods:{
    ...Vuex.mapActions(['']),
  },
  watch:{
  },
    mounted(){
    	store.state.transport_id = this.id_transport
    	store.commit('getDrivers')
  }
})


Vue.component('create-drivers', {
  template:`
    <div>
       <div class="item form-group">
       		<label for="name" class="col-form-label col-md-3 col-sm-3 label-align">Nombre</label>
			<div class="col-md-8 col-sm-8 ">
		    	<input class="form-control" required="required" type="text" 
		    		v-model="$store.state.driver_selection.name" name="name"
		    	>
		    </div> 
 		</div>
 		<div class="item form-group">
       		<label for="identity_card" class="col-form-label col-md-3 col-sm-3 label-align">Cedula de Identidad</label>
			<div class="col-md-8 col-sm-8 ">
		    	<input class="form-control"  type="text"
		    		required="required" name="identity_card"
		    		v-model="$store.state.driver_selection.identity_card"
		    	>
		    </div> 
 		</div>
    </div>
  `,
  data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['driver_selection']),
    ...Vuex.mapMutations(['']),
  },
  methods:{
    //...Vuex.mapActions(['']),
  },
  watch:{
  },
    mounted(){
  }
 
})

const store = new Vuex.Store({
  state: {
    transport_id: '',
    drivers: [],
    driver_selection:{
    	id: '',
    	name: '',
    	identity_card: 'V-',
    },
    loading: false,
  },
  mutations:{
  	getDrivers:function(state) {
  		state.loading = true
  		axios
	        .get(this._vm.$api_url + 'drivers/' + state.transport_id)
	        .then(response => {
	          state.drivers = response.data
	        })
	        .catch(error => {
	          if (error.response.status == 500) {
	            store.commit('getDrivers')
	          }
	        })
	        .finally(() => state.loading = false)
  	}
  },
  actions: {
  	postDriver:function(commit) {
  		store.state.loading = true
  		//alert(store.state.driver_selection.name)
  		alert(store.state.driver_selection.identity_card)
  		//alert(store.state.driver_selection.identity_card.length)
  		if (store.state.driver_selection.name
  			&& store.state.driver_selection.identity_card.length <= 10
  			&& store.state.driver_selection.identity_card.length >= 9
  			) {
  			url = this._vm.$api_url +  'drivers/store'
  		}
	  	else{
	  		message = {
                title: 'Error',
                type: 'error',
                text: `Verifique la información que esta agregando.`,
              }
            store.dispatch('notification', message)
	  		store.state.loading = false
	  		return false
	  	}
  		axios
	        .post(url, {
	    		data:{
	    			transport_id: store.state.transport_id,
	    			name: store.state.driver_selection.name,
	    			identity_card: store.state.driver_selection.identity_card,
	    		}
	        })
	        .then(response => {
	          state.drivers = response.data
	        })
	        .catch(error => {

	        })
	        .finally(() => store.state.loading = false)
  	},
  	notification(commit, data){
      new PNotify({
        title: data.title,
        text:  data.text,
        type: data.type,
        styling: 'bootstrap3'
      });
    },
  },
  modules: {
  }
})


new Vue({
  el:'#app',
  store,
})