<?php

namespace Dex\Marketplace\Domain\Repository;

use Dex\Marketplace\Domain\Model\Idea;
use Dex\Marketplace\Domain\Model\IdeaId;
use Dex\Marketplace\Domain\Model\Rating;

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
