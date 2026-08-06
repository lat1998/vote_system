<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['election_id', 'candidate_id', 'user_id', 'qr_token'])]
class Vote extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'voted_at' => 'datetime',
        ];
    }

    /**
     * Get the election this vote belongs to
     */
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    /**
     * Get the candidate this vote is for
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Get the voter who cast this vote
     */
    public function voter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
