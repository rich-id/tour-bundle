<?php declare(strict_types=1);

namespace RichId\TourBundle\Action;

use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Exception\UnsupportedActionStorageException;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Rule\TourExists;
use RichId\TourBundle\Rule\TourHasDatabaseStorage;

/**
 * Class ResetPerformedTours
 *
 * @package   RichId\TourBundle\Action
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class ResetPerformedTours
{
    /** @var TourExists */
    private $tourExists;

    /** @var TourHasDatabaseStorage */
    private $tourHasDatabaseStorage;

    /** @var UserTourRepository */
    private $userTourRepository;

    public function __construct(TourExists $tourExists, TourHasDatabaseStorage $tourHasDatabaseStorage, UserTourRepository $userTourRepository)
    {
        $this->tourExists = $tourExists;
        $this->tourHasDatabaseStorage = $tourHasDatabaseStorage;
        $this->userTourRepository = $userTourRepository;
    }

    public function __invoke(string $tourKeyname): void
    {
        if (!($this->tourExists)($tourKeyname)) {
            throw new NotFoundTourException($tourKeyname);
        }

        if (!($this->tourHasDatabaseStorage)($tourKeyname)) {
            throw new UnsupportedActionStorageException($tourKeyname);
        }

        $this->userTourRepository->deleteByTourKeyname($tourKeyname);
    }
}
