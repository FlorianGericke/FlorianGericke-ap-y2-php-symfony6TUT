<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    public function index()
    {
        return new Response('
            <html lang="en">
                <body>
                    <div>Hello</div>
                </body>
            </html>     
        ');
    }
}