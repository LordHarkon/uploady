<?php

namespace Uploady;

/**
 * A class that handles Page Translation
 *
 * @package Uploady
 * @version 1.5.3
 * @author fariscode <farisksa79@protonmail.com>
 * @license MIT
 * @link https://github.com/farisc0de/Uploady
 */

class PageTranslation
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addTranslation($data)
    {
        $this->db->prepare("INSERT INTO pages_translation (page_id, language_id, title, content) VALUES (:page, :language, :title, :content)");
        $this->db->bind(":language", $data['lang_id']);
        $this->db->bind(":page", $data['page_id']);
        $this->db->bind(":title", $data['title']);
        $this->db->bind(":content", $data['content']);
        return $this->db->execute();
    }

    public function updateTranslation($data)
    {
        $this->db->prepare("UPDATE pages_translation SET
         title = :title,
         content = :content WHERE 
         language_id = :language AND page_id = :page");

        $this->db->bind(":language", $data['lang_id']);
        $this->db->bind(":page", $data['page_id']);
        $this->db->bind(":title", $data['title']);
        $this->db->bind(":content", $data['content']);

        return $this->db->execute();
    }

    public function getTranslation($language, $page)
    {
        $this->db->prepare("SELECT * FROM pages_translation WHERE language_id = :language AND page = :page");
        $this->db->bind(":language", $language);
        $this->db->bind(":page", $page);
        $this->db->execute();
        return $this->db->single();
    }

    public function getTranslations()
    {
        $this->db->prepare("SELECT * FROM pages_translation");

        $this->db->execute();

        return $this->db->resultset();
    }

    public function getTranslationRecord($id)
    {
        $this->db->prepare("SELECT * FROM pages_translation WHERE id = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();
        return $this->db->single();
    }

    public function deleteTranslation($language, $page)
    {
        $this->db->prepare("DELETE FROM pages_translation WHERE language_id = :language AND page_id = :page");
        $this->db->bind(":language", $language);
        $this->db->bind(":page", $page);
        $this->db->execute();
    }
}
