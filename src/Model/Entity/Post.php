<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $title
 * @property string|null $title_sub1
 * @property string|null $title_sub2
 * @property string $context
 * @property string|null $featured_image
 * @property \Cake\I18n\FrozenDate $open_date
 * @property string|null $is_open
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Category $category
 */
class Post extends Entity
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
        'category_id' => true,
        'title' => true,
        'title_sub1' => true,
        'title_sub2' => true,
        'context' => true,
        'featured_image' => true,
        'open_date' => true,
        'is_open' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'category' => true,
    ];
}
