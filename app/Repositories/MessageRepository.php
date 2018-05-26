<?php

namespace App\Repositories;


use App\Entities\Message;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\UuidGenerator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;
use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository implements MessageRepositoryContract
{
    use PaginatesFromParams;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct(
            $entityManager,
            $entityManager->getClassMetadata(Message::class)
        );
    }

    /**
     * @param Message $message
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Message $message)
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }

    /**
     * @param int $limit
     * @param int $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function all(int $limit, int $page)
    {
        $query = $this->createQueryBuilder('m')
            ->getQuery();

        return $this->paginate($query, $limit, $page);
    }

    /**
     * @param int $limit
     * @param int $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function archive(int $limit, int $page)
    {
        $query = $this->createQueryBuilder('m')
            ->where('m.archivedAt IS NOT NULL')
            ->getQuery();

        return $this->paginate($query, $limit, $page);
    }

    /**
     * @param int $id
     * @return null|object
     */
    public function findById(int $id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @param $message
     * @param string $field
     * @param $value
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($message, string $field, $value)
    {
        $method = 'set' . ucfirst(camel_case($field));
        $message->$method($value);
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }

    /**
     * @param $sender
     * @param $subject
     * @param $message
     * @return Message
     */
    public function prepareDate($sender, $subject,  $message)
    {
        return new Message(
            $sender,
            $subject,
            $message
        );
    }
}
