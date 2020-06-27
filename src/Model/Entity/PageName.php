<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PageName Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $page_name
 * @property string|null $slug
 * @property int $view_order
 * @property string|null $comment
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\CategoryName[] $category_names
 */
class PageName extends Entity
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
        'page_name' => true,
        'slug' => true,
        'view_order' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'category_names' => true,
    ];
}
