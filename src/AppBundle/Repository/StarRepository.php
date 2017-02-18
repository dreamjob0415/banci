<?php

namespace AppBundle\Repository;

/**
 * StarRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StarRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Retrieve all repos starred by a user.
     *
     * @param int $userId User id
     *
     * @return array
     */
    public function findAllByUser($userId)
    {
        $repos = $this->createQueryBuilder('s')
            ->select('r.fullName')
            ->leftJoin('s.repo', 'r')
            ->where('s.user = ' . $userId)
            ->getQuery()
            ->getArrayResult();

        $res = [];
        foreach ($repos as $repo) {
            $res[] = $repo['fullName'];
        }

        return $res;
    }

    /**
     * Remove stars for a user.
     *
     * @param array $starIds
     * @param int   $userId
     *
     * @return mixed
     */
    public function removeFromUser($starIds, $userId)
    {
        return $this->createQueryBuilder('s')
            ->delete()
            ->where('s.repo IN (:ids)')->setParameter('ids', $starIds)
            ->andWhere('s.repo = :userId')->setParameter('userId', $userId)
            ->getQuery()
            ->execute();
    }
}
