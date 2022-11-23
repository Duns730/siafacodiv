Vue.component('state', {
  template:`
    <div>
      <select class='form-control'
        required='required'
        id='state_id'
        name='state_id' 
        v-model='$store.state.address.id_state'
        @change='getMunicipalities'
      >
        <option
          v-for='state of $store.state.states[0]'
          :value='state.id'
        > 
            {{ state.name }} 
        </option> 
      </select>
    </div>
  `,
  computed: {
    ...Vuex.mapState(['address', 'states', 'municipalities']),
    ...Vuex.mapMutations(['initializeVariable']),
  },
  methods:{
    getMunicipalities(){
      store.commit('initializeVariable','state')
      //url = 'http://siacodiv.test/api/
      axios
        .get(this.$api_url + 'adresses/municipalities/' + store.state.address.id_state)
        .then(response => {
          store.state.municipalities = response.data
          //console.log(store.state.municipalities)
      })
    },
  }
})