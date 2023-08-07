<?php

namespace awsm\wp\libraries\utilities;

trait Auth 
{   
    protected function currentUser()
    {
        return wp_get_current_user();
    }

    protected function userId()
    {
        return get_current_user_id();
    }

    protected function isLoggedIn()
    {
        return is_user_logged_in();
    }

    protected function isAdmin()
    {
        return in_array('administrator',  wp_get_current_user()->roles);
    }
}