<?php

namespace App\Support;

use App\Services\SentimentAnalysisService;

class SentimentAnalyzer
{
    /**
     * @param $comment
     *
     * @return array {score,category}
     */
    public static function analyze($comment)
    {
        $service = new SentimentAnalysisService();

        return [
            'score'    => $service->score($comment),
            'category' => $service->categorise($comment),
        ];
    }
}