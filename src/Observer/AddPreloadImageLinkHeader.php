<?php declare(strict_types=1);

namespace FriendsOfHyva\PreloadImages\Observer;

use FriendsOfHyva\PreloadImages\ViewModel\PreloadImages;
use Magento\Framework\App\Response\HttpInterface as HttpResponse;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;
use function array_map as map;

class AddPreloadImageLinkHeader implements ObserverInterface
{
    /**
     * @var PreloadImages
     */
    private $preloadImages;

    public function __construct(PreloadImages $preloadImages)
    {
        $this->preloadImages = $preloadImages;
    }

    public function execute(Event $event)
    {
        /** @var HttpResponse $response */
        $response = $event->getData('response');

        $resources = $this->preloadImages->getUrls();
        if ($resources) {
            $resourceLinks = map([$this, 'preloadImageValue'], $resources);
            $response->setHeader('link', implode(',', $resourceLinks));
        }
    }

    private function preloadImageValue(string $url): string
    {
        return "<$url>; rel=preload; as=image; nopush";
    }
}
