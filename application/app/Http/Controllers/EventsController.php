<?php

declare(strict_types=1);

namespace Application\Http\Controllers;

use Inertia\Inertia;

class EventsController extends Controller
{
    public function show()
    {
        return Inertia::render('User/Show', [
            'user' => [
                'name' => 'John Doe',
            ],
        ]);
    }
}
