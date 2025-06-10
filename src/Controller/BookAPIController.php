<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;

final class BookAPIController extends AbstractController
{
    #[Route('/api/library/books', name: 'api_library_show_all', methods:['GET'])]
    public function apiShowAllBook(
        BookRepository $bookRepository,
    )  : Response {
        $books = $bookRepository->findAll();
        return $this->json($books);
    }
    #[Route('/api/library/book/{isbn}', name: 'api_library_by_isbn', methods:['GET'])]
    public function apiShowBookByIsbn(
            BookRepository $bookRepository,
            string $isbn
        ): Response {
            $book = $bookRepository->findByIsbn($isbn);
        
            return $this->json($book);
        }



}
