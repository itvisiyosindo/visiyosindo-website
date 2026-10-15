<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure partners directory exists
        $directory = storage_path('app/public/partners');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Create dummy partner logos (using placeholder images)
        $partners = [
            ['name' => 'Siemens Healthineers', 'order' => 1, 'url' => 'https://www.siemens-healthineers.com'],
            ['name' => 'GE Healthcare', 'order' => 2, 'url' => 'https://www.gehealthcare.com'],
            ['name' => 'Philips Healthcare', 'order' => 3, 'url' => 'https://www.philips.com/healthcare'],
            ['name' => 'Medtronic', 'order' => 4, 'url' => 'https://www.medtronic.com'],
            ['name' => 'Johnson & Johnson', 'order' => 5, 'url' => 'https://www.jnj.com'],
            ['name' => 'Abbott Laboratories', 'order' => 6, 'url' => 'https://www.abbott.com'],
            ['name' => 'Boston Scientific', 'order' => 7, 'url' => 'https://www.bostonscientific.com'],
            ['name' => 'Stryker Corporation', 'order' => 8, 'url' => 'https://www.stryker.com'],
            ['name' => 'Baxter International', 'order' => 9, 'url' => 'https://www.baxter.com'],
            ['name' => 'Becton Dickinson', 'order' => 10, 'url' => 'https://www.bd.com'],
            ['name' => 'Cardinal Health', 'order' => 11, 'url' => 'https://www.cardinalhealth.com'],
            ['name' => 'McKesson Corporation', 'order' => 12, 'url' => 'https://www.mckesson.com'],
            ['name' => 'Olympus Medical', 'order' => 13, 'url' => 'https://www.olympus-global.com/medical'],
            ['name' => 'Fresenius Medical Care', 'order' => 14, 'url' => 'https://www.freseniusmedicalcare.com'],
            ['name' => 'B. Braun Melsungen', 'order' => 15, 'url' => 'https://www.bbraun.com'],
            ['name' => 'Zimmer Biomet', 'order' => 16, 'url' => 'https://www.zimmerbiomet.com'],
        ];

        foreach ($partners as $partnerData) {
            // Create a simple SVG logo placeholder
            $svg = $this->createLogoSvg($partnerData['name']);
            $fileName = 'partner-' . str_replace(' ', '-', strtolower($partnerData['name'])) . '.svg';
            $filePath = $directory . '/' . $fileName;
            
            File::put($filePath, $svg);

            Partner::create([
                'name' => $partnerData['name'],
                'logo_path' => 'partners/' . $fileName,
                'website_url' => $partnerData['url'],
                'description' => 'Trusted partner in healthcare solutions',
                'display_order' => $partnerData['order'],
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Created ' . count($partners) . ' partner records with logos!');
    }

    /**
     * Create a simple SVG logo placeholder
     */
    private function createLogoSvg(string $name): string
    {
        // Get initials from name (max 3 letters)
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            if (strlen($initials) < 3) {
                $initials .= substr($word, 0, 1);
            }
        }
        $initials = strtoupper(substr($initials, 0, 3));

        // Generate a color based on name
        $hash = md5($name);
        $hue = hexdec(substr($hash, 0, 2)) % 360;
        
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 80" width="200" height="80">
  <rect width="200" height="80" fill="hsl({$hue}, 70%, 95%)"/>
  <text x="100" y="50" font-family="Arial, sans-serif" font-size="24" font-weight="bold" 
        fill="hsl({$hue}, 70%, 40%)" text-anchor="middle" dominant-baseline="middle">
    {$initials}
  </text>
</svg>
SVG;
    }
}

