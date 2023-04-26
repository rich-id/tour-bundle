<?php

declare(strict_types=1);

namespace RichId\TourBundle\SecurityVoter;

use RichId\TourBundle\Rule\HasAccessToAdministration;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TourAdministrationVoter extends Voter
{
    const EDIT_ADMINISTRATION_TOUR = 'EDIT_ADMINISTRATION_TOUR';

    /** @var HasAccessToAdministration */
    protected $hasAccessToAdministration;

    public function __construct(HasAccessToAdministration $hasAccessToAdministration)
    {
        $this->hasAccessToAdministration = $hasAccessToAdministration;
    }

    protected function supports(string $attribute, $subject)
    {
        return \in_array($attribute, [self::EDIT_ADMINISTRATION_TOUR], true);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case self::EDIT_ADMINISTRATION_TOUR:
                return ($this->hasAccessToAdministration)();
            default:
                throw new \LogicException('This code should not be reached!');
        }
    }
}
