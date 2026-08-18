<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['election_id', 'name', 'bio', 'image', 'position'])]
class Candidate extends Model
{
    use HasFactory;

    /**
     * Get the election this candidate belongs to
     */
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    /**
     * Get all votes for this candidate
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get total vote count
     */
    public function getVoteCount()
    {
        return $this->votes()->count();
    }

    /**
     * Get vote percentage for this election
     */
    public function getVotePercentage()
    {
        $totalVotes = $this->election->getTotalVotes();
        if ($totalVotes === 0) {
            return 0;
        }
        return ($this->getVoteCount() / $totalVotes) * 100;
    }
}
