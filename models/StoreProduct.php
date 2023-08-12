<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "store_product".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $image Ссылка на изображение
 *
 * @property Product $product
 */
class StoreProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
