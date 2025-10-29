<?php

namespace App\Service\Pages;

use App\Interface\PageInterface;
use App\Repository\EvcCikkRepository;
use App\Service\Modules\LangService;
use App\Service\Modules\ModulService;
use App\Service\Modules\SeoService;
use App\Service\Modules\TextService;
use App\Entity\EvcMenu;
use App\Entity\EvcCikk;

class ArticleService extends SubPageService implements PageInterface
{

    private EvcCikk $cikk;
    public function __construct(
        private readonly SeoService        $seoService,
        private readonly TextService       $textService,
        private readonly LangService       $langService,
        private readonly ModulService      $modulService,
        private readonly EvcCikkRepository $cikkRepo

    ) {
        parent::__construct($seoService,$langService);
    }

    public function getData(EvcMenu $currentPage, $additionalData = []): array
    {
        $this->cikk = $this->cikkRepo->findOneBy(['cikk_id' => $currentPage->getMenuCikkId()]);

        $this->setMeta($currentPage);
        $this->setSchema($currentPage);

        $ajanlat = $this->textService->setText($this->modulService->getModul(15));

        $basicData = [
            'schema' => $this->seoService->getSchema(),
            'meta' => $this->seoService->getMeta(),
            'img' => $this->seoService->getImg(),
            'schemaBreadCrumbs' => $this->seoService->getBreadCrumbs(),
            'content' => $this->textService->setText($this->cikk->getCikkSzoveg()),
            'title' => $this->cikk->getCikkTitle(),
            'ajanlat' => $ajanlat,
            'alias' => $currentPage->getMenuAlias(),
            'fajlnev' => $currentPage->getMenuFajlnev()
        ];

        return array_merge($basicData, $additionalData);

    }

    

    public function setSchema(EvcMenu $currentPage): void
    {
        $schema = json_encode([
            "@context" => "https://schema.org",
            "@type" => "NewsArticle",
            "headline" => $this->seoService->getTitle(),
            "image" => [
                $this->seoService->getImg()
            ],
            "datePublished" => $this->cikk->getCikkDate()?->format('Y-m-d\TH:i:sP'),
            "dateModified" => $this->cikk->getCikkLastMod()?->format('Y-m-d\TH:i:sP')
        ]);

        $this->seoService->setSchema($schema);
    }
}
