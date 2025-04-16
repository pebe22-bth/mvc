<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController
{
    private function getQuotes(): array
    {
        $filename = "../assets/data/quotes.json";
        $jsonData = file_get_contents($filename);
        
        return json_decode($jsonData, true);
    }

    #[Route("/api/quote", name: "api_quote")]
    public function jsonQuote(): Response
    {
        //Inspirational quotes provided by <a href="https://zenquotes.io/" target="_blank">ZenQuotes API</a>

        $quoteList = $this -> getQuotes();
        $quote = $quoteList[random_int(0, count($quoteList) - 1)];
        $quote["attribition"] = 'Inspirational quotes provided by <a href="https://zenquotes.io/" target="_blank">ZenQuotes API</a>';
        
        $response = new JsonResponse($quote);
        $response->setEncodingOptions(
        $response->getEncodingOptions() | JSON_PRETTY_PRINT
    );
    return $response;
    }
    
}