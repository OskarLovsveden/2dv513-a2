<?php

class TableMaker {
    private $post = array();
    private $fullname = array();
    private $subreddit = array();

    public function addToPostFields($obj) {
        $this->post[] = array(
            $obj->id,
            $obj->parent_id,
            $obj->link_id,
            $obj->author,
            $obj->body,
            $obj->subreddit_id,
            $obj->score,
            $obj->created_utc
        );
    }

    public function addToFullnameFields($obj) {
        $this->fullname[] = array(
            $obj->id,
            $obj->name
        );
    }

    public function addToSubredditFields($obj) {
        $this->subreddit[] = array(
            $obj->subreddit_id,
            $obj->subreddit
        );
    }

    public function getPostFields(): array {
        return $this->post;
    }

    public function getFullnameFields(): array {
        return $this->fullname;
    }

    public function getSubredditFields(): array {
        return $this->subreddit;
    }
}
