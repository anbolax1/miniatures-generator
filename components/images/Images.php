<?php


namespace app\components\images;


class Images
{
    public static function generateMiniature(string $link, array $max): string
    {
        try {
            $isSuccess = rand(0,1);

            if (!$isSuccess) {
                throw new \Exception("Something bad happened in the method " . __METHOD__);
            }

            return $link . "-miniature";

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function generateWatermarkedMiniature(string $link, array $max): string
    {
        try {
            return Images::generateMiniature($link, $max) . "-watermarked";
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}