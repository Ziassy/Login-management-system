<?php

function is_logged_in()
{
    $ci = get_instance(); // to call library CI
    // Already Login or not
    if (!$ci->session->userdata('email')) {
        redirect('auth'); // auth is login page
    } else {
        //if it's true. then, check his/her Role
        $role_id = $ci->session->userdata('role_id');
        // where page are we?
        $menu = $ci->uri->segment(1); //segmen is "urutan"

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}


// function access

function check_access($role_id, $menu_id)
{

    $ci = get_instance();

    $result = $ci->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
