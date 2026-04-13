<?php

namespace app\components;

use yii\i18n\Formatter;

class CdnFormatter extends Formatter
{
    /**
     * Format an S3 URL to use the CDN domain
     * Converts: https://nyc3.digitaloceanspaces.com/auditiva/carousel/slide-1.jpg
     * To: https://cdn.auditiva.us/carousel/slide-1.jpg
     * 
     * @param string $url The S3 URL
     * @param string $cdnDomain The CDN domain (defaults to cdn.auditiva.us)
     * @return string The CDN URL
     */
    public function asS3Url($url, $cdnDomain = 'https://cdn.auditiva.us')
    {
        if (empty($url)) {
            return '';
        }

        // If it's already a CDN URL, return as-is
        if (strpos($url, 'cdn.auditiva.us') !== false) {
            return $url;
        }

        // If it's an S3 URL, extract the path and prepend CDN domain
        if (preg_match('#^https?://[^/]+/[^/]+/(.+)$#', $url, $matches)) {
            return $cdnDomain . '/' . $matches[1];
        }

        // If it's already just a path, prepend CDN domain
        if (strpos($url, 'http') !== 0) {
            // remove '../media/' if present
            $url = str_replace('../media/', '', $url);
            return $cdnDomain . '/' . ltrim($url, '/');
        }

        // Return original URL if we can't parse it
        return $url;
    }
}
