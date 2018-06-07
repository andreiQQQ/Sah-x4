<?php

namespace App\Providers;


use App\Entities\GameSession;
use App\Models\Piece;
use App\User;

class GameProvider
{
    public function initGameTable(GameSession $session)
    {
        $subscriptions = $session->subscriptions;
        if ($subscriptions->count() < 4) {
            throw new \Exception('Must be subscribed to session all 4 players');
        }

        $gameTable = [
            // 1
            new Piece($subscriptions[0], Piece::ROOK, [2, 0]),
            new Piece($subscriptions[0], Piece::KNIGHT, [3, 0]),
            new Piece($subscriptions[0], Piece::BISHOP, [4, 0]),
            new Piece($subscriptions[0], Piece::QUEEN, [5, 0]),
            new Piece($subscriptions[0], Piece::KING, [6, 0]),
            new Piece($subscriptions[0], Piece::BISHOP, [7, 0]),
            new Piece($subscriptions[0], Piece::KNIGHT, [8, 0]),
            new Piece($subscriptions[0], Piece::ROOK, [9, 0]),

            new Piece($subscriptions[0], Piece::PAWN, [2, 1]),
            new Piece($subscriptions[0], Piece::PAWN, [3, 1]),
            new Piece($subscriptions[0], Piece::PAWN, [4, 1]),
            new Piece($subscriptions[0], Piece::PAWN, [5, 1]),
            new Piece($subscriptions[0], Piece::PAWN, [6, 1]),
            new Piece($subscriptions[0], Piece::PAWN, [7, 1]),
            new Piece($subscriptions[0], Piece::PAWN, [8, 1]),
            new Piece($subscriptions[0], Piece::PAWN, [9, 1]),

            // 2
            new Piece($subscriptions[1], Piece::ROOK, [0, 2]),
            new Piece($subscriptions[1], Piece::KNIGHT, [0, 3]),
            new Piece($subscriptions[1], Piece::BISHOP, [0, 4]),
            new Piece($subscriptions[1], Piece::QUEEN, [0, 5]),
            new Piece($subscriptions[1], Piece::KING, [0, 6]),
            new Piece($subscriptions[1], Piece::BISHOP, [0, 7]),
            new Piece($subscriptions[1], Piece::KNIGHT, [0, 8]),
            new Piece($subscriptions[1], Piece::ROOK, [0, 9]),

            new Piece($subscriptions[1], Piece::PAWN, [1, 2]),
            new Piece($subscriptions[1], Piece::PAWN, [1, 3]),
            new Piece($subscriptions[1], Piece::PAWN, [1, 4]),
            new Piece($subscriptions[1], Piece::PAWN, [1, 5]),
            new Piece($subscriptions[1], Piece::PAWN, [1, 6]),
            new Piece($subscriptions[1], Piece::PAWN, [1, 7]),
            new Piece($subscriptions[1], Piece::PAWN, [1, 8]),
            new Piece($subscriptions[1], Piece::PAWN, [1, 9]),

            // 3
            new Piece($subscriptions[2], Piece::ROOK, [2, 11]),
            new Piece($subscriptions[2], Piece::KNIGHT, [3, 11]),
            new Piece($subscriptions[2], Piece::BISHOP, [4, 11]),
            new Piece($subscriptions[2], Piece::QUEEN, [5, 11]),
            new Piece($subscriptions[2], Piece::KING, [6, 11]),
            new Piece($subscriptions[2], Piece::BISHOP, [7, 11]),
            new Piece($subscriptions[2], Piece::KNIGHT, [8, 11]),
            new Piece($subscriptions[2], Piece::ROOK, [9, 11]),

            new Piece($subscriptions[2], Piece::PAWN, [2, 10]),
            new Piece($subscriptions[2], Piece::PAWN, [3, 10]),
            new Piece($subscriptions[2], Piece::PAWN, [4, 10]),
            new Piece($subscriptions[2], Piece::PAWN, [5, 10]),
            new Piece($subscriptions[2], Piece::PAWN, [6, 10]),
            new Piece($subscriptions[2], Piece::PAWN, [7, 10]),
            new Piece($subscriptions[2], Piece::PAWN, [8, 10]),
            new Piece($subscriptions[2], Piece::PAWN, [9, 10]),

            // 4
            new Piece($subscriptions[3], Piece::ROOK, [11, 2]),
            new Piece($subscriptions[3], Piece::KNIGHT, [11, 3]),
            new Piece($subscriptions[3], Piece::BISHOP, [11, 4]),
            new Piece($subscriptions[3], Piece::QUEEN, [11, 5]),
            new Piece($subscriptions[3], Piece::KING, [11, 6]),
            new Piece($subscriptions[3], Piece::BISHOP, [11, 7]),
            new Piece($subscriptions[3], Piece::KNIGHT, [11, 8]),
            new Piece($subscriptions[3], Piece::ROOK, [11, 9]),

            new Piece($subscriptions[3], Piece::PAWN, [10, 2]),
            new Piece($subscriptions[3], Piece::PAWN, [10, 3]),
            new Piece($subscriptions[3], Piece::PAWN, [10, 4]),
            new Piece($subscriptions[3], Piece::PAWN, [10, 5]),
            new Piece($subscriptions[3], Piece::PAWN, [10, 6]),
            new Piece($subscriptions[3], Piece::PAWN, [10, 7]),
            new Piece($subscriptions[3], Piece::PAWN, [10, 8]),
            new Piece($subscriptions[3], Piece::PAWN, [10, 9]),
        ];

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
     * @param $positionFrom
     * @param $positionTo
     * @return bool
     */
    public function performAction(GameSession $session, $positionFrom, $positionTo)
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