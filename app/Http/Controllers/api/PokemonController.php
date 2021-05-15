<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\Pokemon;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Api\ApiResponseController;

class PokemonController extends ApiResponseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pokemons = Pokemon::paginate(10);
        for ($x = 0; $x < count($pokemons); $x++){
            $array_moves=  unserialize($pokemons[$x]->moves);
            for ($i = 0; $i < count($array_moves); $i++){
                $array_moves[$i] = json_decode($array_moves[$i]);
            }
            $pokemons[$x]->moves=$array_moves;
        }
        return $this->successResponse($pokemons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $random_moves = ['HP','DEF','ATK'];
        $moves_p = $request->all()['moves'];
        $array = [];
        for ($x = 0; $x < count($moves_p); $x++){
            array_push($array, json_decode($moves_p[$x]));
            if ($array[$x]->power == null){
                $array[$x]->power = $random_moves[array_rand($random_moves)];
            }
            $array[$x]=json_encode($array[$x]);
        }

        $name = $request->all()['name'];
        $HP = $request->all()['HP'];
        $ATK = $request->all()['ATK'];
        $DEF = $request->all()['DEF'];
        $SPD = $request->all()['SPD'];
        $type = $request->all()['type'];
        $moves = serialize($array);
        $image_path = $request->all()['image_path'];
        $pokemon = new Pokemon();
        $pokemon->name = $name;
        $pokemon->hp = $HP;
        $pokemon->atk = $ATK;
        $pokemon->def = $DEF;
        $pokemon->spd = $SPD;
        $pokemon->type = $type;
        $pokemon->moves = $moves;
        $pokemon->image_path= $image_path;
        $pokemon->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
        // return "hola";
        $pokemon = Pokemon::where('id',$id)->first();
        $pokemon->moves= unserialize($pokemon->moves);
    
        $moves=$pokemon->moves;

        $strjson = '[';
        for ($i=0; $i < count($moves); $i++) { 
            $strjson .= $moves[$i];
            if($i < count($moves)-1) $strjson .= ', ';
        }
        $strjson .= ']';
        //dd($strjson);
        $pokemon->moves=json_decode($strjson);
        
        return $this->successResponse($pokemon);
    }

    public function getPokemon($id){
        $pokemon=Pokemon::where('id',$id)->first();
        return $pokemon;
    }


}
