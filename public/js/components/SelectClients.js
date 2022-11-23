Vue.component('select-clients', {
  template:`
    <div>
    {{ getClients }}
    	<input class="form-control" type="text" v-model="name_search" @keyup.enter="nameSearch">
      <ul class="to_do" >
          <a href="#">
            <li v-for="client of result_clients">
                <select-client-item
                :client="client"
                ></select-client-item>
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
    ...Vuex.mapState(['clients']),
    getClients(){
        this.result_clients = store.state.clients
    }
  },
  methods:{
    nameSearch(){
        if(this.name_search.length > 3){
          this.result_clients = []
          for(client of store.state.clients){
            if (client.name.includes(this.name_search.toUpperCase())
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