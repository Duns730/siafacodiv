Vue.component('population-center', {
  template:`
  <div>
      <div class="input-group">
        <select class='form-control'
          required='required'
          id='population_center_id'
          name='population_center_id' 
          v-model='$store.state.address.id_population_center'
          @change='getLocation'
        >
          <option
            v-for='population_center of $store.state.population_centers[0]'
            :value='population_center.id'
          > 
              {{ population_center.name }} 
          </option> 
        </select>
        <span class="input-group-btn" data-toggle="modal" data-target=".createPoblationCenter">
          <button type="button" class="btn btn-primary">
            <i class='fa fa-plus-square'> </i>
          </button>
        </span>
      </div>

      <div class="modal fade createPoblationCenter" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel2">Nuevo Centro Poblado</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <h4>Nombre</h4>
                <input type="text" v-model="new_population_center" class="form-control">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" @click="postNewPopulationCenter">Guardar</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  `,
  data(){
    return{
      new_population_center: ''
    }
  },
  computed: {
    ...Vuex.mapState(['address', 'population_centers', 'locations']),
    ...Vuex.mapMutations(['initializeVariable']),
  },
  methods:{
    getLocation(){
      store.commit('initializeVariable','population_center')
      //url = 'http://siacodiv.test/api/
      axios
        .get(this.$api_url + 'adresses/locations/' + store.state.address.id_population_center)
        .then(response => {
          store.state.locations = response.data
      })
    },
    postNewPopulationCenter() {

        if (store.state.address.id_municipality != 0) {
          if (this.new_population_center != '') {
            axios
              .post(this.$api_url + 'adresses/population-centers/store', {
                data: {
                  name: this.new_population_center,
                  municipality_id: store.state.address.id_municipality,
                }
              })
              .then(response => {
                data = response.data
                if (data.status == 201) {
                  store.state.population_centers[0].push(data)
                  store.state.address.id_population_center = data.id
                  store.state.locations = [[{id:'', name:'Cree un registro'}]]
                  store.state.address.id_location = ''
                }
              })
          }
          else{
            alert('Debe llenar el campo Nombre')
          }
        }
        else{
          alert('Debe seleccionar un municipio')
        }
    },
  }
})