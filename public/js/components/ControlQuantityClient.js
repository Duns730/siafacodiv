Vue.component('control-quantity-client', {
  template:`
    <div class="col-8">
        <div class="col-12 table-responsive">
          <table class="table table-striped jambo_table bulk_action"
            v-if="$store.state.purchase_products[0]">
            <thead class="small">
                <tr>
                  <td v-for="client of $store.state.clients.clients">
                    {{ client.name }}
                  </td>
                </tr>
            </thead>
            <tbody class="small">
                <tr>
                  <td v-for="client of $store.state.clients.clients">
                    {{ client.name }}
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['clients']),
    ...Vuex.mapMutations(['',]),
  },
  methods:{
  },
  watch:{
  },
})