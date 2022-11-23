Vue.component('show-select-clients', {
  template:`
    <div> 
    {{ getClient }}
      <input type="hidden" name="client_id" v-model="$store.state.client_select.id" id="client_id">
      <input class="form-control" required="required" name="client_name" type="text" id="client_name" disabled=""
        v-model="$store.state.client_select.name"
      >
    </div>
  `,
  props:['client'],
    data: function () {
      return{
      }
  },
  computed: {
    ...Vuex.mapState(['client_select']),
    ...Vuex.mapMutations(['getNegotiations', 'getInvoicesPayment',]),
    getClient(){
        store.state.client_select.id = this.client.id
        store.state.client_select.name = this.client.name
    },
  },
  methods:{
  },
  watch:{
    '$store.state.client_select.id'(value, oldValue){
        store.commit('getNegotiations') 
        store.commit('getInvoicesPayment')
    }
  },
})