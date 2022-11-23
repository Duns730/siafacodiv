Vue.component('permission-item-list', {
  template:`
    <div>
      <div class="col-md-12 col-sm-12">
        <h2>Modulo: {{ title }}</h2>
        
        <ul class="to_do" v-for="permission of permissions_user">
          <li v-if="permission.name.includes(objet)">
            <p>
              <permission-item
                :permission="permission"
                :user_id="user_id"
              ></permission-item>
            </p>
          </li>
        </ul>
      </div>
    </div>
  `,
  props:['permissions_user', 'objet', 'title', 'user_id'],
  computed: {
  }, 
  methods:{
    
  }
})