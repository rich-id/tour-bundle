<?php declare(strict_types=1);

namespace RichId\TourBundle\Action;

use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\UserTourPerformedRepository;
use RichId\TourBundle\Rule\UserTourExists;

/**
 * Class ResetPerformedTours
 *
 * @package   RichId\TourBundle\Action
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class ResetPerformedTours
{
    /** @var UserTourExists */
    private $userTourExists;

    /** @var UserTourPerformedRepository */
    private $userTourPerformedRepository;

    public function __construct(UserTourExists $userTourExists, UserTourPerformedRepository $userTourPerformedRepository)
    {
        $this->userTourExists = $userTourExists;
        $this->userTourPerformedRepository = $userTourPerformedRepository;
    }

    public function __invoke(string $tour): void
    {
        if (!($this->userTourExists)($tour)) {
            throw new NotFoundTourException($tour);
        }

        $this->userTourPerformedRepository->deleteByTour($tour);
    }
}
