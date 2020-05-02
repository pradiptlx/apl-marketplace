<?php

namespace Dex\Marketplace\Application\ViewAllIdeas;

class ViewAllIdeasResponse
{
    protected $data;

    public function __construct($ideas, $ratings)
    {
        $data = [];

        foreach ($ideas as $idea)
        {
//            $data[$marketplace['id']]
        }
    }
}
