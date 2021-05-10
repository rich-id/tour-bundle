<?php declare(strict_types=1);

namespace RichId\TourBundle\Action;

use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\UserTourRepository;
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

    /** @var UserTourRepository */
    private $userTourRepository;

    public function __construct(UserTourExists $userTourExists, UserTourRepository $userTourRepository)
    {
        $this->userTourExists = $userTourExists;
        $this->userTourRepository = $userTourRepository;
    }

    public function __invoke(string $tourKeyname): void
    {
        if (!($this->userTourExists)($tourKeyname)) {
            throw new NotFoundTourException($tourKeyname);
        }

        $this->userTourRepository->deleteByTour($tourKeyname);
    }
}
