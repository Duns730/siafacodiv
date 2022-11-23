Vue.component('xx-xx-xx', {
  template:`
    <div>
        
    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['']),
    ...Vuex.mapMutations(['']),
  },
  methods:{
    ...Vuex.mapActions(['']),
  },
  watch:{
  },
  mounted(){   
  }
})


const store = new Vuex.Store({
  state: {
    loading: false,
  },
  mutations:{
  },
  actions: {
  },
  modules: {
  }
})


new Vue({
  el:'#app',
  store,
  
})