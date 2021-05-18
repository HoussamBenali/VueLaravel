<template>
<div class="header">

  <b-navbar class="navBar" toggleable="lg" type="light" variant="info">

  <img class="hi" alt="Pokelogo" src="/images/pokelogo.png" width="60" height="60">
  
  <router-link to="" class="link">
    <h5 class="title"><b>PokeCards</b></h5>
  </router-link>

    <b-navbar-toggle class="color" target="nav-collapse"/>
    
    <b-collapse id="nav-collapse" is-nav>

    <b-navbar-nav class="ml-auto" v-if="$store.state.auth">
      <b-nav-item href="#" right>
        <router-link to="/home" active-class="active" class="bigger navindex">Home</router-link>
      </b-nav-item>
      
      <b-nav-item href="#" right>
        <router-link to="/adventure" active-class="active" class="bigger navindex">Adventure</router-link>
      </b-nav-item>

      <b-nav-item href="#" right>
        <router-link to="/shop" active-class="active" class="bigger navindex">Shop</router-link>
      </b-nav-item>

      <b-nav-item href="#"  style="margin-right: 5px;" right >
        <router-link to="/mazos" active-class="active" class="bigger navindex">Mazos</router-link>
      </b-nav-item>


        <div class="dropdown" >
          <button class="btn dropdown-toggle navindex lower" type="button" active-class="active" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img :src="'/api/getAvatar'" style="max-width: 30px; max-height: 30px; min-width: 30px; min-height: 30px; border-radius: 50%; margin-right: 5px;">{{$store.state.user.nick}}
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item navindex" href="/changeAvatar">Change Avatar</a>
            <a class="dropdown-item navindex" href="/changeProfile" >Change Profile</a>
            <a class="dropdown-item navindex" href="/changePass" >Change Password</a>
            <a class="dropdown-item navindex" href=""><a @click="Logout()" active-class="active" style="display: block;">Logout</a></a>
          </div>
        </div>

     
    
    </b-navbar-nav>

      <b-navbar-nav class="ml-auto" v-else>
 
        <b-nav-item href="#" right>
          <router-link to="/login" active-class="active" class="navindex ">Login</router-link>
        </b-nav-item>
        <b-nav-item href="#" right >
          <router-link to="/register" active-class="active" class="navindex">Register</router-link>
        </b-nav-item>
       </b-navbar-nav>   
    </b-collapse>
  </b-navbar>
</div>
</template>

<script>

import store from "../store/store"
export default {
  data() {
    return {
    }
  },
  name: 'navigator',
  methods:{
   async Logout(){
        localStorage.removeItem("who")  
        await store.dispatch('logout')
        this.$router.push('login')  
    },
    changeRoute(event){
    	const path = event.target.value;
      this.$router.push({ path: `/${path}` });
    }
    
  },
  
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">

hr{
    border-top: 1px solid black;
 }

.color{
  background: white !important;
}

.navindex{
    position: relative !important;;
    color: #000;
    padding-top: 1vh;
    padding-bottom: 1vh;
    border-radius: 1vh;
    background: white;
    text-decoration: none;
    display: block;
    margin-left: auto;
    margin-right: auto;
    min-width: 80px;
    max-width: 300px;
    text-align: center;
 }

 .lower{
   margin-top: 1vh;
   margin-left: auto;
   margin-right: auto;
   min-width: 80px;
   max-width: 300px;
   width: 100%;
 }

 .bigger{
  padding: 1.5vh;
 }

 .navindex:hover{
    background: black;
    color: white;
    text-decoration: none;
 }

.title{
  border-radius: 1vh;
  background: white;
  font-size: 35px;
  padding-right: 2vh;
  padding-left: 2vh;
  padding-top: 0.4vh;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
  color: yellow;
  text-decoration: none;
  margin-top:1vh;
}

.link:hover{
  text-decoration: none;
}

.hi{
  margin-right: 0.5vw;
}

</style>

