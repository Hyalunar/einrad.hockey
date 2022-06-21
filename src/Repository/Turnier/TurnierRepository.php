<?php

namespace App\Repository\Turnier;

use App\Entity\Turnier\Turnier;
use App\Entity\Turnier\TurnierBericht;
use App\Entity\Turnier\TurniereListe;
use App\Repository\TraitSingletonRepository;

use Doctrine\ORM\EntityRepository;
use App\Repository\DoctrineWrapper;
use Doctrine\ORM\Exception\ORMException;

class TurnierRepository
{
    use TraitSingletonRepository;

    public EntityRepository $liste;
    public EntityRepository $turnier;
    public EntityRepository $bericht;

    private function __construct()
    {
        $this->liste = DoctrineWrapper::manager()->getRepository(TurniereListe::class);
        $this->turnier = DoctrineWrapper::manager()->getRepository(Turnier::class);
        $this->bericht = DoctrineWrapper::manager()->getRepository(TurnierBericht::class);
    }

    /**
     * @param int $turnier_id
     * @return TurniereListe[]
     */
    public function getSetzListe(Turnier $turnier): array
    {
        return $this->liste->findBy(['turnier' => $turnier, 'liste' => 'setz']);
    }

    public function turnier(int $turnier_id = 1005): Turnier
    {
        return $this->turnier->find($turnier_id);
    }

    /**
     * @throws ORMException
     */
    public function speichern(Turnier $turnier): void
    {
        DoctrineWrapper::manager()->persist($turnier);
        DoctrineWrapper::manager()->flush();
    }

    public function getBericht(int $turnier_id): ?TurnierBericht
    {
        return $this->bericht->findOneBy(['turnierId' => $turnier_id]);
    }

}