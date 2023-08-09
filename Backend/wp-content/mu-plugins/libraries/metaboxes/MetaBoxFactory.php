<?php 

namespace awsm\wp\libraries\metaboxes;

use Exception;
use awsm\wp\libraries\interfaces\MetaBoxesInterface;

class MetaBoxFactory implements MetaBoxesInterface {

    protected $required = [
        'id',
        'title',
    ];

    protected $attributes = [
        'id' => null,
        'title' => null,
        'callback' => null,
        'screen' => null,
        'context' => 'advanced',
        'priority' => 'default',
        'callback_args' => null,
    ];

    protected $nonceField = [
        'action' => -1,
        'name' => '_wpnonce',
    ];

    /**
     * Set default empty value if meta box is empty or reseted. 
     * This is necessary because wordpress dont provide a meta query comparison against null
     * If your meta value dont be included in a meta query, let the default null value
     */
    protected $emptyValue = null;

    private $incommingAttributes = [];

    public function __construct($attributes)
	{
        $this->checkForMissingKeys($attributes)
            ->setAttributes()
            ->setNonceField();
        return $this;
    }

    /**
     * Set all needed attributes for your meta box
     * This method should be called in in the add_action('add_meta_boxes') wordpress hook
     * 
     * @link https://developer.wordpress.org/reference/functions/add_meta_box/
     */
    public function add()
    {
        add_meta_box(
            $this->attributes['id'],
            $this->attributes['title'],
            $this->attributes['callback'],
            $this->attributes['screen'],
            $this->attributes['context'],
            $this->attributes['priority'],
            $this->attributes['callback_args']
        );
    }

    public function render( $post ) 
    {
        echo __('This method should be overwritten by the your own class', 'awsm_lib');
    }

    /**
     * Update the registered meta box after the related post is saved
     * @param int $post_id
     * 
     * @link https://developer.wordpress.org/reference/functions/update_post_meta/
     */
    public function save( $post_id )
    {
        if( !isset( $_POST[$this->nonceField['name']]) || !wp_verify_nonce( $_POST[$this->nonceField['name']], $this->nonceField['action'] ) ) {
            return;
        }

        if( !isset( $_POST[$this->attributes['id']] ) || is_null( $_POST[$this->attributes['id']] ) ) {
            $_POST[$this->attributes['id']] = $this->emptyValue;
        }

        update_post_meta( $post_id, $this->attributes['id'], $_POST[$this->attributes['id']]);
    }
    
    protected function checkForMissingKeys($attributes) 
    {
        $missingKeys = array_filter($this->required, function($key) use($attributes) {
            return !array_key_exists($key, $attributes);
        });

        if(!empty($missingKeys)) {
            throw new Exception('Attributes are missing, please add these keys: ' . implode(', ', $missingKeys));
        }

        $this->incommingAttributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    protected function setAttributes()
    {
        foreach ($this->attributes as $key => $value) {
            if($key === 'title') {
                $this->attributes[$key] = __( $this->incommingAttributes[$key], 'awsm_lib');
            } else {
                $this->attributes[$key] = $this->incommingAttributes[$key];
            }
        }
        return $this;
    }

    protected function setNonceField()
    {
        $this->nonceField['action'] = $this->attributes['id'] . '_action';
        $this->nonceField['name'] = $this->attributes['id'] . '_nonce_field';
        return $this;
    }

    /**
     * Retrieve or display none hidden field forms
     * 
     * @link https://developer.wordpress.org/reference/functions/wp_nonce_field/
     */
    protected function registerNonceField()
    {
        wp_nonce_field($this->nonceField['action'], $this->nonceField['name']);
        return $this;
    }

}