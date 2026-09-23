<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class OgImageController extends Controller
{
    /**
     * Allowed types for OG image generation
     */
    private const ALLOWED_TYPES = ['default', 'product', 'news', 'career'];
    
    /**
     * Maximum title/subtitle length
     */
    private const MAX_TITLE_LENGTH = 100;
    private const MAX_SUBTITLE_LENGTH = 150;

    /**
     * Generate dynamic Open Graph image
     */
    public function generate(Request $request): Response
    {
        // Sanitize and validate inputs
        $title = $this->sanitizeText($request->input('title', 'PT Visi Yosindo Medikal'), self::MAX_TITLE_LENGTH);
        $subtitle = $this->sanitizeText($request->input('subtitle', 'Solusi Kesehatan Indonesia'), self::MAX_SUBTITLE_LENGTH);
        $type = $this->validateType($request->input('type', 'default'));

        // Generate cache key based on inputs
        $cacheKey = 'og_image_' . md5($title . $subtitle . $type);
        
        // Return cached image if exists (cache for 24 hours)
        $imageData = Cache::remember($cacheKey, 86400, function () use ($title, $subtitle, $type) {
            return $this->generateImageData($title, $subtitle, $type);
        });

        return new Response($imageData, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400, immutable',
            'Content-Disposition' => 'inline; filename="og-image.png"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Sanitize text input
     */
    private function sanitizeText(string $text, int $maxLength): string
    {
        // Remove any potentially harmful characters
        $text = strip_tags($text);
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        
        // Limit length
        if (mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength - 3) . '...';
        }
        
        return $text;
    }

    /**
     * Validate type parameter
     */
    private function validateType(string $type): string
    {
        return in_array($type, self::ALLOWED_TYPES) ? $type : 'default';
    }

    /**
     * Generate image data
     */
    private function generateImageData(string $title, string $subtitle, string $type): string
    {
        // Image dimensions (1200x630 is standard for OG images)
        $width = 1200;
        $height = 630;

        // Create image
        $image = imagecreatetruecolor($width, $height);

        // Enable anti-aliasing
        imageantialias($image, true);

        // Define colors based on type
        $colors = $this->getColors($image, $type);

        // Create gradient background
        $this->createGradientBackground($image, $width, $height, $colors);

        // Add decorative elements
        $this->addDecorativeElements($image, $width, $height, $colors);

        // Add company logo placeholder (circle with text)
        $this->addLogo($image, $colors);

        // Add title text
        $this->addTitle($image, $title, $width, $colors);

        // Add subtitle text
        $this->addSubtitle($image, $subtitle, $width, $colors);

        // Add footer branding
        $this->addFooter($image, $width, $height, $colors);

        // Output image
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();

        // Free memory
        imagedestroy($image);

        return $imageData;
    }

    /**
     * Get color scheme based on type
     */
    private function getColors($image, string $type): array
    {
        $schemes = [
            'default' => [
                'bg_start' => [15, 23, 42],      // slate-900
                'bg_end' => [30, 41, 59],        // slate-800
                'primary' => [59, 130, 246],     // blue-500
                'secondary' => [6, 182, 212],    // cyan-500
                'text' => [255, 255, 255],       // white
                'text_muted' => [148, 163, 184], // slate-400
                'accent' => [99, 102, 241],      // indigo-500
            ],
            'product' => [
                'bg_start' => [15, 23, 42],
                'bg_end' => [30, 58, 138],       // blue-900
                'primary' => [59, 130, 246],
                'secondary' => [147, 197, 253],  // blue-300
                'text' => [255, 255, 255],
                'text_muted' => [191, 219, 254], // blue-200
                'accent' => [96, 165, 250],      // blue-400
            ],
            'news' => [
                'bg_start' => [15, 23, 42],
                'bg_end' => [55, 48, 163],       // indigo-800
                'primary' => [129, 140, 248],    // indigo-400
                'secondary' => [165, 180, 252],  // indigo-300
                'text' => [255, 255, 255],
                'text_muted' => [199, 210, 254], // indigo-200
                'accent' => [99, 102, 241],
            ],
            'career' => [
                'bg_start' => [15, 23, 42],
                'bg_end' => [21, 94, 117],       // cyan-800
                'primary' => [34, 211, 238],     // cyan-400
                'secondary' => [103, 232, 249],  // cyan-300
                'text' => [255, 255, 255],
                'text_muted' => [165, 243, 252], // cyan-200
                'accent' => [6, 182, 212],
            ],
        ];

        $scheme = $schemes[$type] ?? $schemes['default'];

        return [
            'bg_start' => imagecolorallocate($image, ...$scheme['bg_start']),
            'bg_end' => imagecolorallocate($image, ...$scheme['bg_end']),
            'primary' => imagecolorallocate($image, ...$scheme['primary']),
            'secondary' => imagecolorallocate($image, ...$scheme['secondary']),
            'text' => imagecolorallocate($image, ...$scheme['text']),
            'text_muted' => imagecolorallocate($image, ...$scheme['text_muted']),
            'accent' => imagecolorallocate($image, ...$scheme['accent']),
            'raw' => $scheme,
        ];
    }

    /**
     * Create gradient background
     */
    private function createGradientBackground($image, int $width, int $height, array $colors): void
    {
        $raw = $colors['raw'];
        
        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            
            $r = (int)($raw['bg_start'][0] + ($raw['bg_end'][0] - $raw['bg_start'][0]) * $ratio);
            $g = (int)($raw['bg_start'][1] + ($raw['bg_end'][1] - $raw['bg_start'][1]) * $ratio);
            $b = (int)($raw['bg_start'][2] + ($raw['bg_end'][2] - $raw['bg_start'][2]) * $ratio);
            
            $color = imagecolorallocate($image, $r, $g, $b);
            imageline($image, 0, $y, $width, $y, $color);
        }
    }

    /**
     * Add decorative elements
     */
    private function addDecorativeElements($image, int $width, int $height, array $colors): void
    {
        // Add transparent circles for decoration
        $circleColor = imagecolorallocatealpha($image, 
            $colors['raw']['primary'][0], 
            $colors['raw']['primary'][1], 
            $colors['raw']['primary'][2], 
            100 // 78% transparent
        );

        // Large circle on right
        imagefilledellipse($image, $width - 100, $height - 100, 400, 400, $circleColor);
        
        // Medium circle on top left
        imagefilledellipse($image, 100, 100, 200, 200, $circleColor);

        // Accent line at bottom
        $lineColor = imagecolorallocatealpha($image, 
            $colors['raw']['secondary'][0], 
            $colors['raw']['secondary'][1], 
            $colors['raw']['secondary'][2], 
            80
        );
        imagefilledrectangle($image, 0, $height - 8, $width, $height, $lineColor);

        // Gradient accent bar at bottom
        for ($x = 0; $x < $width; $x++) {
            $ratio = $x / $width;
            $r = (int)($colors['raw']['primary'][0] * (1 - $ratio) + $colors['raw']['secondary'][0] * $ratio);
            $g = (int)($colors['raw']['primary'][1] * (1 - $ratio) + $colors['raw']['secondary'][1] * $ratio);
            $b = (int)($colors['raw']['primary'][2] * (1 - $ratio) + $colors['raw']['secondary'][2] * $ratio);
            
            $gradientColor = imagecolorallocate($image, $r, $g, $b);
            imageline($image, $x, $height - 6, $x, $height, $gradientColor);
        }
    }

    /**
     * Add logo placeholder
     */
    private function addLogo($image, array $colors): void
    {
        $logoX = 80;
        $logoY = 80;
        $logoSize = 60;

        // Draw logo circle
        imagefilledellipse($image, $logoX, $logoY, $logoSize, $logoSize, $colors['primary']);
        
        // Add "VY" text in logo
        $fontPath = $this->getFontPath();
        if ($fontPath) {
            imagettftext($image, 18, 0, $logoX - 15, $logoY + 7, $colors['text'], $fontPath, 'VY');
        }

        // Company name next to logo
        if ($fontPath) {
            imagettftext($image, 20, 0, $logoX + 45, $logoY + 7, $colors['text'], $fontPath, 'PT Visi Yosindo Medikal');
        }
    }

    /**
     * Add title text
     */
    private function addTitle($image, string $title, int $width, array $colors): void
    {
        $fontPath = $this->getFontPath('bold');
        if (!$fontPath) {
            // Fallback to built-in font
            $title = mb_substr($title, 0, 40);
            imagestring($image, 5, 80, 250, $title, $colors['text']);
            return;
        }

        // Calculate font size based on title length
        $maxWidth = $width - 160;
        $fontSize = 56;
        
        // Wrap text if too long
        $lines = $this->wrapText($title, $fontPath, $fontSize, $maxWidth);
        
        $y = 280;
        $lineHeight = 70;
        
        foreach ($lines as $line) {
            imagettftext($image, $fontSize, 0, 80, $y, $colors['text'], $fontPath, $line);
            $y += $lineHeight;
        }
    }

    /**
     * Add subtitle text
     */
    private function addSubtitle($image, string $subtitle, int $width, array $colors): void
    {
        $fontPath = $this->getFontPath();
        if (!$fontPath) {
            imagestring($image, 4, 80, 380, $subtitle, $colors['text_muted']);
            return;
        }

        imagettftext($image, 24, 0, 80, 420, $colors['text_muted'], $fontPath, $subtitle);
    }

    /**
     * Add footer branding
     */
    private function addFooter($image, int $width, int $height, array $colors): void
    {
        $fontPath = $this->getFontPath();
        if (!$fontPath) {
            return;
        }

        $footerText = 'visiyosindo.com';
        $fontSize = 18;
        
        // Calculate text width for right alignment
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $footerText);
        $textWidth = $bbox[2] - $bbox[0];
        
        imagettftext($image, $fontSize, 0, $width - $textWidth - 80, $height - 50, $colors['text_muted'], $fontPath, $footerText);

        // Add "Solusi Kesehatan Indonesia" tagline
        $tagline = 'Solusi Kesehatan Indonesia';
        imagettftext($image, 16, 0, 80, $height - 50, $colors['secondary'], $fontPath, $tagline);
    }

    /**
     * Get font path
     */
    private function getFontPath(string $weight = 'regular'): ?string
    {
        // Try to use system fonts
        $fonts = [
            'bold' => [
                '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
                '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
                'C:\Windows\Fonts\arialbd.ttf',
                'C:\Windows\Fonts\segoeui.ttf',
            ],
            'regular' => [
                '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
                '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
                'C:\Windows\Fonts\arial.ttf',
                'C:\Windows\Fonts\segoeui.ttf',
            ],
        ];

        foreach ($fonts[$weight] ?? $fonts['regular'] as $font) {
            if (file_exists($font)) {
                return $font;
            }
        }

        // Try public fonts directory
        $publicFont = public_path('fonts/inter-' . $weight . '.ttf');
        if (file_exists($publicFont)) {
            return $publicFont;
        }

        return null;
    }

    /**
     * Wrap text to fit within max width
     */
    private function wrapText(string $text, string $fontPath, int $fontSize, int $maxWidth): array
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine ? $currentLine . ' ' . $word : $word;
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $testLine);
            $testWidth = $bbox[2] - $bbox[0];

            if ($testWidth > $maxWidth && $currentLine) {
                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }

        if ($currentLine) {
            $lines[] = $currentLine;
        }

        return array_slice($lines, 0, 3); // Max 3 lines
    }

    /**
     * Generate SVG-based OG image (alternative method)
     */
    public function generateSvg(Request $request): Response
    {
        // Sanitize and validate inputs
        $title = $this->sanitizeText($request->input('title', 'PT Visi Yosindo Medikal'), self::MAX_TITLE_LENGTH);
        $subtitle = $this->sanitizeText($request->input('subtitle', 'Solusi Kesehatan Indonesia'), self::MAX_SUBTITLE_LENGTH);
        $type = $this->validateType($request->input('type', 'default'));

        $colors = $this->getSvgColors($type);

        $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg width="1200" height="630" viewBox="0 0 1200 630" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="bgGradient" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{$colors['bg_start']};stop-opacity:1" />
      <stop offset="100%" style="stop-color:{$colors['bg_end']};stop-opacity:1" />
    </linearGradient>
    <linearGradient id="accentGradient" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" style="stop-color:{$colors['primary']};stop-opacity:1" />
      <stop offset="100%" style="stop-color:{$colors['secondary']};stop-opacity:1" />
    </linearGradient>
  </defs>
  
  <!-- Background -->
  <rect width="1200" height="630" fill="url(#bgGradient)"/>
  
  <!-- Decorative circles -->
  <circle cx="1100" cy="530" r="200" fill="{$colors['primary']}" opacity="0.1"/>
  <circle cx="100" cy="100" r="100" fill="{$colors['secondary']}" opacity="0.1"/>
  <circle cx="900" cy="150" r="80" fill="{$colors['primary']}" opacity="0.05"/>
  
  <!-- Accent bar at bottom -->
  <rect x="0" y="624" width="1200" height="6" fill="url(#accentGradient)"/>
  
  <!-- Logo circle -->
  <circle cx="80" cy="80" r="30" fill="{$colors['primary']}"/>
  <text x="80" y="88" font-family="Arial, sans-serif" font-size="20" font-weight="bold" fill="white" text-anchor="middle">VY</text>
  
  <!-- Company name -->
  <text x="125" y="88" font-family="Arial, sans-serif" font-size="20" fill="white">PT Visi Yosindo Medikal</text>
  
  <!-- Main title -->
  <text x="80" y="300" font-family="Arial, sans-serif" font-size="56" font-weight="bold" fill="white">{$title}</text>
  
  <!-- Subtitle -->
  <text x="80" y="380" font-family="Arial, sans-serif" font-size="24" fill="{$colors['text_muted']}">{$subtitle}</text>
  
  <!-- Footer tagline -->
  <text x="80" y="580" font-family="Arial, sans-serif" font-size="16" fill="{$colors['secondary']}">Solusi Kesehatan Indonesia</text>
  
  <!-- Footer website -->
  <text x="1120" y="580" font-family="Arial, sans-serif" font-size="16" fill="{$colors['text_muted']}" text-anchor="end">visiyosindo.com</text>
</svg>
SVG;

        return new Response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=86400, immutable',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Security-Policy' => "default-src 'none'; style-src 'unsafe-inline'",
        ]);
    }

    /**
     * Get SVG color scheme
     */
    private function getSvgColors(string $type): array
    {
        $schemes = [
            'default' => [
                'bg_start' => '#0f172a',
                'bg_end' => '#1e293b',
                'primary' => '#3b82f6',
                'secondary' => '#06b6d4',
                'text_muted' => '#94a3b8',
            ],
            'product' => [
                'bg_start' => '#0f172a',
                'bg_end' => '#1e3a8a',
                'primary' => '#3b82f6',
                'secondary' => '#93c5fd',
                'text_muted' => '#bfdbfe',
            ],
            'news' => [
                'bg_start' => '#0f172a',
                'bg_end' => '#3730a3',
                'primary' => '#818cf8',
                'secondary' => '#a5b4fc',
                'text_muted' => '#c7d2fe',
            ],
            'career' => [
                'bg_start' => '#0f172a',
                'bg_end' => '#155e75',
                'primary' => '#22d3ee',
                'secondary' => '#67e8f9',
                'text_muted' => '#a5f3fc',
            ],
        ];

        return $schemes[$type] ?? $schemes['default'];
    }
}
