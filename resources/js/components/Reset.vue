<template>
<div id="reset">
  <div class="container0">
    <form @submit.prevent="Reset">
     <div class="messageOrerror">
            <div v-if="message" class="alert alert-success" role="alert">
              {{message}}
            </div>
            <Error v-if="error" :error="error"></Error>
          </div>
        <h2><b>Reset:</b></h2>
        <hr>
        <div class="form-group">
            <BaseInput label="Password:" 
            type="password"
            v-model="$v.form.password.$model"
            :validator = "$v.form.password"
            ></BaseInput>
        </div>

        <div class="form-group">
            <BaseInput label="Confirm password:"
            type="password" 
            v-model="$v.form.rpassword.$model"
            :validator = "$v.form.rpassword"
            ></BaseInput>
        </div>
    
        <button type="submit" class="mybtn">Reset</button>

    </form>

  </div>   
</div>
</template>

<script>
import axios from 'axios';
import Error from './Error';
import { required, minLength, sameAs} from 'vuelidate/lib/validators';
import BaseInput from "./BaseInput.vue";

export default {
  name: 'Reset',
  components:{
    BaseInput, 
    Error
    
  },
  data(){
    return{
      form:{
      password: '',
      rpassword:'',
      },
      message: null,
      error: null,
    }
  },
  validations: {
        form: {
            password: {
                required,
                minLength: minLength(8)
            },
            rpassword: {
                required,
                sameAsPassword: sameAs('password')
            }
        }
    },
  methods: {
    async Reset(){
      const res = await axios.post('/api/reset/'+this.$route.params.token,{
            password: this.$v.form.$model.password,
            password_confirm: this.$v.form.$model.rpassword,
            token:this.$route.params.token,
            });

            console.log(res.data.message)
            if (res.data.message=="Success"){
                  console.log('Success')
                  this.message="The password has been reset!";
                  this.error='';
                  console.log(this.message)
            } else {
               this.message='';
               this.error='There was an error';
            }     
    },

  },
}

</script>

<style scoped lang="scss">
@import "../../../public/css/styles.css";

#reset{
  background-color: #f6f7c7;
  display: block;
  width: 100%;
  height: 90vh;
}

h2{
  margin-top:2vh;
}

.psw{
  padding: 12.5px;
  padding-bottom: 5px;
}

.container0{
  margin-top: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.container1{
  min-width: 280px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color:#f1f1f1;
  margin-top: 1vh;
}


/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  border-radius: 1vh;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
  opacity: 0.8;
}


.mybtn{
  margin-bottom: 0;
}


</style>
