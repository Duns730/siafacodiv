Vue.component('select-client-item', {
  template:`
    <div>
      <span @click="selectClient" data-dismiss="modal">
        {{ client.name }}
      </span>
    </div>
  `,
  props:['client'],
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['client_select']),
    ...Vuex.mapMutations(['getNegotiationsClient']),
  },
  methods:{
    selectClient(){
      store.state.client_select.id = this.client.id
      store.state.client_select.name = this.client.name
      store.commit('getNegotiationsClient')
    }
  },
})