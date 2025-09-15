<?php
namespace App\Custom;

class BlogSEOSchema
{
    public $title ;
    public $metaDescription ;
    public $author;
    public $createdAt;
    public $updatedAt;
    public $showSchema = false;

    public function __construct($title, $metaDescription, $author, $createdAt, $updatedAt,$showSchema)
    {
        $this->title = $title;
        $this->metaDescription = $metaDescription;
        $this->author = $author;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->showSchema = $showSchema;
    }

    public function getSchema()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $this->title,
            'description' => $this->metaDescription,
            'author' => [
                '@type' => 'Person',
                'name' => $this->author,
            ],
            'datePublished' => $this->createdAt->toIso8601String(),
            'dateModified' => $this->updatedAt->toIso8601String(),
            // Add more schema properties as needed
        ];
    }
}
