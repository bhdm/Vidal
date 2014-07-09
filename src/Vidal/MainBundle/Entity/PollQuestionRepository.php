<?php
namespace Vidal\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PollQuestionRepository extends EntityRepository
{
    public function findNext($poll,$id)
    {
        $tid = $poll->getId();
        $result = $this->getEntityManager()
            ->createQuery("
                    SELECT q FROM EvrikaMainBundle:PollQuestion q
                    LEFT JOIN q.poll p WITH p.id = $tid
                    WHERE q.id > $id
                    ORDER BY q.id ASC")
            ->setMaxResults(1)
            ->getOneOrNullResult();
        return $result;
    }

    public function findFirst($poll)
    {
        $tid = $test->getId();
        $result = $this->getEntityManager()
            ->createQuery("
                    SELECT q FROM EvrikaMainBundle:PollQuestion q
                    LEFT JOIN q.poll p WITH p.id = $tid
                    ORDER BY q.id ASC")
            ->setMaxResults(1)
            ->getOneOrNullResult();
        return $result;
    }
}