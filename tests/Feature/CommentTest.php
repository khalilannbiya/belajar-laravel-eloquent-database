<?php

namespace Tests\Feature;

use App\Models\Comment;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function testCreateComment()
    {
        $comment = new Comment();
        $comment->email = "syeichkhalil30@gmail.com";
        $comment->title = "Test Comment";
        $comment->comment = "Sample Comment";
        $comment->save();

        self::assertNotNull($comment->id);
    }

    public function testDefaultAttributeValues()
    {
        $comment = new Comment();
        $comment->email = "syeichkhalil30@gmail.com";
        $comment->title = "Test Comment";
        $comment->save();

        self::assertNotNull($comment->id);
        self::assertNotNull($comment->email);
        self::assertNotNull($comment->title);
        self::assertNotNull($comment->comment);
        self::assertEquals('Sample Comment Default', $comment->comment);
    }
}
