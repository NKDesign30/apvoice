<?php


function mo_saml_show_addons_page()
{
    require_once ABSPATH . "\x2f\167\160\55\x61\144\x6d\151\156\57\x69\x6e\x63\154\x75\x64\145\163\57\160\154\165\x67\x69\156\x2e\x70\x68\160";
    $R0 = array();
    $x_ = array("\163\143\151\155" => __("\101\154\154\x6f\167\x73\40\x72\145\141\x6c\x2d\164\151\155\x65\40\165\x73\x65\162\40\x73\171\156\x63\x20\50\x61\165\x74\x6f\x6d\141\x74\x69\143\40\165\163\145\x72\x20\143\162\x65\x61\164\x65\54\x20\x64\x65\154\145\x74\145\x2c\x20\141\156\144\x20\x75\x70\144\x61\x74\x65\51\x20\146\162\x6f\x6d\x20\x79\157\x75\162\40\x49\144\145\x6e\x74\x69\164\x79\x20\x50\162\x6f\x76\x69\144\x65\x72\x20\x73\165\x63\x68\40\141\x73\x20\101\x7a\165\162\x65\54\x20\x4f\x6b\x74\x61\x2c\40\x4f\156\x65\154\x6f\147\x69\x6e\x20\x69\x6e\164\x6f\40\171\x6f\165\x72\x20\x57\157\162\x64\120\162\x65\163\x73\40\163\x69\x74\x65\x2e", "\155\x69\x6e\x69\x6f\162\141\x6e\147\145\55\x73\141\155\x6c\x2d\x32\x30\x2d\x73\x69\156\147\x6c\145\55\x73\151\147\x6e\x2d\157\x6e"), "\160\141\x67\x65\137\162\x65\x73\164\162\x69\143\x74\151\x6f\x6e" => __("\x52\145\163\x74\x72\151\143\x74\x20\141\143\143\x65\x73\x73\x20\164\x6f\x20\127\157\x72\x64\120\162\x65\163\163\x20\160\x61\x67\145\163\x2f\160\157\x73\164\x73\x20\x62\x61\163\x65\x64\x20\157\156\x20\x75\x73\145\x72\40\162\157\154\x65\163\x20\x61\156\144\x20\x74\150\x65\151\162\40\x6c\x6f\147\x69\156\x20\x73\x74\x61\x74\x75\163\x2c\x20\164\x68\x65\162\x65\142\171\40\x70\162\x6f\x74\145\143\164\151\156\x67\x20\x74\x68\x65\x73\x65\40\160\141\147\145\163\57\x70\x6f\163\164\163\x20\146\x72\x6f\155\x20\165\x6e\x61\165\x74\150\x6f\162\151\x7a\x65\x64\40\x61\x63\143\145\163\163\56", "\155\151\x6e\151\x6f\162\x61\156\147\x65\55\163\141\x6d\x6c\55\62\x30\x2d\163\151\156\x67\x6c\x65\55\x73\x69\x67\x6e\55\x6f\156"), "\146\x69\154\x65\x5f\160\x72\x65\166\145\x6e\x74\151\x6f\x6e" => __("\x52\x65\x73\164\162\151\x63\164\x20\141\x6e\171\x20\153\x69\x6e\x64\40\157\146\40\x6d\x65\x64\151\x61\x20\x66\x69\x6c\x65\x73\40\163\165\143\x68\x20\x61\163\40\x69\x6d\141\x67\x65\x73\54\40\141\x75\144\x69\157\x2c\40\166\151\144\x65\157\163\54\40\x64\157\x63\x75\x6d\145\x6e\164\163\x2c\40\x65\164\143\x2c\40\141\156\144\x20\x61\x6e\171\x20\x65\170\x74\x65\x6e\163\151\157\x6e\40\50\x63\157\156\x66\151\x67\x75\x72\141\142\x6c\145\51\40\x73\x75\143\150\x20\141\163\x20\160\x6e\x67\54\x20\160\x64\x66\x2c\x20\x6a\x70\x65\147\54\x20\x6a\160\147\x2c\40\x62\155\160\x2c\40\147\x69\146\54\x20\x65\x74\143\56", "\x6d\151\x6e\x69\157\162\141\156\x67\x65\55\x73\x61\x6d\154\55\x32\x30\55\x73\151\156\x67\x6c\x65\x2d\163\x69\x67\156\55\157\156"), "\x73\x73\157\x6c\157\x67\x69\156" => __("\x53\x53\117\40\x4c\157\x67\151\156\x20\101\x75\144\151\164\x20\164\x72\x61\x63\x6b\163\40\x61\x6c\154\40\164\150\145\x20\x53\x53\x4f\x20\x75\163\x65\162\x73\40\141\156\144\x20\147\145\x6e\x65\x72\x61\164\x65\163\40\x64\145\164\141\x69\x6c\145\x64\40\162\145\160\157\162\164\163\x2e\40\x54\x68\x65\40\x61\144\166\x61\156\143\x65\x64\x20\163\145\141\x72\143\150\40\x66\151\154\164\x65\162\x73\x20\151\156\x20\x61\165\144\x69\x74\40\162\x65\160\157\x72\164\x73\x20\x6d\x61\153\x65\163\x20\151\x74\40\x65\141\163\171\x20\164\x6f\40\x66\151\156\144\x20\x61\156\x64\x20\x6b\x65\x65\160\x20\x74\x72\x61\143\153\40\157\146\40\171\x6f\165\x72\40\x75\163\145\x72\163\56", "\155\x69\156\x69\x6f\162\141\x6e\x67\145\55\x73\141\155\x6c\55\62\x30\55\x73\x69\156\147\154\x65\55\163\151\147\156\55\x6f\156"), "\x62\x75\144\x64\x79\x70\162\145\x73\163" => __("\111\156\x74\x65\147\x72\141\x74\x65\40\x75\x73\x65\x72\40\151\x6e\x66\157\x72\x6d\141\164\151\157\x6e\x20\163\145\x6e\164\x20\x62\171\40\x74\150\145\40\123\101\x4d\114\x20\111\x64\x65\x6e\164\151\164\x79\x20\120\162\x6f\166\151\144\x65\162\x20\151\x6e\x20\x53\101\x4d\x4c\x20\101\x73\163\145\162\164\151\157\156\40\167\x69\x74\150\40\164\x68\145\x20\102\x75\144\x64\x79\x50\x72\x65\163\163\40\x70\162\x6f\146\151\154\145\40\146\151\x65\154\144\x73\56", "\155\151\156\151\x6f\162\141\156\x67\145\55\163\x61\x6d\154\55\62\60\x2d\163\151\x6e\147\154\x65\x2d\x73\151\147\x6e\55\x6f\156"), "\x6c\x65\x61\x72\x6e\144\x61\163\x68" => __("\x41\x6c\154\x6f\x77\x73\x20\x6d\141\160\160\151\156\147\40\x79\x6f\x75\x72\x20\x75\x73\x65\x72\x73\40\164\x6f\x20\144\151\146\146\x65\162\145\156\164\x20\114\x65\141\162\156\x44\x61\x73\150\40\114\115\x53\x20\160\154\x75\147\x69\156\40\x67\162\x6f\165\160\163\x20\141\x73\x20\x70\145\162\40\164\x68\x65\x69\x72\x20\x67\162\157\x75\160\40\151\x6e\x66\157\x72\x6d\141\x74\x69\157\156\40\163\x65\x6e\164\40\x62\x79\40\x63\157\x6e\146\151\147\x75\x72\x65\144\40\x20\x53\x41\x4d\x4c\40\111\144\x65\156\164\x69\x74\x79\40\x50\162\157\x76\151\x64\145\162\56", "\x6d\151\x6e\x69\x6f\162\141\x6e\147\145\55\x73\x61\x6d\x6c\x2d\x32\60\x2d\x73\151\156\x67\x6c\x65\55\163\x69\x67\x6e\x2d\x6f\156"), "\141\x74\x74\162\x69\142\165\x74\x65\x5f\x62\141\163\x65\144\137\162\145\x64\x69\x72\145\143\164\x69\x6f\156" => __("\105\x6e\x61\142\154\x65\x73\x20\171\x6f\165\x20\164\x6f\40\x72\145\144\x69\162\x65\x63\164\x20\171\157\165\162\40\x75\163\145\x72\163\x20\x74\x6f\40\144\x69\146\x66\145\162\145\156\x74\x20\160\x61\x67\145\163\x20\141\x66\164\x65\162\x20\164\150\145\171\x20\x6c\157\x67\x20\151\156\x74\x6f\x20\171\x6f\165\162\40\x73\151\x74\x65\54\x20\x62\x61\163\145\144\x20\157\x6e\x20\x74\150\145\x20\141\164\164\x72\151\x62\165\164\145\x73\40\163\145\x6e\x74\x20\x62\x79\40\x79\157\x75\162\x20\111\x64\145\156\164\151\164\x79\x20\x50\x72\157\166\151\x64\x65\162\x2e", "\x6d\151\156\151\x6f\x72\141\156\147\145\55\x73\x61\155\154\x2d\62\x30\55\x73\151\156\147\154\145\x2d\163\151\x67\156\x2d\157\156"), "\163\x73\157\163\x65\x73\x73\151\157\156" => __("\x48\x65\x6c\x70\163\40\171\x6f\x75\x20\x69\x6e\40\x6d\141\156\141\x67\x69\x6e\147\40\164\150\x65\x20\154\x6f\147\151\x6e\x20\163\145\163\x73\x69\157\x6e\x20\x74\151\x6d\x65\x20\157\x66\40\x79\157\165\162\40\x75\163\145\162\x73\40\x62\141\x73\x65\x64\40\x6f\156\40\164\x68\145\x69\x72\40\x57\157\162\x64\120\162\x65\x73\163\40\x72\157\154\x65\x73\x2e\40\x53\x65\x73\x73\x69\x6f\156\x20\x74\x69\155\145\x20\x66\x6f\162\x20\x72\x6f\154\x65\163\40\x63\x61\156\40\142\x65\40\163\x70\x65\x63\151\x66\151\145\144\x2e", "\155\151\x6e\x69\x6f\x72\x61\x6e\147\x65\55\x73\141\x6d\x6c\55\62\60\x2d\x73\151\x6e\147\154\x65\55\x73\151\x67\156\55\x6f\x6e"), "\x66\163\x73\x6f" => __("\101\x6c\154\157\167\163\40\x73\x65\x63\165\x72\145\40\x61\x63\x63\145\163\163\x20\164\157\x20\164\x68\x65\40\163\151\x74\x65\40\165\163\x69\x6e\x67\40\166\x61\x72\x69\x6f\x75\x73\40\146\x65\x64\145\x72\141\164\x69\x6f\x6e\163\40\x73\165\x63\150\40\141\163\40\x49\156\x43\x6f\x6d\155\x6f\x6e\x2c\40\x48\101\113\101\x2c\x20\110\113\x41\x46\54\x20\145\164\143\x2e\40\125\163\x65\162\x73\x20\x63\x61\x6e\x20\x6c\x6f\147\x20\x69\x6e\x74\157\x20\164\150\x65\40\x57\157\162\144\x50\162\145\x73\x73\x20\163\x69\x74\x65\40\x75\163\151\156\147\40\x74\150\x65\x69\162\x20\165\x6e\x69\x76\145\162\x73\151\x74\171\x20\x63\162\145\144\x65\x6e\x74\151\x61\x6c\163\56", "\155\151\156\x69\157\162\141\x6e\x67\x65\55\x73\141\x6d\154\x2d\62\60\x2d\x73\x69\156\x67\154\145\55\x73\151\x67\156\x2d\157\x6e"), "\155\145\155\x62\145\162\160\x72\x65\163\163" => __("\x4d\x61\x70\40\165\163\x65\162\x73\40\x74\157\40\x64\151\146\x66\145\x72\145\x6e\164\40\x6d\145\155\142\x65\162\x73\150\151\160\40\x6c\x65\x76\145\x6c\x73\x20\143\162\145\141\x74\x65\x64\x20\142\x79\x20\164\150\x65\40\x4d\x65\155\x62\145\x72\120\162\x65\163\163\40\x70\x6c\165\x67\151\156\x20\165\x73\151\x6e\147\x20\164\x68\145\x20\x67\162\x6f\x75\x70\40\x69\x6e\146\x6f\x72\x6d\141\164\x69\x6f\x6e\40\163\145\x6e\x74\40\142\x79\x20\171\157\x75\162\x20\x49\144\x65\156\x74\x69\164\171\40\x50\162\x6f\166\151\144\145\162\56", "\155\151\156\151\157\162\x61\156\147\x65\55\163\x61\155\154\55\x32\x30\55\163\x69\x6e\x67\154\145\55\x73\151\x67\x6e\55\157\156"), "\x77\160\137\x6d\x65\x6d\x62\145\162\x73" => __("\111\x6e\164\145\147\162\141\164\x65\40\x57\x50\55\x6d\x65\x6d\142\145\162\163\40\x66\x69\145\154\144\163\x20\x75\x73\x69\x6e\147\x20\164\x68\x65\x20\x61\164\164\x72\x69\142\x75\164\145\x73\x20\x73\x65\x6e\x74\40\x62\171\x20\171\x6f\x75\162\40\123\101\x4d\x4c\x20\x49\144\145\156\164\151\164\171\x20\x50\x72\157\x76\x69\144\x65\x72\x20\x69\156\x20\164\150\x65\40\x53\101\115\114\40\x41\163\163\x65\x72\x74\151\x6f\x6e\x2e", "\155\151\x6e\x69\157\162\141\x6e\x67\x65\55\x73\141\x6d\x6c\x2d\62\60\55\x73\x69\x6e\x67\154\x65\55\163\151\x67\x6e\55\157\156"), "\x77\157\157\x63\157\x6d\155\x65\162\143\x65" => __("\x4d\x61\160\x20\x57\157\157\x43\x6f\x6d\x6d\x65\162\143\x65\40\143\x68\145\x63\x6b\157\x75\x74\40\x70\141\147\145\x20\146\x69\x65\154\x64\x73\40\x75\x73\x69\x6e\147\x20\164\x68\x65\x20\141\164\164\162\151\142\165\x74\x65\163\x20\x73\x65\156\x74\40\x62\171\40\x79\x6f\165\162\x20\x49\x44\x50\56\x20\124\150\151\163\40\x61\154\163\x6f\x20\141\x6c\154\x6f\167\x73\40\x79\x6f\165\x20\164\157\40\155\x61\160\x20\164\150\x65\40\165\x73\x65\162\x73\40\x69\156\40\x64\x69\x66\146\x65\162\145\156\164\x20\127\x6f\157\x43\157\155\155\x65\x72\x63\145\x20\162\x6f\x6c\x65\x73\x20\142\x61\x73\x65\144\x20\x6f\x6e\x20\x74\x68\x65\x69\x72\x20\111\104\x50\40\x67\162\157\x75\x70\x73\56", "\155\151\156\x69\157\x72\141\156\x67\145\55\x73\x61\x6d\154\x2d\62\x30\55\x73\151\156\147\154\x65\55\163\151\147\156\x2d\157\156"), "\147\x75\x65\163\x74\137\x6c\x6f\x67\151\x6e" => __("\101\x6c\x6c\157\x77\x73\x20\x75\163\145\x72\163\40\164\157\40\x53\123\x4f\40\x69\x6e\x74\157\x20\171\x6f\165\162\40\x73\151\x74\145\40\x77\x69\164\150\x6f\x75\x74\x20\x63\x72\145\141\164\151\x6e\x67\40\x61\40\x75\163\x65\162\x20\x61\x63\143\157\165\156\x74\x20\x66\157\162\x20\x74\150\145\x6d\x2e\40\x54\150\x69\x73\40\x69\x73\40\x75\163\x65\146\x75\154\40\167\150\145\x6e\40\x79\x6f\165\40\144\157\x6e\x74\40\x77\x61\x6e\164\x20\x74\x6f\40\x6d\x61\156\141\147\145\40\164\150\145\x20\165\x73\x65\x72\x20\x61\x63\x63\157\165\x6e\x74\x73\x20\141\164\x20\164\150\145\x20\x57\157\x72\x64\120\x72\x65\163\163\x20\x73\x69\x74\145\56", "\x6d\x69\x6e\151\x6f\x72\x61\156\147\145\55\163\141\x6d\x6c\x2d\x32\x30\55\x73\x69\156\x67\154\x65\55\163\151\147\156\55\x6f\156"), "\160\141\151\x64\137\x6d\x65\x6d\x5f\x70\162\x6f" => __("\115\x61\x70\40\x79\x6f\165\x72\x20\165\x73\x65\x72\163\40\x74\157\40\x64\151\146\x66\145\x72\145\156\164\x20\x50\x61\x69\144\40\x4d\x65\155\x62\x65\x72\163\150\151\x70\120\162\x6f\40\155\145\x6d\142\145\x72\163\150\x69\160\40\154\x65\x76\x65\x6c\x73\x20\141\163\40\160\x65\162\40\x74\x68\145\x20\147\x72\157\165\160\40\x69\x6e\146\157\162\155\x61\164\x69\x6f\x6e\40\x73\x65\156\x74\x20\142\171\x20\x79\x6f\165\162\40\111\x64\145\156\x74\x69\x74\x79\40\120\x72\x6f\x76\x69\144\145\x72\56", "\155\x69\156\151\157\x72\x61\x6e\147\145\x2d\x73\141\x6d\x6c\x2d\62\60\55\x73\151\156\147\x6c\145\x2d\x73\x69\x67\156\x2d\157\x6e"), "\x70\162\157\146\x69\154\x65\137\x70\x69\x63\164\x75\162\x65\137\x61\x64\144\137\x6f\x6e" => __("\115\141\x70\x73\40\162\141\x77\x20\x69\x6d\141\147\145\40\144\x61\164\141\x20\157\x72\40\125\122\114\x20\x72\x65\143\145\x69\x76\145\144\x20\146\162\157\x6d\x20\171\157\x75\x72\40\111\144\145\x6e\x74\x69\164\171\x20\x50\x72\157\x76\x69\144\145\x72\x20\151\156\x74\157\40\x47\162\x61\x76\x61\164\141\x72\x20\x66\157\x72\x20\x74\x68\145\x20\165\163\145\162\56", "\x6d\151\x6e\151\x6f\162\141\x6e\147\x65\x2d\x73\141\155\154\55\x32\60\55\163\151\156\147\x6c\x65\55\163\151\x67\x6e\x2d\x6f\156"));
    echo "\40\x20\x20\40\74\144\x69\166\x20\x69\x64\x3d\42\x6d\x69\x6e\151\157\162\x61\x6e\x67\145\55\x61\x64\144\157\156\x73\x22\x20\x73\x74\171\154\145\75\x22\160\x6f\163\151\164\151\x6f\x6e\x3a\x72\145\x6c\141\x74\x69\166\x65\73\x7a\55\x69\156\x64\x65\x78\x3a\40\61\42\76\15\12\40\x20\40\40\x20\x20\x20\x20\x3c\x70\x20\151\144\x3d\42\162\x65\x63\x6f\x6d\155\145\x6e\144\x65\x64\x5f\x73\x65\x63\164\x69\x6f\156\42\40\163\x74\171\x6c\145\75\42\x66\157\x6e\x74\55\163\x69\x7a\x65\72\x32\x30\160\170\73\x70\141\144\x64\x69\156\x67\x2d\x6c\145\146\x74\x3a\x31\x30\160\170\73\155\141\x72\x67\151\x6e\55\164\157\x70\x3a\x35\160\170\x3b\144\151\163\x70\x6c\x61\x79\x3a\156\157\156\x65\x22\76\74\x62\76";
    _e("\122\x65\x63\157\155\x6d\145\x6e\x64\145\144\x20\101\144\144\x2d\157\156\163\40\146\157\x72\40\x79\157\165", "\155\x69\x6e\x69\x6f\162\141\x6e\x67\145\55\x73\141\155\x6c\x2d\62\x30\x2d\x73\x69\x6e\147\154\145\55\x73\151\x67\x6e\x2d\157\156");
    echo "\x3a\x3c\x2f\x62\x3e\74\x2f\x70\76\xd\12\15\xa\40\40\40\40\40\x20\x20\x20";
    foreach (mo_saml_options_addons::$RECOMMENDED_ADDONS_PATH as $ez => $T5) {
        if (!is_plugin_active($T5)) {
            goto WiY;
        }
        $u2 = $ez;
        $R0[$u2] = $u2;
        echo get_addon_tile($u2, mo_saml_options_addons::$ADDON_TITLE[$u2], $x_[$u2], mo_saml_options_addons::$ADDON_URL[$u2], true);
        WiY:
        Bek:
    }
    sbf:
    if (empty($R0)) {
        goto hOQ;
    }
    echo "\x20\40\40\x20\x20\x20\x20\40\x20\x20\x20\40\x3c\163\143\x72\x69\160\x74\76\15\12\40\40\40\x20\40\40\40\40\x20\40\x20\x20\40\40\40\x20\144\157\x63\165\x6d\145\156\164\56\147\145\164\105\154\x65\155\x65\x6e\x74\x42\x79\x49\x64\x28\x22\x72\x65\143\x6f\x6d\155\145\x6e\x64\145\144\x5f\x73\x65\x63\x74\x69\157\x6e\42\x29\56\x73\x74\x79\x6c\145\x2e\162\x65\155\157\x76\145\x50\162\157\x70\145\x72\x74\x79\x28\x22\144\151\163\160\154\141\x79\42\x29\73\15\xa\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\74\57\x73\143\162\151\160\x74\76\15\xa\40\x20\40\x20\40\40\40\x20\40\x20\x20\40\x3c\150\x72\40\143\154\x61\x73\163\75\x22\x72\x65\143\x6f\155\x6d\x65\156\x64\x65\x64\137\x73\145\143\x74\x69\x6f\156\x22\40\163\x74\171\x6c\x65\75\42\143\154\x65\141\x72\x3a\x62\x6f\x74\150\73\143\x6f\154\x6f\x72\72\40\x62\154\x75\145\73\166\x69\x73\x69\142\x69\154\x69\x74\x79\72\x20\x68\151\144\144\145\156\73\x22\76\15\12\x20\40\x20\x20\x20\40\40\x20\40\40\40\40\74\x62\x72\x2f\x3e\xd\12\40\x20\40\40\40\x20\40\x20\40\40\40\x20";
    hOQ:
    echo "\x20\40\40\x20\40\x20\x20\40\x3c\160\x20\163\x74\x79\x6c\145\75\x22\146\157\156\x74\x2d\163\x69\172\145\72\62\x30\160\170\73\160\141\x64\144\151\156\147\55\x6c\145\146\x74\x3a\x31\x30\x70\170\x3b\155\x61\162\147\x69\156\55\164\x6f\x70\x3a\x35\x70\170\73\x22\76\74\142\x3e";
    _e("\x43\150\145\x63\x6b\x20\157\165\164\40\x61\154\154\40\x6f\165\x72\40\x61\144\x64\55\157\x6e\x73", "\x6d\x69\x6e\151\x6f\162\x61\x6e\147\145\x2d\163\141\x6d\154\55\62\x30\55\163\151\x6e\x67\154\x65\55\163\x69\x67\x6e\55\x6f\156");
    echo "\72\74\57\142\x3e\x3c\57\160\76\15\xa\15\xa\x20\40\x20\40\40\x20\40\x20";
    foreach ($x_ as $ez => $T5) {
        if (in_array($ez, $R0)) {
            goto eZ9;
        }
        echo get_addon_tile($ez, mo_saml_options_addons::$ADDON_TITLE[$ez], $T5, mo_saml_options_addons::$ADDON_URL[$ez], false);
        eZ9:
        mKF:
    }
    iZk:
    echo "\40\x20\40\40\x3c\x2f\144\151\166\x3e\40";
}
function get_addon_tile($Fd, $B6, $x_, $qd, $wC)
{
    $B7 = plugins_url("\56\x2e\x2f\151\x6d\x61\147\145\x73\57\141\x64\144\157\x6e\163\x5f\154\157\x67\157\x73\x2f" . $Fd . "\56\x70\156\x67", __FILE__);
    echo "\x20\40\x20\x20\x3c\x64\151\x76\x20\x63\154\141\x73\x73\75\x22\x72\x6f\167\42\76\15\12\40\x20\x20\40\40\x20\40\40\74\x64\151\x76\x20\x63\154\141\163\x73\x3d\42\147\x72\151\144\137\166\151\x65\x77\x22\x3e\40";
    if ($wC) {
        goto M0Y;
    }
    echo "\x20\40\x20\x20\x20\40\x20\x20\x20\40\40\40\40\40\x20\x20\x3c\144\151\166\40\143\x6c\x61\163\x73\x3d\42\x63\x61\x72\144\42\x3e\40";
    goto yvS;
    M0Y:
    echo "\x20\40\40\40\x20\x20\x20\x20\x20\x20\x20\40\x3c\144\151\166\x20\x63\154\x61\x73\x73\x3d\42\x63\x61\162\x64\40\164\x65\170\164\x2d\x78\x73\x2d\143\x65\156\x74\x65\x72\42\x3e\40";
    yvS:
    echo "\x20\40\40\40\x20\x20\40\40\40\x20\x20\x20\40\40\x20\x20\x20\x20\40\40\x3c\144\x69\x76\40\x63\x6c\x61\163\x73\x3d\42\x61\144\x64\157\x6e\x2d\150\145\x61\x64\145\162\x22\x3e\xd\xa\40\x20\x20\40\40\x20\x20\x20\x20\40\40\40\40\x20\40\40\x20\40\x20\40\40\x20\40\x20\x3c\x69\155\147\40\x73\162\x63\75\42";
    echo $B7;
    echo "\42\x20\x63\154\141\x73\163\75\42\141\x64\144\157\x6e\x2d\151\x6d\x67\x22\x3e\15\12\x20\x20\40\40\x20\40\40\x20\x20\40\40\x20\x20\x20\40\40\x20\x20\40\40\x20\x20\40\x20\74\144\151\x76\40\x63\x6c\x61\163\163\x3d\x22\x61\x64\144\157\156\55\150\x65\141\x64\151\x6e\x67\42\76\15\12\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\40\40\40\40\40\40\40\x20\x20\x20\40\40\x20\74\x64\151\166\40\143\x6c\141\163\x73\x3d\42\x63\141\x72\144\x2d\164\x69\164\x6c\145\42\x3e\x20";
    echo $B6;
    echo "\x20\x3c\x2f\x64\151\x76\76\15\xa\x20\x20\x20\40\x20\40\40\x20\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\40\40\40\40\x20\74\57\x64\x69\166\76\xd\xa\40\40\40\40\x20\40\40\40\40\40\40\40\x20\40\40\40\x20\x20\x20\x20\x3c\57\144\x69\166\76\xd\xa\40\x20\40\40\x20\x20\40\x20\40\40\x20\x20\40\40\40\x20\x20\x20\x20\x20\x3c\x64\x69\x76\x20\x73\164\171\x6c\145\x3d\42\x77\x69\x64\x74\150\72\61\x30\60\x25\x3b\42\76\xd\12\x20\x20\40\40\40\40\40\x20\40\x20\x20\x20\40\40\40\x20\x20\40\x20\x20\x20\x20\40\40\x3c\x70\x20\143\154\141\163\163\x3d\x22\143\x61\162\x64\55\164\145\x78\x74\x22\x3e";
    echo $x_;
    echo "\x3c\x2f\x70\76\xd\xa\x20\40\40\x20\x20\x20\40\x20\40\40\40\40\x20\40\40\40\40\x20\x20\x20\x20\x20\x20\x20\x3c\x64\x69\x76\x3e\x3c\142\165\164\x74\157\156\x20\x63\154\141\163\163\75\42\142\x74\x6e\x2d\141\x64\144\157\156\x20\142\x74\x6e\55\141\144\x64\157\x6e\55\x67\x72\x61\144\42\40\x6f\x6e\143\154\x69\143\x6b\75\42\167\x69\156\144\157\x77\56\157\160\145\156\x28\x27";
    echo $qd;
    echo "\x27\51\x3b\42\x3e";
    _e("\114\x65\x61\162\x6e\x20\x4d\157\162\145", "\x6d\151\x6e\151\x6f\162\141\x6e\147\145\x2d\x73\x61\155\154\55\x32\60\x2d\x73\151\156\147\154\x65\x2d\163\151\x67\x6e\x2d\x6f\156");
    echo "\74\x2f\142\x75\164\164\x6f\x6e\x3e\x3c\57\x64\x69\x76\x3e\xd\xa\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\40\x20\40\x20\x20\40\40\40\x20\74\57\144\151\x76\76\15\xa\x20\40\x20\40\x20\40\40\x20\40\40\40\40\x20\x20\40\x20\74\x2f\144\151\x76\x3e\xd\12\40\x20\40\40\x20\40\x20\x20\x20\x20\40\40\x3c\57\x64\151\x76\x3e\xd\12\x20\x20\40\40\40\x20\x20\x20\x3c\57\144\151\x76\76\xd\12\x20\x20\40\x20";
}
