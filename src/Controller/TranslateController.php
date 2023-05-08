<?php

declare (strict_types = 1);

namespace App\Controller;

use App\Service\TranslationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslateController extends AbstractController
{

    #[Route('/', name:'home')]
    public function action(Request $request, TranslationService $translationService): Response
    {
        $text = urldecode($request->query->get('text') ?? '');
        $source_lang = $request->query->get('source_lang') ?? '';
        $target_lang = $request->query->get('target_lang') ?? '';
        $formality = $request->query->get('formality') ?? 'prefer_less';

        try {
            $translations = $translationService->getTranslation($text, $source_lang, $target_lang, $formality);
        } catch (\Exception $e) {
           
            return $this->render('translator/translator.html.twig', [
                'source_lang' => $source_lang,
                'target_lang' => $target_lang,
                'text' => $text,
                'response' => '',
                'formality' => $formality,
                'error' => $e->getMessage()
            ]);
        }

        $translations = $translationService->getTranslation($text, $source_lang, $target_lang, $formality);

        return $this->render('translator/translator.html.twig', [
            'source_lang' => $source_lang,
            'target_lang' => $target_lang,
            'text' => $text,
            'response' => $translations,
            'formality' => $formality,
            'error' => ''
        ]);
    }
}
