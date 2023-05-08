<?php

declare (strict_types = 1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TranslationService
{
    private string $api_authorization;

    public function __construct(
        private HttpClientInterface $httpClient,
        ParameterBagInterface $parameterBag
    ) {
        $api_authorization = $parameterBag->get('api_authorization');

        if (!$api_authorization) {
            throw new \InvalidArgumentException ('API authorization key is missing in .env');
        }

        $this->api_authorization = $api_authorization;
    }

    public function getTranslation(string $text, string $source_lang, string $target_lang, string $formality): string
    {
        $request = "text={$text}&preserve_formatting=1&formality={$formality}&split_sentences=1";

        if ($source_lang) {
            $request .= "&source_lang={$source_lang}";
        }

        if ($target_lang) {
            $request .= "&target_lang={$target_lang}";
        } else {
            $request .= "&target_lang=FI";
        }

        try {
            $response = $this->httpClient->request('POST', 'https://api-free.deepl.com/v2/translate', [
                'headers' => [
                    'Authorization' => "DeepL-Auth-Key {$this->api_authorization}",
                    'User-Agent' => 'YourApp/1.2.3',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    'text' => $text,
                    'preserve_formatting' => 1,
                    'formality' => $formality,
                    'split_sentences' => 1,
                    'source_lang' => $source_lang,
                    'target_lang' => $target_lang ?: 'FI',
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                $response_array = $response->toArray();
                $translations = $response_array['translations'][0]['text'];

                return $translations;

            } elseif ($statusCode == 429) {
                throw new \RuntimeException ('Too many requests. Please wait and try again later.');

            } elseif ($statusCode == 456) {
                throw new \RuntimeException ('Translation limit of your account has been reached. Consider upgrading your subscription.');

            } else {
                throw new \RuntimeException ('Temporary error in the DeepL service. Please try again later.');
            }

        } catch (TransportExceptionInterface $e) {
            throw new \RuntimeException ('An error occurred while trying to access the DeepL API.');
        } catch (ClientExceptionInterface | ServerExceptionInterface $e) {
            throw new \RuntimeException ('An error occurred while communicating with the DeepL API.');
        }
    }
}
