Vue.component('totalize-proforma', {
  template:`
    <div>

      <div class="item form-group">
        <label for="number_invoice" class="col-form-label col-md-4 col-sm-4 label-align">Número de  Factura</label>
        <div class="col-md-7 col-sm-7 ">
          <input type="number" v-model="$store.state.number_invoice" class="form-control">
        </div>
      </div>

      <div class="item form-group" ><!-- v-if="$store.state.provisional" --> 
        <label for="number_invoice" class="col-form-label col-md-4 col-sm-4 label-align">Número de  Control</label>
        <div class="col-md-7 col-sm-7 ">
          <input type="number" v-model="$store.state.control_number" class="form-control">
        </div>
      </div>

      <div class="item form-group">
        <label for="number_invoice" class="col-form-label col-md-4 col-sm-4 label-align">Fecha</label>
        <div class="col-md-7 col-sm-7 ">
          <input type="date" v-model="$store.state.date" class="form-control">
        </div>
      </div>

      <div class="item form-group">
        <label for="number_invoice" class="col-form-label col-md-4 col-sm-4 label-align">Vendedor</label>
        <div class="col-md-7 col-sm-7 ">
          <select v-model="$store.state.seller_id_select"  class="form-control">
            <option 
              v-for="seller of $store.state.sellers"
              :value="seller.id"
            >
              {{ seller.id }} - {{ seller.name }}
            </option>
          </select>
        </div>
      </div>

      
    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['seller_id_select', 'number_invoice', 'date', 'sellers', 'control_number', 'provisional']),
  },
  methods:{
  }
})