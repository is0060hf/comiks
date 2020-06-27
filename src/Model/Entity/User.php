<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $login_name
 * @property string $login_cd
 * @property string $password
 * @property string|null $mail_address
 * @property int $rank_kb
 * @property int $user_role
 * @property string|null $job_name
 * @property string|null $twitter_account
 * @property string|null $youtube_account
 * @property string|null $instagram_account
 * @property string|null $facebook_account
 * @property string|null $intro_message
 * @property string|null $skill_message
 * @property string|null $icon_image_path
 * @property string|null $default_featured_image_path
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Category[] $categories
 * @property \App\Model\Entity\CategoryName[] $category_names
 * @property \App\Model\Entity\PageName[] $page_names
 * @property \App\Model\Entity\Post[] $posts
 * @property \App\Model\Entity\PricePlan[] $price_plans
 * @property \App\Model\Entity\UserActivity[] $user_activities
 * @property \App\Model\Entity\UserNoticeFlag[] $user_notice_flags
 * @property \App\Model\Entity\UserNotice[] $user_notices
 * @property \App\Model\Entity\UserSkill[] $user_skills
 */
class User extends Entity
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
        'login_name' => true,
        'login_cd' => true,
        'password' => true,
        'mail_address' => true,
        'rank_kb' => true,
        'user_role' => true,
        'job_name' => true,
        'twitter_account' => true,
        'youtube_account' => true,
        'instagram_account' => true,
        'facebook_account' => true,
        'intro_message' => true,
        'skill_message' => true,
        'icon_image_path' => true,
        'default_featured_image_path' => true,
        'created' => true,
        'modified' => true,
        'categories' => true,
        'category_names' => true,
        'page_names' => true,
        'posts' => true,
        'price_plans' => true,
        'user_activities' => true,
        'user_notice_flags' => true,
        'user_notices' => true,
        'user_skills' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
}
