<?php

namespace App\Libraries\AjaxTokens;

class Post extends Token
{
    public function new()
    {
        return $this->ID([
            "data" => [
                [
                    "table" => "posts",
                    "action" => "add",
                ],
            ],
            'modal' => [
                'header' => 'Add Post',
                'button' => 'Add',
            ]
        ]);
    }
    public function edit($id)
    {
        return $this->ID([
            "data" => [
                [
                    "table" => "posts",
                    "action" => "edit",
                    "where" => [
                        "id" => $id,
                    ],
                ],
            ],
        ]);
    }
    public function demo()
    {
        return $this->ID([
            'data' => [
                [
                    'table' => 'posts',
                    'action' => 'insert',
                    'set' => [
                        'title' => json_encode('Demo Title'),
                        'content' => json_encode('Demo Content')
                    ]
                ]
            ]
        ]);
    }
}
