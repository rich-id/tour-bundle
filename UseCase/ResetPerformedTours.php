<?php declare(strict_types=1);

namespace RichId\TourBundle\UseCase;

use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\UserTourPerformedRepository;
use RichId\TourBundle\Validator\UserTourExist;

/**
 * Class ResetPerformedTours
 *
 * @package   RichId\TourBundle\UseCase
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class ResetPerformedTours
{
    /** @var UserTourExist */
    private $userTourExist;

    /** @var UserTourPerformedRepository */
    private $userTourPerformedRepository;

    public function __construct(UserTourExist $userTourExist, UserTourPerformedRepository $userTourPerformedRepository)
    {
        $this->userTourExist = $userTourExist;
        $this->userTourPerformedRepository = $userTourPerformedRepository;
    }

    public function __invoke(string $tour): void
    {
        if (!($this->userTourExist)($tour)) {
            throw new NotFoundTourException($tour);
        }

        $this->userTourPerformedRepository->deleteByTour($tour);
    }
}
