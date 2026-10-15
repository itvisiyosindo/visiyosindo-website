<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Models\JobVacancy;

class ApplicationScreeningService
{
    /**
     * Perform auto-screening for a job application
     * 
     * @param JobApplication $application
     * @return array Match scores and details
     */
    public function screenApplication(JobApplication $application): array
    {
        $vacancy = $application->vacancy;
        
        $educationScore = $this->calculateEducationMatch($application->education, $vacancy->education);
        $majorScore = $this->calculateMajorMatch($application->major, $vacancy->requirements);
        $skillScore = $this->calculateSkillMatch($application, $vacancy);
        $experienceScore = $this->calculateExperienceMatch($application->work_experience, $vacancy->experience);
        
        // Calculate weighted overall score
        $overallScore = (
            $educationScore * 0.25 +    // 25% weight
            $majorScore * 0.30 +         // 30% weight
            $skillScore * 0.30 +         // 30% weight
            $experienceScore * 0.15      // 15% weight
        );
        
        $details = [
            'education_breakdown' => $this->getEducationBreakdown($application->education, $vacancy->education),
            'major_keywords' => $this->extractMajorKeywords($application->major),
            'matched_skills' => $this->getMatchedSkills($application, $vacancy),
            'missing_skills' => $this->getMissingSkills($application, $vacancy),
            'experience_years' => $this->extractExperienceYears($application->work_experience),
            'recommendation' => $this->getRecommendation($overallScore),
            'screening_timestamp' => now()->toIso8601String(),
        ];
        
        return [
            'match_score' => round(min(100, max(0, $overallScore)), 2),
            'education_match' => round($educationScore, 2),
            'major_match' => round($majorScore, 2),
            'skill_match' => round($skillScore, 2),
            'experience_match' => round($experienceScore, 2),
            'screening_details' => $details,
            'screened_at' => now(),
            'recommendation' => $this->getRecommendation($overallScore),
        ];
    }
    
    /**
     * Calculate education level match
     */
    protected function calculateEducationMatch(string $applicantEd, ?string $requiredEd): float
    {
        if (!$requiredEd) return 100.0;
        
        $levels = ['SMA', 'D3', 'S1', 'S2', 'S3'];
        $applicantLevel = array_search(strtoupper($applicantEd), $levels);
        $requiredLevel = array_search(strtoupper($requiredEd), $levels);
        
        if ($applicantLevel === false || $requiredLevel === false) return 50.0;
        
        if ($applicantLevel >= $requiredLevel) {
            return 100.0;
        } else {
            $diff = $requiredLevel - $applicantLevel;
            return max(0, 100 - ($diff * 30)); // -30 points per level below
        }
    }
    
    /**
     * Calculate major/field of study match
     */
    protected function calculateMajorMatch(string $major, ?array $requirements): float
    {
        if (!$requirements || empty($requirements)) return 75.0;
        
        $major = strtolower($major);
        $matchCount = 0;
        $totalRequirements = 0;
        
        // Common major keywords with synonyms
        $majorKeywords = [
            'teknik informatika' => ['informatika', 'computer science', 'it', 'sistem informasi', 'software engineering', 'programming'],
            'akuntansi' => ['accounting', 'finance', 'keuangan', 'ekonomi'],
            'manajemen' => ['management', 'bisnis', 'administrasi'],
            'teknik' => ['engineering', 'mesin', 'elektro', 'sipil'],
            'kedokteran' => ['medical', 'kesehatan', 'keperawatan', 'farmasi'],
            'kimia' => ['chemistry', 'biokimia', 'farmasi'],
        ];
        
        foreach ($requirements as $req) {
            $req = strtolower(trim((string) $req));
            if ($req === '') {
                continue;
            }

            $totalRequirements++;
            
            // Direct match
            if (str_contains($major, $req) || str_contains($req, $major)) {
                $matchCount++;
                continue;
            }
            
            // Synonym match
            foreach ($majorKeywords as $baseKeyword => $synonyms) {
                if (str_contains($major, $baseKeyword) || str_contains($req, $baseKeyword)) {
                    foreach ($synonyms as $synonym) {
                        if (str_contains($major, $synonym) || str_contains($req, $synonym)) {
                            $matchCount++;
                            break 2;
                        }
                    }
                }
            }
        }

        if ($totalRequirements === 0) {
            return 75.0;
        }

        if ($matchCount === 0) {
            return 0.0;
        }

        return min(100.0, ($matchCount / $totalRequirements) * 100);
    }
    
