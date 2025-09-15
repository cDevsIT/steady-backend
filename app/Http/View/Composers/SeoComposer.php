<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class SeoComposer
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        // Check if the current route has a post model binding
        if ($this->request->route('web.post')) {
            $post = $this->request->route('web.post');

            // Share SEO meta tags with the views
            $view->with('metaTitle', $post->title)
                ->with('metaDescription', $post->meta_description)
                ->with('metaKeywords', $post->meta_keywords);
        } else {
            // Provide default values or handle the case when post is not available
            $view->with('metaTitle', 'Default Title')
                ->with('metaDescription', 'Default description')
                ->with('metaKeywords', 'Default keywords');
        }
    }
}
