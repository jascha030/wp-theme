<?php

namespace Jascha030\WpTheme\Service;

use Symfony\Component\Finder\SplFileInfo;

class ViteService
{
    private const SCRIPT_TAG_ADDITIONS = [
        'entry' => 'type="module" crossorigin',
        'import' => 'rel="modulepreload"',
    ];

    private string $entry;

    private \SplFileInfo $manifestFileInfo;

    private array $manifest;

    public function __construct(string $entry)
    {
        $this->entry = $entry;
    }

    final public function hookMethods(): void
    {
        \add_filter('script_loader_tag', [$this, 'scriptLoaderEntryFilters'], 10);
        \add_action('wp_enqueue_scripts', [$this, 'enqueueMainScript'], 10);
        \add_action('wp_enqueue_scripts', [$this, 'enqueuePreload'], 20);
        \add_action('wp_enqueue_scripts', [$this, 'enqueueStyles'], 30);
    }

    /**
     * @throws \JsonException
     */
    final public function enqueueMainScript(): void
    {
        $manifest = $this->getManifest();

        if (!isset($manifest[$this->entry])) {
            return;
        }

        $src = $this->getAssetUrl($manifest[$this->entry]['file']);

        \wp_enqueue_script('__wps_vite_service_entry_' . $this->entry, $src, [], time());
    }

    /**
     * @throws \JsonException
     */
    final public function enqueuePreload(): void
    {
        $manifest = $this->getManifest();

        if (empty($manifest[$this->entry]['imports'])) {
            return;
        }

        foreach ($manifest[$this->entry]['imports'] as $imports) {
            $file = $manifest[$imports]['file'];
            $src  = $this->getAssetUrl($file);

            \wp_enqueue_script('__wp_vite_service_import_' . $file, $src, [], time());
        }
    }

    /**
     * @throws \JsonException
     */
    final public function enqueueStyles(): void
    {
        $manifest = $this->getManifest();

        if (empty($manifest[$this->entry]['css'])) {
            return;
        }

        foreach ($manifest[$this->entry]['css'] as $file) {
            $src    = $this->getAssetUrl($file);
            $handle = basename($src, '.css');

            \wp_enqueue_style($handle, $src, [], time());
        }
    }

    final public function scriptLoaderEntryFilters(string $tag, string $handle, string $src): string
    {
        foreach (self::SCRIPT_TAG_ADDITIONS as $prefixKey => $addition) {
            if (strpos($handle, "__wps_vite_service_{$prefixKey}_") !== false) {
                return sprintf('<script id="%s" %s src="%s" />', $handle, $addition, esc_url($src));
            }
        }

        return $tag;
    }

    /**
     * @throws \JsonException
     */
    private function getManifest(): array
    {
        if (!isset($this->manifest)) {
            $file = $this->getManifestFileInfo();

            $this->manifest = \json_decode(
                $file->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        }

        return $this->manifest;
    }

    private function getManifestFileInfo(): SplFileInfo
    {
        if (!isset($this->manifestFileInfo)) {
            $this->manifestFileInfo = new SplFileInfo(\get_template_directory() . '/dist/manifest.json');
        }

        return $this->manifestFileInfo;
    }

    private function getAssetUrl(string $fileName): string
    {
        return \get_template_directory_uri() . '/dist/' . $fileName;
    }
}
