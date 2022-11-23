Vue.component('negotiations-status', {
  template:`
    <div>
      <div class="progress">
        <div :class="state[11].bg" 
              role="progressbar" :style="state[11].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[11].title"
        >
        </div>
        <div :class="state[10].bg" 
              role="progressbar" :style="state[10].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[10].title"
        >
        </div>
        <div :class="state[9].bg" 
              role="progressbar" :style="state[9].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[9].title"
        >
        </div>
        <div :class="state[8].bg" 
              role="progressbar" :style="state[8].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[8].title"
        >
        </div>
        <div :class="state[7].bg" 
              role="progressbar" :style="state[7].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[7].title"
        >
        </div>
        <div :class="state[6].bg" 
              role="progressbar" :style="state[6].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[6].title"
        >
        </div>
        <div :class="state[5].bg" 
              role="progressbar" :style="state[5].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[5].title"
        >
        </div>
        <div :class="state[4].bg" 
              role="progressbar" :style="state[4].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[4].title"
        >
        </div>
        <div :class="state[3].bg" 
              role="progressbar" :style="state[3].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[3].title"
        >
        </div>
        <div :class="state[2].bg" 
              role="progressbar" :style="state[2].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[2].title"
        >
        </div>
        <div :class="state[1].bg" 
              role="progressbar" :style="state[1].width" aria-valuenow="10" aria-valuemin="0" 
              aria-valuemax="100" data-toggle="tooltip" data-placement="top" 
              :data-original-title="state[1].title"
        >
        </div>
      </div>
    </div>
  `,
  props:['dates'],
    data: function () {
    return {
      state:{
        1: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-dark',    width: 'width: 5%',   title: 'Creado'},
        2: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-secondary',width: 'width: 14.5%',  title: 'Proformado'},
        3: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-danger',  width: 'width: 24%',  title: 'Almacén(Selección)'},
        4: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-danger',  width: 'width: 33.5%',  title: 'Proforma Depurada'},
        5: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-warning', width: 'width: 43%',  title: 'Facturado'},
        6: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-warning', width: 'width: 52.5%',  title: 'IVA Pago'},
        7: {bg: 'progress-bar title progress-bar-striped progress-bar-animated ',           width: 'width: 62%',  title: 'Almacén(Embalaje)'},
        8: {bg: 'progress-bar title progress-bar-striped progress-bar-animated ',           width: 'width: 71.5%',  title: 'Almacén(Embalado)'},
        9: {bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-primary',           width: 'width: 81%',  title: 'Pedido Despachado'},
        10:{bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-primary',           width: 'width: 90.5%',  title: 'Pedido Entregado'},
        11:{bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-success', width: 'width: 100%', title: 'Pago Completo'},
      },
      state_default:{
        bg: 'progress-bar title progress-bar-striped progress-bar-animated bg-white',
        title: '',
      },
    }
  },
  computed: {
    selectState() {
      for(index in this.dates){
       if (this.dates[index] == '') {
        this.state[index].bg = this.state_default.bg
        this.state[index].title = this.state_default.title
       }
      }
    },
  },
  methods:{
  },
  mounted(){
    this.selectState
  },
})

Vue.component('app-search-negotiations', {
  template:`
    <div>
        <input class="form-control" type="text" v-model="name_search" @keyup.enter="nameSearch()">
        <ul class="to_do" >
            <a v-for="item of $store.state.negotiations"  :href="$base_url+'negotiations/'+item.id">
              <li>
                <div class="row">
                  <div class="col-md-6 col-sm-6">{{ item.title }}</div>
                  <div class="col-md-6 col-sm-6">{{ item.name }}</div>
                </div>
              </li>
            </a>
          </ul>
    </div>
  `,
    data: function () {
    return {
      name_search: '',
      result_negotiations: [],
    }
  },
  computed: {
    ...Vuex.mapState(['negotiations', 'url']),
    ...Vuex.mapMutations(['getNegotiations']),
  },
  methods:{
    nameSearch(){
        if(this.name_search.length > 2){
          store.commit('getNegotiations', this.name_search)
        }
        else{
          alert('Debes colocar al menos 3 caracteres')
        }
    },
  },
  watch:{
  },
  mounted(){
    //store.commit('getNegotiations')
    //this.result_negotiations = store.state.negotiations
  }
})

const store = new Vuex.Store({
  state: {
    data_target: '.modalSearchNegotiations',
    loading: false,
    negotiations:[],
  },
  mutations:{
    getNegotiations:function(state, frament) {
      state.loading = true
      axios
        .get(this._vm.$api_url + 'negotiations/client/'+ frament)
        .then(response => {
          state.negotiations = response.data
          console.log(state.negotiations)
        })
        .catch(error => {
          if (error.response.status == 500) {
            store.commit('getNegotiations')
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
  }
})