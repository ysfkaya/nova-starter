<?php

namespace App\SEO;

use App\Models\Page;
use App\Support\PageOptions;
use Artesaos\SEOTools\Contracts\SEOFriendly;
use Artesaos\SEOTools\Contracts\SEOTools;
use Illuminate\Support\Str;

class PageSeo implements SEOFriendly
{
    public function __construct(
        public Page $page,
        public PageOptions $options
    ) {
    }

    /**
     * Performs SEO settings.
     *
     * @param SEOTools $seo
     */
    public function loadSEO(SEOTools $seo): void
    {
        $description = $this->options->seo['description'] ?? Str::limit(strip_tags($this->page->body), 160, '...');

        $description = str_replace(['&nbsp;'], '', $description);

        $seo->setTitle($this->options->seo['title'] ?? $this->page->title)
            ->setDescription(trim($description))
            ->setCanonical($this->page->url);
    }
}
