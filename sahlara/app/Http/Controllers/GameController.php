<?php

namespace App\Http\Controllers;

use App\Entities\GameSession;
use App\Events\GameEvent;
use App\Providers\GameProvider;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * @var GameProvider
     */
    protected $gameProvider;

    /**
     * GameController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->gameProvider = new GameProvider();
    }

    /**
     * @param Request $request
     * @param GameSession $session
     */
    public function handle(Request $request, GameSession $session)
    {
        $positionFrom = $request->position_from;
        $positionTo = $request->position_to;

        $this->gameProvider->performAction($session, $positionFrom, $positionTo);

        broadcast(new GameEvent($session));
    }
}
