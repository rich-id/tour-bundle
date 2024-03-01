<?php declare(strict_types=1);

namespace RichId\TourBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use RichId\TourBundle\Repository\TourRepository;

/**
 * Class Tour.
 *
 * @package   RichId\TourBundle\Entity
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
#[ORM\Entity(repositoryClass: TourRepository::class)]
#[ORM\Table(name: 'rich_id_tour')]
class Tour
{
    #[ORM\Id]
    #[ORM\Column(name: 'keyname', type: 'string', length: 255, nullable: false)]
    protected string $keyname;

    #[ORM\Column(name: "is_disabled", type: 'boolean', nullable: false, options: ["default" => 0])]
    private bool $isDisabled = false;

    public function getId(): string
    {
        return $this->keyname;
    }

    public function getKeyname(): string
    {
        return $this->keyname;
    }

    public function isDisabled(): bool
    {
        return $this->isDisabled;
    }

    public function disable(): self
    {
        $this->isDisabled = true;

        return $this;
    }

    public function enable(): self
    {
        $this->isDisabled = false;

        return $this;
    }

    public static function build(string $keyname): self
    {
        $entity = new self();

        $entity->keyname = $keyname;

        return $entity;
    }
}
