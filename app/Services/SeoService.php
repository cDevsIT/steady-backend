<?php
namespace App\Services;

use App\Custom\BlogSEOSchema;
use Carbon\Carbon;

class SeoService
{

    public function generateSeoData(BlogSEOSchema $post)
    {
        return [
            'metaTitle' => $post->title,
            'metaDescription' => $post->metaDescription,
            'canonicalUrl' => url()->current(),
            'schema' => $this->generateSchema($post),
        ];
    }

    private function generateSchema(BlogSEOSchema $post)
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->metaDescription,
            'author' => [
                '@type' => 'Person',
                'name' => $post->author ?: 'Admin',
            ],
            'datePublished' => $this->toIso8601String($post->createdAt),
            'dateModified' => $this->toIso8601String($post->updatedAt),
        ];
    }

    private function toIso8601String($date)
    {
        // Convert to Carbon instance if it's not already one
        return Carbon::parse($date)->toIso8601String();
    }
}
