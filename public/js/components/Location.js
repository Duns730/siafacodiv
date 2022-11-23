Vue.component('location', {
  template:`
  <div>
      <div class="input-group">
        <select class='form-control'
          required='required'
          id='location_id'
          name='location_id' 
          v-model='$store.state.address.id_location'
        >
          <option
            v-for='location of $store.state.locations[0]'
            :value='location.id'
          > 
              {{ location.name }} 
          </option> 
        </select>
        <span class="input-group-btn" data-toggle="modal" data-target=".createlocation">
          <button type="button" class="btn btn-primary">
            <i class='fa fa-plus-square'> </i>
          </button>
        </span>
      </div>

      <div class="modal fade createlocation" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel2">Nuevo Ubicacion</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 col-sm-12 ">
                  <h4>Nombre</h4>
                  <textarea v-model="new_location" class="form-control">
                  </textarea>
                  
                </div>
              </div>
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" @click="postNewlocation">Guardar</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  `,
  data(){
    return{
      new_location: ''
    }
  },
  computed: {
    ...Vuex.mapState(['address', 'locations']),
    ...Vuex.mapMutations(['initializeVariable']),
  },
  methods:{
    postNewlocation() {
        if (store.state.address.id_population_center != 0) {
          if (this.new_location != '') {
            axios
              .post(this.$api_url + 'adresses/locations/store', {
                data: {
                  name: this.new_location,
                  population_center_id: store.state.address.id_population_center,
                }
              })
              .then(response => {
                data = response.data
                if (data.status == 201) {
                  store.state.locations[0].push(data)
                  store.state.address.id_location = data.id
                  store.state.vias = [[{id:'', name:'Cree un registro'}]]
                  store.state.address.id_via = ''
                }
              })
          }
          else{
            alert('Debe llenar el campos')
          }
        }
        else{
          alert('Debe seleccionar un centro poblado')
        }
    },
  }
})