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
        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $image = $request->request->get('image');

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
                'Book "' . $title . ' " added to library!'
            );

        return new Response('Saved new book with id '.$book->getId());
    }
    #[Route('/library/show', name: 'library_show_all', methods:['GET'])]
    public function showAllBook(
        BookRepository $bookRepository,
        SessionInterface $session
    )  : Response {
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
            $book = $bookRepository
                ->find($id);
        
            return $this->json($book);
        }
#[Route('/library/delete/{id}', name: 'library_delete_by_id', methods:['POST'])]
public function deleteBookById(
    ManagerRegistry $doctrine,
    int $id
): Response {
    $entityManager = $doctrine->getManager();
    $book = $entityManager->getRepository(Library::class)->find($id);

    if (!$book) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }

    $entityManager->remove($book);
    $entityManager->flush();

    return $this->redirectToRoute('library_show_all');
}
#[Route('/library/update/{id}/{value}', name: 'library_update', methods:['POST'])]
public function updateBook(
    ManagerRegistry $doctrine,
    int $id,
    int $value
): Response {
    $entityManager = $doctrine->getManager();
    $book = $entityManager->getRepository(Library::class)->find($id);

    if (!$book) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }

    $book->setValue($value);
    $entityManager->flush();

    return $this->redirectToRoute('library_show_all');
}
#[Route('/library/view', name: 'library_view_all')]
public function viewAllBook(
    BookRepository $bookRepository
): Response {
    $books = $bookRepository->findAll();

    $data = [
        'products' => $books
    ];

    return $this->render('library/view.html.twig', $data);
}
#[Route('/library/view/{value}', name: 'library_view_minimum_value', methods:['GET'])]
public function viewBookWithMinimumValue(
    BookRepository $bookRepository,
    int $value
): Response {
    $books = $bookRepository->findByMinimumValue($value);

    $data = [
        'products' => $books
    ];

    return $this->render('library/view.html.twig', $data);
}
#[Route('/library/show/min/{value}', name: 'library_by_min_value', methods:['GET'])]
public function showBookByMinimumValue(
    BookRepository $bookRepository,
    int $value
): Response {
    $books = $bookRepository->findByMinimumValue2($value);

    return $this->json($books);
}

}
