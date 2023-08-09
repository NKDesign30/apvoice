<?php 

namespace apo\rxts\metaboxes;

use awsm\wp\libraries\utilities\Auth;
use awsm\wp\libraries\metaboxes\MetaBoxFactory;
use awsm\wp\libraries\interfaces\RenderableInterface;

class UserAccessPermissions extends MetaBoxFactory implements RenderableInterface
{

    use Auth;
    
    const ID = 'apo_user_access_permissions';

    const POST_TYPES = array( 'page', 'post', 'trainings', 'training-series', 'surveys', 'revision' );

    const EMPTY_VALUE = 'NO_RESTRICTION';

    /**
     * Set default empty value if meta box is empty or reseted. 
     * This is necessary because wordpress dont provide a meta query comparison against null
     * If your meta value dont be included in a meta query, let the default null value
     */
    protected $emptyValue = self::EMPTY_VALUE;

    public function __construct()
    {
        $attributes = [
            'id' => self::ID,
            'title' => 'User access permissions',
            'callback' => array($this, 'render'),
            'screen' => self::POST_TYPES,
            'context' => 'side',
            'priority' => 'default',
        ];

        parent::__construct($attributes);
    }

    public function render( $post ) 
    {
        global $wp_roles;
        $this->registerNonceField();
        $selectedPermissions = maybe_unserialize( get_post_meta( $post->ID, self::ID, true ) );
        ?> 
        <p>
            <label style="display: inline-block; margin-bottom: 1rem;" for="<?= self::ID ?>"><?= __('Restrict this post to a specific user roles', 'rxts') ?></label>
            <br />
            <select multiple id="<?= self::ID ?>" name="<?= self::ID ?>[]" style="width: 100%; min-height: 200px;">
            <?php foreach($wp_roles->roles as $role => $meta) : ?>
                <option 
                style="padding: .25rem; cursor: pointer;"
                value="<?= $role; ?>"
                <?= in_array($role, $selectedPermissions) ? 'selected' : null; ?>
                ><?= $meta['name'] ?></option>
            <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    public static function canAccess( $post_id )
    {
        $permissions = get_post_meta($post_id, self::ID, true);
        if( (new self())->isAdmin() || array_intersect( array_merge( (array) wp_get_current_user()->roles, [self::EMPTY_VALUE]), (array) $permissions) || empty($permissions)) {
            return true;
        }
        return false;
    }
}
