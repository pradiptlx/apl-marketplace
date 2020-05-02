<?php

namespace Idy\Idea\Application\RateIdea;

use Idy\Idea\Domain\Exception\InvalidRatingException;
use Idy\Idea\Domain\Model\Author;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Repository\IdeaRepository;

class RateIdeaService
{
    protected $repository;

    public function __construct(IdeaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RateIdeaRequest $request
     * @return RateIdeaResponse
     */
    public function handle(RateIdeaRequest $request) : RateIdeaResponse
    {
        try {
            $ideaId = new IdeaId($request->getIdeaId());
            $ideaFromDb = $this->repository->byId($ideaId);
            $ratings = $this->repository->getRatingsByIdeaId($ideaId);
            $idea = new Idea($ideaId, $ideaFromDb['title'], $ideaFromDb['description'], $ideaFromDb['votes'], $ratings, new Author($ideaFromDb['author_name'], $ideaFromDb['author_email']));
            $rating = $idea->addRating($request->getName(), $request->getValue());

            $response = $this->repository->rate($ideaId, $rating);

            return new RateIdeaResponse($response, "Idea successfully rated.");
        } catch (InvalidRatingException $exception) {
            return new RateIdeaResponse($exception, $exception->getMessage(), 400, true);
        } catch (\Exception $exception) {
            return new RateIdeaResponse($exception, $exception->getMessage(), 500, true);
        }


    }
}