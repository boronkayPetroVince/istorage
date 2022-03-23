<?php


namespace App\Service\Classes;


use App\Entity\Contact;
use App\Service\Interfaces\ContactServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ContactService extends CrudService implements ContactServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Contact::class);
    }

    public function getAllContact():iterable{
        return $this->getRepo()->findAll();
    }

    public function removeAllContactByClient(int $client_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Contact::class, "contact")
            ->where("contact.client_ID =: client_ID")
            ->setParameter("client_ID", $client_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneContactById(int $id):Contact{
        return $this->getRepo()->find($id);
    }
    public function addContact(Contact $contact):void{
        $this->em->persist($contact);
        $this->em->flush();
    }

    public function updateContact(int $id):void{
        $contact = $this->getOneContactById($id);
        $this->em->persist($contact);
        $this->em->flush();
    }
}