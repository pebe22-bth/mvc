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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class BookController extends AbstractController
{
    #[Route('/library', name: 'library_home')]
    public function index(): Response
    {
        return $this->render('book/home.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/library/create', name: 'library_create_get', methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('book/create.html.twig');
    }

    #[Route('/library/create', name: 'library_create_post', methods: ['POST'])]
    public function createBook(
        Request $request,
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        $title = (string)$request->request->get('title');
        $isbn = (string)$request->request->get('isbn');
        $author = (string)$request->request->get('author');
        $image = (string)$request->request->get('image');

        $book = new Book();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setimage($image);

        // tell Doctrine you want to (eventually) save the Book
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Boken "' . $title . ' " är inlagd i biblioteket!'
        );

        return $this->redirectToRoute('library_show_all');
    }
    #[Route('/library/show', name: 'library_show_all', methods:['GET'])]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();
        $data = [
            "books" => $books
            ];
        return $this->render('book/view.html.twig', $data);
    }
    #[Route('/library/show/{id}', name: 'library_by_id', methods:['GET'])]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);
        $data = [
        "book" => $book
        ];

        return $this->render('book/single-view.html.twig', $data);
    }
    #[Route('/library/delete', name: 'library_delete', methods:['POST'])]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $id = (int) $request->request->get('id');
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found with id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Boken "' . $book->getTitle() . ' " borttagen från biblioteket!'
        );

        return $this->redirectToRoute('library_show_all');
    }
    #[Route('/library/update/{id}', name: 'library_update_get', methods:['GET'])]
    public function updateBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);
        $data = [
        "book" => $book
        ];

        return $this->render('book/update.html.twig', $data);
    }
    #[Route('/library/update', name: 'library_update_post', methods:['POST'])]
    public function updateBookPost(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $id = (int) $request->request->get('id');
        $title = (string) $request->request->get('title');
        $isbn = (string) $request->request->get('isbn');
        $author = (string) $request->request->get('author');
        $image = (string) $request->request->get('image');
        $book = $entityManager->getRepository(Book::class)->find($id);
        if (!$book) {
            throw $this->createNotFoundException('No book found with id ' . $id);
        }
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setimage($image);

        $entityManager->persist($book);

        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Boken "' . $title . ' " är uppdaterad.'
        );

        return $this->redirectToRoute('library_show_all');
    }

    #[Route('/library/reset', name: 'library_reset_really', methods: ['GET'])]
    public function reallyReset(): Response
    {
        return $this->render('book/reset.html.twig');
    }

    #[Route('/library/reset', name: 'library_reset_database', methods:['POST'])]
    public function resetDatabase(
        BookRepository $bookRepository
    ): Response {
        $bookRepository->reset();

        $this->addFlash(
            'notice',
            'Databasen är återställd!'
        );

        return $this->redirectToRoute('library_show_all');
    }
}
