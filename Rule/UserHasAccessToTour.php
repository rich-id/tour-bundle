<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Model\UserTourInterface;
use RichId\TourBundle\Model\UserTourPerformed;
use RichId\TourBundle\Validator\UserTourExist;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserHasAccessToTour
 *
 * @package   RichId\TourBundle\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class UserHasAccessToTour
{
    /** @var Security */
    private $security;

    /** @var UserTourExist */
    private $userTourExist;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(Security $security, UserTourExist $userTourExist, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->userTourExist = $userTourExist;
        $this->entityManager = $entityManager;
    }

    public function __invoke(string $tour): bool
    {
        if (!($this->userTourExist)($tour)) {
            return false;
        }

        $user = $this->security->getUser();

        if (!$user instanceof UserTourInterface) {
            return false;
        }

        $userTourPerformedRepository = $this->entityManager->getRepository(UserTourPerformed::class);
        $existingEntity = $userTourPerformedRepository->findOneBy(
            [
                'user' => $user->getId(),
                'tour' => $tour,
            ]
        );

        return null === $existingEntity;
    }
}
