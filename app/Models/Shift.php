<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'title',
        'group',
        'description',
        'start',
        'end',
        'team_size',
    ];

    /**
     * Export shifts
     */
    public function export() {
      return [
        'shift','', $this->type, $this->title, $this->description,
        $this->start, $this->end, $this->team_size
      ];
    }

    /**
     * @inheritDoc
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        // Empty types
        if(empty($this->type)) {
            $this->type = '';
        }
        return parent::save($options);
    }

    /**
     * Shift belongs to a plan
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Shift can have many subscriptions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }
}
