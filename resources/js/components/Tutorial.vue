<template>
 <div class="wrap">
<div id="battle" >  
  
  <div class="battle-arena" :style=" {'background-image': 'url('+mapa+')','background-size': '100% 100%'} ">
    <div class="tutorial-card-opponent">
    <Card  :HP="opponent.HP" :maxHP="opponent.maxHP" :Name="opponent.name" :ATK="opponent.ATK" :DEF="opponent.DEF" :SPD="opponent.SPD"
     :Img="opponent.image_path" :Type="opponent.type" :Level="opponent.level" :HPBar="opponent.HPBar" ></Card>
    </div>
    <div class="tutorial-card-player">
    <Card :HP="player.HP" :maxHP="player.maxHP" :Name="player.name" :ATK="player.ATK" :DEF="player.DEF" :SPD="player.SPD" :Img="player.image_path" 
          :Type="player.type" :Level="player.level" :HPBar="player.HPBar" :Player="player" :IconsPath="IconsPath"></Card>
    </div>
    
    <div class="bottom-menu">
        <div class="battle-text text-box-left">
            {{battleText}}
      </div>
          <div class="text-box-right">
            <div v-if="options" id="battleOptions">
                <div @click="selectOption(1)" class="option-1">{{battleOptions[0]}}</div>
                <div @click="selectOption(2)" class="option-2">{{battleOptions[1]}}</div>
                <div @click="selectOption(3)" class="option-3">{{battleOptions[2]}}</div>
                <div @click="selectOption(4)" class="option-4">{{battleOptions[3]}}</div>
            </div>
            <div v-if="attacks" id="attackOptions">
                <div @click="selectAttack(1)" class="option-1">{{player.moves[0].name}}</div>
                <div @click="selectAttack(2)" class="option-2">{{player.moves[1].name}}</div>
                <div @click="selectAttack(3)" class="option-3">{{player.moves[2].name}}</div>
                <div @click="selectAttack(4)" class="option-4"> {{player.moves[3].name}}</div>
                
            </div>
            <div v-if="disabledOptions" id="battleOptions">
            </div>
            
        </div>
    </div>
  </div>

</div> 
 </div>
</template>

<script>
import axios from 'axios';
import Card from './Card';
import store from '../store/store'
import Vue from 'vue';

