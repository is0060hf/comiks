<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $category_name
 * @property int $view_order
 * @property int $user_id
 * @property string|null $default_featured_image_path
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\CategoryName[] $category_names
 * @property \App\Model\Entity\Post[] $posts
 */
class Category extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'category_name' => true,
        'view_order' => true,
        'user_id' => true,
        'default_featured_image_path' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'category_names' => true,
        'posts' => true,
    ];
}
