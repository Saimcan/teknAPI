<?php

namespace App\Repository;

use App\Entity\Device;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Device>
 *
 * @method Device|null find($id, $lockMode = null, $lockVersion = null)
 * @method Device|null findOneBy(array $criteria, array $orderBy = null)
 * @method Device[]    findAll()
 * @method Device[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    public function save(Device $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Device $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function checkRegistrationExpiration(int $uid): bool
    {
        /**
         * @var Device $device
         */
        $device = $this->findBy([
            'uid' => $uid
        ]);

        $now = new \DateTime();
        $expirationInterval = new \DateInterval("P90D");
        $expirationDateTime = new DateTime($device->getClientTokenExpirationDateTime());
        $expirationTimestamp = $expirationDateTime->add($expirationInterval)->getTimestamp();

        if($expirationTimestamp < $now->getTimestamp()){
            return true;
        }else{
            return false;
        }
    }

    public function checkRegistration(int $uid): bool
    {
        /**
         * @var Device $device
         */
        $device = $this->findOneBy([
            'uid' => $uid
        ]);

        if(!is_null($device) && $device->getClientToken()){
            return true;
        }else{
            return false;
        }
    }

//    /**
//     * @return Device[] Returns an array of Device objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Device
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
