<?php declare(strict_types=1);

namespace RichId\TourBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tour.
 *
 * @package   RichId\TourBundle\Entity
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @ORM\Entity(repositoryClass="RichId\TourBundle\Repository\TourRepository")
 * @ORM\Table(name="rich_id_tour")
 */
class Tour
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=255, nullable=false, name="keyname")
     */
    protected $keyname;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, name="is_disabled", options={"default":0})
     */
    private $isDisabled = false;

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
