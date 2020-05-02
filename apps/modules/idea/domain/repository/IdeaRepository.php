<?php

namespace Idy\Idea\Domain\Repository;

use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\Rating;

interface IdeaRepository
{
    public function byId(IdeaId $id);
    public function save(Idea $idea);
    public function allIdeas();
    public function allRatings();
    public function vote(Idea $idea);
    public function getRatingsByIdeaId(IdeaId $id);
    public function rate(IdeaId $id, Rating $rating);
}