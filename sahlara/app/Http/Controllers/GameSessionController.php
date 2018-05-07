<?php

namespace App\Http\Controllers;

use App\Entities\GameSession;
use App\Entities\GameSubscription;
use App\Events\SubscribeEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameSessionController extends Controller
{
    /**
     * GameSessionController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sessions = GameSession::all();

        return view('sessions.index', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sessions.new');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $session = new GameSession();
        $session->name = $request->name;
        $session->user_id = Auth::id();
        $session->save();

        return redirect()->route('sessions');
    }

    /**
     * @param GameSession $session
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(GameSession $session)
    {
        return view('sessions.show', [
            'sessionUser' => $session->user,
            'currentUser' => Auth::user(),
            'session' => $session,
        ]);
    }

    /**
     * @param GameSession $session
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe(GameSession $session)
    {
        $this->authorize('subscribe', $session);

        $subscription = new GameSubscription();
        $subscription->user_id = Auth::id();
        $subscription->session_id = $session->id;
        $subscription->save();

        broadcast(new SubscribeEvent(Auth::user(), $session))->toOthers();

        return redirect()->route('session.show', [
            'session' => $session,
        ]);
    }

    /**
     * @param GameSession $session
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribers(GameSession $session)
    {
        return response()->json($session->subscribers);
    }
}
