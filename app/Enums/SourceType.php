<?php

namespace App\Enums;

enum SourceType: string
{
    case YouTube_Video = 'youtube-video';
    case Reddit_Post = 'reddit-post';
    case Blog_Article = 'blog-article';
    case Forum_Thread = 'forum-thread';
    case ECommerce_Product_Page = 'ecommerce-product-page';
    case Manufacture_Product_Page = 'manufacture-product-page';
}
