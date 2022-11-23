Vue.component('app-search-invoice', {
  template:`
    <div>
          <input v-model="invoice_number" class="form-control" v-on:keyup.enter="searchInvoice()"/>
    </div>
  `,
    data: function () {
    return {
      invoice_number: '',
    }
  },
  computed: {
  },
  methods:{
    searchInvoice(){
      location.href = this.$base_url + 'invoices/search/' + this.invoice_number
    }
  },
  watch:{
  },
})
