<?php declare(strict_types=1);

namespace FriendsOfHyva\PreloadImages\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use function array_filter as filter;
use function array_unique as unique;
use function array_values as values;

class PreloadImages implements ArgumentInterface
{
    private $urls = [];

    public function add(string $imageUrl): self
    {
        $this->urls[] = $imageUrl;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getUrls(): array
    {
        return values(unique(filter($this->urls)));
    }
}
