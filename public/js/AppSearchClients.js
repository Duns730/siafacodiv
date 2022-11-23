Vue.component('app-search-clients', {
  template:`
    <div>
        {{ deliverClients }}
        <input class="form-control" type="text" v-model="name_search" @keyup.enter="nameSearch">
        <ul class="to_do" >
            <a v-for="item of result_clients" :href="$base_url+'clients/'+item.id">
              <li>
                  {{ item.name }}
              </li>
            </a>
          </ul>
    </div>
  `,
    data: function () {
    return {
      name_search: '',
      result_clients: [],
    }
  },
  computed: {
    ...Vuex.mapState(['clients', 'url']),
    deliverClients() {
      this.result_clients = store.state.clients
    },
    
  },
  methods:{
    nameSearch(){
        if(this.name_search.length > 3){
          this.result_clients = []
          for(client of store.state.clients){
            if (client.name.includes(this.name_search.toUpperCase())
                || client.rif.includes(this.name_search.toUpperCase())
                || client.id.toString().padStart(10, '0').includes(this.name_search)) {
              this.result_clients.push(client)
            }
          }
        }
    },
  },
  watch:{
    'name_search'(old_val, new_val){
      this.nameSearch()
    }
  },
})

const store = new Vuex.Store({
  state: {
    data_target: '.modalSearchClients',
    loading: false,
    clients:[],
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
    this.$store.commit('getClients')    
  }
})