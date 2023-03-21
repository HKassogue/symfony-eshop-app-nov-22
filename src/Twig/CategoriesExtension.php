<?php

namespace App\Twig;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoriesExtension extends AbstractExtension 
{
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('categories', [$this, 'get'])
        ];
    }

    public function get() 
    {
        //return $this->entityManager->getRepository(Category::class)->findAll();
        return $this->entityManager->getRepository(Category::class)->findBy(['active' => true], ['name' => 'ASC']);
    }
}