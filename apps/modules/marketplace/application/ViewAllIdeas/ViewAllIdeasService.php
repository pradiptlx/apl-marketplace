<?php

namespace Dex\Marketplace\Application\ViewAllIdeas;

use Dex\Marketplace\Application\IdeaMapper;
use Dex\Marketplace\Domain\Repository\IdeaRepository;

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