    /**
     * Calculate skills match
     */
    protected function calculateSkillMatch(JobApplication $application, JobVacancy $vacancy): float
    {
        $requiredSkills = $vacancy->skills ?? [];
        if (empty($requiredSkills)) return 85.0;
        
        // Extract skills from work experience and other fields
        $applicantText = strtolower(
            ($application->work_experience ?? '') . ' ' . 
            ($application->major ?? '') . ' ' .
            ($application->last_job ?? '')
        );
        
        $matchedCount = 0;
        foreach ($requiredSkills as $skill) {
            if (str_contains($applicantText, strtolower($skill))) {
                $matchedCount++;
            }
        }
        
        if (count($requiredSkills) === 0) return 85.0;
        
        return ($matchedCount / count($requiredSkills)) * 100;
    }
    
    /**
     * Calculate experience match
     */
    protected function calculateExperienceMatch(?string $workExperience, ?string $requiredExperience): float
    {
        $applicantYears = $this->parseExperienceYears($workExperience);
        $requiredYears = $this->parseExperienceYears($requiredExperience);

        if (!$requiredExperience || $requiredYears === 0) {
            return $applicantYears === 0 ? 100.0 : 90.0;
        }

        if ($applicantYears === null) {
            $applicantYears = $this->extractExperienceYears($workExperience);
        }

        if ($applicantYears === null) {
            return 70.0;
        }

        if ($applicantYears >= $requiredYears) {
            return 100.0;
        }

        $gap = $requiredYears - $applicantYears;
        return max(35.0, 100 - ($gap * 20));
    }
    
    /**
     * Extract estimated experience years from text
     */
    protected function extractExperienceYears(?string $text): int
    {
        if (!$text) return 0;

        $parsedYears = $this->parseExperienceYears($text);
        if ($parsedYears !== null) {
            return $parsedYears;
        }
        
        // Look for explicit year mentions
        if (preg_match('/(\d+)\s*(tahun|year|th)/i', $text, $matches)) {
            return (int) $matches[1];
        }
        
        // Estimate from text length (rough heuristic)
        $wordCount = str_word_count($text);
        if ($wordCount > 100) return 3;
        if ($wordCount > 50) return 2;
        if ($wordCount > 20) return 1;
        
        return 0;
    }

    protected function parseExperienceYears(?string $value): ?int
    {
        if (!$value) {
            return null;
        }

        $normalized = strtolower(trim($value));

        return match (true) {
            $normalized === 'fresh',
            $normalized === 'fresh graduate',
            str_contains($normalized, 'fresh graduate') => 0,
            $normalized === '1-2' => 1,
            $normalized === '2-5' => 2,
            $normalized === '5-10' => 5,
            $normalized === '10+' => 10,
            preg_match('/(\d+)\s*-\s*(\d+)/', $normalized, $matches) === 1 => (int) $matches[1],
            preg_match('/(\d+)\s*\+/', $normalized, $matches) === 1 => (int) $matches[1],
            preg_match('/(\d+)\s*(tahun|year|th)/i', $normalized, $matches) === 1 => (int) $matches[1],
            default => null,
        };
    }
    
    protected function getEducationBreakdown(string $applicantEd, ?string $requiredEd): array
    {
        return [
            'applicant' => $applicantEd,
            'required' => $requiredEd ?? 'Tidak disebutkan',
            'meets_requirement' => $this->calculateEducationMatch($applicantEd, $requiredEd) >= 100,
        ];
    }
    
    protected function extractMajorKeywords(string $major): array
    {
        $words = explode(' ', strtolower($major));
        return array_filter($words, fn($w) => strlen($w) > 3);
    }
    
    protected function getMatchedSkills(JobApplication $application, JobVacancy $vacancy): array
    {
        $requiredSkills = $vacancy->skills ?? [];
        $applicantText = strtolower(
            ($application->work_experience ?? '') . ' ' . 
            ($application->major ?? '')
        );
        
        $matched = [];
        foreach ($requiredSkills as $skill) {
            if (str_contains($applicantText, strtolower($skill))) {
                $matched[] = $skill;
            }
        }
        
        return $matched;
    }
    
    protected function getMissingSkills(JobApplication $application, JobVacancy $vacancy): array
    {
        $matched = $this->getMatchedSkills($application, $vacancy);
        $required = $vacancy->skills ?? [];
        
        return array_values(array_diff($required, $matched));
    }
    
    protected function getRecommendation(float $score): string
    {
        if ($score >= 80) return 'highly_recommended';
        if ($score >= 65) return 'recommended';
        if ($score >= 50) return 'consider';
        return 'not_recommended';
    }
    
    /**
     * Get recommendation badge HTML class
     */
    public static function getRecommendationBadge(string $recommendation): array
    {
        return match($recommendation) {
            'highly_recommended' => [
                'label' => 'Sangat Direkomendasikan',
                'class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                'icon' => '🌟'
            ],
            'recommended' => [
                'label' => 'Direkomendasikan',
                'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                'icon' => '✓'
            ],
            'consider' => [
                'label' => 'Pertimbangkan',
                'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                'icon' => '⚠'
            ],
            default => [
                'label' => 'Tidak Direkomendasikan',
                'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                'icon' => '○'
            ],
        };
    }
}
