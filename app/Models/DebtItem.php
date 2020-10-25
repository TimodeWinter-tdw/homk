<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DebtItem
 *
 * @property int $id
 * @property int $creator_id
 * @property int $indebted_user
 * @property float $amount
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem whereIndebtedUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebtItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $indebtedUser
 */
class DebtItem extends Model
{
    protected $fillable = [
        'indebted_user', 'amount', 'description'
    ];

    protected $casts = [
        'amount' => 'float'
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function indebtedUser() {
        return $this->hasOne(User::class, 'id', 'indebted_user');
    }
}