export default {
  name: 'Tutorial',
  components:{
    Card,

  },
  
  data(){
    return{
        opponent:{},
        player:{
            name: this.$route.params.pokemon,
        },

        IconsPath: '',
        battleText: "What will "+ this.$route.params.pokemon+ " do?",
        battleOptions: ["Fight", "Cards", "Item", "Run"],
        menu: 'options',
        attacks: false,
        options: true,
        disabledOptions: false,
        matchEndOptions:["Yes", "No"],
        turn: true,
        matchEnded: false,
        timeOut:'',
        mapa: 'https://raw.githubusercontent.com/HoussamBenali/Assets/main/images/Fondos/Grassland.jpg',

    }
  },
  mounted() {  
      
      this.getPokeData()
      
    },
methods: {

        async getPokeData(){
          
                const resB = await axios.get('/api/pokemon/'+1)
                let Bulbasaur = resB.data.data
                const resC= await axios.get('/api/pokemon/'+4)
                let Charmander = resC.data.data
                const resS = await axios.get('/api/pokemon/'+7)
                let Squirtle = resS.data.data
                //console.log(Charmander


          if (this.player.name == "Bulbasaur"){

                this.player=Bulbasaur
                Vue.set(this.player, "HPBar",  {width: '100%'})
                Vue.set(this.player, "maxHP",  Bulbasaur.HP)

                this.opponent = Charmander
                Vue.set(this.opponent, "HPBar",  {width: '100%'})
                Vue.set(this.opponent, "maxHP",  Charmander.HP)

          } else if (this.player.name == 'Charmander'){
                this.player = Charmander
                Vue.set(this.player, "HPBar",  {width: '100%'})
                Vue.set(this.player, "maxHP",  Charmander.HP)

                this.opponent = Squirtle
                Vue.set(this.opponent, "HPBar",  {width: '100%'})
                Vue.set(this.opponent, "maxHP", Squirtle.HP)

            } else{
                this.player = Squirtle
                Vue.set(this.player, "HPBar",  {width: '100%'})
                Vue.set(this.player, "maxHP", Squirtle.HP)

                this.opponent = Bulbasaur
                Vue.set(this.opponent, "HPBar",  {width: '100%'})
                Vue.set(this.opponent, "maxHP", Bulbasaur.HP)
            }
      
        },

        faintAnimation(){
          this.attacks = false
          this.options = false
          this.matchEnded = true;
          this.SetFirstPokemon(this.player.id);
          //console.log(store.getters.user)
          setTimeout(() => { this.$router.push('../home')},8000)
      },

      async SetFirstPokemon(id){
        await axios.post('/api/setPokemon/'+id)      
      },
      
      Fainted(poke){
        if(poke.HP <= 0){
            return true
        } else{
            return false
          }
      },


      selectOption(option) {
        if (option == 1){
            this.attacks= true;
            this.options= false;
            this.battleText='Choose your attack.';
            
        } else if (option ==2){
            this.battleText = "You're our only hope " + this.player.name + "!";
            this.timeOut=setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"}, 2000);

        }else if (option==3){
            this.battleText = "No items in bag.";
            this.timeOut=setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"}, 2000);
          
        }else if (option==4){
            this.battleText = "Can't escape.";
            this.timeOut=setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"}, 2000);
       
        }
      },

selectAttack(attack) {
        this.attacks = false
        this.options = false
        this.disabledOptions = true
        let realDamage=Math.round(((this.player.moves[attack-1].power + this.player.ATK)/2) - this.opponent.DEF)
        if (realDamage<=0){
            realDamage=1
        }
        this.opponent.HP -= realDamage
        var percent=this.opponent.HP/this.opponent.maxHP*100
        if(this.Fainted(this.opponent)){
              this.opponent.HP=0
              this.opponent.HPBar = {width: '0%'}
              this.battleText = this.player.name + " used " + this.player.moves[attack-1].name + "!"
              setTimeout(() => {this.battleText = this.opponent.name + " has fainted! "},2001)
              setTimeout(() => {this.battleText = "You have won 100 PokeCoins"},4000)
              this.faintAnimation()

        } else{
              this.opponent.HPBar.width =percent + "%"
              setTimeout(() => { 
                if (this.Fainted(this.player)==false){
                    this.timeOut=setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"}, 2000);     
                }  
              }, 2000);

                this.battleText = this.player.name + " used " + this.player.moves[attack-1].name + "!"
                setTimeout(() => {this.opponentAttack()},2000)
          }   
                
  },

      opponentAttack(){
        
          var random = Math.floor((Math.random() * 4) + 1)
          let realDamage=Math.round(((this.opponent.moves[random-1].power + this.opponent.ATK)/2) - this.player.DEF)
          if (realDamage<=0){
            realDamage=1
          }
          this.player.HP -=  realDamage
          var percent=Math.round(this.player.HP/this.player.maxHP*100)
          if(this.Fainted(this.player)){
              this.player.HP=0
              this.player.HPBar = {width: '0%'}
              this.battleText = this.opponent.name + " used " + this.opponent.moves[random-1].name + "!" 
              this.faintAnimation()
              setTimeout(() => {this.battleText = this.player.name + " has fainted!"},2001)
              setTimeout(() => {this.battleText = "Better luck next time!"},4000)
              setTimeout(() => {this.battleText = "You took your pokecard and ran away!"},6000)
          } else{
              this.player.HPBar.width = percent + "%"
              this.battleText = this.opponent.name + " used " + this.opponent.moves[random-1].name + "!"
              setTimeout(() => { this.attacks = false, this.options = true, this.disabledOptions = false},2000)
          }   
        
        },
    }
}


</script>

<style scoped lang="css">
@import "../../css/tutorial.css";
@import "../../css/tutorialMobile.css";


</style>
