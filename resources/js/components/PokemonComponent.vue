
<template>
    <div>
        <h1>Pokemons</h1> 
        Pokemons; {{user_cards}}
        PokeCoins: {{coins_total}}
        <!-- {{coins}} -->
        <div  class="row">
            <span v-for="pokemon in pokemons" :key="pokemon.id">
                <span v-if="exist_pokeCart(pokemon)">
                    <div class="col-md-5 s_sec ">
                        <div class="card carta" >
                                <img class="card-img-top" :src=pokemon.image_path style=" filter: grayscale(100%);">
                                <span class="card-name">{{ pokemon.name }}</span>
                                <span class="card-name">Price: {{ pokemon.price }}</span>
                                <div>
                                    <span class="btn btn-primary posbtn" data-toggle="modal" data-target="#centralModalInfo" @click="getPokemon(pokemon)"  >
                                        Ver
                                    </span>
                                </div>
                        </div>
                    </div>
                </span>
                <span v-else-if="exist_userCards(pokemon.id)">
                    <div class="col-md-5 s_sec ">
                        <div class="card carta">
                                <img class="card-img-top" :src=pokemon.image_path  alt="bulbasaur" style=" filter: grayscale(100%);">
                                <span class="card-name">{{ pokemon.name }}</span>
                                <span class="card-name">Price: {{ pokemon.price }}</span>
                                <div>
                                    <span class="btn btn-primary posbtn" data-toggle="modal" data-target="#centralModalInfo" @click="getPokemon(pokemon)"  >
                                        Ver
                                    </span>
                                </div>
                        </div>
                    </div>
                </span>
                <span v-else>
                <!-- Si el preu es superior al presupost -->
                    <div class="col-md-5 s_sec ">
                        <div class="card carta" v-if="coins_total >= pokemon.price" :style="cardColor(pokemon.rarity)">
                            <img class="card-img-top" :src=pokemon.image_path >
                            <span class="card-name">{{ pokemon.name }}</span>
                            <span class="card-name">Price: {{ pokemon.price }}</span>
                                <div>
                                    <span class="btn btn-primary posbtn" data-toggle="modal" data-target="#centralModalInfo" @click="getPokemon(pokemon)"  >
                                        Ver
                                    </span>
                                    <button class="btn btn-primary posbtn" @click="addPokemon(pokemon)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div> 
                        </div>
                <!-- Si te els diners per comprarlo -->
                        <div class="card carta" v-else :style="cardColor(pokemon.rarity)">
                            <!-- <span> -->
                            <img class="card-img-top" :src=pokemon.image_path > 
                            <span class="card-name">{{ pokemon.name }}</span>
                            <span class="card-name" style="color: red">Price: {{ pokemon.price }}</span>
                                <div>
                                    <span class="btn btn-primary posbtn" data-toggle="modal" data-target="#centralModalInfo" @click="getPokemon(pokemon)"  >
                                        Ver
                                    </span>
                                    <button class="btn btn-primary posbtn" @click="addPokemon(pokemon)" disabled>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div> 
                          
                        </div>
                    </div>
                </span>
            </span>
            <!-- Informacio extra -->
            <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-notify modal-info" role="document">
                    <div class="card cartaInfo" :style="cardColor(pokeInfo.rarity)">
                        <img class="card-img-top-info" :src=pokeInfo.image_path  alt="bulbasaur">
                            <span class="card-name-info">{{ pokeInfo.name }}</span>
                            <span class="card-text-info">ATK: {{ pokeInfo.atk }}</span>
                            <span class="card-text-info">DEF: {{ pokeInfo.def }}</span>
                            <span class="card-text-info">SPD: {{ pokeInfo.spd}}</span>
                    </div>
                </div>
            </div>
            </div>
        <div class="row">
            <div class="col-md-3 s_sec">
            <hr>
            <v-pagination 
                class="mt-3"
                v-model="currentPage" 
                :page-count="total"
                :classes="bootstrapPaginationClasses"
                :labels="paginationAnchorTexts">
            </v-pagination>  
            </div>
        </div>
    
</div>

</template>

