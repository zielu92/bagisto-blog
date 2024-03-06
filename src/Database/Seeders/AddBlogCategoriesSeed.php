<?php

namespace Mziel\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Core\Models\Channel;
use Illuminate\Support\Facades\Log;
use Mziel\Blog\Repositories\BlogCategoryRepository;

class AddBlogCategoriesSeed extends Seeder
{
    public function __construct(protected BlogCategoryRepository $blogCategoryRepository)
    {

    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channelsIDs = Channel::all()->pluck('id');

        $exampleCategoreis = [
            [
                'title' => 'Health & Wellness',
                'channels' => $channelsIDs,
                'meta_title' => 'Health & Wellness',
                'slug' => 'Health-Wellness',
                'meta_keywords' => 'Health, Wellness',
                'meta_description' => 'This category covers topics related to physical and mental health, including fitness tips, nutrition advice, mindfulness practices, stress management techniques, and personal development strategies.'
            ],
            [
                'title' => 'Lifestyle & Culture',
                'channels' => $channelsIDs,
                'meta_title' => 'Lifestyle & Culture',
                'slug' => 'Lifestyle-Culture',
                'meta_keywords' => 'Lifestyle, Culture',
                'meta_description' => 'Here, readers can explore a wide range of topics related to lifestyle choices, cultural trends, travel experiences, home decor ideas, fashion tips, entertainment recommendations, and leisure activities.'
            ],
            [
                'title' => 'Personal Finance & Investing',
                'channels' => $channelsIDs,
                'meta_title' => 'Personal-Finance-Investing',
                'slug' => 'Personal Finance & Investing',
                'meta_keywords' => 'Personal, Finance, Investing',
                'meta_description' => 'This category focuses on financial literacy, budgeting tips, saving strategies, investment advice, retirement planning, debt management, and building wealth for a secure financial future.'
            ],
            [
                'title' => 'Technology & Innovation',
                'channels' => $channelsIDs,
                'meta_title' => 'Technology & Innovation',
                'slug' => 'Technology-Innovation',
                'meta_keywords' => 'Technology, Innovation',
                'meta_description' => 'From the latest gadgets and tech reviews to discussions on emerging technologies, digital trends, cybersecurity tips, software recommendations, and insights into the future of innovation, this category keeps readers updated on all things tech-related.'
            ],
        ];

        foreach($exampleCategoreis as $exampleCategory) {
            $this->blogCategoryRepository->create($exampleCategory);
        }
    }
}
