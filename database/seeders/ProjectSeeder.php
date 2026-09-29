<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'SkylerHR',
                'slug' => 'skylerhr',
                'excerpt' => 'Web portal, landing page and social media for a HR talent platform.',
                'body' => '<p>SkylerHR is a portal for companies and talents. We shaped the brand’s digital presence with a clear web intro, a focused landing page, and an Instagram feed that presents the product to the right audience.</p><ul><li>Portal for companies and talents — web intro</li><li>Landing page — web design</li><li>Instagram feed — social media</li></ul>',
                'cover_image' => 'media/skylerhr-cover.webp',
                'client_name' => 'SkylerHR',
                'completed_at' => '2024-03-01',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'MG25CARGO',
                'slug' => 'mg25cargo',
                'excerpt' => 'Social media storytelling and Instagram feeds for a cargo brand.',
                'body' => '<p>MG25CARGO needed a consistent social presence. We built Instagram feed concepts that highlight logistics reliability and keep the brand visible across channels.</p><ul><li>Instagram feed concepts — social media</li><li>Visual storytelling for cargo services</li></ul>',
                'cover_image' => 'media/mg25cargo-cover.webp',
                'client_name' => 'MG25CARGO',
                'completed_at' => '2024-03-15',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Meteo Alarm',
                'slug' => 'meteoalarm',
                'excerpt' => 'Logo, website and social teaser for a weather-alert brand.',
                'body' => '<p>Meteo Alarm combines branding and product communication. We delivered logo design, a website presentation, and an Instagram teaser that introduces the service.</p><ul><li>Logo — design &amp; branding</li><li>Website — web design</li><li>Instagram teaser — social media</li></ul>',
                'cover_image' => 'media/meteoalarm-cover.webp',
                'client_name' => 'Meteo Alarm',
                'completed_at' => '2024-04-01',
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        $galleries = [
            'skylerhr' => [
                ['path' => 'media/skylerhr-1.webp', 'caption' => 'Portal intro for companies and talents'],
                ['path' => 'media/skylerhr-2.webp', 'caption' => 'Landing page design'],
            ],
            'mg25cargo' => [
                ['path' => 'media/mg25cargo-1.webp', 'caption' => 'Instagram feed concept'],
                ['path' => 'media/mg25cargo-2.webp', 'caption' => 'Instagram feed concept'],
            ],
            'meteoalarm' => [
                ['path' => 'media/meteoalarm-1.webp', 'caption' => 'Website presentation'],
                ['path' => 'media/meteoalarm-teaser.mp4', 'poster' => 'media/meteoalarm-teaser.webp', 'caption' => 'Instagram teaser'],
            ],
        ];

        foreach ($projects as $data) {
            $project = Project::query()->updateOrCreate(['slug' => $data['slug']], $data);

            // Only fill an empty gallery, so re-seeding never duplicates or undoes admin edits.
            if ($project->media()->doesntExist()) {
                foreach ($galleries[$project->slug] ?? [] as $order => $media) {
                    $project->media()->create($media + ['sort_order' => $order]);
                }
            }
        }
    }
}
