<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Laravel\Head\Facades\Head;

class PageController extends Controller
{
    public function home(): Response
    {
        return $this->renderPage(
            'Welcome',
            'Home',
            'Build and discover better golf setups with Must Have Golf.',
        );
    }

    public function products(): Response
    {
        return $this->renderPage('Products', 'Products', 'Discover golf products and equipment worth putting in your bag.');
    }

    public function builder(): Response
    {
        return $this->renderPage('Builder', 'Builder', 'Build a golf setup tailored to your game.');
    }

    public function guides(): Response
    {
        return $this->renderPage('Guides', 'Guides', 'Practical golf guides for better buying and better play.');
    }

    public function completedBuilds(): Response
    {
        return $this->renderPage('CompletedBuilds', 'Completed Builds', 'Explore golf setups built for real players.');
    }

    public function about(): Response
    {
        return $this->renderPage('About', 'About', 'Learn more about Must Have Golf.');
    }

    public function affiliateDisclosure(): Response
    {
        return $this->renderPage('AffiliateDisclosure', 'Affiliate Disclosure', 'Learn how Must Have Golf uses affiliate links.');
    }

    public function contact(): Response
    {
        return $this->renderPage('Contact', 'Contact', 'Get in touch with Must Have Golf.');
    }

    public function privacyPolicy(): Response
    {
        return $this->renderPage('PrivacyPolicy', 'Privacy Policy', 'Read the Must Have Golf privacy policy.');
    }

    public function termsOfService(): Response
    {
        return $this->renderPage('TermsOfService', 'Terms of Service', 'Read the Must Have Golf terms of service.');
    }

    public function profile(): Response
    {
        return $this->renderPage('Profile', 'Profile', 'Manage your Must Have Golf profile.');
    }

    public function account(): Response
    {
        return $this->renderPage('Account', 'Account', 'Manage your Must Have Golf account.');
    }

    private function renderPage(string $page, string $title, string $description): Response
    {
        Head::title($title)
            ->description($description)
            ->canonical()
            ->og(title: $title, description: $description)
            ->searchableByRobots();

        return Inertia::render($page, [
            'title' => $title,
        ]);
    }
}
