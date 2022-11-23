Vue.component('address-es', {
  template:`
    <div>
        <div class="item form-group">
          <label for="state" class="col-form-label col-md-2 col-sm-2 label-align">Estado</label>
          <div class="col-md-3 col-sm-3 ">
              <state></state> 
          </div> 
          <label for="municipality_id" class="col-form-label col-md-2 col-sm-2 label-align">Municipio</label>
          <div class="col-md-3 col-sm-3 ">
              <municipality></municipality>
          </div>  
        </div>

        <div class="item form-group">
          <label for="populationcenter_id" class="col-form-label col-md-2 col-sm-2 label-align">Centro Poblado</label>
          <div class="col-md-3 col-sm-3 ">
              <population-center></population-center>
          </div>
  
        </div>

      <div class="item form-group">  
          <label for="location_id" class="col-form-label col-md-2 col-sm-2 label-align">Ubicación</label>
          <div class="col-md-8 col-sm-8 ">
              <location></location>
          </div>  
      </div>


        
    </div>
  `,
  computed: {
    ...Vuex.mapState(['states'])
  }
})


const store = new Vuex.Store({
  state: {
    address:{
        'id_state': '',
        'id_municipality': '',
        'id_population_center': '',
        'id_location': '',
    },
    states:{},
    municipalities:{},
    population_centers:{},
    locations:{},
  },
  mutations: {
   getStates:function(state) {
      axios
        .get(this._vm.$api_url + 'adresses/states/')
        .then(response => {
          state.states = response.data
      })
      .catch(error => {
            if (error.response.status == 500) {
              store.commit('getStates')
            }
          });
    },
    initializeVariable:function(state, variable) {
      switch (variable) {
        case 'state':
          state.address.id_municipality = ''
          state.population_centers = {};
          state.address.id_population_center = ''
          state.locations = {};
          state.address.id_location = ''
          break;
        case 'municipality':
          state.address.id_population_center = ''
          state.locations = {};
          state.address.id_location = ''
          break;
        case 'population_center':
          state.address.id_location = ''
          break;
      }
      
    }
  },
  actions: {
  },
  modules: {
  }
})

new Vue({
  el:'#app',
  store,
  mounted(){
    this.$store.commit('getStates')
  }
})

