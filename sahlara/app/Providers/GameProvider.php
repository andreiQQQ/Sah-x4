<?php

namespace App\Providers;


use App\Entities\GameSession;
use App\Models\Piece;
use App\Providers\Helper\PieceValidator;
use App\User;

class GameProvider
{
    /**
     * @var PieceValidator
     */
    protected $pieceValidator;

    /**
     * GameProvider constructor.
     */
    public function __construct()
    {
        $this->pieceValidator = new PieceValidator();
    }

    /**
     * @param GameSession $session
     * @return array|mixed
     * @throws \Exception
     */
    public function initGameTable(GameSession $session)
    {
        $subscriptions = $session->subscriptions;
        if ($subscriptions->count() < 4) {
            throw new \Exception('Must be subscribed to session all 4 players');
        }

        $gameTable = [];
        foreach ($subscriptions as $subscription) {
            switch ($subscription->side) {
                case 1:
                    $gameTable = array_merge($gameTable, [
                        new Piece($subscription, Piece::ROOK, [0, 2]),
                        new Piece($subscription, Piece::KNIGHT, [0, 3]),
                        new Piece($subscription, Piece::BISHOP, [0, 4]),
                        new Piece($subscription, Piece::QUEEN, [0, 5]),
                        new Piece($subscription, Piece::KING, [0, 6]),
                        new Piece($subscription, Piece::BISHOP, [0, 7]),
                        new Piece($subscription, Piece::KNIGHT, [0, 8]),
                        new Piece($subscription, Piece::ROOK, [0, 9]),

                        new Piece($subscription, Piece::PAWN, [1, 2]),
                        new Piece($subscription, Piece::PAWN, [1, 3]),
                        new Piece($subscription, Piece::PAWN, [1, 4]),
                        new Piece($subscription, Piece::PAWN, [1, 5]),
                        new Piece($subscription, Piece::PAWN, [1, 6]),
                        new Piece($subscription, Piece::PAWN, [1, 7]),
                        new Piece($subscription, Piece::PAWN, [1, 8]),
                        new Piece($subscription, Piece::PAWN, [1, 9])
                    ]);
                    break;
                case 2:
                    $gameTable = array_merge($gameTable, [
                        new Piece($subscription, Piece::ROOK, [2, 11]),
                        new Piece($subscription, Piece::KNIGHT, [3, 11]),
                        new Piece($subscription, Piece::BISHOP, [4, 11]),
                        new Piece($subscription, Piece::QUEEN, [5, 11]),
                        new Piece($subscription, Piece::KING, [6, 11]),
                        new Piece($subscription, Piece::BISHOP, [7, 11]),
                        new Piece($subscription, Piece::KNIGHT, [8, 11]),
                        new Piece($subscription, Piece::ROOK, [9, 11]),

                        new Piece($subscription, Piece::PAWN, [2, 10]),
                        new Piece($subscription, Piece::PAWN, [3, 10]),
                        new Piece($subscription, Piece::PAWN, [4, 10]),
                        new Piece($subscription, Piece::PAWN, [5, 10]),
                        new Piece($subscription, Piece::PAWN, [6, 10]),
                        new Piece($subscription, Piece::PAWN, [7, 10]),
                        new Piece($subscription, Piece::PAWN, [8, 10]),
                        new Piece($subscription, Piece::PAWN, [9, 10]),
                    ]);
                    break;
                case 3:
                    $gameTable = array_merge($gameTable, [
                        new Piece($subscription, Piece::ROOK, [11, 2]),
                        new Piece($subscription, Piece::KNIGHT, [11, 3]),
                        new Piece($subscription, Piece::BISHOP, [11, 4]),
                        new Piece($subscription, Piece::QUEEN, [11, 5]),
                        new Piece($subscription, Piece::KING, [11, 6]),
                        new Piece($subscription, Piece::BISHOP, [11, 7]),
                        new Piece($subscription, Piece::KNIGHT, [11, 8]),
                        new Piece($subscription, Piece::ROOK, [11, 9]),

                        new Piece($subscription, Piece::PAWN, [10, 2]),
                        new Piece($subscription, Piece::PAWN, [10, 3]),
                        new Piece($subscription, Piece::PAWN, [10, 4]),
                        new Piece($subscription, Piece::PAWN, [10, 5]),
                        new Piece($subscription, Piece::PAWN, [10, 6]),
                        new Piece($subscription, Piece::PAWN, [10, 7]),
                        new Piece($subscription, Piece::PAWN, [10, 8]),
                        new Piece($subscription, Piece::PAWN, [10, 9]),
                    ]);
                    break;
                case 4:
                    $gameTable = array_merge($gameTable, [
                        new Piece($subscription, Piece::ROOK, [2, 0]),
                        new Piece($subscription, Piece::KNIGHT, [3, 0]),
                        new Piece($subscription, Piece::BISHOP, [4, 0]),
                        new Piece($subscription, Piece::QUEEN, [5, 0]),
                        new Piece($subscription, Piece::KING, [6, 0]),
                        new Piece($subscription, Piece::BISHOP, [7, 0]),
                        new Piece($subscription, Piece::KNIGHT, [8, 0]),
                        new Piece($subscription, Piece::ROOK, [9, 0]),

                        new Piece($subscription, Piece::PAWN, [2, 1]),
                        new Piece($subscription, Piece::PAWN, [3, 1]),
                        new Piece($subscription, Piece::PAWN, [4, 1]),
                        new Piece($subscription, Piece::PAWN, [5, 1]),
                        new Piece($subscription, Piece::PAWN, [6, 1]),
                        new Piece($subscription, Piece::PAWN, [7, 1]),
                        new Piece($subscription, Piece::PAWN, [8, 1]),
                        new Piece($subscription, Piece::PAWN, [9, 1]),
                    ]);
                    break;
            }
        }

        $gameTable = array_reduce($gameTable, function ($gameTable, $piece) {
            list ($y, $x) = $piece->position;
            /** @var $piece Piece */
            if (!isset($gameTable[$y])) {
                $gameTable[$y] = [];
            }

            $gameTable[$y][$x] = $piece;

            return $gameTable;
        }, []);

        return $gameTable;
    }

