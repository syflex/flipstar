<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserWallet;
use App\GameUsers;
use App\Game;
use App\User;
use Auth;

class FlipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        UserWallet::where('user_id', Auth::user()->id)->decrement('amount', $request->get('category'));

        $game = GameUsers::create([
            'user_id' => Auth::user()->id,
            'game_id' => $request->get('game_id'),
            'star' => $request->get('ratingModel'),
        ]);

        $users =  GameUsers::where('game_id',$request->get('game_id'))->get();
        $is_complet = false;

        $data = $game;

        if (count($users) >= 3) {
            Game::where('id', $request->get('game_id'))->update([
                'is_completed' => true
            ]);

            $winner_id =  GameUsers::where('game_id',$request->get('game_id'))->inRandomOrder()->limit(1)->first('user_id');
            $winner = User::where('id', $winner_id->user_id)->first();
            $is_complet = true;
            $data = $winner;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'success',
            'is_complet' => $is_complet,
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
