<template>
<body>
<div id="LoginForm">
	<div class="container0">
  	<form @submit.prevent="login">
       	<div v-if="credentials.length > 0" class="alert alert-warning" role="alert">
          	{{credentials}}
      	</div>
   
      	<h2><b>Login</b></h2>
      	<hr>

      	<div class="form-group">
          	<label for="email"><b>Email:</b></label>
          	<input type="text" class="form-control" v-model="form.email" placeholder="Enter Email" name="email" id="email" required>
      	</div>

      	<div class="form-group">
          	<label for="password"><b>Password:</b></label>
          	<input type="password" class="form-control" v-model="form.password" placeholder="Enter Password" name="password" id="password" required>
      	</div>

      	<button class="mybtn" type="submit">Login</button>
 	 
      	<div class="container">
          	<label class="psw">
              	<span> Forgot your pasword?<router-link to="forgot"> Click here</router-link></span>
          	</label>
      	</div>
  	</form>
	</div>
 	<div class="newUser">
      	<p>New here? Register for free now!</p>
      	<router-link to="register" class="goRegister">Create an account</router-link>
    	</div>
</div>

</body>
</template>

<script>
import axios from 'axios'
axios.defaults.withCredentials = true
export default {

	data: () => ({
    	form: {
        	email:"",
        	password:"",
    	},
    	credentials: ""
	}),
	methods: {
    async login () {
        	try{
          	await this.$store.dispatch('login',this.form)
			const res =await axios.get('/api/pokesUser')
          	this.$awn.success("Bienvenido")
			console.log(res.data)
			var pokes = res.data
          	if (pokes.length<1){
            	return this.$router.push('starting');
          	} else{
            	return this.$router.push('home');
          	}
			
        	}catch{
            	this.$awn.warning("Credenciales invalidas")
            	this.credentials="Credenciales invalidas"
        	}
    	}
	},
}
</script>
<style lang="scss">
	@import '~vue-awesome-notifications/dist/styles/style.scss';
	@import "../../../public/css/styles.css";

</style>

<style scoped>
	#LoginForm{
	background-color: #f6f7c7;
	display: block;
	width: 100%;
	overflow: auto;
	height:fit-content;
	text-align: center;
    
  }

  .alert{
	margin-top:2vh;
  }
 
  .newUser{
	border:solid 3px black;
	border-radius: 1vh;
	min-width: 300px;
	padding: 2vh;
	margin-top: 1vh;
	width: 37%;
	background-color: white;
	margin-left: auto;
	margin-right: auto;
  }
 
  .goRegister{
	border-radius: 1vh;
	background-color: #4CAF50;
	padding: 1.5vh;
	color: white;
	display: block;
	margin-top: 2vh;
	margin-left: auto;
	margin-right: auto;
  }
 
  .goRegister:hover{
	text-decoration: none;
	opacity: 0.8;
	color: white;
  }
 
  .check{
	display: block;
	margin-top: 2vh;
	margin-bottom: 2vh;
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
	width: 100%;
  }
 
  .container{
	min-width: 250px;
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	background-color:#f1f1f1;
	margin-top: 2vh;
  }
 
  button {
	background-color: #4CAF50;
	border-radius: 1vh;
	color: white;
	padding: 1.5vh;
	margin: 8px 0;
	border: none;
	cursor: pointer;
	width: 100%;
  }
 
  button:hover {
	opacity: 0.8;
  }
 
  .mybtn{
	margin-bottom: 0;
  }
 
</style>