    /**
     * @param GameSession $session
     * @param array $positionFrom
     * @param array $positionTo
     * @return bool
     */
    public function performAction(GameSession $session, array $positionFrom, array $positionTo)
    {
        if ($positionFrom === $positionTo) {
            return false;
        }

        if (!$this->validatePosition($positionFrom) || $this->validatePosition($positionTo)) {
            return false;
        }

        $pieceFrom = $this->getPiece($session, $positionFrom);
        if (!$pieceFrom || $pieceFrom->subscription->id !== $session->current_subscription_id) {
            return false;
        }

        $pieceTo = $this->getPiece($session, $positionTo);
        if ($this->pieceValidator->validatePieceToPosition($pieceFrom, $positionTo, $pieceTo !== false)) {
            return false;
        }

        $gameTable = $session->game_bag;
        $gameTable[$positionTo[0]][$positionTo[1]] = $gameTable[$positionFrom[0]][$positionFrom[1]];
        unset($gameTable[$positionFrom[0]][$positionFrom[1]]);

        $session->game_bag = $gameTable;
        $session->save();

        return true;
    }

    /**
     * @param GameSession $session
     * @param array $position
     * @return Piece|bool
     */
    public function getPiece(GameSession $session, array $position)
    {
        list ($y, $x) = $position;
        $bag = @$session->game_bag[$y][$x];
        if (!$bag) {
            return false;
        }

        return Piece::fromArray($bag);
    }

    /**
     * @param array $position
     * @return bool
     */
    public function validatePosition(array $position)
    {
        list ($y, $x) = $position;
        if ($y < 0 || $y > 11 || $x < 0 || $x > 11) {
            return false;
        } elseif (($y < 2 || $y > 9) && ($x < 2 || $x > 9)) {
            return false;
        }

        return true;
    }
}