<script>
import vPagination from 'vue-plain-pagination'
import BaulComponent from './BaulComponent'
import cart from '../store/index'
import user from '../store/store'
    export default {
        components: { vPagination, BaulComponent },
        name: 'PokemonComponent',
        props: ['pokemons','total'],
        mounted () {
            
        },
        
        data: function () {
            return {
                // pokemon_local=this.pokemons,
                user:user.state.user,
                // coins:user.state.monedas,
                cards:null,
                pokeInfo:"",
                // coins_minim:null,
                currentPage: 1,
                bootstrapPaginationClasses: {
                    ul: 'pagination',
                    li: 'page-item',
                    liActive: 'active',
                    liDisable: 'disabled',
                    button: 'page-link'  
                },
                paginationAnchorTexts: {
                    first: '',
                    prev: '&lsaquo;',
                    next: '&rsaquo;',
                    last: ''
                },
                objec:{
                    ob1:{
                        name:"1"
                    },
                    ob2:{
                        name:"2"
                    }
                }
            }
        },
        methods: {
            getPokemon (pokemon) {
                this.pokeInfo = pokemon
                console.log(this.pokeInfo)
            },
            async addPokemon (pokemon) { // todo lo que usemos en la vista hay que retornarlo
                await axios.post('/api/cart/addpoke',{
                    id_poke:pokemon.id
                })
                await axios.post('/api/user/restarPrice',{
                    price:pokemon.price
                })
                // .then((res) => {
                //     // console.log(res)
                //     this.coins = res.data
                // })
                // .then(() => {
                //     // this.pokemons_cart=cart.state.pokemons_cart
                // })
                user.dispatch('add_poke',pokemon.price)
                cart.dispatch('addPoke',pokemon)
                // console.log(cart.state.pokemons_cart[7])
                return pokemon
            },
            exist_pokeCart(poke){
                for (let x = 0; x < this.pokemons_cart.length; x++) {
                    var boolea = null
                    // console.log(this.pokemons_cart[x].id, poke.id)
                    if (this.pokemons_cart[x].id == poke.id){
                        // console.log("existe",poke.name)
                        // console.log(this.pokemons_cart[x].id == poke.id)
                        // console.log(this.pokemons_cart[x].id, poke.id)
                        boolea = true
                        break
                    }else{
                        // console.log("no existe",poke.name)
                        boolea = false
                        // break
                    }
                }
                return boolea
            },
            exist_userCards(poke_id){
                console.log(this.user_cards)
                // console.log(this.pokemons_cart)
                var pokeList=this.user_cards.split(',')
                for (let x = 0; x < pokeList.length; x++) {
                    // console.log(this.user_cards[x] == poke_id,"User Cards")
                    // console.log(this.user_cards[x], poke_id,"User Cards")
                    var boolea = null
                    if (pokeList[x] == poke_id){
                        boolea = true
                        break
                    }else{
                        boolea = false
                    }
                }
                return boolea
            },
            cardColor(rarity){
                 console.log(rarity)
                if (rarity=="common"){
                    return  {"background-image": "linear-gradient( to top left, white, yellow, white)"}
                }
                  else if (rarity=="rare"){
                    return  {"background-image": "linear-gradient(to top left, white, #009933 , white )"}
                }
                else if (rarity=="superrare"){
                    return  {"background-image": "linear-gradient(to top left, white, blue , white )"}
                }
                else if (rarity=="unique"){
                     return  {"background-image": "linear-gradient(to top left, white, #cc00cc, white )"}
                }
                else if (rarity=="legend"){
                     return  {"background-image": "linear-gradient(to top left, white, orange , white )"}
                }

            }
        },

        computed:{
            pokemons_cart: function () {
                //console.log(cart.state.pokemons_cart,"computed_Pokemon")
                return cart.state.pokemons_cart
                },
            
            coins_total: function () {
                //console.log("coin total")
                return user.state.monedas
            },
            user_cards: function () {
                return user.state.cards
            },

    
        },
        watch:{
            currentPage (newVal, oldVal){
                //console.log(newVal)
                this.$emit('getCurrentPage',newVal)
            },
        },
        mounted (){
            //console.log(cart.state.pokemons_cart,"estat cart")
            
            this.cards=user.state.cards.split(',')
        }
        
    }
