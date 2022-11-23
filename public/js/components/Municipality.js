Vue.component('municipality', {
  template:`
    <div>
      <select class='form-control'
        required='required'
        id='municipality_id'
        name='municipality_id' 
        v-model='$store.state.address.id_municipality'
        @change='getPopulationCenters'
      >
        <option
          v-for='municipalities of $store.state.municipalities[0]'
          :value='municipalities.id'
        > 
            {{ municipalities.name }} 
        </option> 
      </select>
    </div>
  `,
  computed: {
    ...Vuex.mapState(['address', 'municipalities', 'population_centers']),
    ...Vuex.mapMutations(['initializeVariable']),
  },
  methods:{
    getPopulationCenters(){
      store.commit('initializeVariable','municipality')
      //url = 'http://siacodiv.test/api/
      axios
        .get(this.$api_url + 'adresses/population-centers/' + store.state.address.id_municipality)
        .then(response => {
          store.state.population_centers = response.data
          console.log(store.state.population_centers)
      })
    },
  }
})