<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $bookModel = new Book();
        $books = $bookModel->findAll();

        $this->render('index', ['books' => $books]);
    }
}
