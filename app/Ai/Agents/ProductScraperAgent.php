<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;

class ProductScraperAgent implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a product data extraction agent. You will be given the HTML content of a golf product
        page from a manufacturer's website, along with the product name.

        Extract the following information:
        - description: A concise, accurate product description (2–4 paragraphs). Use the page content
          only — do not invent details. If no description is found, return an empty string.
        - release_date: The product release or launch date in YYYY-MM-DD format. If only a year is
          known, use YYYY-01-01. If unknown, return null.
        - sku: The product sku or product number. If unkown, return null.
        - image_urls: An array of absolute URLs to product images found on the page. Prefer high
          resolution images. Include up to 5 URLs. Return an empty array if none are found.

        Return only the structured data. Do not include any commentary.
        INSTRUCTIONS;
    }

    public function messages(): iterable
    {
        return [];
    }

    public function tools(): iterable
    {
        return [];
    }

    /**
     * @return array<string>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'description' => $schema->string()
                ->description('Product description extracted from the page')
                ->required(),

            'release_date' => $schema->string()
                ->description('Product release date in YYYY-MM-DD format')
                ->nullable(),

            'sku' => $schema->string()
                ->description('Product number or sku')
                ->nullable(),

            'image_urls' => $schema->array()
                ->description('Absolute URLs of product images found on the page')
                ->items($schema->string())
                ->required(),
        ];
    }
}
