<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;

class MenusController extends Controller
{

    use Auth;

	public function __construct()
	{
        parent::__construct();
	}

    public function index( Request $request )
    {
        $menuLocations = array_filter(get_nav_menu_locations(), function($id) {
            return $id !== 0;
        });

        
        $mappedMenus = array_map(
            [$this, 'createMenuResponse'],
            $menuLocations, array_keys($menuLocations)
        );

        $menus = array_combine(array_keys($menuLocations), $mappedMenus);

        return $menus;
    }

    public function show( Request $request )
    {
        $menu = get_term($request['id']);

        if(!$menu || !is_nav_menu($menu)) return $this->couldNotFoundMenu($request['id']);

        $menu = $this->createMenuResponse($request['id'], $menu->slug);

        return $menu;
    }

    public function showByLocationSlug( Request $request )
    {
        $locationId = get_nav_menu_locations()[$request['slug']];

        if(!$locationId) return $this->couldNotFoundMenu($request['slug']);

        $menu = $this->createMenuResponse($locationId, $request['slug']);

        return $menu;
    }

    private function couldNotFoundMenu($id)
    {
        return new \WP_Error( 'not_found', 'No menu has been found with this ID: `'.$id.'`. Please ensure you passed an existing menu ID.', [ 'status' => 404 ] );
    }

    private function createMenuResponse($id, $slug)
    {
        return [
            'id' => $id !== 0 ? $id : null,
            'slug' => $slug,
            'menu' => $id !== 0 ? get_term($id) : [],
            'items' =>  $this->generateItems($id),
        ];
    }

    private function generateItems($id)
    {
        if($id !== 0) {

            $items = $this->filterMenuItemsByPermission($id);
            //print_r($items);

            return array_map(function($item) {
                $item->template = preg_replace('/template-|.php/i','', get_page_template_slug($item->object_id));
                $item->icon = get_field( 'icon', $item );

                if ( is_array( $item->icon ) && ! empty( $item->icon ) ) {
                    $attachment = get_attached_file( $item->icon['id'] );

                    if ( ! empty( $attachment ) ) {
                        $item->icon_source = base64_encode( file_get_contents( $item->icon['url'] ) );
                    }
                }

                if ( empty( $blog_id ) || ! is_multisite() ) {
                    $url = get_option( 'home' );
                } else {
                    switch_to_blog( $blog_id );
                    $url = get_option( 'home' );
                    restore_current_blog();
                }
                $item->url_path = str_replace($url, "", $item->url);

                $item->show_in_more = (bool) (int) get_field( 'show_in_more', $item );
                $item->granted_user_roles = get_field( 'granted_user_roles', $item );
                $item->public_resource = (bool) get_field( 'public_resource', $item );

                return $item;
            }, $items);
        }
        return [];
    }

    private function canSee($item)
    {
        $userRoles = get_field( 'granted_user_roles', $item );
        return $this->isAdmin() || 
            array_intersect( array_merge( (array) wp_get_current_user()->roles, ['NO_RESTRICTION']), (array) $userRoles) || 
            is_null($userRoles) || 
            $userRoles === 'NO_RESTRICTION';
    }

    private function filterMenuItemsByPermission($id)
    {
        return array_values(
            array_filter( (array) wp_get_nav_menu_items($id), function($item) {
                return $this->canSee($item);
            })
        );
    }

}