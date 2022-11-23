Vue.component('configuration-action', {
  template:`
    <div>
        <label for="concept" class="col-form-label col-md-12 col-sm-12">{{ $store.state.configuration.concept }}</label>
        <div class="col-md-12 col-sm-12 " v-if="$store.state.configuration.type == 'textarea'">
        	<textarea v-model="$store.state.configuration.value" class="form-control" name="newValue"></textarea>
        </div>
        <div class="col-md-12 col-sm-12 " v-else>
        	<input type="$store.state.configuration.type" v-model="$store.state.configuration.value" class="form-control" name="newValue">
          
        </div>
    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['configuration']),
    ...Vuex.mapMutations(['']),

  },
  methods:{
    ...Vuex.mapActions(['getData']),
  },
  watch:{
  },
})


const store = new Vuex.Store({
  state: {
    loading: false,
    configuration: [],
  },
  mutations:{
  },
  actions: {
  	getData:function(commit, data){
  		store.state.configuration = data
  	},
  	postConfiguration:function(commit) {
  		store.state.loading = true
  		axios
         	.post(this._vm.$api_url + 'configurations/update', {
	            data: {
	              id: store.state.configuration.id,
	              value: store.state.configuration.value,
	            }
	         })
	         .then(response => {
	         	data = response.data
	         	console.log(data)
	         	if (data.status == 201) {
	         		message = {
		                  title: 'Exito',
		                  type: 'success',
		                  text: '',
		            }
		            store.dispatch('notification', message)
					location.href = this._vm.$base_url + 'configurations'
	         	}
	         	else{
	         		message = {
		                title: 'Error',
		                type: 'error',
		                text: `La configuración no pudo ser actualizada, por favor refresque el navegador e intente nuevamente`,
		             }
	          		store.dispatch('notification', message)
	         	}
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
  mounted(){   
  }
})