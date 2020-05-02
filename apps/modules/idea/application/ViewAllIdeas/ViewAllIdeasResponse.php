<?php

namespace Idy\Idea\Application\ViewAllIdeas;

class ViewAllIdeasResponse
{
    protected $data;

    public function __construct($ideas, $ratings)
    {
        $data = [];

        foreach ($ideas as $idea)
        {
//            $data[$idea['id']]
        }
    }
}