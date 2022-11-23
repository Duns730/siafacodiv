Vue.component('image-galery', {
  template:`
    <div>
    	 {{ getUrlImage }}
    	
		    <div class="thumbnail" :style="style">
		      <div class="image view view-first">
		        <img style="width: 100%; display: block;height: 100%" :src="image.url" alt="image" />
		        <div class="mask">
		          <p>-</p>
		          <div class="tools tools-bottom">
		            <a href="#"><i class="fa fa-times" @click="destroyImage"></i></a>
		          </div>
		        </div>
		      </div>
		      <div class="caption"></div>
		    </div>
    </div>
  `,
  props:['image_props'],
    data: function () {
    return {
    	image: {
    		id: '',
    		url: '',
    	},
    	style:'display: block',
    }
  },
  computed: {
    getUrlImage(){
        this.image.url = this.image_props.url
        this.image.id = this.image_props.id
    }
  },
  methods:{
    destroyImage(){
    	axios.get(this.$api_url + 'image/destroy/' + this.image.id)
        .then(response => {
          data = response.data
          if (data.status == 201) {
          	this.style = 'display: none'
            new PNotify({
              title: 'Exito',
              text: 'La imagen ha sido Eliminada exitosamente' ,
              type: 'success',
              styling: 'bootstrap3'
            });

          }
          else{
            new PNotify({
              title: 'Error',
              text: 'La imagen no pudo ser eliminada',
              type: 'error',
              styling: 'bootstrap3'
            });
          }
        })
    }
  }
})

const store = new Vuex.Store({
  state: {
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
  data:{
    effective_percentage: 50,
    transfer_percentage: 50,
  },
  store,
  mounted(){  
  }
})