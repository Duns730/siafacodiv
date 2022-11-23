Vue.component('form-search', {
  template:`
    <div>
      <div class="title_right">
          <div class="col-md-5 col-sm-5 form-group pull-right top_search">
            <div class="input-group"  data-toggle="modal" :data-target="$store.state.data_target">
              <input type="text" class="form-control" placeholder="Buscar">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Ir!</button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  `,
  props:[],
    data: function () {
    return {
    }
  },
  computed: {
    ...Vuex.mapState(['data_target', 'loading']),
  },
  methods:{
  }
})