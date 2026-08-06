<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'status', 'start_date', 'end_date', 'election_code', 'position_order'])]
class Election extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    /**
     * Get all candidates for this election
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * Get all votes for this election
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get all voters who participated in this election
     */
    public function voters()
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    /**
     * Check if election is active
     */
    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if (!$this->end_date) {
            return true;
        }

        return now()->lte($this->end_date);
    }

    /**
     * Check if election has ended
     */
    public function hasEnded(): bool
    {
        return now()->isAfter($this->end_date);
    }

    /**
     * Get vote count per candidate
     */
    public function getVoteResults()
    {
        return $this->candidates()
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->get();
    }

    /**
     * Get total votes cast in this election
     */
    public function getTotalVotes()
    {
        return $this->votes()->count();
    }
}
