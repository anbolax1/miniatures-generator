<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $image Ссылка на изображение
 * @property int|null $is_deleted
 *
 * @property StoreProduct[] $storeProducts
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[StoreProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStoreProduct(): \yii\db\ActiveQuery
    {
        return $this->hasOne(StoreProduct::class, ['product_id' => 'id']);
    }
}
