<?php

namespace MicroCMS\Domain;

class Comment 
{
    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Comment author.
     *
     * @var string
     */
    private $author;

    /**
     * Comment content.
     *
     * @var integer
     */
    private $content;

    /**
     * Associated article.
     *
     * @var \MicroCMS\Domain\Article
     */
    private $article;

	/** ajout MYF
     * Comment signal.
     *
     * @var integer
     */
    private $signal;
	
	/** ajout MYF
     * Comment father.
     *
     * @var integer
     */
    private $father;

	
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }
	
	 public function getSignal() {
        return $this->signal;
    }

    public function setSignal($signal) {
        $this->signal = $signal;
        return $this;
    }	
	
	/*  getter setter de father */
	 public function getFather() {
        return $this->father;
    }

    public function setFather($father) {
        $this->father = $father;
        return $this;
    }
	
} /* overall */