Vue.component('permission-item', {
  template:`
    <div>
      <input type="checkbox" class="flat" v-model="permission.check" @change="enableOrDisablePermission"> {{ permission.description }}
    </div>
  `,
  props:['permission', 'user_id'],
  computed: {
  }, 
  methods:{
    enableOrDisablePermission(){
      if (this.permission.check) {
        url = this.$api_url + 'permission/store'
        text = 'El permiso <b>"' + this.permission.description + '"</b> ha sido otorgado!'
      }
      else{
        url = this.$api_url + 'permission/destroy'
        text = 'El permiso <b>"' + this.permission.description + '"</b> ha sido revocado!' 
      }

     axios.post(url, {
          data: {
            name: this.permission.name,
            id: this.user_id,
          }
        })
        .then(response => {
          data = response.data
          if (data.status == 201) {
            new PNotify({
              title: data.messege,
              text: text ,
              type: 'success',
              styling: 'bootstrap3'
            });
          }
          else{
            new PNotify({
              title: 'Error al Otorgar Permiso ',
              text: 'Error con el permiso <b>"' + this.permission.description + '"</b>!',
              type: 'error',
              styling: 'bootstrap3'
            });
          }
        })
    }
  }
})