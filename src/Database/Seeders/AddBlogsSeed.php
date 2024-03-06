<?php

namespace Mziel\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Core\Models\Channel;
use Mziel\Blog\Models\BlogCategory;
use Illuminate\Database\Eloquent\Model;
use Mziel\Blog\Repositories\BlogRepository;

class AddBlogsSeed extends Seeder
{

    public function __construct(protected BlogRepository $blogRepository)
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

        $examplePosts = [
            [
                'blog_category_id' => BlogCategory::inRandomOrder()->first()->id,
                'title' => 'Unlocking the Power of Positive Thinking: How a Positive Mindset Can Transform Your Life',
                'channels' => $channelsIDs,
                'content' => "In a world filled with challenges and uncertainties, maintaining a positive mindset can be a game-changer. In this blog post, we'll delve into the incredible benefits of positive thinking and how it can transform every aspect of your life.

                From improving mental health to enhancing physical well-being, positive thinking has been linked to numerous health benefits. Research suggests that individuals with a positive outlook are better equipped to handle stress, overcome obstacles, and bounce back from setbacks.

                But the power of positive thinking extends beyond personal well-being. It can also have a profound impact on your relationships, career, and overall success. By cultivating a positive mindset, you'll attract more opportunities, foster stronger connections with others, and achieve greater levels of fulfillment.

                In this blog post, we'll explore practical strategies for adopting a more positive outlook, including mindfulness practices, gratitude exercises, and visualization techniques. Whether you're facing challenges in your personal or professional life, embracing the power of positive thinking can help you unlock your full potential and live a happier, more fulfilling life.",
                'meta_title' => 'Unlocking the Power of Positive Thinking: How a Positive Mindset Can Transform Your Life',
                'slug' => 'unlocking-power-positive-thinking',
                'meta_keywords' => 'positive thinking, mindset transformation, mental health benefits, resilience, personal development',
                'meta_description' => 'Explore the incredible benefits of positive thinking and how it can transform your life. Learn practical strategies for adopting a more positive outlook and unlocking your full potential for happiness and fulfillment.',
            ],
            [
                'blog_category_id' => BlogCategory::inRandomOrder()->first()->id,
                'title' => 'The Art of Self-Care: Prioritizing Your Well-Being',
                'channels' => $channelsIDs,
                'content' => "In today's fast-paced world, it's easy to neglect our own well-being in favor of keeping up with work, family, and other commitments. However, prioritizing self-care is essential for maintaining balance, reducing stress, and fostering overall happiness.

                In this blog post, we'll explore the art of self-care and why it's so important to carve out time for ourselves amidst our busy schedules. From simple daily rituals to more indulgent treats, self-care comes in many forms and is unique to each individual.

                We'll discuss the benefits of self-care, including improved mental health, increased productivity, and enhanced resilience in the face of challenges. Whether it's practicing mindfulness, indulging in a favorite hobby, or simply taking a leisurely walk outdoors, finding activities that nourish your mind, body, and soul is key to living a fulfilling life.

                Join us as we delve into the world of self-care and discover practical tips and strategies for incorporating it into your daily routine. By making self-care a priority, you'll not only improve your own well-being but also become better equipped to navigate life's ups and downs with grace and resilience.",
                'meta_title' => 'The Art of Self-Care: Prioritizing Your Well-Being',
                'slug' => 'art-self-care-prioritizing-well-being',
                'meta_keywords' => 'self-care, well-being, stress management, mindfulness, personal growth',
                'meta_description' => 'Discover the importance of self-care and how it contributes to overall well-being. Explore practical tips and strategies for incorporating self-care into your daily routine to reduce stress and foster a happier, more balanced life.',
            ],
            [
                'blog_category_id' => BlogCategory::inRandomOrder()->first()->id,
                'title' => 'The Power of Setting Goals: Achieve Success and Fulfillment',
                'channels' => $channelsIDs,
                'content' => "Setting goals is the first step towards turning your dreams into reality. Whether you're aiming for personal growth, professional success, or improved health and well-being, having clear, actionable goals can provide direction and motivation to fuel your journey.

                In this blog post, we'll explore the power of setting goals and how it can transform your life. We'll discuss the importance of setting specific, measurable, achievable, relevant, and time-bound (SMART) goals, as well as strategies for staying focused and overcoming obstacles along the way.

                From short-term objectives to long-term aspirations, we'll guide you through the process of setting meaningful goals that align with your values and aspirations. Whether you're striving for career advancement, financial independence, or personal development, goal setting is the key to unlocking your full potential and achieving success and fulfillment.

                Join us as we dive into the world of goal setting and discover practical tips and techniques for creating a roadmap to the life you desire. By harnessing the power of goal setting, you'll gain clarity, confidence, and momentum to pursue your dreams with passion and purpose.",
                'meta_title' => 'The Power of Setting Goals: Achieve Success and Fulfillment',
                'slug' => 'power-setting-goals-achieve-success-fulfillment',
                'meta_keywords' => 'goal setting, success, personal development, motivation, achievement',
                'meta_description' => 'Learn how setting goals can transform your life and lead to success and fulfillment. Discover practical strategies for setting and achieving meaningful goals that align with your aspirations and values.',
            ],
            [
                'blog_category_id' => BlogCategory::inRandomOrder()->first()->id,
                'title' => 'Embracing Change: Thriving in Times of Uncertainty',
                'channels' => $channelsIDs,
                'content' => "Change is inevitable, yet many of us resist it out of fear of the unknown. However, learning to embrace change is essential for growth, resilience, and ultimately, success. In this blog post, we'll explore the art of embracing change and how it can empower you to thrive in times of uncertainty.

                We'll discuss why change is necessary for personal and professional growth, as well as strategies for navigating transitions with grace and resilience. From reframing your mindset to cultivating adaptability and flexibility, we'll share practical tips and techniques for embracing change as a catalyst for positive transformation.

                Whether you're facing a major life transition, adapting to a new work environment, or simply seeking to break out of your comfort zone, learning to embrace change can unlock new opportunities and possibilities. By reframing change as a natural and inevitable part of life, you'll gain the confidence and resilience to navigate whatever challenges come your way.

                Join us as we explore the power of embracing change and discover how it can propel you towards a future filled with growth, fulfillment, and endless possibilities. By embracing change with an open heart and mind, you'll not only survive but thrive in times of uncertainty.",
                'meta_title' => 'Embracing Change: Thriving in Times of Uncertainty',
                'slug' => 'embracing-change-thriving-times-uncertainty',
                'meta_keywords' => 'change, resilience, adaptation, personal growth, uncertainty',
                'meta_description' => 'Explore the art of embracing change and thriving in times of uncertainty. Gain practical tips and techniques for cultivating resilience and adapting to change as a catalyst for personal growth and fulfillment.',
            ],
        ];

        foreach($examplePosts as $examplePost) {
            $this->blogRepository->create($examplePost);
        }
    }
}
