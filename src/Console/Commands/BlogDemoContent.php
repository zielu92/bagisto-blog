<?php

namespace Mziel\Blog\Console\Commands;

use Illuminate\Console\Command;
use Mziel\Blog\Database\Seeders\AddBlogCategoriesSeed;
use Mziel\Blog\Database\Seeders\AddBlogsSeed;

class BlogDemoContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish demo content for blogs (without images)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Adding demo categories...');
        $this->call(AddBlogCategoriesSeed::class);
        $this->comment('Adding demo blog posts...');
        $this->call(AddBlogsSeed::class);
        $this->comment('Adding demo content has been finished');
    }
}
