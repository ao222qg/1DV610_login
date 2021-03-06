<?php

class PostController {
    
    private $pv;
    private $pm;

    public function __construct(PostView $pv, PostModel $pm) {
        $this->pv = $pv;
        $this->pm = $pm;
    }

    public function initPost() : void {
        try {
            if($this->pv->isPosted())
                $this->userWantsToPost();

            else if($this->pv->isDeleted())
                $this->userWantsToDeletePost();

            else if($this->pv->isUpVoted())
                $this->userWantsToUpvote();

            else if($this->pv->isDownVoted())
                $this->userWantsToDownvote();
            else return;
        } catch(Exception $e) {
            $this->pv->showMessage($e->getMessage());
        }
    }

    private function userWantsToPost() : void {
        $this->pm->doActionPost($this->pv->getPost());
    }

    private function userWantsToUpvote() : void {
        $this->pm->doActionVote($this->pv->getPostID());
    }

    private function userWantsToDownvote() : void {
        $this->pm->doActionDownVote($this->pv->getPostID());
    }
    
    private function userWantsToDeletePost() : void {
        $this->pm->doActionDelete($this->pv->getPostID(), $this->pv->getAuthor());  
    }
}