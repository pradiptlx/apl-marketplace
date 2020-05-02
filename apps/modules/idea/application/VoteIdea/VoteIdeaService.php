<?php

namespace Idy\Idea\Application\VoteIdea;

use Idy\Idea\Domain\Model\Author;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Repository\IdeaRepository;

class VoteIdeaService
{
    protected $repository;

    public function __construct(IdeaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param VoteIdeaRequest $request
     * @return VoteIdeaResponse
     */
    public function handle(VoteIdeaRequest $request) : VoteIdeaResponse
    {
        try {
            $ideaFromDb = $this->repository->byId(new IdeaId($request->getIdeaId()));
            $idea = new Idea(new IdeaId($ideaFromDb['id']), $ideaFromDb['title'], $ideaFromDb['description'], $ideaFromDb['votes'], [], new Author($ideaFromDb['author_name'], $ideaFromDb['author_email']));
            $idea->vote();

            $response = $this->repository->vote($idea);

            return new VoteIdeaResponse($response, "Idea voted successfully.");
        } catch (\Exception $exception) {
            return new VoteIdeaResponse($exception, $exception->getMessage(), 500, true);
        }
    }
}