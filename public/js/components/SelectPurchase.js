Vue.component('select-purchase', {
  template:`
    <div>
      <div class="col-10 offset-1">
        <select v-model="$store.state.purchase_id" class="form-control" @change="selectPurchase">
          <option
            v-for="purchase of $store.state.purchases"
            :value="purchase.id"
          >
            {{ formatDate(purchase.date) }} => {{purchase.title}}
          </option>
        </select>
      </div>
    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['purchases','purchase_id', 'purchases_select']),
    ...Vuex.mapMutations(['getPurchases', 'getClientsPurchaseProformas']),
  },
  methods:{
    selectPurchase(){
      for(purchase of store.state.purchases){
        if (purchase.id == store.state.purchase_id) {
          store.state.purchases_select.title = purchase.title
          store.state.purchases_select.document_number = purchase.document_number
          store.state.purchases_select.date = this.formatDate(purchase.date)
        }
      }
      store.commit('getClientsPurchaseProformas')
    },
    formatDate(date){
      return date.split("-").reverse().join("-")
    },
  },
  watch:{
  },
  mounted(){
    store.commit('getPurchases')
  },
})