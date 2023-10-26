<?php

namespace App\Jobs\Recommendation;

use Illuminate\Contracts\Queue\ShouldQueue;

class ContentBasedJob implements ShouldQueue
{
    const USER_ID = '__USER__';
    protected $data;
    protected $exclude;

    function __construct($user, $objects, $exclude)
    {
        $this->data = $this->processObjects($objects);
        $this->data[self::USER_ID] = $this->processUser($user);
        $this->exclude = $exclude;
    }

    public function getRecommendation($quantity = null)
    {
        $recommended = new RecommendedJob();
        $result = [];
        $count = 0;
        $scoreBegin = 0.8;

        while (!$result && $scoreBegin > 0.6) {
            foreach ($this->data as $k => $v) {
                if($k !== self::USER_ID) {
                    $score = $recommended->similarityDistance($this->data, self::USER_ID, $k);
                    if ($score > $scoreBegin && $k != $this->exclude) {
                        $result[$k] = $score;
                        ++$count;
                    }
                    if ($quantity == $count) {
                        break;
                    }
                }
            }
            $scoreBegin -= 0.1;
        }

        arsort($result);
        return $result;
    }

    protected function processUser($user)
    {
        $result = [];

        foreach ($user as $tag) {
            $result[$tag] = 1.0;
        }

        return $result;
    }

    protected function processObjects($objects)
    {
        $result = [];

        foreach ($objects as $object => $model) {
            foreach ($model->genre_id as $tag) {
                $result[$model->id][$tag] = 1.0;
            }
        }

        return $result;
    }
}
