<?php

namespace App\Services;

class ContentFilterService
{
    /**
     * List of profanity words (Indonesian & English)
     */
    private array $profanityWords = [
        // Indonesian profanity
        'anjing', 'babi', 'bangsat', 'bajingan', 'brengsek', 'kampret', 'tolol', 'bodoh',
        'goblok', 'idiot', 'tai', 'pepek', 'memek', 'kontol', 'ngentot', 'jancok', 'asu',
        'kimak', 'monyet', 'perek', 'lonte', 'jablay', 'cocot', 'coli', 'colmek',
        // English profanity
        'fuck', 'shit', 'bitch', 'ass', 'damn', 'bastard', 'dick', 'pussy', 'cock',
    ];

    /**
     * Gambling keywords
     */
    private array $gamblingWords = [
        'judi', 'judol', 'slot', 'casino', 'poker', 'betting', 'taruhan', 'togel',
        'bandar', 'jackpot', 'maxwin', 'gacor', 'rtp', 'scatter', 'bonus new member',
        'deposit', 'withdraw', 'betting online', 'sportsbook', 'live casino', 'pragmatic',
        'joker123', 'habanero', 'slot88', 'gates of olympus', 'sweet bonanza',
    ];

    /**
     * Pornography keywords
     */
    private array $pornographyWords = [
        'porn', 'porno', 'pornografi', 'sex', 'seks', 'bokep', 'video panas',
        'xxx', 'dewasa', 'telanjang', 'bugil', 'naked', 'nude', 'hot video',
        'ngentot', 'colmek', 'coli', 'onlyfans', 'webcam', 'live show',
    ];

    /**
     * Spam patterns
     */
    private array $spamPatterns = [
        // URLs with suspicious patterns
        '/https?:\/\/(www\.)?(bit\.ly|tinyurl|goo\.gl)/i',
        // Multiple URLs
        '/(https?:\/\/[^\s]+.*){3,}/',
        // Excessive caps (more than 50% uppercase in words longer than 5 chars)
        '/\b[A-Z]{6,}\b/',
        // Repetitive characters
        '/(.)\1{4,}/',
        // Common spam phrases
        '/\b(click here|klik disini|daftar sekarang|promo|free money)\b/i',
        '/\b(cuan|untung besar|deposit|withdraw|bonus)\b/i',
    ];

    /**
     * Check if text is clean (no profanity, gambling, or pornography)
     */
    public function isClean(string $text): bool
    {
        $lowerText = strtolower($text);

        // Check profanity
        foreach ($this->profanityWords as $word) {
            if (stripos($lowerText, $word) !== false) {
                return false;
            }
        }

        // Check gambling
        foreach ($this->gamblingWords as $word) {
            if (stripos($lowerText, $word) !== false) {
                return false;
            }
        }

        // Check pornography
        foreach ($this->pornographyWords as $word) {
            if (stripos($lowerText, $word) !== false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check message for spam patterns and inappropriate content
     * Returns detailed result with reason
     */
    public function checkMessage(string $message): array
    {
        $lowerMessage = strtolower($message);

        // Check profanity
        foreach ($this->profanityWords as $word) {
            if (stripos($lowerMessage, $word) !== false) {
                return [
                    'is_clean' => false,
                    'reason' => 'kata-kata kasar/tidak pantas',
                    'type' => 'profanity'
                ];
            }
        }

        // Check gambling
        foreach ($this->gamblingWords as $word) {
            if (stripos($lowerMessage, $word) !== false) {
                return [
                    'is_clean' => false,
                    'reason' => 'konten terkait perjudian',
                    'type' => 'gambling'
                ];
            }
        }

        // Check pornography
        foreach ($this->pornographyWords as $word) {
            if (stripos($lowerMessage, $word) !== false) {
                return [
                    'is_clean' => false,
                    'reason' => 'konten pornografi',
                    'type' => 'pornography'
                ];
            }
        }

        // Check spam patterns
        foreach ($this->spamPatterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return [
                    'is_clean' => false,
                    'reason' => 'pola spam terdeteksi',
                    'type' => 'spam'
                ];
            }
        }

        // Check for excessive URLs (more than 2)
        $urlCount = preg_match_all('/https?:\/\/[^\s]+/', $message);
        if ($urlCount > 2) {
            return [
                'is_clean' => false,
                'reason' => 'terlalu banyak link',
                'type' => 'spam'
            ];
        }

        // All checks passed
        return [
            'is_clean' => true,
            'reason' => null,
            'type' => null
        ];
    }

    /**
     * Clean text by replacing inappropriate words with asterisks (optional sanitizer)
     */
    public function sanitize(string $text): string
    {
        $allBadWords = array_merge(
            $this->profanityWords,
            $this->gamblingWords,
            $this->pornographyWords
        );

        foreach ($allBadWords as $word) {
            $replacement = str_repeat('*', strlen($word));
            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', $replacement, $text);
        }

        return $text;
    }
}
