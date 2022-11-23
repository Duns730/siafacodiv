Vue.component('permission', {
  template:`
    <div class="row">
        {{ getIdUser }}
        {{  checkUserPermissions }}
        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="clients"
            title="Clientes"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="sellers"
            title="Vendedores"
            :user_id="$store.state.user_id"
        ></permission-item-list>


        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="negotiations"
            title="Negociaciones"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="products"
            title="Productos"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="proformas"
            title="Proformas"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="purchases"
            title="Compras"
            :user_id="$store.state.user_id"
        ></permission-item-list>
        
        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="payments"
            title="Cobranza"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="creditnotes"
            title="Notas de Credito"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="transports"
            title="Transporte"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="special"
            title=""
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="special"
            title=""
            :user_id="$store.state.user_id"
        ></permission-item-list>



        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="configurations"
            title="Configuraciones"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="users"
            title="Usuarios"
            :user_id="$store.state.user_id"
        ></permission-item-list>

        <permission-item-list
            :permissions_user="check_user_permissions"
            objet="banks"
            title="Bancos"
            :user_id="$store.state.user_id"
        ></permission-item-list>
    </div>
  `,
  props:['id_user'],
    data: function () {
    return {
    check_user_permissions: [],
    }
  },
  computed: {
    ...Vuex.mapState(['permissions', 'permissions_user', 'user_id']),
    getIdUser() {
      store.state.user_id = this.id_user
    },
    checkUserPermissions() {

      for(index in store.state.permissions){
        for(index2 in store.state.permissions_user){
          if (store.state.permissions[index].id == store.state.permissions_user[index2].permission_id) {
            check = true 
            break}
          else{
            check = false}
        }
        this.check_user_permissions.push({
            'id' : store.state.permissions[index].id, 
            'name' : store.state.permissions[index].name, 
            'description' : store.state.permissions[index].description,  
            'check' : check, 
        })
      }
    },
  },
  methods:{
    
  }
})

const store = new Vuex.Store({
  state: {
    loading: false,
    permissions: {},
    permissions_user: {},
    user_id: '',
  },
  mutations:{
    getPermissions:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'permission/')
        .then(response => {
          state.permissions = response.data
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getPermissions')
          }
        })
        .finally(() => state.loading = false)
    },
    getPermissionsUser:function(state) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'permission/' + state.user_id + '/user')
        .then(response => {
          state.permissions_user = response.data
          console.log(state.permissions_user)
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getPermissionsUser')
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
    this.$store.commit('getPermissions')
    this.$store.commit('getPermissionsUser')    
  }
})