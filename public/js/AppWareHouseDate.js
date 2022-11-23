Vue.component('selection-warehouse', {
  template:`
    <div>
      <li><span>Almacén(Selección):</span>
        <span v-if="data.date != ''" >
            {{ data.date }}
        </span>
        <span v-else>
            <input type="checkbox" v-model="selection_warehouse" >
        </span>
      </li>
    </div>
  `,
  props:['data'],
    data: function () {
    return {
      selection_warehouse: false,
      resp: [],
    }
  },
  computed: {
    ...Vuex.mapState(['loading']),
    selectionWarehouseActive(){
      store.state.loading = true
      axios
        .post(this.$api_url + 'negotiations/selectionwarehouse',{
          data: {
            negotiation_id: this.data.negotiation_id,
            user_id: this.data.user_id,
          },
        })
        .then(response => {
          this.resp = response.data
          if (this.resp.status == 201) {
            this.selection_warehouse = true
            this.data.date = this.resp.date
            this.$forceUpdate ()
            message = {
                title: 'Exito',
                type: 'success',
                text: this.resp.message,
              }
              store.dispatch('notification', message)
          }
          else{
            message = {
                title: 'Error',
                type: 'error',
                text: this.resp.message,
              }
              store.dispatch('notification', message)
            this.selection_warehouse = false
          }
        })
        .finally(() => store.state.loading = false)
    }
  },
  methods:{
  },
  watch:{
    'selection_warehouse'(new_value, old_value){
      if (new_value) {
        this.selectionWarehouseActive
      }
    }
  },

})

Vue.component('warehouse-packing', {
  template:`
    <div>
      <li><span>Almacén(Embalaje):</span>
        <span v-if="data.date != ''" >
            {{ data.date }}
        </span>
        <span v-else>
            <input type="checkbox" v-model="warehouse_packing" >
        </span>
      </li>
    </div>
  `,
  props:['data'],
    data: function () {
    return {
      warehouse_packing: false,
      resp: [],
    }
  },
  computed: {
    ...Vuex.mapState(['loading']),
    warehousePackingActive(){
      store.state.loading = true
      axios
        .post(this.$api_url + 'negotiations/warehousepacking',{
          data: {
            negotiation_id: this.data.negotiation_id,
            user_id: this.data.user_id,
          },
        })
        .then(response => {
          this.resp = response.data
          if (this.resp.status == 201) {
            this.warehouse_packing = true
            this.data.date = this.resp.date
            this.$forceUpdate ()
            message = {
                title: 'Exito',
                type: 'success',
                text: this.resp.message,
              }
              store.dispatch('notification', message)
          }
          else{
            message = {
                title: 'Error',
                type: 'error',
                text: this.resp.message,
              }
              store.dispatch('notification', message)
            this.warehouse_packing = false
            //this.$forceUpdate ()
          }
        }) 
        .finally(() => store.state.loading = false)
    }
  },
  methods:{
  },
  watch:{
    'warehouse_packing'(new_value, old_value){
      if (new_value) {
        this.warehousePackingActive
      }
    }
  },

})

Vue.component('warehouse-packed', {
  template:`
    <div>
      <li><span>Almacén(Embalado):</span>
        <span v-if="data.date != ''" >
            {{ data.date }}
        </span>
        <span v-else>
            <input type="checkbox" v-model="warehouse_packed" >
        </span>
      </li>
    </div>
  `,
  props:['data'],
    data: function () {
    return {
      warehouse_packed: false,
      resp: [],
    }
  },
  computed: {
    ...Vuex.mapState(['loading']),
    warehousePackedActive(){
      store.state.loading = true
      axios
        .post(this.$api_url + 'negotiations/warehousepacked',{
          data: {
            negotiation_id: this.data.negotiation_id,
            user_id: this.data.user_id,
          },
        })
        .then(response => {
          this.resp = response.data
          if (this.resp.status == 201) {
            this.warehouse_packed = true
            this.data.date = this.resp.date
            this.$forceUpdate ()
            message = {
                title: 'Exito',
                type: 'success',
                text: this.resp.message,
              }
              store.dispatch('notification', message)
          }
          else{
            message = {
                title: 'Error',
                type: 'error',
                text: this.resp.message,
              }
              store.dispatch('notification', message)
            this.warehouse_packed = false
            //this.$forceUpdate ()
          }
        }) 
        .finally(() => store.state.loading = false)
    }
  },
  methods:{
  },
  watch:{
    'warehouse_packed'(new_value, old_value){
      if (new_value) {
        this.warehousePackedActive
      }
    }
  },

})

Vue.component('order-delivered', {
  template:`
    <div>
      <li><span>Pedido Entregado:</span>
        <span v-if="data.date != ''" >
            {{ data.date }}
        </span>
        <span v-else>
            <input type="date" v-model="date_order_delivered">
        </span>
      </li>
    </div>
  `,
  props:['data'],
    data: function () {
    return {
      date_order_delivered: false,
      resp: [],
    }
  },
  computed: {
    ...Vuex.mapState(['loading']),
    postDateOrderDelivered(){
      store.state.loading = true
      axios
        .post(this.$api_url + 'negotiations/orderdelivered',{
          data: {
            negotiation_id: this.data.negotiation_id,
            user_id: this.data.user_id,
            order_delivered: this.date_order_delivered,
          },
        })
        .then(response => {
          this.resp = response.data
          if (this.resp.status == 201) {
            this.date_order_delivered = 
            this.data.date = this.resp.date
            this.$forceUpdate ()
            message = {
                title: 'Exito',
                type: 'success',
                text: this.resp.message,
              }
              store.dispatch('notification', message)
          }
          else{
            message = {
                title: 'Error',
                type: 'error',
                text: this.resp.message,
              }
              store.dispatch('notification', message)
            this.selection_warehouse = false
          }
        })
        .finally(() => store.state.loading = false)
      
    }
  },
  methods:{
  },
  watch:{
    'date_order_delivered'(new_value, old_value){
      if (new_value) {
        
        this.postDateOrderDelivered
      }
    }
  },

})

const store = new Vuex.Store({
  state: {
    loading: false,
  },
  mutations:{
  },
  actions: {
    notification(commit, data){
      new PNotify({
        title: data.title,
        text:  data.text,
        type: data.type,
        styling: 'bootstrap3'
      });
    },
  },
  modules: {
  }
})


new Vue({
  el:'#app',
  store,
  mounted(){   
  }
})