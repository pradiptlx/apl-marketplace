<?php

namespace Idy\Idea\Application\ViewAllIdeas;

use Idy\Idea\Application\IdeaMapper;
use Idy\Idea\Domain\Repository\IdeaRepository;

class ViewAllIdeasService
{
    protected $repository;

    public function __construct(IdeaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $ideas = $this->repository->allIdeas();
        $ratings = $this->repository->allRatings();

        return new IdeaMapper($ideas, $ratings);
    }
}