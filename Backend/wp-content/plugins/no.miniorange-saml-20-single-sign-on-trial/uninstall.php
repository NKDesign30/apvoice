<?php


require_once dirname(__FILE__) . "\57\x69\156\x63\x6c\x75\144\x65\163\x2f\x6c\x69\x62\57\155\x6f\x2d\157\160\164\x69\157\156\x73\55\x65\x6e\165\155\56\160\x68\160";
require_once dirname(__FILE__) . "\57\111\x6d\160\x6f\x72\x74\x2d\145\170\160\x6f\162\x74\56\160\x68\x70";
define("\x55\x6e\x69\156\163\x74\x61\x6c\154\137\x43\x6c\x61\x73\x73\x5f\x4e\141\155\145\x73", serialize(array("\x53\123\117\137\x4c\x6f\147\151\156" => "\155\x6f\137\x6f\160\164\151\x6f\x6e\163\137\x65\x6e\x75\155\x5f\163\163\157\x5f\x6c\x6f\x67\x69\156", "\x49\x64\145\x6e\x74\x69\x74\171\x5f\x50\162\157\166\151\x64\145\x72" => "\155\x6f\137\x6f\160\164\151\x6f\156\x73\137\x65\156\x75\x6d\137\x69\144\145\x6e\x74\x69\x74\171\x5f\160\x72\x6f\x76\x69\144\x65\x72", "\123\x65\x72\x76\x69\143\x65\x5f\120\162\x6f\166\x69\144\145\x72" => "\x6d\x6f\x5f\x6f\160\164\151\x6f\156\163\x5f\x65\x6e\165\155\137\x73\145\x72\x76\151\143\145\137\160\162\x6f\x76\x69\144\145\x72", "\x41\x74\164\x72\151\x62\165\164\145\137\x4d\141\160\160\x69\x6e\x67" => "\x6d\x6f\137\157\160\164\x69\x6f\x6e\x73\x5f\145\x6e\x75\155\137\x61\164\x74\162\151\142\x75\164\145\137\x6d\x61\x70\x70\151\x6e\147", "\x44\157\155\x61\x69\x6e\x5f\122\145\x73\164\x72\151\143\x74\151\157\x6e" => "\x6d\157\137\157\x70\x74\x69\157\x6e\x73\x5f\x65\156\165\x6d\137\144\157\155\141\151\x6e\x5f\x72\x65\x73\164\x72\151\x63\164\x69\x6f\156", "\x52\x6f\154\145\x5f\x4d\141\160\x70\151\156\147" => "\155\157\137\x6f\x70\x74\151\x6f\x6e\x73\137\x65\x6e\165\155\x5f\x72\157\154\145\137\x6d\x61\x70\x70\x69\156\147", "\x54\145\163\164\x5f\x43\157\156\x66\151\147\165\162\141\x74\x69\157\x6e" => "\x6d\157\137\157\x70\164\x69\157\156\163\137\145\156\165\155\x5f\164\145\163\164\x5f\143\157\x6e\x66\x69\147\165\162\141\164\x69\157\x6e", "\103\x75\x73\164\157\x6d\x5f\103\145\x72\164\151\x66\151\x63\x61\x74\145" => "\155\x6f\137\157\160\x74\151\x6f\156\x73\137\x65\x6e\165\x6d\x5f\143\165\x73\x74\x6f\x6d\137\143\x65\x72\x74\x69\x66\x69\143\x61\164\x65", "\x43\x75\163\164\x6f\155\137\115\x65\163\x73\141\147\x65" => "\x6d\x6f\x5f\x6f\x70\164\x69\x6f\x6e\163\137\x65\156\x75\155\x5f\143\165\x73\x74\x6f\155\x5f\155\145\x73\x73\141\147\x65\163")));
if (defined("\x57\x50\137\x55\x4e\x49\116\x53\124\101\x4c\114\x5f\x50\114\125\x47\111\116")) {
    goto tNW;
}
exit;
tNW:
if (!(get_site_option("\x6d\x6f\137\x73\141\155\x6c\137\x6b\x65\145\160\x5f\163\145\x74\164\x69\156\147\163\137\157\156\x5f\144\x65\x6c\145\x74\x69\x6f\x6e") !== "\164\x72\165\x65")) {
    goto zCv;
}
mo_saml_delete_plugin_configuration();
mo_saml_delete_user_meta();
zCv:
function mo_saml_delete_plugin_configuration()
{
    $N8 = maybe_unserialize(Uninstall_Class_Names);
    $jQ = array();
    foreach ($N8 as $FE => $Ng) {
        $jQ[$FE] = mo_get_configuration_array($Ng, true);
        roR:
    }
    Mq2:
    foreach ($jQ as $rF => $Xa) {
        foreach ($Xa as $E1 => $js) {
            delete_site_option($js);
            v9T:
        }
        gTN:
        HlY:
    }
    Ir3:
}
function mo_saml_delete_user_meta()
{
    $Vk = get_users(array());
    foreach ($Vk as $user) {
        delete_user_meta($user->ID, "\155\x6f\x5f\x73\x61\155\154\x5f\165\163\x65\162\137\x61\164\x74\x72\x69\142\165\164\x65\163");
        delete_user_meta($user->ID, "\155\157\137\x73\x61\x6d\x6c\137\163\x65\163\x73\151\157\156\x5f\x69\x6e\x64\x65\x78");
        delete_user_meta($user->ID, "\155\157\x5f\x73\x61\155\x6c\137\x6e\141\155\145\x5f\151\144");
        RBV:
    }
    Mx1:
}