<?php 

namespace raffle\metaboxes;

use awsm\wp\libraries\metaboxes\MetaBoxFactory;
use awsm\wp\libraries\interfaces\RenderableInterface;

class AwsmMetaBox extends MetaBoxFactory implements RenderableInterface
{
    const ID = 'awsm_meta_box';

    public function __construct()
    {
        $attributes = [
            'id' => self::ID,
            'title' => 'This is an awesome metabox',
            'callback' => array($this, 'render'),
            'screen' => array( 'post' ),
            'context' => 'side',
            'priority' => 'default',
        ];

        parent::__construct($attributes);
    }

    public function render( $post ) 
    {
        $this->registerNonceField();
        $value = esc_attr( get_post_meta( $post->ID, self::ID, true ) );
        ?> 
        <p>
           <label for="<?= self::ID ?>">My field</label>
           <input type="text" id="<?= self::ID ?>" name="<?= self::ID ?>" value="<?= $value ?>" />
        </p>
        <?php
    }
}
