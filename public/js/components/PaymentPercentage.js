
Vue.component('payment-percentage', {
  template:`
  <div>
  {{ getPercentage }}
	<div class="col-md-4 col-sm-4 ">
   		<input placeholder="% Efectivo" name="effective_percentage" v-model="effective_percentage" v-on:blur="transfer_percentage = 100 - effective_percentage" type="number" class="form-control">
   	</div>
   	<div class="col-md-4 col-sm-4 ">
   		<input placeholder="% ZELLE" name="transfer_percentage" v-model="transfer_percentage" v-on:blur="effective_percentage = 100 - transfer_percentage" type="number" class="form-control">
   	</div> 
  </div>
  `,
  props:['percentage'],
  data(){
    return{
     	effective_percentage: '',
		  transfer_percentage: '',
    }
  },
  computed: {
    getPercentage(){
      this.effective_percentage = this.percentage.effective
      this.transfer_percentage = this.percentage.transfer
    }
  },
  methods:{
  	calculate(){
  		this.transfer_percentage = 100 - this.effective_percentage
  	}
  }
})