Vue.component('loading-img', {
  template:`
    <div>
      <div v-if="$store.state.loading"
        class=""
        style="position:fixed;
              top:0px;
              left:0px;
              z-index:500;
              filter:alpha(opacity=65);
             -moz-opacity:65;
              opacity:0.65;
              width: 100%;
              height: 100%;
              background:#000;"
      >
          <img class="card-img-top align-self-center" 
            :src="$base_url+'images/loading.gif'" 
            style="opacity:none;
                  position:fixed;
                  width: 100%;
                  height: 100%;"
          />
      </div>

    </div>
  `,
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['loading']),
  },
  methods:{
  }
})