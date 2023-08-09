<?php 

namespace apo\rxts\policies;

class ApiRoutePolicy
{

    private $server;

    /**
     * @link https://developer.wordpress.org/reference/hooks/rest_api_init/
     * 
     * @param WP_REST_Server $wp_rest_server
     */
    public function protect( $wp_rest_server )
    {
        $this->server = $wp_rest_server;

        $this->loadProtectedNamespaces()
            ->loadPublicPostRoutes()
            ->loadPublicFrontpage()
            ->loadPublicGForms();
    }

    private function loadProtectedNamespaces()
    {
        $namespaces = $this->server->get_namespaces();

        if($namespaces) {
            awsm_collect_route_namespaces($namespaces);
        }

        return $this;
    }

    private function loadPublicPostRoutes()
    {
        $routes = array_map(function($post) {
            if( in_array($post->post_type, ['page', 'post']) ) {
                $post->post_type = $post->post_type . 's';
            }
            return "/wp/v2/{$post->post_type}/{$post->post_id}";
        }, $this->getPublicPostRoutes());

        if($routes) {
            awsm_collect_public_routes($routes);
        }

        return $this;
    }

    private function loadPublicFrontpage()
    {
        $frontpage = [
            '/wp/v2/frontpage',
            '/wp/v2/pages/' . get_option( 'page_on_front' ),
        ];
        awsm_collect_public_routes($frontpage);
        return $this;
    }

    private function loadPublicGForms()
    {
        $ids = [
            get_option( 'apo_register_form' ),
            get_option( 'apo_password_forgotten_form' ),
            get_option( 'apo_reset_password_form' ),
        ];

        $gForms = array_map(function($id) {
            return "/gf/v2/forms/{$id}";
        }, $ids);

        if($gForms) {
            awsm_collect_public_routes($gForms);
        }

        return $this;
    }

    private function getPublicPostRoutes()
    {
        global $wpdb;

        $sql = $wpdb->prepare( "
            SELECT 
                `{$wpdb->prefix}postmeta`.`post_id`, 
                `{$wpdb->prefix}posts`.`post_type`
            FROM 
                `{$wpdb->prefix}postmeta`
            LEFT JOIN 
                `{$wpdb->prefix}posts` 
            ON 
                `{$wpdb->prefix}postmeta`.`post_id` = `{$wpdb->prefix}posts`.`ID`
            WHERE 
                `{$wpdb->prefix}postmeta`.`meta_key` = %s AND 
                `{$wpdb->prefix}postmeta`.`meta_value` = %d AND 
                `{$wpdb->prefix}posts`.`post_status` = %s
            ", "public_resource", 1, "publish");

        return $wpdb->get_results( $sql );
    }
}