
Vue.component('municipalities', {
  template:`
    <div>
      <select class='form-control' id='municipality_id' name='municipality_id'>
        <option value=''> {{$store.state.state}} </option>  
      </select>
    </div>
  `,
  data(){
    return {
      algo: 'true'
    }
  }
})
/**/
Vue.component('populationcenter', {
  template:`
    <div>
      <select class='form-control' id='populationcenter_id' name='populationcenter_id'>
        <option value=''>  </option>  
      </select>
    </div>
  `,
})


const store = new Vuex.Store({
	state:{
		state: '',
		adresses: []
	},
	mutations:{
		getAdresses: function(state) {
			urlAdresses = 'http://metz.test/api/admin/adresses/municipalities/' + state.state
			axios
		      .get(urlAdresses)
		      .then(response => {
		        state.adresses = response.data.bpi
		        console.log(state.adresses)
		      })
		}
	}
})

new Vue({
	el:'#app',
	store: store,
	data:{
		state: store.state
	}
})