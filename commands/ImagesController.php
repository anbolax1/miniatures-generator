<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Product;
use yii\console\Controller;
use yii\console\ExitCode;

class ImagesController extends Controller
{
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionGenerateMiniature($sizes = [], $watermarked = false, $publishedOnly = true)
    {
        $images = \Yii::$app->Images;
        // Разбиваем параметр sizes на массив размеров
        $sizeArray = explode(',', $sizes);

        // Получаем продукты в зависимости от параметра publishedOnly
        if ($publishedOnly) {
            $products = Product::find()
                ->joinWith('storeProduct')
                ->where(['product.is_deleted' => 0])
                ->andWhere(['not', ['store_product.product_id' => null]])
                ->all();
        } else {
            $products = Product::find()
                ->joinWith('storeProduct')
                ->where(['product.is_deleted' => 0])
                ->all();
        }

        // Переменные-счетчики для успешного и неудачного создания миниатюр
        $successCount = 0;
        $failureCount = 0;

        // Проходимся по продуктам и создаем миниатюры
        foreach ($products as $product) {
            // Создаем миниатюру для изображения продукта
            if (!empty($product->image)) {
                try {
                    foreach ($sizeArray as $size) {
                        $dimensions = explode('x', $size);
                        $images::generateMiniature($product->image, ['width' => $dimensions[0], 'height' => $dimensions[1]]);
                    }
                    $successCount++;
                } catch (\Exception $e) {
                    $failureCount++;
                }
            }

            // Создаем миниатюру для изображения продукта в магазине
            if (!empty($product->storeProduct->product_image)) {
                try {
                    foreach ($sizeArray as $size) {
                        $dimensions = explode('x', $size);
                        $images::generateMiniature($product->storeProduct->product_image, ['width' => $dimensions[0], 'height' => $dimensions[1]]);
                    }
                    $successCount++;
                } catch (\Exception $e) {
                    $failureCount++;
                }
            }
        }

        // Выводим результаты
        echo "Успешно создано миниатюр: " . $successCount . "\n";
        echo "Неудачное создание миниатюр: " . $failureCount . "\n";
    }
}
