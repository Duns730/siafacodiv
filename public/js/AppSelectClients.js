const store = new Vuex.Store({
  state: {
    loading: false,
    clients: {},
    negotiations: {},
    client_select:{
      id: '',
      name: '',
    }
  },
  mutations:{
    getClients:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'clients/')
        .then(response => {
          state.clients = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getClients')
          }
        })
        .finally(() => state.loading = false)
    },
    getNegotiationsClient:function(state) {
      
      state.loading = true
      axios
        .get(this._vm.$api_url + 'clients/' + state.client_select.id + '/negotiations')
        .then(response => {
          state.negotiations = response.data
          store.commit('verifyLengthNegotiations')
        })
        .catch(error => {
            if (error.response.status == 500) {
              store.commit('getNegotiations')
            }
        })
        .finally(() => state.loading = false)
    },
    verifyLengthNegotiations:function(state){
      text = '<ul>'
      if (state.negotiations[0].negotiations.length > 0) {
        for(negotiation of state.negotiations[0].negotiations){
          if (!negotiation.invoice_date) {
            text += '<li>'+negotiation.title+'</li>'
          }
        }
        text += '</ul>'
      }

      if (text.length > 9) {
        new PNotify({
          title: 'Cliente con Proformas por facturar',
          type: 'warning',
          text: text,
          nonblock: {
              nonblock: true
          },
          styling: 'bootstrap3',
        });
      }

      
    },
  },
  actions: {
  },
  modules: {
  }
})


new Vue({
  el:'#app',
  data:{
    effective_percentage: 50,
    transfer_percentage: 50,
  },
  store,
  mounted(){
    this.$store.commit('getClients')   
  }
})