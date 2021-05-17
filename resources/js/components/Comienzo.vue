<template>
<div id="Comenzando">
  <div class="main">
    <h1 class="welcome">
      <span class="centerWelcome">
      Welcome to the world of PokeCards!
      </span>
    </h1>
    <h2>Choose your starter:</h2>
  </div>
  <div>
</div>

<div class="chooseOne">
  <div class="center">

    <router-link class="router" to="/tutorial/Bulbasaur">
    <div @click="Bulbasaur" class="card starting carta">
      <img class="card-img-top" :src="Bulbasaur.image_path" alt="bulbasaur">
      <span class="card-name">{{Bulbasaur.name}}</span>
      <span class="card-text">HP: {{Bulbasaur.hp}}</span>
      <span class="card-text">ATK: {{Bulbasaur.atk}}</span>
      <span class="card-text">DEF: {{Bulbasaur.def}}</span>
      <span class="card-attack">SPD: {{Bulbasaur.spd}}</span>
    </div>
    </router-link>

    <router-link class="router" to="/tutorial/Charmander">
    <div @click="Charmander" class="card starting carta">
      <img class="card-img-top" :src="CardsPath +'Charmander.png'" alt="charmander">
      <span class="card-name"><img class="types-icon" :src="IconsPath+'Fire.png'" /> 
       Charmander 
      <img class="types-icon" :src="IconsPath+'Fire.png'" /></span>
      <span class="card-text">ATK: 45</span>
      <span class="card-text">DEF: 25</span>
      <span class="card-attack">SPD: 10</span>
    </div>
    </router-link>
    
    <router-link class="router" to="/tutorial/Squirtle">
    <div @click="Squirtle" class="card starting carta">
      <img class="card-img-top" :src="CardsPath +'Squirtle.png'" alt="squirtle">
      <span class="card-name">Squirtle</span>
      <span class="card-text">ATK: 35</span>
      <span class="card-text">DEF:40</span>
      <span class="card-attack">SPD: 5</span>
    </div>
    </router-link>
  </div>
</div>
</div>
</template>

<script>
//import axios from 'axios';
import $ from 'jquery';

$(document).ready(function () {
  //Desactiva cortar, copiar y pegar
  $(document).bind('cut copy paste', function (e) {
      e.preventDefault();        
  });

  //Desactiva click dret
  $(document).on("contextmenu",function(e){
      console.log(e)
      return false;
      });
});

export default {
  name: 'Comenzando',
  components:{
  },
  data(){
    return{
      pokemon:'',
      CardsPath: " https://raw.githubusercontent.com/HoussamBenali/Assets/b09577915f44df2007555b8f23d58850cf26b696/images/Cartas/",
      IconsPath: "https://raw.githubusercontent.com/HoussamBenali/Assets/b09577915f44df2007555b8f23d58850cf26b696/images/Types/",
    }
  },
  methods:{
    async getPokeData(){
                const resB = await axios.get('/api/pokemon/1')
                let Bulbasaur = resB.data.data
                console.log("Print bulbasur -------------")
                console.log(Bulbasaur)

                const resC= await axios.get('/api/pokemon/4')
                let Charmander = resC.data.data
              
                const resS = await axios.get('/api/pokemon/'+7)
                let Squirtle = resS.data.data
                console.log(Squirtle)
    },

    Charmander(){
      return this.pokemon = 'Charmander'
    },
    Bulbasaur(){
      return this.pokemon = 'Bulbasaur'
    },
    Squirtle(){
      return this.pokemon = 'Squirtle'
    }
  },
  beforeRouteLeave (to, from, next) {
			this.$dialog.confirm('Are you sure you want to pick '+this.pokemon+'?')
			.then(function () {
				next();
			})
			.catch(function () {
				next(false);
			});
		},

    
    
}


</script>

<style lang="scss">
@import "../../css/cards.css";
@import "../../css/cardsMobile.css";

//background: linear-gradient(45deg, #17ead9, #6078ea);

.chooseOne{
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
}
.router{
    text-decoration: none !important;
    color: black !important;
    margin-right: 1.5vw !important;
}


.router:hover{

  text-decoration: none;
}


</style>
