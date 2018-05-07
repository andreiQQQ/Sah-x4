<?php

namespace App\Entities;


use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\GameSession
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\GameSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\GameSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\GameSession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\GameSession whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\GameSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\GameSession whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $subscribers
 * @property-read \App\User $user
 */
class GameSession extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function subscribers()
    {
        return $this->hasManyThrough(
            User::class,
            GameSubscription::class,
            'session_id',
            'id',
            'id',
            'user_id'
        );
    }
}