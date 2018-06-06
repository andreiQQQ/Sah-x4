<?php

namespace App\Models;


use App\Entities\GameSubscription;
use App\User;

class Piece implements \JsonSerializable
{
    const KING = 'king';
    const QUEEN = 'queen';
    const ROOK = 'rook';
    const BISHOP = 'bishop';
    const KNIGHT = 'knight';
    const PAWN = 'pawn';

    /**
     * @var User
     */
    public $subscriber;

    /**
     * @var string
     */
    public $code;

    /**
     * @var array
     */
    public $position;

    /**
     * Piece constructor.
     * @param User $subscriber
     * @param string $code
     * @param array $position
     */
    public function __construct(User $subscriber, $code, array $position)
    {
        $this->subscriber = $subscriber;
        $this->code = $code;
        $this->position = $position;
    }

    /**
     * @param array $bag
     * @return Piece
     */
    public static function fromArray(array $bag)
    {
        $piece = new Piece();
        $piece->subscriber = GameSubscription::find($bag['subscriber_id']);
        $piece->code = $bag['code'];
        $piece->position = $bag['position'];

        return $piece;
    }

    /**
     * @return array
     */
    public function toJson()
    {
        return [
            'subscriber_id' => $this->subscriber->id,
            'code' => $this->code,
            'position' => $this->position,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toJson();
    }
}