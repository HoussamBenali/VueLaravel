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
        <router-link to="/home" active-class="active" class="navindex">Home</router-link>
      </b-nav-item>
      
      <b-nav-item href="#" right>
        <router-link to="/adventure" active-class="active" class="navindex">Adventure</router-link>
      </b-nav-item>

      <b-nav-item href="#" right>
        <router-link to="/shop" active-class="active" class="navindex">Shop</router-link>
      </b-nav-item>

      <b-nav-item href="#" right>
        <router-link to="/profile" active-class="active" class="navindex">Profile</router-link>
      </b-nav-item>

      <b-nav-item href="#" right>
        <a @click="Logout"  active-class="active" class="navindex">Logout</a>
      </b-nav-item>
      
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

export default {
  name: 'navigator',
  methods:{
    async Logout(){
        await this.$store.dispatch("logout")
        return this.$router.push('login')
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