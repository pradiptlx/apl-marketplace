<?php

namespace Idy\Idea\Application\CreateNewIdea;

use Idy\Idea\Domain\Exception\InvalidEmailDomainException;
use Idy\Idea\Domain\Model\Author;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Repository\IdeaRepository;

class CreateNewIdeaService
{
    private $ideaRepository;

    public function __construct(
        IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    /**
     * @param CreateNewIdeaRequest $request
     * @return CreateNewIdeaResponse
     */
    public function handle(CreateNewIdeaRequest $request) : CreateNewIdeaResponse
    {
        try {
            $idea = Idea::makeIdea($request->getIdeaTitle(), $request->getIdeaDescription(),Idea::INIT_VOTE, new Author($request->getAuthorName(), $request->getAuthorEmail()));
            $response = $this->ideaRepository->save($idea);

            return new CreateNewIdeaResponse($response, "Idea created successfully.");
        } catch (InvalidEmailDomainException $domainException) {
            return new CreateNewIdeaResponse($domainException, $domainException->getMessage(), 400, true);
        } catch (\Exception $exception) {
            return new CreateNewIdeaResponse($exception, $exception->getMessage(), 500, true);
        }
    }

}