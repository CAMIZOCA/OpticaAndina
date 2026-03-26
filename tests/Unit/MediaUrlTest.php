<?php

namespace Tests\Unit;

use App\Support\MediaUrl;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MediaUrlTest extends TestCase
{
    #[Test]
    public function it_keeps_absolute_urls_untouched(): void
    {
        $url = 'https://cdn.example.com/products/lens.jpg';

        $this->assertSame($url, MediaUrl::image($url));
    }

    #[Test]
    public function it_builds_public_disk_urls_from_relative_storage_paths(): void
    {
        config()->set('app.url', 'https://opticandina.com');
        config()->set('filesystems.disks.public.url', 'https://opticandina.com/storage');

        $this->assertSame(
            'https://opticandina.com/storage/products/lens.jpg',
            MediaUrl::image('products/lens.jpg')
        );
    }

    #[Test]
    public function it_turns_storage_relative_paths_into_absolute_public_urls(): void
    {
        config()->set('app.url', 'https://opticandina.com');

        $this->assertSame(
            'https://opticandina.com/storage/products/lens.jpg',
            MediaUrl::image('/storage/products/lens.jpg')
        );
    }
}