</script>
<style scoped>
/* @import "../../css/cards.css"; */
/* .text{
    text-align: center;
} */
img{
    width:130px;
    height:130px;
}

/* @import "../../css/cards.css"; */
/* @import "../../css/cardsMobile.css"; */



@media (min-width: 630px) {

.cartaInfo{
    min-width: 120px;
    /* max-width: 150px; */
    width: 15vw;
    height: 455px;
    font-size: 40px;
    background: linear-gradient( to top left, rgb(77, 76, 76), white, rgb(90, 90, 90));
    background-size:300% 300%;
    margin: 0vw;
    margin-bottom: 20px;
    border-radius: 5px;
    border: solid black 2px !important;
    animation: reflect 3s infinite linear;
    /*animation-direction: alternate;*/
}

.carta{
    min-width: 120px;
    /* max-width: 150px; */
    width: 10vw;
    height: 235px;
    font-size: 40px;
    background: linear-gradient( to top left, rgb(77, 76, 76), white, rgb(90, 90, 90));
    background-size:300% 300%;
    margin: 0vw;
    margin-bottom: 20px;
    border-radius: 5px;
    border: solid black 2px !important;
    animation: reflect 3s infinite linear;
    /*animation-direction: alternate;*/
}

@keyframes reflect {
    0% {
        background-position: 0% 50%;
    }
    100% {
        background-position: 100% 50% ;
    }
}
.card-img-top{
    border: black 0px solid;
    margin-left: auto;
    margin-right: auto;
    margin-top: 5px;
    margin-bottom: 5px;
    /* min-width: 100px; */
    /* max-width:125px; */
    width: 9vw; 
    height: 130px;
    /* background-color: white; */
}
.card-img-top-info{
    border: black 0px solid;
    margin-left: auto;
    margin-right: auto;
    margin-top: 5px;
    margin-bottom: 5px;
    /* min-width: 100px; */
    /* max-width:125px; */
    width: 12vw; 
    height: 160px;
    /* background-color: white; */
}

.behind{
    min-width: 120px;
    max-width: 150px;
    width: 10vw;
    max-height: 205px;
    height: 205px;
}

.behind-card-name{
    padding-top: 0.5vh;
    padding-bottom: 0.5vh;
    margin: 0px;
    background-color: black;
    color: white;
    font-size: 30%;
}


.card:focus{
    border: solid 4px blue !important;
}


.card-name{
    margin: 0px;
    background-color: black;
    color: white;
    font-size: 30%;
}
.card-name-info{
    margin: 0px;
    background-color: black;
    color: white;
    font-size: 60%;
}


.card-text{
    border-bottom: solid 2px black;
    font-size: 30%;
    text-decoration: none;
}

.card-text-info{
    border-bottom: solid 2px black;
    font-size: 60%;
    text-decoration: none;
}

.card-attack{
    font-size: 30%;
}

.router{
    text-decoration: none !important;
    color: black !important;
    margin-top: 2vh;
}

.router:hover{
    text-decoration: none;
    padding: 0;
    background-color: blue;
}

.center{
    display: flex;
    align-items: center;
    justify-content: center;
}

.types-icon{
    max-width: 18px;
    margin-bottom: 0.1vh;
}


.welcome{
    font-family: "PokemonSolid";
    color: yellow;
    background-color: black;
    width: 100%;
    font-size: 30px;
    height: 65px;
    padding-top: 10px;
}

.centerWelcome{
    padding: 5vh;
}


.hp-bar-fill-opponent{
    position: absolute;
    height: 100%;
    border-radius: 20px;
}

.hp-bar-fill-player{
    position: absolute;
    height: 100%;
    border-radius: 20px;
}

.hp-bar{
    position: relative;
    height: 15px;
    width: 85%;
    border-radius: 20px;
    background: grey;
    opacity: 0.5;
    margin: 0;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.level{
    position: relative;
    opacity: 0.7;
    font-size: 16px;
    font-family: "Roboto Condensed";
    padding: 0;
    margin: 0;
}

.player-level{

    position: relative;
    display: block;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    opacity: 0.7;
    font-size: 16px;
    font-family: "Roboto Condensed";
}

.posbtn{
    margin-bottom: 2vh;
}
}

</style>


