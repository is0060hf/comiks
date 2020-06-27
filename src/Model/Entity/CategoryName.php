<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CategoryName Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $page_name_id
 * @property int $category_id
 * @property string $slug
 * @property int $view_order
 * @property string|null $comment
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\PageName $page_name
 * @property \App\Model\Entity\Category $category
 */
class CategoryName extends Entity
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
        'user_id' => true,
        'page_name_id' => true,
        'category_id' => true,
        'slug' => true,
        'view_order' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'page_name' => true,
        'category' => true,
    ];
}
