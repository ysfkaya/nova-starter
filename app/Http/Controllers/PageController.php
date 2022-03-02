<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\SEO\PageSeo;
use App\Support\PageOptions;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $slug = '/')
    {
        $page = Page::findBySlug($slug);

        $template = $page->template;

        $view = "templates.$template";

        abort_unless(view()->exists($view), 404);

        $options = new PageOptions($page);

        $this->loadSEO(new PageSeo($page, $options));

        return view($view, compact('page', 'options'));
    }
}
