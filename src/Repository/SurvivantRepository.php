<?php

namespace App\Repository;

use App\Entity\Survivant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Survivant>
 */
class SurvivantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Survivant::class);
    }

    public function ordreDescendant(): array
       {
           return $this->createQueryBuilder('s')
               ->orderBy('s.nom', 'DESC')
               ->getQuery()
               ->getResult()
           ;
       }

	  public function nain($value): array
	     {
	         return $this->createQueryBuilder('s')
				->leftjoin("s.race", "r")
	             ->Where('r.id= :nain')
			   ->setParameter(":nain",$value)
	             ->getQuery()
	             ->getResult()
	         ;
	     }

		public function elf($value): array
		   {
		       return $this->createQueryBuilder('s')
			  ->leftjoin("s.race", "r")
	             ->Where('r.id= :elf')
			   ->andWhere('s.puissance>=25')
			   ->setParameter(":elf",$value)
		        ->getQuery()
		        ->getResult()
		       ;
		   }

		   public function archer($value): array
		   {
		       return $this->createQueryBuilder('s')
			  ->leftjoin("s.race", "r")
			  ->leftjoin("s.classe", "c")
	             ->Where('c.id= :archer')
	             ->andWhere('r.id!=1')
			   ->setParameter(":archer",$value)
		        ->getQuery()
		        ->getResult()
		       ;
		   }

		   public function filters($puissance, $race): array
       {
           return $this->createQueryBuilder('s')
               ->where('s.puissance >= :puissance')
               ->setParameter('puissance', $puissance)
			->leftJoin("s.race", "r")
			->andWhere('r.race_name = :race')
			->setParameter("race",$race)
               ->getQuery()
               ->getResult()
           ;
       }
	
		public function sumPuissanceByRace(): array
		{
		return $this->createQueryBuilder('s')
			->leftJoin("s.race", "r")
			->select('r.race_name as racename', 'SUM(s.puissance) as totalPuissance')
			->groupBy("r.race_name")
			->getQuery()
			->getScalarResult();
		}
	 
    //    /**
    //     * @return Survivant[] Returns an array of Survivant objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Survivant
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


}
