<?php


include_once dirname(__FILE__) . "\57\x55\164\x69\154\x69\164\151\x65\163\56\160\x68\x70";
include_once dirname(__FILE__) . "\57\x52\x65\163\x70\x6f\156\163\145\x2e\x70\x68\160";
include_once dirname(__FILE__) . "\57\x4c\157\147\157\x75\164\x52\x65\x71\165\145\163\x74\56\x70\x68\160";
require_once dirname(__FILE__) . "\57\151\156\143\x6c\165\144\x65\x73\x2f\x6c\x69\x62\57\x65\x6e\143\x72\171\160\x74\151\157\x6e\x2e\160\x68\x70";
include_once "\x78\x6d\x6c\x73\145\143\x6c\x69\142\163\x2e\160\150\160";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
class mo_login_wid extends WP_Widget
{
    public function __construct()
    {
        $iD = get_site_option("\163\x61\x6d\x6c\137\x69\x64\145\156\164\151\164\171\137\156\141\x6d\x65");
        parent::__construct("\x53\141\x6d\154\137\114\157\x67\x69\x6e\137\127\x69\144\147\x65\164", "\114\157\147\151\x6e\x20\167\151\164\x68\40" . $iD, array("\x64\145\163\143\162\x69\x70\x74\x69\157\156" => __("\x54\x68\x69\x73\40\151\163\40\141\40\x6d\151\x6e\x69\117\x72\x61\156\147\145\40\x53\x41\x4d\x4c\x20\x6c\x6f\x67\x69\156\x20\x77\151\x64\x67\x65\x74\56", "\155\x6f\163\x61\155\x6c")));
    }
    public function widget($qW, $pu)
    {
        extract($qW);
        $o9 = apply_filters("\x77\151\x64\x67\x65\164\x5f\x74\x69\x74\154\x65", $pu["\167\151\144\x5f\164\151\164\154\x65"]);
        echo $qW["\142\x65\146\157\162\145\137\x77\x69\144\x67\x65\164"];
        if (empty($o9)) {
            goto uF;
        }
        echo $qW["\x62\x65\x66\x6f\162\x65\137\164\x69\x74\154\145"] . $o9 . $qW["\x61\x66\x74\145\x72\137\164\x69\x74\154\x65"];
        uF:
        $this->loginForm();
        echo $qW["\x61\x66\x74\145\162\x5f\x77\x69\144\x67\x65\x74"];
    }
    public function update($sz, $vN)
    {
        $pu = array();
        $pu["\167\151\144\137\164\x69\x74\154\x65"] = strip_tags($sz["\x77\x69\144\x5f\x74\151\164\154\145"]);
        return $pu;
    }
    public function form($pu)
    {
        $o9 = '';
        if (!array_key_exists("\x77\151\x64\x5f\x74\151\x74\x6c\145", $pu)) {
            goto O_;
        }
        $o9 = $pu["\167\151\x64\x5f\x74\x69\164\154\x65"];
        O_:
        echo "\15\xa\11\x9\x3c\x70\x3e\x3c\154\141\x62\145\154\40\146\157\162\x3d\42" . $this->get_field_id("\x77\x69\x64\x5f\164\x69\x74\154\145") . "\40\x22\x3e" . _e("\x54\x69\x74\154\x65\72") . "\x20\74\x2f\154\x61\x62\x65\x6c\76\15\xa\x9\11\x9\74\x69\156\x70\x75\x74\x20\143\x6c\x61\x73\163\x3d\x22\x77\x69\x64\145\x66\141\x74\42\x20\151\144\x3d\x22" . $this->get_field_id("\167\x69\144\x5f\x74\151\x74\x6c\x65") . "\42\x20\156\x61\x6d\x65\x3d\x22" . $this->get_field_name("\167\151\144\x5f\x74\x69\x74\x6c\x65") . "\42\40\x74\171\x70\145\75\42\x74\x65\x78\x74\x22\x20\166\141\x6c\165\145\75\x22" . $o9 . "\42\x20\57\x3e\15\xa\x9\11\74\x2f\x70\x3e";
    }
    public function loginForm()
    {
        global $post;
        $A7 = get_site_option("\163\x61\155\x6c\x5f\163\163\157\137\x73\145\164\164\x69\x6e\x67\x73");
        $I7 = get_current_blog_id();
        $P0 = Utilities::get_active_sites();
        if (in_array($I7, $P0)) {
            goto y8;
        }
        return;
        y8:
        if (!(empty($A7[$I7]) && !empty($A7["\x44\105\106\x41\125\114\x54"]))) {
            goto aX;
        }
        $A7[$I7] = $A7["\x44\105\x46\101\x55\114\124"];
        aX:
        if (!is_user_logged_in()) {
            goto G4;
        }
        $current_user = wp_get_current_user();
        $t2 = "\x48\145\154\154\x6f\x2c";
        if (empty($A7[$I7]["\x6d\x6f\137\x73\141\155\x6c\137\143\x75\163\x74\x6f\155\137\147\162\x65\145\x74\x69\156\x67\137\x74\x65\x78\164"])) {
            goto e4;
        }
        $t2 = $A7[$I7]["\x6d\x6f\137\x73\141\x6d\154\x5f\x63\x75\x73\164\x6f\x6d\137\x67\162\145\x65\164\151\156\x67\x5f\x74\x65\x78\x74"];
        e4:
        $fh = '';
        if (empty($A7[$I7]["\x6d\157\x5f\x73\x61\x6d\154\137\147\162\x65\145\164\x69\156\147\137\x6e\x61\155\x65"])) {
            goto fm;
        }
        switch ($A7[$I7]["\155\157\x5f\163\141\155\154\137\x67\x72\x65\x65\x74\151\x6e\147\137\x6e\141\155\x65"]) {
            case "\x55\123\x45\x52\x4e\x41\x4d\x45":
                $fh = $current_user->user_login;
                goto lI;
            case "\x45\115\x41\x49\114":
                $fh = $current_user->user_email;
                goto lI;
            case "\106\116\101\x4d\x45":
                $fh = $current_user->user_firstname;
                goto lI;
            case "\114\x4e\101\115\x45":
                $fh = $current_user->user_lastname;
                goto lI;
            case "\x46\x4e\x41\115\105\x5f\x4c\116\101\x4d\x45":
                $fh = $current_user->user_firstname . "\x20" . $current_user->user_lastname;
                goto lI;
            case "\114\x4e\x41\x4d\105\x5f\106\116\101\x4d\105":
                $fh = $current_user->user_lastname . "\x20" . $current_user->user_firstname;
                goto lI;
            default:
                $fh = $current_user->user_login;
        }
        BV:
        lI:
        fm:
        if (!empty(trim($fh))) {
            goto xk;
        }
        $fh = $current_user->user_login;
        xk:
        $G4 = $t2 . "\x20" . $fh;
        $QF = "\x4c\x6f\x67\157\165\164";
        if (empty($A7[$I7]["\155\x6f\137\x73\x61\x6d\x6c\x5f\143\x75\163\x74\157\155\x5f\154\x6f\x67\157\165\164\x5f\164\145\x78\164"])) {
            goto f4;
        }
        $QF = $A7[$I7]["\x6d\x6f\x5f\x73\141\155\x6c\137\x63\165\x73\x74\x6f\x6d\x5f\154\157\x67\x6f\x75\164\x5f\164\x65\x78\164"];
        f4:
        echo $G4 . "\40\x7c\40\74\141\x20\x68\162\x65\146\75\42" . wp_logout_url(home_url()) . "\x22\40\164\x69\x74\154\145\x3d\x22\x6c\x6f\147\157\165\x74\42\40\x3e" . $QF . "\74\x2f\141\x3e\74\57\x6c\x69\x3e";
        goto zv;
        G4:
        echo "\15\xa\x9\11\x9\74\163\x63\x72\x69\160\164\76\xd\xa\11\11\11\x9\146\165\156\143\x74\151\157\156\40\163\x75\142\155\x69\164\123\141\155\154\106\x6f\162\x6d\50\x29\x7b\40\144\157\143\165\x6d\145\x6e\x74\x2e\x67\145\x74\x45\154\x65\x6d\145\156\x74\x42\x79\x49\x64\x28\42\x6c\x6f\x67\x69\x6e\42\x29\x2e\x73\x75\142\155\x69\164\50\51\73\x20\175\15\12\x9\x9\x9\74\57\x73\143\x72\151\160\x74\x3e\15\xa\11\11\11\x3c\x66\157\x72\155\x20\156\141\155\145\75\x22\x6c\157\147\x69\x6e\42\40\x69\144\x3d\x22\x6c\157\147\x69\156\x22\x20\x6d\145\164\150\157\144\x3d\x22\160\x6f\x73\164\42\40\x61\x63\164\x69\157\156\x3d\x22\42\76\xd\12\x9\11\11\11\x3c\x69\x6e\160\165\x74\x20\x74\171\x70\x65\x3d\42\x68\151\x64\x64\145\156\42\x20\156\x61\x6d\x65\x3d\x22\x6f\160\x74\151\x6f\x6e\42\40\166\x61\x6c\x75\x65\x3d\42\163\141\x6d\x6c\137\x75\x73\x65\162\137\x6c\157\147\151\x6e\42\40\x2f\76\xd\12\15\12\x9\11\x9\x9\x3c\146\x6f\156\164\40\163\x69\172\x65\75\42\53\x31\42\40\x73\x74\171\x6c\145\75\42\x76\145\x72\x74\151\x63\x61\154\x2d\x61\x6c\151\x67\156\x3a\164\x6f\160\73\x22\76\40\x3c\57\x66\x6f\x6e\164\76";
        $B0 = get_site_option("\163\141\155\154\x5f\151\x64\x65\156\164\151\164\171\x5f\156\x61\155\x65");
        $ea = get_site_option("\163\141\155\154\137\170\x35\60\71\x5f\x63\145\x72\164\151\146\x69\143\x61\x74\145");
        if (!empty($B0) && !empty($ea)) {
            goto Ox;
        }
        echo "\x50\154\x65\141\163\x65\x20\x63\157\156\x66\x69\x67\x75\162\145\x20\164\150\x65\40\x6d\151\156\151\117\x72\x61\156\x67\x65\40\123\x41\115\114\x20\x50\x6c\x75\x67\x69\x6e\x20\146\151\162\163\x74\56";
        goto uc;
        Ox:
        $Ed = "\114\157\x67\151\x6e\x20\x77\x69\164\150\x20\43\43\x49\x44\120\x23\43";
        if (empty($A7[$I7]["\155\x6f\137\x73\141\x6d\x6c\137\143\165\x73\x74\x6f\155\137\154\x6f\x67\x69\156\137\164\x65\x78\164"])) {
            goto NJ;
        }
        $Ed = $A7[$I7]["\155\157\x5f\x73\141\x6d\x6c\137\x63\x75\163\x74\x6f\155\137\154\x6f\147\x69\156\137\x74\145\x78\164"];
        NJ:
        $Ed = str_replace("\x23\x23\x49\104\x50\x23\43", $B0, $Ed);
        $kQ = false;
        if (!(isset($A7[$I7]["\155\x6f\137\163\x61\155\154\137\x75\163\145\x5f\x62\x75\164\x74\157\x6e\x5f\x61\163\x5f\167\151\x64\x67\x65\x74"]) && $A7[$I7]["\155\157\137\163\141\x6d\154\137\x75\x73\x65\137\x62\165\x74\164\x6f\156\x5f\x61\x73\x5f\167\151\x64\x67\x65\164"] == "\x74\x72\165\x65")) {
            goto hM;
        }
        $kQ = true;
        hM:
        if (!$kQ) {
            goto wM;
        }
        $QP = isset($A7[$I7]["\155\157\137\163\x61\x6d\x6c\x5f\x62\x75\164\164\x6f\x6e\137\167\151\144\164\150"]) ? $A7[$I7]["\155\x6f\x5f\x73\141\x6d\154\137\142\165\x74\x74\157\156\x5f\x77\151\x64\x74\150"] : "\61\x30\60";
        $w5 = isset($A7[$I7]["\155\157\137\163\141\155\x6c\x5f\x62\x75\x74\164\157\x6e\x5f\x68\145\151\x67\150\164"]) ? $A7[$I7]["\155\x6f\137\163\141\x6d\154\x5f\x62\x75\164\164\157\156\x5f\x68\x65\151\147\x68\x74"] : "\65\60";
        $t6 = isset($A7[$I7]["\x6d\x6f\x5f\x73\x61\155\x6c\x5f\142\x75\164\164\x6f\x6e\x5f\x73\x69\x7a\x65"]) ? $A7[$I7]["\155\157\137\163\141\155\154\137\142\165\164\164\157\156\137\x73\151\172\x65"] : "\65\60";
        $Yq = isset($A7[$I7]["\155\x6f\137\163\x61\155\154\x5f\x62\x75\x74\x74\157\x6e\137\143\165\x72\x76\145"]) ? $A7[$I7]["\x6d\157\x5f\x73\141\155\x6c\x5f\142\165\164\164\157\x6e\137\143\165\162\166\145"] : "\x35";
        $Ur = isset($A7[$I7]["\x6d\x6f\137\163\x61\155\x6c\x5f\142\165\164\x74\x6f\156\137\143\157\x6c\157\162"]) ? $A7[$I7]["\155\x6f\137\163\x61\x6d\x6c\x5f\x62\x75\x74\x74\157\x6e\x5f\x63\157\x6c\157\162"] : "\60\x30\70\x35\x62\x61";
        $TE = isset($A7[$I7]["\155\x6f\x5f\x73\141\155\x6c\137\x62\x75\164\x74\x6f\156\x5f\x74\150\145\x6d\x65"]) ? $A7[$I7]["\x6d\157\137\x73\141\x6d\x6c\x5f\x62\165\164\x74\157\x6e\137\164\x68\x65\x6d\x65"] : "\x6c\x6f\x6e\x67\x62\165\x74\164\x6f\x6e";
        $lF = isset($A7[$I7]["\155\x6f\137\163\141\x6d\154\137\142\165\164\x74\157\156\x5f\x74\x65\170\164"]) ? $A7[$I7]["\x6d\157\x5f\x73\141\155\x6c\x5f\142\165\x74\164\157\x6e\137\164\145\170\164"] : (get_site_option("\163\141\x6d\x6c\x5f\151\144\145\156\164\151\164\171\x5f\x6e\141\155\145") ? get_site_option("\x73\x61\x6d\154\x5f\x69\144\x65\156\164\x69\x74\x79\x5f\x6e\x61\155\x65") : "\114\157\147\x69\156");
        $mC = isset($A7[$I7]["\x6d\157\137\163\141\x6d\154\x5f\146\x6f\x6e\164\137\x63\x6f\154\157\162"]) ? $A7[$I7]["\155\157\x5f\163\x61\155\154\x5f\146\x6f\156\x74\x5f\143\157\x6c\157\162"] : "\x66\146\x66\146\146\146";
        $zH = isset($A7[$I7]["\155\x6f\x5f\x73\x61\x6d\154\137\x66\157\x6e\x74\137\x73\x69\x7a\x65"]) ? $A7[$I7]["\x6d\x6f\x5f\163\x61\x6d\154\137\x66\157\x6e\x74\137\x73\151\172\145"] : "\x32\x30";
        $NA = isset($A7[$I7]["\x73\x73\x6f\x5f\142\165\x74\x74\157\x6e\x5f\x6c\x6f\x67\x69\x6e\137\146\157\x72\x6d\137\x70\x6f\x73\151\164\x69\x6f\156"]) ? $A7[$I7]["\163\x73\157\x5f\x62\165\164\x74\157\156\137\x6c\x6f\147\151\x6e\137\146\x6f\162\x6d\x5f\x70\157\x73\x69\x74\x69\157\156"] : "\x61\x62\157\166\x65";
        $Ed = "\x3c\x69\156\x70\165\x74\x20\164\171\160\145\75\x22\142\165\164\164\157\x6e\x22\40\156\141\x6d\x65\75\42\x6d\x6f\137\x73\141\155\x6c\137\x77\160\137\x73\163\x6f\137\x62\x75\x74\164\x6f\x6e\x22\40\166\141\154\x75\x65\75\42" . $lF . "\42\40\163\164\x79\x6c\145\x3d\x22";
        $Xn = '';
        if ($TE == "\154\157\156\147\x62\165\164\164\157\x6e") {
            goto fZ;
        }
        if ($TE == "\x63\x69\162\x63\x6c\x65") {
            goto oE;
        }
        if ($TE == "\157\x76\141\154") {
            goto bM;
        }
        if ($TE == "\x73\161\x75\141\162\x65") {
            goto Zc;
        }
        goto Wy;
        oE:
        $Xn = $Xn . "\167\151\144\x74\150\x3a" . $t6 . "\160\170\x3b";
        $Xn = $Xn . "\x68\x65\x69\147\150\x74\x3a" . $t6 . "\x70\x78\73";
        $Xn = $Xn . "\142\x6f\162\144\145\x72\55\x72\141\144\x69\165\163\72\x39\x39\71\x70\x78\73";
        goto Wy;
        bM:
        $Xn = $Xn . "\167\151\x64\x74\150\72" . $t6 . "\160\x78\73";
        $Xn = $Xn . "\150\x65\x69\x67\x68\x74\72" . $t6 . "\x70\170\73";
        $Xn = $Xn . "\x62\x6f\162\x64\145\x72\x2d\162\141\144\151\x75\x73\x3a\x35\160\x78\73";
        goto Wy;
        Zc:
        $Xn = $Xn . "\167\151\x64\164\x68\72" . $t6 . "\x70\x78\x3b";
        $Xn = $Xn . "\150\145\x69\147\x68\x74\72" . $t6 . "\160\170\73";
        $Xn = $Xn . "\142\157\162\x64\x65\162\55\x72\x61\x64\x69\165\x73\72\60\x70\x78\x3b";
        Wy:
        goto Pr;
        fZ:
        $Xn = $Xn . "\167\x69\x64\x74\150\72" . $QP . "\160\170\x3b";
        $Xn = $Xn . "\x68\145\151\147\x68\164\x3a" . $w5 . "\x70\x78\x3b";
        $Xn = $Xn . "\x62\x6f\x72\144\145\x72\x2d\162\x61\x64\x69\x75\163\72" . $Yq . "\160\x78\73";
        Pr:
        $Xn = $Xn . "\x62\141\x63\153\147\x72\157\x75\x6e\144\x2d\x63\x6f\x6c\x6f\x72\x3a\43" . $Ur . "\x3b";
        $Xn = $Xn . "\x62\x6f\x72\x64\145\x72\55\x63\157\x6c\x6f\x72\x3a\x74\x72\141\x6e\x73\160\x61\x72\145\x6e\164\x3b";
        $Xn = $Xn . "\143\157\x6c\x6f\162\72\43" . $mC . "\73";
        $Xn = $Xn . "\x66\157\x6e\x74\55\163\x69\172\145\72" . $zH . "\160\x78\x3b";
        $Xn = $Xn . "\x70\141\x64\144\151\x6e\147\x3a\60\160\170\73";
        $Ed = $Ed . $Xn . "\x22\57\x3e";
        wM:
        echo "\x20\x3c\x61\x20\x68\162\145\146\75\42\43\42\x20\157\x6e\x43\x6c\151\143\153\75\42\x73\x75\x62\x6d\151\164\123\x61\x6d\x6c\106\x6f\x72\155\x28\51\x22\x3e";
        echo $Ed;
        echo "\74\x2f\141\x3e\74\x2f\146\x6f\162\x6d\76\40";
        uc:
        if ($this->mo_saml_check_empty_or_null_val(get_site_option("\x6d\x6f\x5f\x73\141\x6d\x6c\x5f\162\145\144\151\x72\145\x63\x74\x5f\145\x72\x72\x6f\162\x5f\143\x6f\x64\x65"))) {
            goto OJ;
        }
        echo "\x3c\x64\151\166\x3e\74\57\x64\151\166\76\74\x64\x69\166\40\x74\x69\164\154\x65\75\x22\x4c\157\x67\151\156\40\105\x72\162\x6f\162\42\x3e\x3c\146\x6f\x6e\164\x20\143\157\x6c\157\x72\75\42\162\145\144\x22\x3e\x57\x65\x20\x63\x6f\165\154\x64\40\x6e\x6f\164\x20\163\x69\147\156\x20\x79\157\x75\40\151\156\x2e\40\120\154\145\141\x73\145\x20\x63\x6f\x6e\x74\x61\x63\164\40\171\157\165\162\x20\101\144\x6d\151\x6e\x69\163\x74\162\x61\164\157\162\56\x3c\x2f\x66\x6f\x6e\x74\x3e\74\x2f\144\x69\x76\x3e";
        delete_site_option("\155\157\137\x73\141\155\x6c\x5f\x72\x65\144\x69\162\x65\x63\x74\x5f\145\x72\162\x6f\162\137\x63\157\144\145");
        delete_site_option("\x6d\157\137\x73\141\x6d\x6c\x5f\x72\x65\x64\x69\162\x65\143\x74\x5f\x65\x72\x72\x6f\162\x5f\162\x65\141\x73\x6f\x6e");
        OJ:
        echo "\x3c\141\x20\x68\x72\145\x66\x3d\x22\150\164\x74\x70\72\57\57\x6d\151\156\151\x6f\162\141\156\147\x65\56\x63\157\x6d\57\x77\x6f\x72\x64\x70\x72\145\163\163\x2d\154\144\x61\160\x2d\x6c\x6f\147\x69\x6e\x22\x20\163\164\x79\x6c\145\x3d\x22\x64\x69\163\160\154\x61\x79\x3a\x6e\157\x6e\x65\42\x3e\x4c\x6f\147\151\156\x20\164\x6f\x20\127\x6f\x72\144\120\162\x65\x73\x73\40\165\163\151\156\147\40\x4c\x44\101\x50\x3c\57\141\x3e\15\12\11\x9\x9\x9\74\141\40\x68\162\145\146\75\42\x68\x74\x74\160\x3a\57\57\x6d\151\x6e\151\x6f\162\141\156\x67\x65\x2e\x63\157\155\x2f\143\x6c\157\x75\144\55\x69\144\145\156\164\x69\164\171\55\142\162\x6f\153\145\162\x2d\163\x65\162\166\x69\143\x65\42\x20\x73\164\171\154\x65\75\42\x64\151\x73\x70\x6c\x61\x79\72\x6e\x6f\x6e\x65\x22\76\x43\154\157\165\144\40\111\x64\x65\156\x74\x69\x74\x79\40\142\x72\x6f\153\x65\x72\x20\x73\x65\162\x76\151\x63\145\x3c\57\x61\76\xd\12\x9\x9\11\x9\x3c\x61\x20\x68\x72\145\x66\75\42\x68\164\164\x70\x3a\57\x2f\155\151\156\151\x6f\162\x61\x6e\x67\145\56\143\157\155\57\163\x74\162\x6f\x6e\147\137\x61\165\164\150\x22\40\x73\x74\x79\x6c\145\75\x22\144\x69\x73\x70\154\141\171\x3a\x6e\157\x6e\x65\73\x22\x3e\x3c\57\x61\x3e\xd\xa\11\11\x9\11\74\141\40\x68\x72\x65\x66\75\x22\x68\x74\x74\x70\x3a\57\57\x6d\x69\x6e\x69\x6f\162\x61\156\x67\145\56\x63\x6f\x6d\57\x73\151\156\147\154\145\x2d\163\151\x67\x6e\x2d\x6f\156\x2d\x73\163\x6f\x22\x20\x73\x74\171\154\145\x3d\x22\x64\x69\163\160\154\x61\x79\x3a\x6e\x6f\156\x65\x3b\42\x3e\74\57\141\76\15\12\x9\11\x9\11\74\x61\40\x68\162\x65\x66\x3d\x22\150\164\164\x70\x3a\57\x2f\155\x69\156\x69\x6f\x72\141\156\147\145\x2e\143\x6f\x6d\x2f\146\162\x61\x75\x64\x22\40\x73\x74\x79\x6c\145\x3d\x22\144\x69\163\x70\x6c\141\171\x3a\156\x6f\x6e\145\x3b\42\76\74\x2f\141\x3e\15\xa\xd\12\x9\11\11\74\x2f\x75\x6c\76\15\12\11\x9\74\x2f\x66\157\x72\x6d\x3e";
        zv:
    }
    public function mo_saml_check_empty_or_null_val($Ng)
    {
        if (!(!isset($Ng) || empty($Ng))) {
            goto gO;
        }
        return true;
        gO:
        return false;
    }
    function mo_saml_logout($Yu, $uT, $user)
    {
        $hi = get_site_option("\163\141\155\x6c\x5f\x6c\x6f\147\x6f\x75\x74\x5f\165\x72\x6c");
        $TQ = get_site_option("\x73\x61\x6d\x6c\x5f\154\157\147\157\x75\x74\137\142\151\156\x64\x69\156\147\137\x74\171\x70\145");
        $current_user = $user;
        $T3 = get_user_meta($current_user->ID, "\155\157\137\163\x61\x6d\154\137\x69\144\160\137\x6c\x6f\x67\x69\156");
        $T3 = isset($T3[0]) ? $T3[0] : '';
        $uV = wp_get_referer();
        if (!empty($uV)) {
            goto jR;
        }
        $uV = !empty(get_site_option("\155\157\137\x73\x61\x6d\154\x5f\163\x70\137\x62\141\163\x65\x5f\165\x72\x6c")) ? get_site_option("\x6d\157\x5f\163\x61\155\154\x5f\x73\x70\137\x62\x61\x73\x65\x5f\x75\162\154") : get_network_site_url();
        jR:
        if (!empty($hi)) {
            goto eD;
        }
        wp_redirect($uV);
        exit;
        goto y2;
        eD:
        if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
            goto Kx;
        }
        session_start();
        Kx:
        if (isset($_SESSION["\x6d\157\x5f\x73\x61\x6d\x6c\137\154\157\147\x6f\x75\164\x5f\x72\x65\x71\x75\145\x73\x74"])) {
            goto cH;
        }
        if ($T3 == "\164\x72\165\145") {
            goto xZ;
        }
        wp_redirect($uV);
        exit;
        goto A9;
        cH:
        self::createLogoutResponseAndRedirect($hi, $TQ);
        exit;
        goto A9;
        xZ:
        delete_user_meta($current_user->ID, "\155\157\137\163\141\155\x6c\137\151\x64\160\137\154\x6f\x67\151\x6e");
        $f1 = get_user_meta($current_user->ID, "\155\x6f\x5f\163\141\x6d\154\x5f\156\141\x6d\145\137\151\x64");
        $q1 = get_user_meta($current_user->ID, "\155\x6f\137\163\x61\x6d\x6c\137\x73\x65\x73\163\x69\157\x6e\137\x69\156\x64\x65\170");
        $jt = get_site_option("\155\157\137\163\x61\x6d\154\x5f\x73\160\x5f\142\x61\163\x65\x5f\165\x72\154");
        if (!empty($jt)) {
            goto Z0;
        }
        $jt = get_network_site_url();
        Z0:
        $N5 = get_site_option("\155\157\x5f\163\141\155\x6c\x5f\x73\x70\137\x65\x6e\x74\151\x74\171\x5f\151\144");
        if (!empty($N5)) {
            goto Wp;
        }
        $N5 = $jt . "\x2f\x77\x70\x2d\x63\157\156\164\x65\156\x74\x2f\x70\x6c\165\x67\x69\x6e\163\57\155\151\156\151\157\x72\x61\x6e\147\145\55\163\141\155\154\x2d\62\x30\x2d\163\x69\x6e\x67\154\145\x2d\x73\151\147\x6e\55\157\x6e\57";
        Wp:
        $b1 = $hi;
        $MF = $uV;
        if (!empty($MF)) {
            goto Mc;
        }
        $MF = saml_get_current_page_url();
        if (!strpos($MF, "\x3f")) {
            goto JI;
        }
        $MF = get_network_site_url();
        JI:
        Mc:
        $MF = mo_saml_relaystate_url($MF);
        $Qh = Utilities::createLogoutRequest($f1, $N5, $b1, $q1, $TQ);
        if (empty($TQ) || $TQ == "\110\164\164\160\x52\x65\144\x69\162\145\x63\x74") {
            goto uz;
        }
        if (!(get_site_option("\163\x61\x6d\x6c\x5f\162\x65\161\165\x65\x73\164\x5f\163\x69\x67\x6e\145\144") == "\x75\156\143\x68\x65\143\x6b\145\x64")) {
            goto ER;
        }
        $WO = base64_encode($Qh);
        Utilities::postSAMLRequest($hi, $WO, $MF);
        exit;
        ER:
        $ng = '';
        $Yg = '';
        $WO = Utilities::signXML($Qh, "\116\141\x6d\x65\111\104\x50\x6f\x6c\x69\x63\x79");
        Utilities::postSAMLRequest($hi, $WO, $MF);
        goto ju;
        uz:
        $UF = $hi;
        if (strpos($hi, "\x3f") !== false) {
            goto x6;
        }
        $UF .= "\77";
        goto Ar;
        x6:
        $UF .= "\46";
        Ar:
        if (!(get_site_option("\163\141\x6d\x6c\x5f\162\x65\x71\165\x65\x73\x74\137\163\151\147\x6e\145\x64") == "\165\x6e\143\150\145\x63\153\x65\144")) {
            goto D7;
        }
        $UF .= "\123\101\x4d\x4c\x52\145\161\165\x65\163\164\x3d" . $Qh . "\x26\x52\x65\x6c\141\x79\123\164\141\x74\145\75" . urlencode($MF);
        header("\x4c\157\143\141\164\151\157\156\x3a\40" . $UF);
        exit;
        D7:
        $Qh = "\123\x41\x4d\114\x52\145\x71\x75\x65\163\x74\75" . $Qh . "\x26\122\145\154\141\x79\123\164\x61\x74\x65\75" . urlencode($MF) . "\x26\x53\151\x67\x41\154\x67\x3d" . urlencode(XMLSecurityKey::RSA_SHA256);
        $IP = array("\x74\x79\x70\x65" => "\x70\162\151\x76\x61\x74\145");
        $FE = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $IP);
        $JH = get_site_option("\x6d\157\x5f\x73\x61\x6d\x6c\x5f\143\165\162\x72\x65\x6e\x74\x5f\143\x65\x72\164\x5f\x70\162\151\166\x61\164\145\x5f\153\145\x79");
        $FE->loadKey($JH, FALSE);
        $Nf = new XMLSecurityDSig();
        $PN = $FE->signData($Qh);
        $PN = base64_encode($PN);
        $UF .= $Qh . "\x26\123\151\147\x6e\141\164\165\x72\x65\75" . urlencode($PN);
        header("\x4c\157\143\x61\164\151\157\x6e\x3a" . $UF);
        exit;
        ju:
        A9:
        y2:
    }
    function createLogoutResponseAndRedirect($hi, $TQ)
    {
        $jt = get_site_option("\x6d\157\137\x73\x61\155\154\137\x73\x70\137\142\x61\x73\x65\137\x75\x72\154");
        if (!empty($jt)) {
            goto fs;
        }
        $jt = get_network_site_url();
        fs:
        $FL = $_SESSION["\155\157\x5f\163\141\x6d\154\x5f\x6c\157\x67\x6f\165\x74\137\x72\145\161\165\x65\163\x74"];
        $GH = $_SESSION["\x6d\x6f\x5f\163\141\x6d\x6c\x5f\154\157\x67\x6f\x75\x74\137\x72\x65\x6c\141\x79\137\x73\164\141\x74\145"];
        unset($_SESSION["\155\157\137\163\x61\x6d\x6c\x5f\x6c\x6f\x67\x6f\x75\164\x5f\x72\145\161\165\x65\x73\x74"]);
        unset($_SESSION["\x6d\157\x5f\x73\141\x6d\x6c\x5f\154\157\x67\x6f\x75\164\137\162\145\x6c\141\x79\137\163\x74\x61\x74\145"]);
        $Mo = new DOMDocument();
        $Mo->loadXML($FL);
        $FL = $Mo->firstChild;
        if (!($FL->localName == "\x4c\157\147\157\165\164\x52\145\x71\x75\145\x73\x74")) {
            goto hE;
        }
        $XR = new SAML2_LogoutRequest($FL);
        $N5 = get_site_option("\x6d\157\x5f\163\141\x6d\x6c\137\x73\x70\x5f\x65\156\x74\151\164\x79\137\x69\x64");
        if (!empty($N5)) {
            goto NY;
        }
        $N5 = $jt . "\x2f\x77\160\x2d\x63\x6f\156\x74\145\156\x74\57\160\x6c\x75\147\x69\156\x73\x2f\x6d\x69\156\x69\x6f\162\x61\x6e\x67\x65\55\x73\141\x6d\x6c\55\62\x30\55\163\151\x6e\147\154\145\55\x73\x69\147\156\x2d\x6f\x6e\x2f";
        NY:
        $b1 = $hi;
        $Z2 = Utilities::createLogoutResponse($XR->getId(), $N5, $b1, $TQ);
        if (empty($TQ) || $TQ == "\110\x74\164\160\122\x65\144\151\x72\145\143\164") {
            goto kT;
        }
        if (!(get_site_option("\163\141\155\154\137\x72\145\x71\x75\145\x73\164\x5f\163\x69\147\x6e\x65\144") == "\165\x6e\x63\x68\145\143\x6b\x65\x64")) {
            goto xr;
        }
        $WO = base64_encode($Z2);
        Utilities::postSAMLResponse($hi, $WO, $GH);
        exit;
        xr:
        $ng = '';
        $Yg = '';
        $WO = Utilities::signXML($Z2, "\123\x74\x61\x74\x75\x73");
        Utilities::postSAMLResponse($hi, $WO, $GH);
        goto Vm;
        kT:
        $UF = $hi;
        if (strpos($hi, "\x3f") !== false) {
            goto de;
        }
        $UF .= "\x3f";
        goto JE;
        de:
        $UF .= "\x26";
        JE:
        if (!(get_site_option("\x73\x61\155\x6c\x5f\162\145\161\x75\145\x73\164\x5f\163\x69\147\x6e\145\x64") == "\x75\156\x63\150\145\x63\x6b\145\x64")) {
            goto FQ;
        }
        $UF .= "\123\101\115\114\x52\145\163\160\157\x6e\163\x65\x3d" . $Z2 . "\x26\x52\x65\x6c\141\171\x53\164\x61\164\x65\75" . urlencode($GH);
        header("\x4c\157\x63\141\x74\151\157\x6e\72\40" . $UF);
        exit;
        FQ:
        $UF .= "\123\x41\x4d\x4c\122\145\163\160\x6f\x6e\163\x65\75" . $Z2 . "\46\122\145\154\141\171\x53\164\x61\x74\145\75" . urlencode($GH);
        header("\114\x6f\x63\141\x74\151\x6f\156\x3a\x20" . $UF);
        exit;
        Vm:
        hE:
    }
}
function mo_login_validate()
{
    if (!(isset($_REQUEST["\157\160\164\151\x6f\x6e"]) && $_REQUEST["\157\160\x74\x69\x6f\156"] == "\x6d\157\163\x61\x6d\x6c\137\155\145\x74\141\144\141\164\141")) {
        goto py;
    }
    miniorange_generate_metadata();
    py:
    if (!mo_saml_is_customer_license_verified()) {
        goto Fz;
    }
    if (!(isset($_REQUEST["\157\160\x74\x69\x6f\156"]) && $_REQUEST["\x6f\160\164\x69\x6f\x6e"] == "\x73\141\155\x6c\x5f\165\163\x65\162\137\154\x6f\147\x69\156" || isset($_REQUEST["\157\x70\164\151\x6f\x6e"]) && $_REQUEST["\x6f\160\164\151\157\156"] == "\164\145\163\164\103\157\156\x66\151\x67" || isset($_REQUEST["\157\x70\x74\x69\x6f\x6e"]) && $_REQUEST["\157\x70\x74\x69\x6f\156"] == "\x67\145\164\163\141\x6d\154\x72\x65\161\165\x65\163\x74" || isset($_REQUEST["\157\x70\x74\x69\157\156"]) && $_REQUEST["\157\x70\x74\x69\157\156"] == "\x67\145\164\163\x61\155\154\x72\x65\x73\160\x6f\x6e\x73\x65")) {
        goto rG;
    }
    if (mo_saml_is_sp_configured()) {
        goto kk;
    }
    if (!is_user_logged_in()) {
        goto cL;
    }
    if (!isset($_REQUEST["\x72\x65\144\151\x72\x65\x63\x74\x5f\164\157"])) {
        goto dA;
    }
    $pS = htmlspecialchars($_REQUEST["\x72\x65\144\151\162\x65\x63\164\137\x74\157"]);
    header("\x4c\157\x63\x61\x74\151\157\x6e\x3a\x20" . $pS);
    exit;
    dA:
    cL:
    goto ry;
    kk:
    if (!(is_user_logged_in() and $_REQUEST["\x6f\x70\x74\151\157\x6e"] == "\x73\141\155\154\137\165\x73\145\x72\137\154\157\147\151\x6e")) {
        goto Xo;
    }
    if (!isset($_REQUEST["\x72\145\144\151\x72\145\143\164\137\x74\157"])) {
        goto Aq;
    }
    $pS = htmlspecialchars($_REQUEST["\162\145\144\x69\x72\x65\x63\x74\137\164\x6f"]);
    header("\114\x6f\x63\141\164\x69\157\x6e\x3a\x20" . $pS);
    exit;
    Aq:
    return;
    Xo:
    $jt = get_site_option("\x6d\157\137\x73\141\x6d\x6c\x5f\x73\160\x5f\142\141\163\145\137\x75\x72\x6c");
    if (!empty($jt)) {
        goto fg;
    }
    $jt = get_network_site_url();
    fg:
    $A7 = get_site_option("\163\141\155\154\137\x73\163\157\137\x73\x65\164\x74\151\156\147\163");
    $I7 = get_current_blog_id();
    $P0 = Utilities::get_active_sites();
    if (in_array($I7, $P0)) {
        goto g_;
    }
    return;
    g_:
    if (!(empty($A7[$I7]) && !empty($A7["\104\x45\x46\101\x55\114\x54"]))) {
        goto Sa;
    }
    $A7[$I7] = $A7["\x44\105\x46\101\x55\114\x54"];
    Sa:
    if ($_REQUEST["\157\160\164\x69\x6f\156"] == "\x74\x65\163\164\x43\157\x6e\x66\151\x67" and array_key_exists("\x6e\x65\x77\x63\145\162\x74", $_REQUEST)) {
        goto pg;
    }
    if ($_REQUEST["\157\160\164\x69\157\x6e"] == "\164\x65\163\164\x43\x6f\x6e\146\x69\x67") {
        goto SB;
    }
    if ($_REQUEST["\157\160\x74\151\157\156"] == "\x67\x65\x74\x73\x61\x6d\154\162\145\161\x75\x65\x73\x74") {
        goto L_;
    }
    if ($_REQUEST["\x6f\x70\164\x69\x6f\x6e"] == "\147\x65\x74\x73\141\x6d\154\162\145\x73\x70\x6f\156\x73\145") {
        goto mT;
    }
    if (!empty($A7[$I7]["\155\x6f\x5f\163\141\x6d\154\137\x72\x65\154\x61\171\x5f\163\164\141\x74\x65"])) {
        goto hW;
    }
    if (isset($_REQUEST["\x72\145\144\151\x72\x65\x63\x74\137\x74\157"])) {
        goto B8;
    }
    $MF = saml_get_current_page_url();
    goto mc;
    B8:
    $MF = $_REQUEST["\x72\145\144\x69\x72\x65\x63\x74\x5f\x74\x6f"];
    mc:
    goto bn;
    hW:
    $MF = $A7[$I7]["\x6d\157\x5f\163\141\x6d\154\137\162\x65\154\141\171\137\x73\164\x61\x74\x65"];
    bn:
    goto n7;
    mT:
    $MF = "\x64\x69\x73\160\154\141\171\x53\101\x4d\x4c\122\x65\x73\160\x6f\x6e\x73\145";
    n7:
    goto AQ;
    L_:
    $MF = "\x64\151\x73\160\154\x61\171\123\101\115\x4c\122\145\x71\165\145\x73\x74";
    AQ:
    goto Fj;
    SB:
    $MF = "\164\x65\163\x74\126\x61\x6c\151\x64\141\164\x65";
    Fj:
    goto Ds;
    pg:
    $MF = "\164\x65\x73\x74\x4e\x65\167\x43\x65\x72\x74\151\x66\151\x63\141\164\145";
    Ds:
    $J0 = get_site_option("\163\141\x6d\154\137\x6c\157\x67\151\156\137\165\162\154");
    $Xz = !empty(get_site_option("\163\141\155\x6c\x5f\x6c\x6f\x67\151\x6e\x5f\142\x69\156\x64\151\x6e\147\x5f\164\171\160\145")) ? get_site_option("\163\x61\155\154\137\154\157\x67\x69\156\137\x62\x69\x6e\144\x69\156\x67\x5f\164\x79\x70\145") : "\x48\164\x74\160\x50\x6f\163\x74";
    $A7 = get_site_option("\x73\141\x6d\x6c\137\163\x73\157\x5f\163\145\164\x74\x69\x6e\x67\x73");
    $I7 = get_current_blog_id();
    $P0 = Utilities::get_active_sites();
    if (in_array($I7, $P0)) {
        goto CM;
    }
    return;
    CM:
    if (!(empty($A7[$I7]) && !empty($A7["\104\105\106\x41\125\114\124"]))) {
        goto VE;
    }
    $A7[$I7] = $A7["\104\x45\106\101\x55\x4c\x54"];
    VE:
    $PW = isset($A7[$I7]["\x6d\157\x5f\x73\141\x6d\154\137\146\157\162\x63\145\x5f\x61\165\x74\150\x65\x6e\164\x69\143\x61\164\151\x6f\156"]) ? $A7[$I7]["\x6d\x6f\x5f\163\x61\155\154\137\x66\157\162\143\145\137\141\x75\x74\x68\x65\x6e\164\x69\143\141\x74\151\157\156"] : '';
    $pD = $jt . "\x2f";
    $N5 = get_site_option("\x6d\x6f\137\x73\x61\155\154\137\163\x70\137\x65\x6e\x74\x69\164\171\137\x69\144");
    $RC = get_site_option("\163\141\x6d\154\x5f\x6e\x61\155\145\151\144\x5f\x66\x6f\x72\155\141\164");
    if (!empty($RC)) {
        goto I0;
    }
    $RC = "\x31\56\x31\x3a\156\141\155\x65\x69\144\55\146\x6f\162\x6d\141\164\72\165\x6e\163\160\145\x63\x69\x66\151\x65\x64";
    I0:
    if (!empty($N5)) {
        goto sG;
    }
    $N5 = $jt . "\x2f\x77\x70\x2d\143\x6f\156\x74\145\156\x74\57\x70\154\x75\147\x69\156\x73\57\x6d\x69\156\151\157\x72\141\x6e\147\145\x2d\163\x61\155\154\55\62\x30\x2d\x73\x69\156\147\154\x65\55\x73\151\147\156\55\157\x6e\x2f";
    sG:
    $Qh = Utilities::createAuthnRequest($pD, $N5, $J0, $PW, $Xz, $RC);
    if (!($MF == "\144\151\x73\160\154\141\171\123\101\115\114\x52\145\x71\x75\x65\163\164")) {
        goto PH;
    }
    mo_saml_show_SAML_log(Utilities::createAuthnRequest($pD, $N5, $J0, $PW, "\110\164\x74\160\120\157\x73\x74", $RC), $MF);
    PH:
    $UF = htmlspecialchars_decode($J0);
    if (strpos($J0, "\x3f") !== false) {
        goto Xp;
    }
    $UF .= "\77";
    goto bT;
    Xp:
    $UF .= "\46";
    bT:
    $MF = mo_saml_relaystate_url($MF);
    if ($Xz == "\110\x74\x74\160\x52\x65\x64\x69\162\x65\143\x74") {
        goto JV;
    }
    if (!(get_site_option("\163\x61\x6d\x6c\x5f\162\145\x71\x75\x65\163\164\x5f\x73\x69\x67\x6e\145\144") == "\165\x6e\143\150\145\x63\153\145\x64")) {
        goto ZF;
    }
    $WO = base64_encode($Qh);
    Utilities::postSAMLRequest($J0, $WO, $MF);
    exit;
    ZF:
    $ng = '';
    $Yg = '';
    if ($_REQUEST["\157\x70\164\x69\157\156"] == "\164\145\163\164\x43\157\x6e\146\151\147" && array_key_exists("\156\x65\x77\143\x65\x72\164", $_REQUEST)) {
        goto hg;
    }
    $WO = Utilities::signXML($Qh, "\x4e\x61\x6d\145\x49\104\x50\x6f\154\x69\143\x79");
    goto lW;
    hg:
    $WO = Utilities::signXML($Qh, "\x4e\x61\155\145\x49\x44\120\157\154\151\143\x79", true);
    lW:
    Utilities::postSAMLRequest($J0, $WO, $MF);
    update_site_option("\155\157\x5f\x73\x61\x6d\x6c\x5f\156\x65\167\x5f\x63\145\162\x74\137\164\x65\163\164", true);
    goto Mr;
    JV:
    if (!(get_site_option("\x73\141\x6d\x6c\137\162\x65\161\165\x65\x73\x74\137\x73\x69\147\x6e\145\x64") == "\x75\156\x63\x68\145\x63\x6b\x65\x64")) {
        goto ZS;
    }
    $UF .= "\123\101\115\114\x52\x65\x71\165\145\163\x74\x3d" . $Qh . "\46\x52\145\154\x61\171\123\164\x61\164\x65\75" . urlencode($MF);
    header("\x4c\157\143\x61\x74\x69\157\x6e\x3a\x20" . $UF);
    exit;
    ZS:
    $Qh = "\123\101\x4d\114\x52\x65\161\x75\145\163\164\x3d" . $Qh . "\x26\x52\145\x6c\141\x79\123\x74\x61\164\x65\x3d" . urlencode($MF) . "\x26\123\151\x67\101\154\147\x3d" . urlencode(XMLSecurityKey::RSA_SHA256);
    $IP = array("\x74\x79\x70\x65" => "\160\x72\x69\x76\141\164\x65");
    $FE = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $IP);
    if ($_REQUEST["\157\160\164\x69\x6f\x6e"] == "\x74\x65\163\x74\x43\157\x6e\x66\x69\147" && array_key_exists("\x6e\145\167\143\145\162\x74", $_REQUEST)) {
        goto K6;
    }
    $JH = get_site_option("\x6d\157\137\163\x61\155\x6c\x5f\x63\x75\x72\162\145\156\x74\x5f\143\145\162\x74\137\x70\x72\151\x76\141\x74\145\137\x6b\145\x79");
    goto bq;
    K6:
    $JH = file_get_contents(plugin_dir_path(__FILE__) . "\162\x65\x73\x6f\165\162\x63\x65\163" . DIRECTORY_SEPARATOR . mo_options_enum_default_sp_certificate::SP_Private_Key);
    bq:
    $FE->loadKey($JH, FALSE);
    $Nf = new XMLSecurityDSig();
    $PN = $FE->signData($Qh);
    $PN = base64_encode($PN);
    $UF .= $Qh . "\x26\123\151\x67\156\x61\x74\x75\x72\x65\75" . urlencode($PN);
    header("\x4c\x6f\143\141\x74\151\x6f\x6e\x3a\40" . $UF);
    exit;
    Mr:
    ry:
    rG:
    if (!(array_key_exists("\x53\x41\115\114\122\145\163\x70\157\x6e\163\145", $_REQUEST) && !empty($_REQUEST["\x53\x41\115\x4c\x52\x65\x73\x70\157\156\163\145"]))) {
        goto ka;
    }
    if (array_key_exists("\122\x65\154\141\171\x53\164\141\164\145", $_POST) && !empty($_POST["\122\x65\154\x61\x79\x53\164\x61\x74\x65"]) && $_POST["\x52\145\x6c\x61\x79\123\164\141\x74\145"] != "\57") {
        goto WN;
    }
    $gu = '';
    goto DY;
    WN:
    $gu = $_POST["\122\x65\x6c\x61\x79\x53\164\141\164\145"];
    DY:
    $gu = mo_saml_parse_url($gu);
    $jt = get_site_option("\155\x6f\x5f\163\141\x6d\x6c\x5f\163\160\137\142\x61\x73\145\x5f\165\162\154");
    if (!empty($jt)) {
        goto hj;
    }
    $jt = get_network_site_url();
    hj:
    $mu = $_REQUEST["\x53\101\115\114\x52\x65\163\x70\157\156\x73\x65"];
    $mu = base64_decode($mu);
    if (!($gu == "\144\151\x73\x70\154\x61\171\123\101\115\114\x52\x65\163\160\x6f\x6e\x73\x65")) {
        goto HQ;
    }
    mo_saml_show_SAML_log($mu, $gu);
    HQ:
    if (!(array_key_exists("\123\101\x4d\x4c\122\x65\x73\x70\x6f\x6e\163\145", $_GET) && !empty($_GET["\123\x41\115\x4c\122\x65\163\160\157\x6e\163\145"]))) {
        goto Op;
    }
    $mu = gzinflate($mu);
    Op:
    $Mo = new DOMDocument();
    $Mo->loadXML($mu);
    $kV = $Mo->firstChild;
    $ta = $Mo->documentElement;
    $P3 = new DOMXpath($Mo);
    $P3->registerNamespace("\x73\x61\155\x6c\160", "\165\162\156\72\157\141\x73\151\163\72\156\141\155\145\163\x3a\164\143\x3a\123\101\115\x4c\72\x32\56\x30\72\x70\162\157\164\x6f\x63\157\x6c");
    $P3->registerNamespace("\163\x61\x6d\154", "\165\x72\156\x3a\x6f\x61\x73\151\x73\72\x6e\x61\155\145\163\72\x74\143\72\x53\x41\x4d\x4c\72\x32\x2e\60\x3a\141\163\x73\x65\162\164\x69\x6f\x6e");
    if ($kV->localName == "\x4c\157\147\x6f\165\164\x52\145\x73\x70\x6f\156\x73\x65") {
        goto Gd;
    }
    $Oz = $P3->query("\x2f\163\141\x6d\154\x70\x3a\122\145\163\x70\157\x6e\x73\x65\57\163\x61\155\154\160\x3a\123\164\141\x74\x75\x73\x2f\x73\x61\155\x6c\x70\x3a\123\x74\141\x74\165\163\103\157\x64\145", $ta);
    $fx = isset($Oz) ? $Oz->item(0)->getAttribute("\126\x61\154\x75\x65") : '';
    $aB = explode("\72", $fx);
    if (!array_key_exists(7, $aB)) {
        goto rO;
    }
    $Oz = $aB[7];
    rO:
    $xl = $P3->query("\57\163\141\x6d\154\x70\72\122\145\163\160\x6f\156\163\145\57\163\x61\155\x6c\x70\x3a\123\164\141\x74\165\x73\x2f\163\x61\x6d\x6c\x70\x3a\123\164\141\x74\x75\163\115\145\163\x73\141\x67\145", $ta);
    $uW = isset($xl) ? $xl->item(0) : '';
    if (empty($uW)) {
        goto pK;
    }
    $uW = $uW->nodeValue;
    pK:
    if (array_key_exists("\x52\145\x6c\141\171\123\164\x61\x74\145", $_POST) && !empty($_POST["\122\145\x6c\x61\171\x53\x74\x61\x74\145"]) && $_POST["\122\145\x6c\141\171\x53\x74\141\164\x65"] != "\57") {
        goto G8;
    }
    $gu = '';
    goto Tw;
    G8:
    $gu = $_POST["\122\x65\154\x61\x79\123\164\141\x74\145"];
    $gu = mo_saml_parse_url($gu);
    Tw:
    if (!($Oz != "\x53\165\143\143\145\x73\x73")) {
        goto S0;
    }
    show_status_error($Oz, $gu, $uW);
    S0:
    if (!($gu !== "\x74\x65\163\164\x56\x61\154\151\144\141\164\145" && $gu !== "\x74\145\x73\x74\x4e\145\167\103\x65\162\x74\151\146\x69\143\141\164\145")) {
        goto rw;
    }
    $Mp = parse_url($gu, PHP_URL_HOST);
    $G7 = parse_url($jt, PHP_URL_HOST);
    $li = parse_url(get_current_base_url(), PHP_URL_HOST);
    if (!empty($gu)) {
        goto fd;
    }
    $gu = "\x2f";
    goto nT;
    fd:
    $gu = mo_saml_parse_url($gu);
    nT:
    if (!(!empty($Mp) && $Mp != $li)) {
        goto ET;
    }
    Utilities::postSAMLResponse($gu, $_REQUEST["\x53\x41\x4d\114\122\x65\163\x70\x6f\x6e\163\x65"], mo_saml_relaystate_url($gu));
    ET:
    rw:
    $Hm = maybe_unserialize(get_site_option("\x73\141\155\x6c\x5f\170\x35\60\71\137\143\x65\162\164\151\x66\x69\x63\141\x74\x65"));
    update_site_option("\155\x6f\137\x73\x61\155\x6c\x5f\x72\145\163\160\157\156\x73\x65", base64_encode($mu));
    foreach ($Hm as $FE => $Ng) {
        if (@openssl_x509_read($Ng)) {
            goto Yy;
        }
        unset($Hm[$FE]);
        Yy:
        ES:
    }
    o3:
    $pD = $jt . "\57";
    if ($gu == "\x74\x65\x73\x74\x4e\x65\x77\x43\x65\162\x74\151\x66\x69\143\x61\x74\x65") {
        goto uh;
    }
    $mu = new SAML2_Response($kV, get_site_option("\x6d\x6f\x5f\x73\x61\155\154\x5f\x63\x75\x72\162\145\x6e\x74\x5f\143\145\x72\164\137\160\162\x69\166\141\164\145\x5f\x6b\x65\171"));
    goto JL;
    uh:
    $S8 = file_get_contents(plugin_dir_path(__FILE__) . "\x72\145\163\157\165\162\x63\x65\163" . DIRECTORY_SEPARATOR . mo_options_enum_default_sp_certificate::SP_Private_Key);
    $mu = new SAML2_Response($kV, $S8);
    JL:
    $HA = $mu->getSignatureData();
    $DR = current($mu->getAssertions())->getSignatureData();
    if (!(empty($DR) && empty($HA))) {
        goto mh;
    }
    if ($gu == "\164\145\x73\164\x56\141\x6c\151\x64\x61\x74\145" or $gu == "\x74\145\163\164\x4e\x65\x77\103\145\162\x74\x69\x66\x69\143\141\x74\x65") {
        goto h4;
    }
    wp_die("\127\x65\x20\x63\157\x75\154\x64\x20\156\x6f\x74\x20\x73\151\147\156\x20\171\157\165\40\151\156\x2e\x20\120\x6c\x65\141\163\145\x20\x63\157\156\164\141\143\164\x20\x61\x64\x6d\151\156\x69\x73\x74\162\x61\x74\x6f\162", "\105\162\x72\x6f\x72\72\x20\111\156\166\x61\154\x69\144\40\123\101\x4d\x4c\40\122\145\163\160\x6f\156\x73\145");
    goto rU;
    h4:
    $Z8 = mo_options_error_constants::Error_no_certificate;
    $bC = mo_options_error_constants::Cause_no_certificate;
    echo "\74\x64\x69\166\x20\x73\164\171\154\145\75\42\x66\x6f\156\164\55\x66\x61\x6d\x69\x6c\x79\x3a\x43\x61\154\x69\142\162\151\73\160\141\144\x64\x69\156\147\x3a\x30\40\x33\x25\73\42\76\15\12\x9\x9\11\x9\x9\11\x3c\x64\151\166\x20\x73\164\171\x6c\x65\x3d\x22\x63\x6f\154\x6f\162\72\40\43\141\71\64\64\64\x32\x3b\x62\x61\x63\x6b\147\x72\x6f\165\x6e\x64\55\x63\x6f\x6c\157\162\72\40\x23\146\x32\144\x65\x64\145\x3b\x70\x61\x64\144\x69\x6e\147\72\x20\61\65\x70\170\73\155\x61\x72\147\151\156\55\142\x6f\164\164\x6f\x6d\72\x20\x32\x30\x70\170\73\x74\145\170\164\55\x61\x6c\x69\x67\156\72\x63\145\156\x74\x65\162\73\142\157\x72\144\x65\162\x3a\x31\x70\x78\x20\163\157\x6c\151\x64\40\x23\x45\66\x42\63\102\x32\73\146\157\x6e\x74\55\163\x69\x7a\145\72\61\x38\160\164\73\42\76\x20\x45\122\x52\x4f\122\x3c\x2f\x64\151\x76\x3e\xd\xa\x9\x9\x9\x9\11\11\x3c\x64\151\166\x20\x73\164\171\x6c\145\x3d\42\143\x6f\x6c\157\x72\x3a\x20\43\x61\71\64\x34\64\62\x3b\146\157\x6e\x74\55\x73\151\x7a\x65\72\61\x34\160\x74\x3b\40\155\141\x72\147\x69\156\55\x62\x6f\164\x74\x6f\x6d\72\62\60\x70\x78\73\x22\76\x3c\160\76\x3c\163\x74\x72\157\156\x67\76\x45\x72\x72\157\x72\40\x20\x3a" . $Z8 . "\x20\x3c\57\163\x74\x72\x6f\156\x67\x3e\74\57\160\x3e\15\xa\x9\x9\11\11\x9\11\15\xa\x9\x9\11\x9\x9\x9\74\x70\76\x3c\x73\164\162\x6f\156\147\x3e\120\157\163\x73\151\142\154\145\40\103\141\x75\163\145\72\40" . $bC . "\74\57\x73\x74\162\x6f\x6e\x67\76\74\57\x70\76\15\12\11\x9\11\11\11\11\15\xa\x9\11\x9\x9\x9\x9\x3c\57\144\x69\x76\76\x3c\x2f\x64\151\166\x3e";
    mo_saml_download_logs($Z8, $bC);
    exit;
    rU:
    mh:
    $HU = '';
    if (is_array($Hm)) {
        goto sX;
    }
    $Ri = XMLSecurityKey::getRawThumbprint($Hm);
    $Ri = mo_saml_convert_to_windows_iconv($Ri);
    $Ri = preg_replace("\x2f\134\163\x2b\x2f", '', $Ri);
    if (empty($HA)) {
        goto dC;
    }
    $HU = Utilities::processResponse($pD, $Ri, $HA, $mu, 0, $gu);
    dC:
    if (empty($DR)) {
        goto wu;
    }
    $HU = Utilities::processResponse($pD, $Ri, $DR, $mu, 0, $gu);
    wu:
    goto MN;
    sX:
    foreach ($Hm as $FE => $Ng) {
        $Ri = XMLSecurityKey::getRawThumbprint($Ng);
        $Ri = mo_saml_convert_to_windows_iconv($Ri);
        $Ri = preg_replace("\57\134\x73\x2b\x2f", '', $Ri);
        if (empty($HA)) {
            goto jw;
        }
        $HU = Utilities::processResponse($pD, $Ri, $HA, $mu, $FE, $gu);
        jw:
        if (empty($DR)) {
            goto AX;
        }
        $HU = Utilities::processResponse($pD, $Ri, $DR, $mu, $FE, $gu);
        AX:
        if (!$HU) {
            goto Sw;
        }
        goto FK;
        Sw:
        oX:
    }
    FK:
    MN:
    if (empty($HA)) {
        goto BK;
    }
    $nu = $HA["\x43\145\x72\x74\151\146\x69\143\x61\x74\145\163"][0];
    goto dW;
    BK:
    $nu = $DR["\x43\145\162\x74\x69\x66\151\143\x61\x74\145\163"][0];
    dW:
    if ($HU) {
        goto GN;
    }
    if ($gu == "\164\145\x73\164\126\141\x6c\x69\x64\x61\x74\x65" or $gu == "\164\x65\x73\164\x4e\x65\167\x43\x65\162\164\151\x66\x69\x63\x61\164\x65") {
        goto QV;
    }
    wp_die("\127\145\x20\143\157\x75\x6c\144\40\156\x6f\164\40\163\x69\147\156\40\171\x6f\165\x20\151\x6e\56\40\x50\154\145\141\x73\145\40\143\x6f\x6e\x74\x61\x63\x74\x20\x79\x6f\x75\162\x20\x41\144\x6d\151\x6e\x69\163\164\x72\x61\164\157\x72", "\105\162\x72\x6f\162\40\x3a\103\x65\162\x74\x69\x66\x69\x63\x61\164\x65\40\156\157\164\40\146\157\165\156\x64");
    goto eg;
    QV:
    $Z8 = mo_options_error_constants::Error_wrong_certificate;
    $bC = mo_options_error_constants::Cause_wrong_certificate;
    $p1 = "\55\x2d\55\x2d\55\x42\x45\x47\111\116\x20\x43\105\122\124\x49\x46\x49\x43\x41\x54\x45\55\x2d\x2d\x2d\x2d\x3c\142\x72\76" . chunk_split($nu, 64) . "\74\142\162\76\55\55\55\55\55\x45\x4e\104\x20\x43\x45\122\x54\x49\x46\x49\x43\101\124\x45\55\55\55\55\55";
    echo "\74\144\x69\166\x20\163\x74\x79\x6c\x65\x3d\x22\146\x6f\x6e\x74\55\x66\141\155\151\154\171\72\x43\141\x6c\x69\x62\x72\151\x3b\x70\x61\144\x64\151\156\x67\72\x30\x20\x33\45\73\x22\76";
    echo "\x3c\144\151\x76\x20\x73\164\171\154\x65\75\42\143\157\154\x6f\x72\x3a\x20\x23\x61\x39\x34\x34\x34\x32\73\x62\x61\143\153\x67\x72\157\x75\x6e\144\x2d\143\157\x6c\x6f\162\72\40\x23\146\62\x64\x65\144\145\73\160\141\144\144\151\x6e\x67\x3a\x20\61\x35\160\170\73\x6d\141\162\147\x69\156\x2d\x62\x6f\x74\164\157\155\x3a\40\62\x30\160\170\73\164\145\170\x74\x2d\141\154\151\x67\x6e\72\x63\145\156\x74\145\162\73\x62\x6f\162\x64\x65\162\x3a\x31\160\x78\x20\x73\157\x6c\x69\144\40\x23\x45\66\x42\x33\102\x32\x3b\x66\x6f\x6e\x74\x2d\163\x69\172\x65\x3a\61\70\160\x74\73\x22\x3e\40\x45\x52\x52\117\122\x3c\57\x64\151\x76\76\15\12\x9\11\11\x9\x9\x9\x9\x9\74\144\x69\x76\40\x73\164\x79\x6c\145\x3d\42\x63\x6f\x6c\x6f\162\72\40\43\x61\71\x34\64\x34\x32\x3b\146\x6f\x6e\164\x2d\x73\x69\x7a\x65\x3a\61\64\160\x74\x3b\40\155\x61\x72\x67\x69\156\x2d\x62\157\x74\x74\157\x6d\72\x32\x30\160\x78\73\42\76\74\160\76\74\x73\164\x72\x6f\x6e\x67\76\105\x72\x72\x6f\x72\x3a\x20\74\x2f\163\x74\x72\x6f\x6e\x67\76\125\x6e\141\142\154\x65\40\164\x6f\40\x66\x69\x6e\x64\40\141\x20\x63\x65\x72\x74\151\x66\x69\x63\141\x74\x65\40\155\x61\164\143\x68\x69\156\x67\40\x74\150\x65\40\x63\157\156\146\151\147\x75\x72\145\x64\x20\x66\151\156\x67\145\x72\160\162\151\156\x74\x2e\x3c\57\x70\76\15\12\11\x9\x9\11\x9\x9\11\x9\11\74\160\76\x50\154\145\141\x73\x65\x20\x63\157\x6e\164\x61\x63\164\x20\x79\x6f\x75\162\x20\x61\x64\x6d\x69\x6e\x69\x73\164\x72\x61\164\x6f\162\x20\141\x6e\x64\x20\x72\x65\x70\x6f\x72\x74\40\164\150\x65\x20\146\157\154\154\x6f\x77\x69\156\x67\40\x65\162\x72\x6f\x72\72\x3c\57\x70\76\xd\12\11\x9\11\11\11\11\x9\x9\11\74\x70\76\74\x73\x74\x72\157\156\147\76\120\157\x73\163\151\142\x6c\145\x20\103\141\x75\163\x65\x3a\40\74\57\163\x74\x72\157\x6e\x67\76\47\130\56\x35\60\x39\x20\x43\x65\162\x74\151\x66\151\143\141\x74\x65\x27\40\146\151\145\154\144\40\151\x6e\40\160\x6c\x75\147\x69\x6e\x20\x64\x6f\145\x73\x20\156\157\164\40\x6d\141\164\x63\x68\40\164\150\145\40\x63\145\x72\164\151\x66\151\x63\141\164\145\40\146\x6f\165\156\144\40\151\x6e\40\x53\101\x4d\114\40\x52\x65\163\x70\x6f\x6e\163\x65\56\x3c\x2f\160\76\15\12\11\x9\x9\11\x9\11\x9\11\11\x3c\160\76\74\x73\164\162\157\x6e\147\x3e\103\145\x72\164\151\146\151\x63\141\x74\145\x20\x66\157\165\156\x64\40\151\156\x20\123\101\x4d\114\40\122\x65\163\x70\157\x6e\163\x65\72\40\74\x2f\163\164\x72\157\x6e\x67\76\74\x66\157\x6e\164\40\146\141\143\x65\75\42\x43\157\x75\x72\151\x65\x72\40\x4e\145\x77\x22\x3e\x3c\x62\162\x3e\74\x62\x72\76" . $p1 . "\x3c\57\160\76\74\57\146\x6f\x6e\x74\x3e\xd\12\11\x9\11\11\11\11\11\11\11\74\160\x3e\74\163\164\x72\x6f\x6e\x67\x3e\x53\157\x6c\165\x74\151\x6f\x6e\x3a\40\74\57\x73\x74\162\x6f\156\x67\x3e\x3c\57\x70\76\15\xa\x9\11\x9\x9\11\x9\11\11\x9\74\x6f\x6c\x3e\15\xa\11\11\x9\x9\x9\11\11\11\11\x20\x20\x20\74\x6c\x69\x3e\x43\157\160\x79\40\x70\141\x73\164\145\40\164\150\145\x20\x63\145\162\164\151\146\151\x63\141\164\145\x20\160\162\x6f\166\151\144\145\x64\40\141\x62\x6f\x76\145\40\151\x6e\40\130\x35\x30\x39\x20\103\145\162\164\x69\x66\151\x63\141\164\145\40\165\x6e\144\x65\x72\x20\x53\145\162\166\151\143\x65\40\x50\162\157\x76\x69\x64\x65\162\40\123\145\164\x75\160\x20\164\x61\x62\56\x3c\x2f\x6c\x69\x3e\xd\12\x9\11\x9\x9\11\x9\11\11\x9\x20\x20\x20\x3c\x6c\x69\x3e\x49\146\x20\151\x73\x73\165\145\40\x70\145\x72\163\x69\x73\x74\x73\40\144\x69\163\141\142\154\x65\x20\x3c\142\76\x43\150\141\x72\x61\x63\164\145\162\x20\x65\x6e\x63\x6f\x64\x69\x6e\x67\x3c\x2f\x62\76\x20\x75\x6e\x64\x65\x72\40\x53\x65\162\x76\151\143\145\40\120\162\x6f\166\x64\x65\162\40\x53\145\164\x75\x70\x20\164\x61\x62\x2e\x3c\x2f\154\x69\x3e\15\12\x9\11\x9\11\11\11\x9\x9\x9\74\57\x6f\154\76\xd\12\x9\11\11\x9\x9\11\x9\11\11\74\x2f\x64\151\166\76\15\12\11\11\11\x9\11\x9\11\11\x3c\x64\x69\166\x20\163\x74\171\x6c\145\75\42\155\141\162\x67\x69\156\x3a\63\45\73\x64\151\163\x70\154\x61\171\72\x62\x6c\x6f\143\153\73\x74\x65\x78\x74\55\141\x6c\x69\x67\156\72\x63\x65\x6e\164\x65\x72\x3b\42\x3e\xd\12\11\11\x9\11\11\x9\x9\x9\11\11\x3c\x64\x69\166\x20\x73\164\171\x6c\145\75\x22\155\141\162\x67\x69\156\72\63\x25\x3b\144\x69\163\x70\154\141\171\x3a\x62\x6c\x6f\143\x6b\x3b\x74\x65\x78\x74\x2d\141\154\151\147\x6e\x3a\143\145\156\x74\145\162\x3b\42\x3e\x3c\151\156\x70\x75\x74\40\163\164\x79\x6c\145\x3d\42\160\141\144\144\151\x6e\x67\72\x31\x25\x3b\x77\151\x64\x74\150\x3a\61\x30\x30\x70\170\73\x62\141\143\x6b\147\162\x6f\x75\x6e\x64\72\40\43\x30\60\x39\61\103\104\40\156\157\x6e\x65\40\x72\145\x70\145\141\164\x20\163\x63\x72\157\154\x6c\40\x30\45\40\x30\45\x3b\143\165\162\x73\x6f\x72\72\x20\x70\157\151\x6e\164\x65\162\x3b\146\x6f\156\x74\55\163\151\172\x65\x3a\x31\65\160\x78\73\x62\157\x72\x64\x65\x72\x2d\167\151\144\164\150\72\x20\61\x70\x78\73\x62\157\x72\144\x65\162\x2d\x73\x74\171\x6c\145\72\x20\x73\157\154\151\x64\73\142\x6f\162\x64\145\x72\x2d\x72\141\144\x69\165\163\72\40\63\x70\x78\x3b\167\150\151\x74\145\x2d\x73\160\x61\143\x65\x3a\40\156\x6f\x77\x72\141\x70\73\x62\x6f\x78\55\163\x69\x7a\x69\156\147\x3a\40\142\157\162\x64\145\162\x2d\142\157\x78\x3b\142\157\x72\x64\x65\x72\x2d\143\157\x6c\157\x72\x3a\x20\x23\x30\60\x37\x33\x41\101\73\142\157\x78\x2d\163\150\141\x64\x6f\167\x3a\40\60\160\x78\40\61\160\x78\x20\x30\160\170\40\162\x67\142\x61\x28\x31\x32\x30\x2c\x20\62\60\60\x2c\40\62\63\x30\x2c\x20\x30\56\66\x29\x20\x69\x6e\x73\145\x74\x3b\143\157\154\x6f\x72\72\x20\x23\x46\x46\x46\73\x22\164\171\160\x65\75\x22\x62\165\164\164\x6f\156\x22\40\166\x61\154\165\145\75\42\x44\157\156\145\42\40\x6f\156\103\x6c\151\143\x6b\x3d\x22\163\145\154\146\x2e\143\x6c\x6f\x73\145\50\51\73\42\76\74\57\x64\151\x76\76";
    mo_saml_download_logs($Z8, $bC);
    exit;
    eg:
    GN:
    $Jq = get_site_option("\163\141\155\154\x5f\151\x73\x73\165\145\x72");
    $N5 = get_site_option("\155\157\x5f\163\141\x6d\154\x5f\163\160\137\145\x6e\x74\151\x74\171\137\x69\144");
    if (!empty($N5)) {
        goto DZ;
    }
    $N5 = $jt . "\x2f\x77\x70\x2d\x63\x6f\x6e\164\x65\156\164\x2f\160\x6c\165\147\x69\x6e\x73\x2f\155\x69\156\151\x6f\x72\x61\x6e\x67\x65\x2d\163\x61\x6d\154\55\62\x30\55\x73\x69\x6e\x67\x6c\x65\x2d\163\151\x67\156\55\157\x6e\x2f";
    DZ:
    Utilities::validateIssuerAndAudience($mu, $N5, $Jq, $gu);
    $ZW = current(current($mu->getAssertions())->getNameId());
    $kd = current($mu->getAssertions())->getAttributes();
    $kd["\x4e\141\155\145\111\104"] = array("\x30" => $ZW);
    $q1 = current($mu->getAssertions())->getSessionIndex();
    mo_saml_checkMapping($kd, $gu, $q1);
    goto zq;
    Gd:
    if (!isset($_REQUEST["\x52\x65\154\141\x79\x53\x74\141\164\145"])) {
        goto nM;
    }
    $GH = $_REQUEST["\122\x65\154\141\171\x53\164\x61\x74\x65"];
    nM:
    wp_logout();
    if (empty($GH)) {
        goto ly;
    }
    $GH = mo_saml_parse_url($GH);
    goto R4;
    ly:
    $GH = $jt;
    R4:
    header("\x4c\157\x63\x61\164\151\x6f\156\x3a" . $GH);
    exit;
    zq:
    ka:
    if (!(array_key_exists("\123\x41\x4d\x4c\122\x65\161\165\145\x73\x74", $_REQUEST) && !empty($_REQUEST["\x53\x41\115\114\122\x65\161\x75\145\163\x74"]))) {
        goto li;
    }
    $Qh = $_REQUEST["\123\x41\x4d\114\x52\x65\161\165\145\163\164"];
    $gu = "\57";
    if (!array_key_exists("\x52\145\x6c\x61\x79\x53\x74\x61\164\145", $_REQUEST)) {
        goto dB;
    }
    $gu = $_REQUEST["\x52\x65\x6c\141\171\123\164\141\164\x65"];
    dB:
    $Qh = base64_decode($Qh);
    if (!(array_key_exists("\x53\x41\x4d\114\x52\145\x71\x75\x65\x73\x74", $_GET) && !empty($_GET["\123\101\x4d\114\x52\145\161\165\x65\x73\164"]))) {
        goto s6;
    }
    $Qh = gzinflate($Qh);
    s6:
    $Mo = new DOMDocument();
    $Mo->loadXML($Qh);
    $lO = $Mo->firstChild;
    if (!($lO->localName == "\x4c\x6f\x67\x6f\x75\164\x52\x65\161\x75\145\x73\164")) {
        goto Rl;
    }
    $XR = new SAML2_LogoutRequest($lO);
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto Ux;
    }
    session_start();
    Ux:
    $_SESSION["\x6d\x6f\137\x73\141\x6d\154\137\154\x6f\147\x6f\x75\164\137\x72\x65\x71\165\145\x73\164"] = $Qh;
    $_SESSION["\155\x6f\137\x73\141\x6d\154\x5f\x6c\157\x67\157\x75\x74\x5f\x72\x65\154\141\x79\x5f\163\x74\141\164\x65"] = $gu;
    wp_redirect(htmlspecialchars_decode(wp_logout_url()));
    exit;
    Rl:
    li:
    if (!(isset($_REQUEST["\157\160\164\x69\x6f\156"]) and !is_array($_REQUEST["\x6f\160\164\151\157\156"]) and strpos($_REQUEST["\157\x70\164\x69\x6f\156"], "\x72\145\x61\x64\x73\x61\x6d\154\154\157\147\151\156") !== false)) {
        goto Rt;
    }
    require_once dirname(__FILE__) . "\x2f\151\x6e\143\154\165\144\145\163\x2f\154\151\142\x2f\145\156\143\x72\x79\x70\164\151\157\x6e\56\160\x68\160";
    if (isset($_POST["\x53\124\101\124\x55\123"]) && $_POST["\123\124\x41\124\125\x53"] == "\105\x52\x52\117\122") {
        goto aU;
    }
    if (!(isset($_POST["\x53\x54\x41\124\x55\x53"]) && $_POST["\123\x54\101\x54\125\123"] == "\x53\x55\103\x43\105\x53\123")) {
        goto yD;
    }
    $Yu = '';
    if (!(isset($_REQUEST["\x72\145\x64\151\162\145\x63\x74\x5f\x74\157"]) && !empty($_REQUEST["\162\145\x64\151\x72\x65\x63\x74\x5f\x74\x6f"]) && $_REQUEST["\x72\145\x64\151\x72\x65\143\x74\x5f\164\157"] != "\x2f")) {
        goto mF;
    }
    $Yu = $_REQUEST["\x72\x65\144\151\x72\x65\143\164\x5f\164\157"];
    mF:
    delete_site_option("\x6d\157\137\163\x61\x6d\x6c\x5f\x72\x65\144\151\x72\145\x63\164\x5f\x65\x72\162\157\x72\137\143\x6f\x64\x65");
    delete_site_option("\155\x6f\137\x73\141\155\154\x5f\162\x65\x64\x69\x72\x65\143\164\x5f\x65\162\162\157\162\137\162\145\x61\x73\157\x6e");
    try {
        $iI = get_site_option("\163\x61\x6d\x6c\x5f\x61\155\137\145\155\x61\x69\x6c");
        $Id = get_site_option("\x73\141\155\x6c\x5f\141\155\x5f\165\163\x65\x72\x6e\x61\x6d\x65");
        $ED = get_site_option("\x73\x61\x6d\154\x5f\141\x6d\137\x66\x69\x72\x73\164\137\x6e\141\155\145");
        $oc = get_site_option("\163\x61\x6d\x6c\x5f\141\155\x5f\x6c\x61\x73\164\x5f\x6e\x61\x6d\x65");
        $YY = get_site_option("\163\141\155\154\137\x61\155\137\147\162\157\x75\x70\x5f\156\x61\155\145");
        $qS = get_site_option("\163\141\155\154\x5f\x61\x6d\137\x64\x65\x66\141\x75\154\x74\137\x75\x73\x65\162\x5f\x72\157\x6c\x65");
        $t7 = get_site_option("\163\141\155\x6c\x5f\141\x6d\137\144\x6f\x6e\x74\x5f\x61\154\x6c\157\167\x5f\165\x6e\154\x69\163\x74\145\x64\x5f\x75\x73\x65\162\137\162\157\154\145");
        $Hh = get_site_option("\163\141\155\x6c\x5f\x61\155\x5f\141\143\x63\x6f\x75\156\164\137\x6d\x61\x74\143\150\x65\x72");
        $eY = '';
        $Bb = '';
        $ED = str_replace("\56", "\137", $ED);
        $ED = str_replace("\x20", "\x5f", $ED);
        if (!(!empty($ED) && array_key_exists($ED, $_POST))) {
            goto Us;
        }
        $ED = $_POST[$ED];
        Us:
        $oc = str_replace("\x2e", "\x5f", $oc);
        $oc = str_replace("\40", "\137", $oc);
        if (!(!empty($oc) && array_key_exists($oc, $_POST))) {
            goto s9;
        }
        $oc = $_POST[$oc];
        s9:
        $Id = str_replace("\x2e", "\x5f", $Id);
        $Id = str_replace("\x20", "\x5f", $Id);
        if (!empty($Id) && array_key_exists($Id, $_POST)) {
            goto NN;
        }
        $Bb = $_POST["\116\141\x6d\145\x49\x44"];
        goto Kj;
        NN:
        $Bb = $_POST[$Id];
        Kj:
        $eY = str_replace("\56", "\137", $iI);
        $eY = str_replace("\x20", "\137", $iI);
        if (!empty($iI) && array_key_exists($iI, $_POST)) {
            goto Js;
        }
        $eY = $_POST["\x4e\141\155\145\111\x44"];
        goto BH;
        Js:
        $eY = $_POST[$iI];
        BH:
        $YY = str_replace("\x2e", "\x5f", $YY);
        $YY = str_replace("\x20", "\137", $YY);
        if (!(!empty($YY) && array_key_exists($YY, $_POST))) {
            goto Qw;
        }
        $YY = $_POST[$YY];
        Qw:
        if (!empty($Hh)) {
            goto cO;
        }
        $Hh = "\145\x6d\x61\151\x6c";
        cO:
        $FE = get_site_option("\155\157\137\163\x61\155\x6c\x5f\143\165\x73\x74\157\x6d\x65\162\137\x74\157\x6b\145\156");
        if (!(isset($FE) || trim($FE) != '')) {
            goto Lc;
        }
        $XO = AESEncryption::decrypt_data($eY, $FE);
        $eY = $XO;
        Lc:
        if (!(!empty($ED) && !empty($FE))) {
            goto wE;
        }
        $d9 = AESEncryption::decrypt_data($ED, $FE);
        $ED = $d9;
        wE:
        if (!(!empty($oc) && !empty($FE))) {
            goto R6;
        }
        $CQ = AESEncryption::decrypt_data($oc, $FE);
        $oc = $CQ;
        R6:
        if (!(!empty($Bb) && !empty($FE))) {
            goto Cq;
        }
        $hf = AESEncryption::decrypt_data($Bb, $FE);
        $Bb = $hf;
        Cq:
        if (!(!empty($YY) && !empty($FE))) {
            goto Vq;
        }
        $X4 = AESEncryption::decrypt_data($YY, $FE);
        $YY = $X4;
        Vq:
    } catch (Exception $Tn) {
        echo sprintf("\x41\156\40\145\162\162\157\x72\x20\157\x63\143\165\x72\162\x65\144\40\x77\x68\x69\154\145\x20\160\x72\x6f\143\145\x73\x73\151\x6e\x67\x20\x74\150\145\x20\x53\x41\115\114\40\x52\145\x73\x70\157\156\x73\x65\x2e");
        exit;
    }
    $rv = array($YY);
    mo_saml_login_user($eY, $ED, $oc, $Bb, $rv, $t7, $qS, $Yu, $Hh);
    yD:
    goto vN;
    aU:
    update_site_option("\x6d\x6f\x5f\163\x61\x6d\x6c\x5f\x72\145\x64\151\x72\x65\143\x74\137\145\x72\x72\x6f\162\137\143\157\x64\145", $_POST["\x45\122\122\117\122\137\x52\105\x41\123\x4f\x4e"]);
    update_site_option("\x6d\157\137\163\x61\155\154\x5f\162\145\144\151\x72\x65\x63\164\x5f\145\162\162\157\x72\x5f\162\x65\x61\163\157\x6e", $_POST["\x45\122\122\x4f\122\137\115\105\123\x53\101\107\105"]);
    vN:
    Rt:
    Fz:
}
function mo_saml_relaystate_url($gu)
{
    $jr = parse_url($gu, PHP_URL_SCHEME);
    $gu = str_replace($jr . "\72\x2f\57", '', $gu);
    return $gu;
}
function mo_saml_hash_relaystate($gu)
{
    $jr = parse_url($gu, PHP_URL_SCHEME);
    $gu = str_replace($jr . "\x3a\57\x2f", '', $gu);
    $gu = base64_encode($gu);
    $mw = cdjsurkhh($gu);
    $gu = $gu . "\56" . $mw;
    return $gu;
}
function mo_saml_get_relaystate($gu)
{
    if (!filter_var($gu, FILTER_VALIDATE_URL)) {
        goto lm;
    }
    return $gu;
    lm:
    $J9 = strpos($gu, "\x2e");
    if ($J9) {
        goto ru;
    }
    wp_die("\x41\x6e\x20\x65\162\162\x6f\x72\x20\x6f\x63\x63\x75\x72\x65\x64\56\40\120\154\x65\x61\x73\x65\x20\143\157\156\x74\x61\143\x74\40\171\x6f\x75\162\40\x61\x64\x6d\151\x6e\x69\x73\x74\162\x61\164\x6f\162\56", "\105\162\162\157\x72\40\72\40\x4e\x6f\x74\x20\x61\40\x74\162\x75\x73\164\x65\x64\40\163\x6f\x75\x72\143\x65\40\x6f\146\x20\164\x68\x65\x20\x53\x41\115\x4c\40\x72\x65\163\x70\x6f\156\163\x65");
    exit;
    ru:
    $GH = substr($gu, 0, $J9);
    $Rg = substr($gu, $J9 + 1);
    $jp = cdjsurkhh($GH);
    if (!($Rg !== $jp)) {
        goto BN;
    }
    wp_die("\x41\x6e\40\x65\162\162\x6f\162\40\x6f\x63\143\165\x72\x65\144\x2e\40\120\x6c\145\141\x73\x65\40\x63\x6f\156\x74\141\x63\164\x20\x79\157\165\162\x20\141\x64\x6d\151\156\151\163\164\x72\141\164\157\x72\56", "\105\162\x72\x6f\162\40\72\x20\x4e\157\x74\40\x61\40\x74\162\x75\x73\164\145\144\40\163\x6f\x75\162\x63\x65\40\x6f\x66\40\164\x68\x65\x20\x53\101\115\x4c\x20\x72\x65\163\160\157\x6e\163\x65");
    exit;
    BN:
    $GH = base64_decode($GH);
    return $GH;
}
function cdjsurkhh($WG)
{
    $mw = hash("\163\150\141\x35\61\62", $WG);
    $xB = substr($mw, 7, 14);
    return $xB;
}
function mo_saml_parse_url($gu)
{
    if (!($gu != "\164\x65\163\164\x56\x61\154\x69\144\141\x74\x65" && $gu != "\x74\145\163\164\116\x65\x77\103\x65\x72\x74\151\x66\x69\x63\x61\164\x65")) {
        goto Np;
    }
    $jt = get_site_option("\x6d\x6f\x5f\x73\141\x6d\x6c\x5f\163\160\x5f\x62\141\x73\145\137\x75\x72\x6c");
    if (!empty($jt)) {
        goto ih;
    }
    $jt = get_network_site_url();
    ih:
    $jr = parse_url($jt, PHP_URL_SCHEME);
    if (filter_var($gu, FILTER_VALIDATE_URL)) {
        goto K5;
    }
    $gu = $jr . "\x3a\x2f\x2f" . $gu;
    K5:
    Np:
    return $gu;
}
function mo_saml_is_subsite($gu)
{
    $QB = parse_url($gu, PHP_URL_HOST);
    $eI = parse_url($gu, PHP_URL_PATH);
    if (is_subdomain_install()) {
        goto Ui;
    }
    $ZX = strpos($eI, "\57", 1) != false ? strpos($eI, "\x2f", 1) : strlen($eI) - 1;
    $eI = substr($eI, 0, $ZX + 1);
    $blog_id = get_blog_id_from_url($QB, $eI);
    goto kz;
    Ui:
    $blog_id = get_blog_id_from_url($QB);
    kz:
    if ($blog_id !== 0) {
        goto nx;
    }
    return false;
    goto xL;
    nx:
    return true;
    xL:
}
function mo_saml_show_SAML_log($lO, $WK)
{
    header("\103\x6f\x6e\x74\x65\156\x74\55\x54\171\x70\x65\72\x20\x74\x65\170\x74\57\150\164\155\154");
    $ta = new DOMDocument();
    $ta->preserveWhiteSpace = false;
    $ta->formatOutput = true;
    $ta->loadXML($lO);
    if ($WK == "\144\151\x73\160\154\x61\x79\123\x41\x4d\x4c\x52\145\161\165\x65\x73\x74") {
        goto ns;
    }
    $QK = "\x53\101\115\x4c\40\x52\145\163\x70\157\x6e\163\x65";
    goto qi;
    ns:
    $QK = "\x53\101\x4d\114\40\x52\145\161\x75\x65\163\x74";
    qi:
    $gT = $ta->saveXML();
    $NS = htmlentities($gT);
    $NS = rtrim($NS);
    $rd = simplexml_load_string($gT);
    $E9 = json_encode($rd);
    $yv = json_decode($E9);
    $yO = plugins_url("\151\x6e\x63\154\x75\144\x65\163\57\x63\163\x73\x2f\x73\x74\171\154\145\x5f\x73\x65\x74\x74\151\156\147\163\x2e\x63\x73\x73\x3f\x76\x65\x72\x3d\64\56\70\56\x34\x30", __FILE__);
    echo "\74\154\x69\156\x6b\40\162\145\154\x3d\47\x73\164\x79\154\145\163\x68\145\x65\164\x27\x20\x69\x64\x3d\x27\155\157\137\x73\141\155\154\137\x61\x64\x6d\x69\156\137\163\145\164\x74\151\156\147\x73\137\163\x74\171\x6c\145\55\x63\x73\x73\x27\40\40\x68\162\145\146\x3d\47" . $yO . "\x27\x20\x74\171\x70\x65\x3d\47\x74\x65\x78\x74\57\x63\x73\163\47\40\x6d\x65\x64\151\x61\x3d\47\141\x6c\x6c\47\40\57\x3e\xd\12\40\40\x20\40\40\x20\40\x20\40\x20\40\40\15\xa\x9\x9\11\x3c\144\x69\x76\40\143\154\x61\x73\163\75\42\x6d\x6f\x2d\144\151\163\x70\154\141\x79\55\154\157\147\x73\42\x20\76\74\160\40\x74\x79\160\145\75\42\x74\145\x78\x74\x22\x20\40\40\x69\144\x3d\42\123\101\x4d\114\x5f\164\171\x70\145\42\x3e" . $QK . "\x3c\57\x70\x3e\74\x2f\x64\151\x76\76\xd\12\11\11\x9\x9\xd\12\x9\x9\x9\74\144\x69\166\x20\x74\171\160\x65\x3d\42\x74\145\170\164\x22\x20\x69\144\75\x22\123\x41\x4d\x4c\x5f\x64\151\x73\x70\154\x61\171\42\40\x63\x6c\141\163\x73\75\x22\155\157\x2d\144\x69\163\160\154\141\171\55\142\x6c\x6f\143\153\42\76\x3c\160\162\x65\x20\143\x6c\141\x73\163\x3d\x27\142\x72\x75\163\x68\72\40\x78\x6d\154\73\47\76" . $NS . "\x3c\x2f\x70\x72\x65\x3e\74\x2f\x64\x69\166\76\xd\12\11\x9\x9\74\x62\x72\76\xd\12\11\x9\x9\x3c\144\x69\166\x9\x20\x73\164\x79\x6c\x65\x3d\42\x6d\141\x72\147\151\156\x3a\63\45\73\x64\151\163\160\154\141\x79\72\x62\x6c\x6f\143\153\73\x74\145\170\x74\55\141\154\151\x67\x6e\72\143\x65\x6e\164\x65\x72\73\x22\76\15\xa\40\x20\40\40\40\x20\x20\x20\40\x20\x20\40\xd\xa\11\11\x9\74\x64\151\166\x20\163\164\171\x6c\x65\75\x22\x6d\141\162\147\151\156\72\x33\x25\73\x64\151\163\160\154\141\171\x3a\x62\x6c\157\143\x6b\73\x74\145\170\x74\x2d\141\154\151\x67\156\72\143\145\156\164\145\x72\73\42\x20\x3e\15\xa\11\xd\12\40\40\x20\40\40\40\x20\x20\40\x20\x20\x20\x3c\x2f\144\151\x76\x3e\15\xa\11\11\11\x3c\142\x75\164\164\157\x6e\40\151\x64\x3d\x22\x63\157\160\171\x22\40\157\156\x63\x6c\x69\143\153\75\x22\x63\157\160\171\104\x69\166\x54\x6f\x43\x6c\151\x70\142\157\141\162\x64\50\x29\42\40\x20\163\164\171\x6c\x65\x3d\x22\160\x61\x64\144\x69\156\147\x3a\x31\x25\x3b\167\151\x64\x74\150\x3a\61\x30\x30\x70\x78\73\142\x61\x63\153\147\x72\x6f\x75\x6e\144\72\40\x23\x30\x30\x39\x31\103\x44\x20\156\x6f\156\x65\40\162\x65\160\145\x61\x74\40\x73\143\162\x6f\x6c\x6c\40\x30\45\x20\x30\45\x3b\143\165\x72\163\x6f\x72\x3a\40\160\157\x69\156\164\x65\162\73\146\157\156\164\55\163\151\x7a\145\x3a\61\x35\160\170\x3b\x62\x6f\162\x64\x65\162\x2d\x77\x69\144\164\150\72\40\61\160\x78\x3b\x62\x6f\x72\x64\x65\x72\x2d\x73\x74\x79\154\x65\x3a\x20\163\x6f\154\151\144\73\x62\157\x72\x64\x65\162\x2d\162\x61\144\x69\x75\163\72\40\x33\x70\x78\x3b\x77\150\151\x74\145\x2d\163\x70\x61\143\145\x3a\40\x6e\157\x77\162\x61\x70\x3b\142\x6f\x78\x2d\163\151\172\x69\x6e\x67\72\x20\142\x6f\162\x64\145\x72\55\142\157\x78\x3b\x62\x6f\x72\x64\x65\x72\x2d\143\157\154\157\x72\72\40\x23\x30\60\x37\63\x41\x41\73\142\157\170\x2d\163\150\141\144\157\x77\72\x20\60\x70\x78\x20\61\160\170\40\60\160\170\40\162\x67\142\x61\50\61\62\60\x2c\x20\62\60\x30\54\x20\62\x33\x30\x2c\40\60\56\x36\x29\x20\x69\156\163\145\x74\73\143\x6f\154\x6f\x72\72\x20\x23\x46\106\106\x3b\x22\x20\x3e\x43\157\160\171\74\57\142\x75\164\x74\157\x6e\x3e\15\xa\x9\x9\11\46\x6e\142\x73\x70\x3b\xd\12\x20\40\40\x20\x20\x20\40\40\40\40\x20\x20\x20\40\x20\74\x69\156\160\x75\x74\40\151\x64\75\x22\144\x77\x6e\x2d\142\x74\156\x22\40\163\164\171\x6c\145\x3d\x22\x70\141\x64\x64\x69\156\x67\72\61\45\x3b\167\x69\144\x74\150\x3a\x31\60\x30\x70\x78\73\x62\x61\143\x6b\147\162\157\165\156\144\x3a\x20\x23\x30\60\x39\x31\x43\x44\40\156\157\156\145\x20\x72\x65\160\145\141\x74\x20\x73\x63\x72\x6f\154\154\x20\x30\45\x20\60\x25\x3b\143\165\x72\x73\157\162\72\x20\x70\157\x69\x6e\x74\145\x72\x3b\x66\x6f\156\x74\x2d\x73\x69\x7a\145\72\61\65\160\x78\x3b\142\157\162\x64\x65\162\x2d\x77\151\x64\x74\x68\x3a\40\61\160\170\73\x62\157\162\x64\x65\162\55\x73\164\x79\x6c\x65\72\40\163\157\154\151\144\73\142\157\162\144\x65\162\x2d\162\141\x64\x69\x75\x73\72\40\x33\160\170\x3b\x77\150\151\164\x65\55\163\x70\x61\x63\x65\72\40\156\157\x77\x72\141\160\73\x62\x6f\170\x2d\x73\x69\x7a\151\156\x67\72\x20\142\x6f\162\x64\145\162\55\142\157\170\x3b\x62\157\x72\x64\145\162\x2d\143\x6f\154\157\162\x3a\40\43\x30\x30\x37\63\x41\101\x3b\x62\157\170\x2d\x73\x68\x61\144\x6f\167\x3a\40\x30\160\x78\x20\61\x70\170\x20\60\160\x78\40\162\147\142\141\50\61\62\60\54\x20\62\60\60\54\40\62\63\60\54\40\60\56\66\x29\x20\x69\156\x73\145\x74\x3b\143\x6f\154\157\162\72\40\x23\x46\x46\x46\x3b\42\x74\171\160\145\x3d\42\142\x75\164\x74\x6f\x6e\x22\x20\166\141\x6c\x75\145\75\x22\104\x6f\x77\x6e\x6c\x6f\x61\144\x22\40\15\12\x20\x20\x20\x20\40\x20\x20\x20\40\40\x20\40\40\40\x20\x22\x3e\15\12\11\x9\11\74\57\144\x69\x76\76\15\xa\11\x9\x9\74\x2f\x64\x69\166\x3e\xd\12\11\11\x9\15\12\11\x9\15\xa\x9\11\x9";
    ob_end_flush();
    echo "\15\12\11\74\x73\x63\x72\151\x70\164\x3e\15\xa\xd\xa\x20\40\x20\x20\40\40\40\40\146\x75\x6e\x63\x74\x69\157\156\x20\143\x6f\x70\171\x44\x69\166\124\x6f\x43\154\x69\160\142\157\141\x72\144\50\51\x20\x7b\15\xa\40\40\x20\40\40\40\40\x20\x20\40\40\x20\166\141\x72\x20\141\x75\170\x20\x3d\40\144\x6f\x63\165\x6d\145\156\x74\56\x63\x72\x65\141\x74\145\105\x6c\x65\155\x65\x6e\x74\x28\42\151\156\160\x75\164\x22\51\x3b\xd\xa\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\40\x61\165\170\x2e\163\x65\x74\101\x74\x74\x72\x69\x62\x75\164\145\50\42\166\141\154\165\145\42\x2c\40\x64\x6f\143\165\x6d\145\156\164\x2e\147\x65\164\105\x6c\145\x6d\x65\x6e\x74\102\171\111\144\50\x22\x53\x41\x4d\x4c\x5f\x64\x69\163\x70\154\x61\x79\x22\51\56\x74\x65\170\164\x43\157\x6e\164\x65\x6e\x74\x29\73\15\12\x20\x20\x20\40\x20\x20\x20\40\40\x20\x20\40\x64\x6f\x63\x75\155\145\x6e\x74\56\142\x6f\x64\x79\x2e\141\160\x70\x65\156\x64\x43\x68\x69\154\x64\50\141\165\170\x29\73\xd\12\x20\x20\40\x20\40\x20\x20\x20\40\40\x20\x20\x61\x75\x78\56\x73\x65\154\x65\x63\164\x28\51\x3b\xd\12\x20\40\40\40\x20\40\x20\40\40\x20\40\x20\144\157\143\165\155\145\x6e\164\56\x65\170\x65\143\x43\157\155\x6d\141\156\x64\50\x22\143\157\x70\x79\x22\x29\x3b\15\xa\40\40\x20\x20\x20\40\x20\40\40\40\40\40\x64\x6f\x63\165\155\145\x6e\x74\x2e\142\x6f\144\x79\x2e\x72\145\x6d\157\166\x65\103\150\x69\154\x64\50\141\x75\x78\x29\x3b\15\xa\40\40\x20\x20\40\40\x20\x20\x20\x20\40\x20\144\157\x63\x75\155\145\156\x74\x2e\147\145\164\105\154\x65\155\145\156\164\x42\171\x49\144\x28\47\143\157\160\171\47\x29\x2e\164\145\x78\164\x43\157\x6e\164\145\x6e\x74\40\x3d\40\42\103\x6f\160\151\x65\x64\x22\x3b\xd\12\x20\40\40\40\x20\40\40\x20\40\x20\x20\40\x64\157\143\165\155\145\156\164\x2e\x67\x65\164\105\154\x65\x6d\145\x6e\164\102\x79\111\144\50\x27\x63\x6f\160\171\x27\51\56\x73\x74\x79\x6c\x65\56\x62\x61\x63\153\x67\x72\157\165\x6e\x64\40\75\x20\42\147\x72\145\x79\x22\73\15\xa\40\40\x20\x20\x20\40\40\40\40\40\x20\x20\x77\151\x6e\144\x6f\167\56\x67\145\x74\x53\x65\x6c\x65\x63\x74\x69\x6f\156\50\51\56\x73\145\154\x65\143\x74\x41\154\x6c\x43\x68\x69\154\144\162\145\x6e\x28\40\144\x6f\x63\165\155\x65\x6e\164\x2e\147\x65\x74\x45\x6c\145\155\x65\x6e\x74\102\x79\x49\144\x28\40\x22\x53\101\115\x4c\137\144\151\163\160\x6c\141\x79\x22\x20\51\x20\51\73\15\12\15\12\x20\x20\x20\40\x20\x20\x20\x20\175\15\xa\15\12\x20\40\40\x20\40\40\x20\40\146\x75\x6e\143\x74\x69\157\x6e\40\x64\157\167\156\x6c\x6f\x61\144\50\x66\x69\154\x65\x6e\x61\x6d\145\x2c\40\x74\x65\x78\164\x29\40\x7b\15\12\40\40\40\x20\40\40\40\x20\x20\x20\40\x20\x76\x61\162\40\x65\154\145\155\145\x6e\x74\x20\x3d\40\144\x6f\x63\x75\155\145\156\x74\56\x63\x72\145\x61\164\145\x45\154\145\x6d\145\156\164\50\47\141\47\x29\73\15\xa\40\x20\40\40\40\40\40\40\40\40\x20\x20\x65\x6c\145\x6d\145\x6e\164\56\x73\145\164\101\x74\164\162\151\x62\x75\164\x65\50\x27\150\162\145\146\47\x2c\x20\47\x64\141\164\141\x3a\101\160\160\154\x69\143\141\164\x69\157\x6e\57\157\x63\x74\145\x74\55\163\x74\162\x65\x61\x6d\x3b\x63\x68\141\x72\163\145\x74\x3d\x75\164\x66\55\70\x2c\47\40\x2b\x20\x65\x6e\x63\157\144\145\125\x52\x49\103\x6f\155\160\x6f\156\145\x6e\x74\x28\x74\x65\170\164\51\x29\73\xd\xa\40\40\x20\40\40\40\x20\x20\40\x20\40\40\x65\154\x65\x6d\145\x6e\x74\56\163\x65\164\x41\164\x74\x72\151\142\x75\164\x65\x28\x27\144\157\x77\x6e\154\x6f\x61\x64\x27\x2c\x20\146\x69\154\x65\156\141\155\x65\51\x3b\xd\xa\15\12\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\145\154\145\x6d\145\156\x74\x2e\x73\x74\171\154\x65\56\144\x69\x73\160\154\141\171\x20\75\x20\x27\x6e\157\x6e\145\47\x3b\15\xa\x20\x20\x20\x20\40\x20\x20\x20\x20\40\40\x20\x64\x6f\x63\165\155\145\156\x74\56\142\157\144\171\56\x61\160\160\145\156\x64\103\150\151\x6c\x64\50\x65\154\145\x6d\x65\156\164\x29\x3b\15\12\15\xa\40\x20\x20\x20\40\x20\40\40\40\x20\40\40\145\x6c\x65\155\145\156\164\56\x63\154\x69\x63\153\x28\51\73\15\xa\xd\xa\x20\x20\40\40\40\40\40\40\x20\40\x20\40\144\157\143\165\x6d\145\x6e\x74\56\x62\x6f\144\171\x2e\x72\145\155\157\x76\145\103\x68\151\x6c\x64\x28\145\x6c\x65\x6d\x65\x6e\164\51\73\15\xa\40\40\40\x20\40\40\40\40\x7d\15\xa\xd\12\x20\x20\40\40\x20\40\40\x20\x64\x6f\x63\165\x6d\x65\156\164\56\x67\145\164\105\x6c\145\155\x65\x6e\164\x42\x79\111\x64\x28\x22\x64\x77\156\x2d\142\164\156\42\51\56\141\x64\x64\x45\166\x65\x6e\x74\114\x69\163\164\x65\x6e\145\162\50\42\143\154\x69\143\153\42\54\x20\x66\165\x6e\143\164\x69\157\156\40\50\51\x20\173\xd\xa\15\xa\x20\x20\40\40\x20\40\40\40\40\40\40\x20\x76\x61\x72\40\146\151\154\x65\x6e\141\155\145\x20\x3d\x20\144\157\143\x75\x6d\145\156\164\56\147\145\x74\x45\154\145\155\145\156\x74\x42\x79\x49\x64\x28\x22\x53\x41\x4d\x4c\x5f\x74\x79\x70\145\42\x29\x2e\164\x65\170\164\103\157\x6e\164\x65\156\x74\53\42\x2e\170\x6d\x6c\x22\x3b\xd\xa\40\x20\40\x20\x20\40\x20\x20\40\x20\x20\x20\166\x61\162\40\x6e\x6f\x64\x65\x20\x3d\40\x64\x6f\x63\165\155\x65\x6e\x74\x2e\x67\x65\164\105\x6c\145\x6d\x65\156\x74\102\x79\x49\x64\50\42\x53\x41\x4d\x4c\x5f\x64\151\x73\x70\x6c\x61\x79\x22\x29\73\15\12\40\x20\40\40\x20\40\x20\x20\x20\x20\40\40\x68\x74\x6d\154\103\157\156\164\145\x6e\164\x20\75\x20\x6e\x6f\144\x65\x2e\151\156\156\145\x72\x48\x54\x4d\114\x3b\15\xa\40\x20\x20\40\x20\x20\x20\40\40\x20\40\40\x74\x65\x78\164\x20\75\40\156\157\144\x65\x2e\164\145\170\x74\103\x6f\156\164\145\156\x74\x3b\15\12\x20\40\40\40\x20\x20\x20\40\x20\x20\x20\x20\143\157\x6e\x73\x6f\x6c\x65\x2e\154\x6f\147\50\164\x65\170\164\x29\x3b\15\12\x20\40\x20\40\x20\x20\x20\40\40\40\x20\40\144\157\167\x6e\x6c\157\x61\x64\50\x66\x69\154\145\x6e\x61\x6d\x65\54\x20\164\x65\x78\x74\x29\73\15\12\x20\x20\x20\x20\x20\x20\x20\40\175\x2c\x20\146\x61\x6c\163\x65\51\73\xd\xa\15\xa\15\xa\xd\xa\15\12\xd\12\x20\40\40\40\74\57\x73\x63\x72\151\x70\x74\76\15\12";
    exit;
}
function mo_saml_checkMapping($kd, $gu, $q1)
{
    try {
        $iI = get_site_option("\x73\x61\x6d\154\x5f\141\155\x5f\145\x6d\141\151\154");
        $Id = get_site_option("\163\x61\155\154\137\x61\x6d\137\165\163\145\162\156\141\155\x65");
        $ED = get_site_option("\163\x61\155\154\137\141\x6d\137\146\151\x72\163\x74\x5f\156\x61\155\x65");
        $oc = get_site_option("\x73\x61\155\x6c\x5f\141\x6d\x5f\x6c\x61\x73\x74\x5f\156\x61\x6d\145");
        $YY = get_site_option("\163\141\155\x6c\x5f\141\155\137\x67\162\157\x75\160\137\156\x61\x6d\145");
        $fn = array();
        $fn = maybe_unserialize(get_site_option("\163\141\155\x6c\x5f\141\155\x5f\162\x6f\154\x65\137\155\141\160\x70\x69\156\x67"));
        $Hh = get_site_option("\x73\141\155\154\137\x61\155\x5f\141\143\x63\157\x75\156\164\x5f\155\141\x74\143\150\x65\x72");
        $eY = '';
        $Bb = '';
        if (empty($kd)) {
            goto va;
        }
        if (!empty($ED) && array_key_exists($ED, $kd)) {
            goto m2;
        }
        $ED = '';
        goto Ac;
        m2:
        $ED = $kd[$ED][0];
        Ac:
        if (!empty($oc) && array_key_exists($oc, $kd)) {
            goto Ra;
        }
        $oc = '';
        goto IH;
        Ra:
        $oc = $kd[$oc][0];
        IH:
        if (!empty($Id) && array_key_exists($Id, $kd)) {
            goto E_;
        }
        $Bb = $kd["\x4e\141\x6d\x65\111\104"][0];
        goto zg;
        E_:
        $Bb = $kd[$Id][0];
        zg:
        if (!empty($iI) && array_key_exists($iI, $kd)) {
            goto C_;
        }
        $eY = $kd["\116\x61\155\x65\x49\104"][0];
        goto BG;
        C_:
        $eY = $kd[$iI][0];
        BG:
        if (!empty($YY) && array_key_exists($YY, $kd)) {
            goto vl;
        }
        $YY = array();
        goto BR;
        vl:
        $YY = $kd[$YY];
        BR:
        if (!empty($Hh)) {
            goto CO;
        }
        $Hh = "\145\155\x61\151\x6c";
        CO:
        va:
        if ($gu == "\x74\x65\163\164\126\141\154\151\144\141\164\145") {
            goto sY;
        }
        if ($gu == "\x74\x65\x73\x74\x4e\145\167\x43\145\162\x74\x69\x66\x69\143\x61\x74\145") {
            goto S1;
        }
        mo_saml_login_user($eY, $ED, $oc, $Bb, $YY, $fn, $gu, $Hh, $q1, $kd["\x4e\x61\x6d\x65\x49\104"][0], $kd);
        goto QL;
        sY:
        update_site_option("\155\x6f\x5f\163\141\155\154\137\x74\x65\163\x74", "\x54\145\x73\x74\x20\x53\165\x63\x63\x65\163\x73\146\x75\x6c");
        mo_saml_show_test_result($ED, $oc, $eY, $YY, $kd, $gu);
        goto QL;
        S1:
        update_site_option("\x6d\x6f\137\163\x61\155\x6c\x5f\x74\x65\x73\x74\137\x6e\x65\167\137\143\145\162\164", "\124\x65\x73\x74\40\163\x75\x63\143\145\163\x73\x66\165\154");
        mo_saml_show_test_result($ED, $oc, $eY, $YY, $kd, $gu);
        QL:
    } catch (Exception $Tn) {
        echo sprintf("\x41\156\40\x65\162\162\x6f\162\40\157\143\143\x75\x72\x72\145\144\40\167\x68\x69\x6c\x65\40\160\162\157\x63\145\x73\163\151\x6e\x67\x20\x74\150\145\x20\123\101\115\x4c\x20\122\x65\163\x70\x6f\156\163\145\x2e");
        exit;
    }
}
function mo_saml_show_test_result($ED, $oc, $eY, $YY, $kd, $gu)
{
    echo "\74\144\x69\166\40\x73\164\171\x6c\x65\75\42\x66\157\156\x74\x2d\146\x61\x6d\x69\154\171\72\103\x61\154\x69\x62\162\151\x3b\160\x61\144\x64\x69\x6e\147\x3a\x30\x20\x33\x25\73\42\x3e";
    if (!empty($eY)) {
        goto s0;
    }
    echo "\74\x64\x69\166\x20\x73\x74\x79\x6c\x65\75\42\x63\157\154\157\162\72\x20\43\141\x39\64\64\x34\62\x3b\x62\141\143\x6b\147\x72\157\165\x6e\144\x2d\x63\157\154\x6f\162\x3a\40\43\x66\x32\144\145\x64\145\73\160\141\x64\144\x69\x6e\147\72\40\61\65\160\x78\73\x6d\x61\162\x67\151\156\55\x62\157\x74\164\x6f\155\72\40\x32\60\160\x78\73\164\x65\x78\164\x2d\x61\154\x69\147\156\x3a\x63\145\156\x74\145\x72\73\x62\157\x72\x64\x65\x72\x3a\x31\160\x78\40\163\157\154\x69\x64\40\x23\x45\66\x42\63\x42\x32\x3b\x66\x6f\156\164\x2d\x73\x69\172\145\x3a\x31\x38\x70\164\73\x22\x3e\124\105\x53\x54\40\106\101\x49\x4c\105\x44\x3c\x2f\x64\x69\166\76\xd\xa\x9\x9\11\11\11\x9\74\x64\x69\x76\40\x73\164\171\154\x65\75\x22\143\157\154\x6f\162\72\40\43\141\71\x34\x34\64\x32\x3b\x66\157\x6e\164\55\x73\x69\172\x65\x3a\x31\64\160\164\73\40\x6d\141\x72\147\x69\156\55\x62\157\164\164\157\x6d\x3a\x32\x30\x70\x78\x3b\x22\x3e\127\x41\122\x4e\111\x4e\107\72\x20\123\x6f\x6d\145\x20\101\164\x74\x72\151\x62\165\x74\145\163\x20\104\x69\144\x20\x4e\157\x74\40\115\x61\164\143\x68\x2e\74\x2f\x64\151\166\76\xd\12\11\x9\11\x9\x9\x9\x3c\x64\151\166\40\163\x74\x79\x6c\x65\x3d\42\x64\x69\x73\x70\x6c\x61\x79\x3a\x62\154\x6f\143\x6b\73\164\145\x78\164\x2d\x61\154\151\x67\156\72\143\145\x6e\164\145\x72\x3b\x6d\x61\162\x67\x69\156\55\142\157\164\164\x6f\155\72\64\x25\73\42\76\74\x69\155\x67\40\163\x74\x79\154\x65\x3d\42\x77\x69\144\164\150\x3a\x31\x35\45\x3b\42\163\162\143\75\42" . plugin_dir_url(__FILE__) . "\x69\155\141\147\145\x73\x2f\167\162\x6f\x6e\147\56\160\156\147\42\x3e\74\x2f\144\151\166\76";
    goto Eb;
    s0:
    update_site_option("\x6d\157\137\x73\x61\155\x6c\137\164\145\163\x74\x5f\143\157\x6e\x66\151\x67\x5f\141\x74\x74\x72\163", $kd);
    echo "\74\144\151\x76\x20\163\x74\x79\x6c\145\75\x22\143\x6f\x6c\157\162\72\x20\x23\x33\143\x37\x36\x33\144\73\xd\12\11\11\x9\11\11\11\x62\x61\143\x6b\x67\162\157\165\x6e\x64\x2d\143\x6f\154\x6f\162\x3a\x20\43\144\146\146\60\144\x38\73\x20\160\141\144\x64\151\156\147\72\x32\45\73\x6d\x61\x72\147\x69\x6e\55\142\x6f\x74\164\x6f\x6d\72\x32\60\160\x78\73\164\145\170\x74\x2d\141\x6c\151\147\156\x3a\143\x65\156\164\x65\162\73\x20\x62\157\x72\x64\x65\162\x3a\61\x70\170\x20\x73\157\x6c\x69\144\x20\43\101\105\104\x42\71\101\x3b\40\146\157\156\164\x2d\x73\151\x7a\x65\x3a\61\x38\160\164\x3b\42\76\124\x45\123\124\40\x53\x55\x43\103\105\x53\123\x46\125\x4c\74\57\x64\151\x76\x3e\xd\xa\11\11\11\x9\11\11\x3c\144\x69\166\x20\163\164\x79\154\145\x3d\42\144\151\x73\x70\x6c\x61\x79\72\x62\154\x6f\x63\153\x3b\164\145\170\164\55\x61\x6c\151\x67\156\x3a\x63\145\156\164\145\x72\x3b\x6d\x61\x72\x67\x69\156\x2d\x62\x6f\164\164\x6f\x6d\x3a\x34\45\73\42\76\74\151\155\147\40\x73\x74\171\x6c\145\75\42\167\x69\144\x74\x68\72\x31\x35\x25\73\x22\x73\162\x63\x3d\42" . plugin_dir_url(__FILE__) . "\151\155\141\147\x65\163\57\147\162\x65\x65\156\x5f\143\x68\x65\x63\153\x2e\x70\x6e\x67\x22\x3e\74\57\x64\x69\x76\76";
    Eb:
    $yN = $gu == "\x74\x65\163\x74\x4e\145\167\x43\145\x72\164\x69\146\151\x63\141\x74\x65" ? "\144\x69\163\x70\154\141\x79\x3a\x6e\157\x6e\x65" : '';
    $ec = get_site_option("\x73\141\155\x6c\137\141\x6d\x5f\141\143\143\157\165\156\164\137\x6d\141\164\x63\x68\145\x72") ? get_site_option("\x73\x61\x6d\154\x5f\x61\155\137\141\143\x63\157\x75\x6e\164\x5f\x6d\x61\x74\x63\x68\x65\x72") : "\145\155\141\151\x6c";
    if (!($ec == "\145\155\x61\151\x6c" && !filter_var($kd["\x4e\141\x6d\x65\x49\104"][0], FILTER_VALIDATE_EMAIL))) {
        goto HJ;
    }
    echo "\74\x70\76\74\146\157\x6e\164\x20\x63\x6f\x6c\x6f\x72\75\42\43\106\x46\60\60\60\x30\x22\x20\x73\164\x79\154\145\75\42\146\157\x6e\164\x2d\x73\x69\172\x65\72\x31\x34\x70\164\x22\76\50\127\x61\162\x6e\x69\156\x67\72\x20\124\150\x65\40\x4e\141\x6d\145\111\104\x20\166\x61\x6c\165\145\40\151\163\x20\x6e\157\164\x20\141\40\x76\141\x6c\x69\x64\x20\105\155\141\151\154\40\111\x44\x29\74\57\146\157\156\164\x3e\74\x2f\x70\x3e";
    HJ:
    echo "\x3c\163\x70\x61\x6e\40\163\164\x79\154\x65\75\42\146\157\x6e\164\x2d\163\151\172\x65\x3a\61\64\x70\164\x3b\42\x3e\x3c\142\x3e\110\145\x6c\154\157\x3c\57\x62\76\x2c\40" . $eY . "\74\57\163\160\141\x6e\76\x3c\x62\162\57\x3e\x3c\160\40\163\164\171\154\x65\x3d\42\x66\157\x6e\164\55\167\145\151\147\x68\164\x3a\x62\157\154\x64\x3b\x66\157\x6e\x74\55\x73\151\172\x65\x3a\61\64\160\164\73\x6d\141\x72\x67\151\156\x2d\x6c\145\x66\x74\72\61\x25\73\x22\x3e\101\124\x54\122\x49\102\125\124\x45\123\40\x52\x45\x43\105\x49\126\105\x44\72\x3c\57\x70\x3e\xd\xa\11\x9\x9\11\11\x3c\164\141\142\154\x65\x20\x73\x74\x79\154\x65\x3d\42\x62\x6f\x72\x64\145\162\55\x63\x6f\x6c\154\141\160\163\145\72\x63\157\154\154\x61\160\163\145\x3b\142\157\x72\144\145\x72\55\163\x70\x61\143\151\x6e\x67\x3a\x30\x3b\x20\x64\151\x73\160\154\x61\x79\x3a\164\x61\142\154\x65\73\x77\x69\x64\x74\150\x3a\61\60\x30\x25\73\40\x66\x6f\x6e\164\55\x73\151\x7a\x65\x3a\61\x34\x70\164\73\x62\141\143\x6b\147\162\x6f\x75\156\x64\55\x63\157\154\x6f\162\x3a\43\105\x44\x45\104\105\x44\73\42\76\xd\xa\x9\x9\x9\11\x9\x9\74\164\162\40\163\x74\171\154\145\x3d\x22\x74\x65\170\164\55\141\154\x69\x67\x6e\72\143\x65\x6e\x74\x65\162\73\x22\x3e\x3c\164\x64\40\163\x74\171\154\145\75\x22\146\x6f\156\x74\55\x77\x65\151\147\x68\164\x3a\x62\x6f\154\144\x3b\142\x6f\x72\x64\145\162\72\x32\160\170\40\163\157\154\151\144\x20\x23\x39\64\x39\x30\71\60\x3b\x70\141\x64\x64\151\156\x67\72\62\45\73\x22\x3e\101\124\x54\x52\111\x42\125\x54\x45\x20\x4e\101\115\105\x3c\x2f\164\x64\x3e\x3c\164\x64\x20\x73\164\x79\154\145\x3d\x22\146\x6f\x6e\164\x2d\x77\x65\151\147\x68\x74\72\142\157\x6c\144\73\x70\141\144\x64\x69\x6e\147\x3a\62\45\x3b\142\157\x72\144\145\162\x3a\x32\x70\170\40\163\x6f\x6c\x69\144\40\43\71\64\x39\x30\x39\60\73\40\167\157\x72\144\x2d\167\162\x61\x70\72\142\162\x65\x61\x6b\x2d\x77\157\x72\x64\x3b\x22\76\101\x54\x54\x52\111\102\x55\124\105\x20\x56\x41\x4c\x55\x45\x3c\57\x74\144\x3e\74\x2f\164\162\76";
    if (!empty($kd)) {
        goto tA;
    }
    echo "\116\157\x20\x41\x74\x74\162\151\142\x75\164\145\x73\40\122\x65\143\145\151\166\145\144\56";
    goto k3;
    tA:
    foreach ($kd as $FE => $Ng) {
        echo "\x3c\164\x72\76\x3c\164\x64\x20\x73\x74\x79\154\145\75\47\x66\x6f\156\x74\55\167\145\151\x67\150\x74\72\142\x6f\154\x64\73\x62\x6f\162\x64\145\x72\72\62\x70\x78\x20\x73\157\x6c\151\x64\x20\x23\x39\x34\x39\x30\71\x30\73\160\x61\144\x64\151\x6e\147\x3a\x32\x25\73\47\x3e" . $FE . "\x3c\57\x74\144\x3e\74\x74\x64\40\163\164\171\154\145\75\47\160\x61\x64\144\x69\x6e\147\72\62\45\73\x62\x6f\162\x64\x65\162\72\x32\x70\x78\x20\x73\x6f\154\x69\x64\x20\x23\x39\64\x39\x30\x39\x30\73\40\x77\x6f\162\x64\x2d\x77\x72\x61\x70\72\x62\162\x65\141\x6b\x2d\167\157\x72\x64\x3b\x27\76" . implode("\74\x68\162\57\x3e", $Ng) . "\74\x2f\x74\x64\x3e\x3c\57\164\x72\x3e";
        Q4:
    }
    tF:
    k3:
    echo "\x3c\x2f\164\x61\142\154\145\x3e\74\x2f\144\x69\166\76";
    echo "\74\x64\151\x76\40\x73\164\x79\x6c\x65\75\x22\x6d\x61\x72\x67\151\x6e\72\63\x25\73\144\151\163\x70\154\x61\171\72\x62\x6c\157\x63\x6b\73\164\145\x78\164\55\x61\x6c\151\147\156\72\x63\x65\156\x74\145\162\x3b\x22\76\xd\12\x9\11\x9\x9\11\x9\x9\74\x69\156\x70\x75\164\40\x73\x74\x79\154\x65\75\42\x70\x61\144\144\151\x6e\x67\72\61\x25\73\x77\151\x64\164\150\72\62\65\60\x70\170\73\x62\141\143\x6b\x67\162\157\165\x6e\144\72\x20\43\60\60\71\x31\103\104\x20\156\x6f\156\x65\40\162\145\160\145\x61\164\x20\163\143\162\157\154\x6c\x20\60\45\40\60\x25\73\xd\xa\x9\x9\x9\x9\11\11\x9\x63\165\x72\163\157\162\72\x20\x70\157\151\x6e\164\x65\x72\73\x66\157\156\x74\55\x73\x69\x7a\x65\72\61\x35\x70\170\73\142\157\162\x64\145\x72\55\167\x69\144\164\x68\72\40\61\160\x78\73\x62\x6f\x72\144\x65\162\x2d\x73\x74\171\x6c\145\72\x20\x73\x6f\x6c\x69\144\73\x62\x6f\x72\144\145\x72\x2d\162\141\x64\151\165\x73\x3a\x20\63\x70\170\73\x77\150\151\x74\x65\x2d\x73\x70\x61\143\x65\x3a\15\xa\x9\x9\11\11\11\11\x9\156\157\167\x72\x61\x70\73\x62\157\170\x2d\163\x69\x7a\x69\x6e\147\72\40\142\157\162\144\x65\162\x2d\x62\157\170\73\142\157\162\144\145\162\55\143\x6f\x6c\157\x72\x3a\40\43\x30\x30\67\x33\x41\101\x3b\142\x6f\x78\55\x73\150\x61\x64\x6f\167\x3a\x20\60\x70\x78\x20\x31\x70\x78\x20\60\x70\x78\40\x72\x67\142\x61\x28\x31\62\x30\x2c\x20\62\60\60\x2c\x20\x32\x33\60\54\40\x30\56\66\51\x20\151\156\163\145\x74\73\143\157\154\157\x72\72\x20\43\x46\x46\106\x3b" . $yN . "\x22\15\12\x9\x9\x9\11\x9\x9\x9\11\x74\171\160\x65\75\42\142\x75\x74\x74\x6f\x6e\42\40\166\141\x6c\165\x65\75\42\103\x6f\156\146\x69\147\x75\x72\x65\40\101\164\x74\x72\x69\142\x75\x74\x65\57\x52\x6f\154\145\x20\115\x61\160\x70\151\x6e\x67\x22\40\157\156\x43\x6c\x69\143\x6b\x3d\x22\x63\154\157\163\145\x5f\141\x6e\x64\137\x72\x65\x64\x69\x72\145\143\x74\x28\51\73\42\x3e\40\x26\156\142\163\160\x3b\40\xd\xa\x9\x9\x9\11\11\11\11\x9\15\12\x9\x9\11\11\11\11\11\x3c\151\156\x70\x75\164\x20\163\164\x79\154\145\75\42\160\x61\144\x64\x69\156\x67\x3a\x31\45\73\167\x69\144\x74\150\72\61\60\x30\x70\x78\73\142\141\x63\153\x67\162\157\x75\156\144\x3a\40\x23\x30\60\71\x31\103\x44\40\156\157\x6e\x65\40\x72\x65\x70\x65\141\164\40\x73\143\162\157\154\154\40\x30\x25\x20\60\45\x3b\143\165\162\163\157\162\72\40\160\x6f\151\156\164\x65\x72\73\x66\157\156\x74\55\163\151\x7a\145\x3a\61\65\x70\170\73\x62\x6f\x72\144\145\162\x2d\167\151\x64\164\x68\x3a\40\x31\x70\170\x3b\142\157\162\144\145\162\55\163\x74\171\154\145\x3a\x20\x73\x6f\154\151\x64\x3b\142\157\x72\144\145\x72\55\162\x61\144\x69\x75\163\72\40\63\x70\x78\x3b\167\x68\x69\164\145\55\163\x70\x61\x63\145\x3a\40\x6e\x6f\167\x72\x61\160\73\142\x6f\170\x2d\163\x69\172\151\x6e\x67\72\x20\x62\157\162\144\x65\162\x2d\x62\157\x78\73\142\157\x72\144\x65\x72\55\143\x6f\154\157\162\72\40\x23\x30\60\x37\x33\101\101\73\142\157\170\55\x73\150\141\x64\157\x77\x3a\x20\60\160\x78\40\x31\160\x78\40\x30\160\170\x20\x72\x67\142\x61\x28\61\62\60\x2c\x20\x32\60\60\x2c\40\62\x33\60\54\40\x30\x2e\66\x29\x20\151\156\x73\145\x74\73\143\x6f\x6c\x6f\162\x3a\40\x23\x46\x46\106\x3b\42\x74\x79\x70\x65\75\x22\142\165\x74\x74\x6f\x6e\x22\x20\x76\x61\154\x75\145\75\x22\104\x6f\x6e\x65\42\40\157\156\x43\154\151\143\153\x3d\42\163\145\154\x66\56\x63\x6c\157\163\x65\x28\x29\73\x22\76\x3c\x2f\144\x69\166\x3e\15\xa\x9\x9\11\11\x9\x9\x9\x9\x9\x9\x9\11\74\163\143\162\x69\160\164\76\xd\12\40\40\x20\40\40\x20\x20\40\x20\x20\40\40\xd\12\x9\11\x9\x9\x9\x9\x9\x66\x75\x6e\x63\164\151\157\x6e\x20\x63\154\157\163\145\137\x61\x6e\144\x5f\x72\x65\144\x69\162\x65\x63\x74\50\51\x7b\xd\12\11\11\11\x9\11\11\11\x9\167\x69\x6e\x64\157\x77\x2e\x6f\160\145\156\x65\x72\x2e\162\x65\144\x69\x72\145\143\x74\x5f\164\x6f\137\141\164\x74\x72\x69\x62\165\164\x65\137\x6d\x61\x70\160\x69\156\147\50\x29\x3b\xd\xa\11\x9\11\11\11\11\x9\x9\x73\x65\x6c\146\x2e\x63\154\x6f\x73\145\x28\51\x3b\xd\xa\x9\x9\x9\11\x9\x9\11\x7d\15\xa\x9\x9\x9\x9\x9\11\11\xd\xa\x9\x9\11\11\11\x9\x9\x66\165\x6e\143\164\x69\x6f\x6e\x20\x72\145\x66\x72\x65\x73\150\120\141\162\x65\156\x74\x28\51\x20\x7b\xd\12\x9\x9\11\x9\x9\x9\x9\x9\x77\151\x6e\144\157\x77\56\x6f\160\x65\156\145\162\56\x6c\157\143\x61\164\151\x6f\x6e\56\x72\x65\154\x6f\141\x64\50\x29\x3b\15\12\x9\x9\11\11\x9\x9\11\175\15\xa\11\x9\11\x9\11\x9\x9\74\x2f\x73\x63\x72\x69\160\164\76";
    exit;
}
function mo_saml_convert_to_windows_iconv($Ri)
{
    $G3 = get_site_option("\155\x6f\x5f\163\141\155\154\137\145\x6e\143\x6f\144\x69\156\x67\137\145\x6e\141\x62\x6c\x65\144");
    if (!($G3 === '')) {
        goto DE;
    }
    return $Ri;
    DE:
    return iconv("\x55\x54\x46\55\70", "\103\x50\x31\62\x35\x32\57\57\x49\x47\116\117\122\x45", $Ri);
}
function mo_saml_login_user($eY, $ED, $oc, $Bb, $YY, $fn, $gu, $Hh, $q1 = '', $f1 = '', $kd = null)
{
    do_action("\x6d\x6f\137\141\x62\x72\137\146\x69\x6c\164\x65\162\137\x6c\x6f\x67\151\156", $kd);
    $Bb = mo_saml_sanitize_username($Bb);
    if (get_site_option("\155\x6f\137\x73\x61\155\x6c\137\144\x69\x73\141\142\x6c\145\137\x72\x6f\x6c\x65\x5f\155\x61\x70\x70\x69\x6e\147")) {
        goto mg;
    }
    check_if_user_allowed_to_login_due_to_role_restriction($YY);
    mg:
    $jt = get_site_option("\x6d\x6f\137\163\141\x6d\x6c\137\163\160\x5f\142\141\x73\145\137\x75\162\154");
    mo_saml_restrict_users_based_on_domain($eY);
    if (!empty($fn)) {
        goto y5;
    }
    $fn["\x44\105\106\101\x55\x4c\124"]["\x64\x65\x66\141\165\x6c\164\137\x72\x6f\x6c\x65"] = "\x73\165\x62\163\143\x72\151\x62\x65\162";
    $fn["\104\x45\106\x41\125\114\124"]["\x64\157\x6e\x74\137\141\154\x6c\157\167\x5f\165\x6e\x6c\151\163\x74\x65\144\137\x75\163\145\x72"] = '';
    $fn["\x44\105\x46\x41\x55\114\x54"]["\x64\157\156\x74\137\x63\x72\x65\x61\164\145\x5f\165\x73\145\162"] = '';
    $fn["\104\105\x46\101\x55\x4c\124"]["\153\145\x65\160\137\x65\x78\x69\x73\x74\151\156\x67\137\x75\163\x65\162\163\137\162\x6f\154\145"] = '';
    $fn["\104\x45\106\x41\x55\x4c\x54"]["\155\157\x5f\x73\141\x6d\x6c\137\x64\x6f\x6e\164\x5f\141\154\154\x6f\x77\137\165\163\x65\x72\x5f\164\x6f\x6c\x6f\147\x69\x6e\x5f\x63\x72\x65\141\x74\145\137\x77\x69\164\150\x5f\x67\151\x76\x65\x6e\137\147\162\x6f\x75\160\x73"] = '';
    $fn["\x44\x45\x46\101\125\x4c\x54"]["\155\x6f\137\163\x61\x6d\154\x5f\162\145\163\164\162\x69\x63\164\137\165\163\145\x72\163\x5f\167\x69\x74\150\x5f\x67\x72\x6f\x75\x70\163"] = '';
    y5:
    global $wpdb;
    $RI = get_current_blog_id();
    $Nw = "\165\156\x63\150\x65\x63\153\145\144";
    if (!empty($jt)) {
        goto Gh;
    }
    $jt = get_network_site_url();
    Gh:
    if (email_exists($eY) || username_exists($Bb)) {
        goto VV;
    }
    $qO = Utilities::get_active_sites();
    $j9 = get_site_option("\x6d\x6f\x5f\x61\160\x70\154\171\x5f\162\157\x6c\145\x5f\155\x61\x70\160\151\x6e\x67\x5f\x66\157\x72\137\163\151\x74\x65\x73");
    if (!get_site_option("\155\x6f\x5f\x73\x61\155\154\137\144\151\163\x61\x62\x6c\145\137\x72\x6f\x6c\145\137\x6d\141\160\160\151\156\147")) {
        goto bv;
    }
    $QD = wp_generate_password(12, false);
    $Tw = wpmu_create_user($Bb, $QD, $eY);
    goto bG;
    bv:
    $Tw = mo_saml_assign_roles_to_new_user($qO, $j9, $fn, $YY, $Bb, $eY);
    bG:
    switch_to_blog($RI);
    if (!empty($Tw)) {
        goto s3;
    }
    if (!get_site_option("\155\x6f\137\163\141\x6d\x6c\137\144\x69\163\x61\x62\x6c\145\x5f\162\157\x6c\145\137\x6d\x61\x70\160\x69\156\x67")) {
        goto gN;
    }
    wp_die("\x57\145\x20\x63\x6f\165\154\x64\40\x6e\157\164\x20\x73\151\147\x6e\40\x79\x6f\x75\x20\x69\x6e\x2e\40\120\154\145\x61\x73\x65\40\143\157\156\164\x61\x63\x74\x20\x61\x64\x6d\x69\156\151\163\164\162\x61\164\x6f\x72", "\114\157\x67\x69\x6e\40\106\141\x69\154\145\144\x21");
    goto oJ;
    gN:
    $ck = get_site_option("\x6d\157\137\163\141\x6d\x6c\x5f\x61\x63\143\157\165\156\x74\x5f\143\x72\x65\141\164\151\x6f\x6e\137\x64\x69\x73\141\142\x6c\145\144\137\155\x73\x67");
    if (!empty($ck)) {
        goto uW;
    }
    $ck = "\x57\x65\x20\x63\x6f\165\x6c\144\x20\x6e\157\164\x20\x73\x69\x67\156\40\x79\157\x75\x20\x69\156\56\40\x50\154\145\141\x73\145\40\143\157\x6e\x74\x61\143\x74\x20\x79\x6f\x75\162\40\101\144\155\x69\x6e\151\x73\164\x72\141\164\x6f\x72\56";
    uW:
    wp_die($ck, "\105\162\162\x6f\162\72\x20\116\x6f\164\40\x61\40\127\x6f\x72\144\x50\162\145\x73\x73\40\x4d\x65\155\x62\x65\162");
    oJ:
    s3:
    $user = get_user_by("\x69\144", $Tw);
    mo_saml_map_basic_attributes($user, $ED, $oc, $kd);
    mo_saml_map_custom_attributes($Tw, $kd);
    $x5 = mo_saml_get_redirect_url($jt, $gu);
    do_action("\155\151\x6e\151\x6f\162\141\156\x67\x65\x5f\160\x6f\x73\164\137\141\165\x74\x68\145\156\164\x69\x63\141\164\x65\137\165\x73\x65\x72\137\x6c\157\x67\151\156", $user, null, $x5, true);
    mo_saml_set_auth_cookie($user, $q1, $f1, true);
    do_action("\x6d\157\137\x73\141\x6d\154\x5f\141\x74\x74\x72\x69\x62\165\x74\145\163", $Bb, $eY, $ED, $oc, $YY, null, true);
    goto mp;
    VV:
    if (email_exists($eY)) {
        goto DN;
    }
    $user = get_user_by("\154\157\x67\x69\x6e", $Bb);
    goto X_;
    DN:
    $user = get_user_by("\x65\x6d\141\x69\x6c", $eY);
    X_:
    $Tw = $user->ID;
    if (!(!empty($eY) and strcasecmp($eY, $user->user_email) != 0)) {
        goto QU;
    }
    $Tw = wp_update_user(array("\x49\x44" => $Tw, "\165\x73\x65\162\137\145\x6d\x61\151\154" => $eY));
    QU:
    mo_saml_map_basic_attributes($user, $ED, $oc, $kd);
    mo_saml_map_custom_attributes($Tw, $kd);
    $qO = Utilities::get_active_sites();
    $j9 = get_site_option("\x6d\x6f\137\141\160\160\x6c\171\x5f\162\157\154\145\x5f\x6d\x61\160\160\151\x6e\x67\x5f\x66\157\x72\137\x73\x69\164\145\x73");
    if (get_site_option("\x6d\x6f\x5f\x73\141\x6d\x6c\137\x64\151\163\141\142\x6c\145\137\x72\x6f\x6c\x65\137\155\141\160\160\x69\156\x67")) {
        goto Ql;
    }
    foreach ($qO as $blog_id) {
        switch_to_blog($blog_id);
        $user = get_user_by("\151\144", $Tw);
        $zb = '';
        if ($j9) {
            goto E5;
        }
        $zb = $blog_id;
        goto HB;
        E5:
        $zb = 0;
        HB:
        if (empty($fn)) {
            goto YP;
        }
        if (!empty($fn[$zb])) {
            goto eo;
        }
        if (!empty($fn["\104\105\106\x41\125\114\124"])) {
            goto VG;
        }
        $qS = "\163\165\142\163\x63\x72\151\142\145\x72";
        $t7 = '';
        $Nw = '';
        $nf = '';
        goto bB;
        VG:
        $qS = isset($fn["\104\105\x46\101\x55\x4c\124"]["\x64\x65\146\141\x75\x6c\x74\x5f\x72\x6f\154\145"]) ? $fn["\x44\105\x46\101\125\114\x54"]["\144\145\x66\141\x75\154\164\x5f\162\157\154\145"] : "\163\x75\142\163\x63\x72\x69\x62\145\162";
        $t7 = isset($fn["\104\x45\x46\101\x55\114\124"]["\x64\x6f\x6e\x74\137\141\x6c\x6c\157\167\137\165\156\154\x69\163\x74\x65\144\x5f\165\163\x65\x72"]) ? $fn["\104\x45\106\x41\125\114\x54"]["\x64\x6f\x6e\x74\137\x61\154\x6c\157\167\x5f\x75\x6e\154\x69\163\164\x65\144\x5f\x75\163\x65\x72"] : '';
        $Nw = isset($fn["\104\105\106\101\x55\114\124"]["\144\157\156\x74\137\143\162\145\141\164\145\137\x75\163\x65\162"]) ? $fn["\x44\x45\x46\101\125\114\124"]["\x64\157\x6e\x74\137\x63\162\145\141\164\x65\137\x75\163\145\x72"] : '';
        $nf = isset($fn["\104\x45\106\101\125\x4c\124"]["\153\x65\145\x70\x5f\145\x78\x69\x73\164\x69\x6e\x67\x5f\x75\163\x65\162\x73\x5f\162\x6f\x6c\145"]) ? $fn["\x44\x45\x46\101\x55\114\124"]["\x6b\x65\x65\x70\x5f\145\x78\151\163\164\151\156\147\137\165\x73\x65\x72\x73\137\162\x6f\154\145"] : '';
        bB:
        goto J5;
        eo:
        $qS = isset($fn[$zb]["\144\x65\x66\x61\x75\154\x74\137\162\x6f\154\x65"]) ? $fn[$zb]["\144\x65\x66\x61\165\154\164\137\162\x6f\x6c\x65"] : '';
        $t7 = isset($fn[$zb]["\144\x6f\x6e\164\x5f\x61\154\x6c\157\x77\x5f\x75\x6e\x6c\151\163\x74\x65\144\x5f\x75\163\145\162"]) ? $fn[$zb]["\144\157\x6e\x74\137\x61\x6c\x6c\x6f\167\137\x75\156\154\x69\163\x74\145\x64\x5f\165\163\x65\162"] : '';
        $Nw = isset($fn[$zb]["\x64\x6f\156\x74\x5f\x63\x72\145\141\x74\x65\137\x75\163\145\162"]) ? $fn[$zb]["\x64\x6f\156\164\x5f\143\162\x65\141\x74\145\x5f\165\163\145\x72"] : '';
        $nf = isset($fn[$zb]["\153\145\x65\160\137\145\x78\151\163\164\x69\x6e\147\x5f\165\x73\145\162\163\137\x72\157\x6c\145"]) ? $fn[$zb]["\x6b\145\x65\160\x5f\145\170\151\163\x74\151\156\x67\x5f\165\163\145\162\163\x5f\162\157\x6c\x65"] : '';
        J5:
        YP:
        if (!is_user_member_of_blog($Tw, $blog_id)) {
            goto xM;
        }
        if (isset($nf) && $nf == "\x63\150\x65\143\153\x65\144") {
            goto sE;
        }
        $vP = assign_roles_to_user($user, $fn, $blog_id, $YY, $zb);
        goto JP;
        sE:
        $vP = false;
        JP:
        if (is_administrator_user($user)) {
            goto U6;
        }
        if (isset($nf) && $nf == "\x63\150\145\x63\153\x65\x64") {
            goto xJ;
        }
        if ($vP !== true && !empty($t7) && $t7 == "\143\x68\x65\143\153\x65\144") {
            goto Hc;
        }
        if ($vP !== true && !empty($qS) && $qS !== "\146\141\x6c\163\x65") {
            goto dJ;
        }
        if ($vP !== true && is_user_member_of_blog($Tw, $blog_id)) {
            goto Fm;
        }
        goto jH;
        xJ:
        goto jH;
        Hc:
        $Tw = wp_update_user(array("\x49\x44" => $Tw, "\162\x6f\154\x65" => false));
        goto jH;
        dJ:
        $Tw = wp_update_user(array("\111\104" => $Tw, "\x72\157\x6c\145" => $qS));
        goto jH;
        Fm:
        $ZQ = get_site_option("\x64\x65\x66\x61\x75\154\x74\137\x72\x6f\154\x65");
        $Tw = wp_update_user(array("\111\104" => $Tw, "\162\x6f\154\x65" => $ZQ));
        jH:
        U6:
        goto YN;
        xM:
        $De = TRUE;
        $A7 = get_site_option("\x73\141\x6d\x6c\x5f\163\x73\157\137\163\x65\164\164\x69\x6e\147\x73");
        if (!empty($A7[$blog_id])) {
            goto Fx;
        }
        $A7[$blog_id] = $A7["\x44\x45\106\x41\x55\x4c\x54"];
        Fx:
        if (empty($fn)) {
            goto OW;
        }
        if (array_key_exists($zb, $fn)) {
            goto U1;
        }
        if (!array_key_exists("\x44\105\x46\101\125\x4c\x54", $fn)) {
            goto zc;
        }
        $lp = get_saml_roles_to_assign($fn, $zb, $YY);
        if (!(empty($lp) && strcmp($fn["\x44\105\106\101\125\x4c\x54"]["\x64\157\x6e\x74\x5f\x63\x72\145\141\164\145\137\165\163\145\x72"], "\143\x68\x65\143\x6b\145\x64") == 0)) {
            goto vr;
        }
        $De = FALSE;
        vr:
        zc:
        goto Kq;
        U1:
        $lp = get_saml_roles_to_assign($fn, $zb, $YY);
        if (!(empty($lp) && strcmp($fn[$zb]["\x64\x6f\156\164\x5f\143\x72\x65\x61\164\x65\137\x75\163\145\162"], "\143\150\145\143\153\145\x64") == 0)) {
            goto CX;
        }
        $De = FALSE;
        CX:
        Kq:
        OW:
        if (!$De) {
            goto fx;
        }
        add_user_to_blog($blog_id, $Tw, false);
        $vP = assign_roles_to_user($user, $fn, $blog_id, $YY, $zb);
        if ($vP !== true && !empty($t7) && $t7 == "\x63\x68\145\143\153\x65\144") {
            goto RD;
        }
        if ($vP !== true && !empty($qS) && $qS !== "\x66\x61\154\x73\x65") {
            goto qL;
        }
        if ($vP !== true) {
            goto Z1;
        }
        goto NT;
        RD:
        $Tw = wp_update_user(array("\x49\x44" => $Tw, "\162\157\154\145" => false));
        goto NT;
        qL:
        $Tw = wp_update_user(array("\111\104" => $Tw, "\162\x6f\154\145" => $qS));
        goto NT;
        Z1:
        $ZQ = get_site_option("\x64\145\x66\141\165\154\164\137\x72\x6f\154\145");
        $Tw = wp_update_user(array("\111\x44" => $Tw, "\162\x6f\154\x65" => $ZQ));
        NT:
        fx:
        YN:
        kI:
    }
    dS:
    Ql:
    switch_to_blog($RI);
    if ($Tw) {
        goto yx;
    }
    wp_die("\x49\x6e\166\x61\154\x69\x64\x20\165\x73\x65\162\x2e\x20\120\x6c\145\x61\163\145\x20\164\x72\171\40\x61\147\x61\151\156\56");
    yx:
    $user = get_user_by("\x69\144", $Tw);
    mo_saml_set_auth_cookie($user, $q1, $f1, true);
    do_action("\x6d\157\x5f\163\141\155\x6c\137\x61\x74\164\x72\151\x62\x75\164\145\163", $Bb, $eY, $ED, $oc, $YY);
    mp:
    mo_saml_post_login_redirection($jt, $gu);
}
function mo_saml_add_user_to_blog($eY, $Bb, $blog_id = 0)
{
    if (email_exists($eY)) {
        goto u0;
    }
    if (!empty($Bb)) {
        goto Cb;
    }
    $Tw = mo_saml_create_user($eY, $eY, $blog_id);
    goto mX;
    Cb:
    $Tw = mo_saml_create_user($Bb, $eY, $blog_id);
    mX:
    goto km;
    u0:
    $user = get_user_by("\x65\x6d\141\x69\154", $eY);
    $Tw = $user->ID;
    if (empty($blog_id)) {
        goto Wu;
    }
    add_user_to_blog($blog_id, $Tw, false);
    Wu:
    km:
    return $Tw;
}
function mo_saml_create_user($Bb, $eY, $blog_id)
{
    $f9 = wp_generate_password(10, false);
    if (username_exists($Bb)) {
        goto zt;
    }
    $Tw = wp_create_user($Bb, $f9, $eY);
    goto Jn;
    zt:
    $user = get_user_by("\154\157\x67\151\x6e", $Bb);
    $Tw = $user->ID;
    if (!$blog_id) {
        goto kJ;
    }
    add_user_to_blog($blog_id, $Tw, false);
    kJ:
    Jn:
    if (!is_wp_error($Tw)) {
        goto AZ;
    }
    echo "\74\x73\x74\x72\x6f\x6e\x67\76\x45\x52\122\117\122\74\57\x73\164\x72\157\x6e\147\76\x3a\x20\x45\x6d\x70\x74\171\x20\125\x73\x65\162\40\116\x61\x6d\x65\40\141\x6e\x64\x20\x45\155\x61\151\154\x2e\40\120\154\x65\x61\163\x65\x20\143\157\156\164\141\x63\x74\x20\x79\157\x75\x72\40\x61\x64\x6d\151\156\151\163\164\162\141\164\157\162\56";
    exit;
    AZ:
    return $Tw;
}
function mo_saml_assign_roles_to_new_user($qO, $j9, $fn, $YY, $Bb, $eY)
{
    global $wpdb;
    $user = NULL;
    $Ea = false;
    foreach ($qO as $blog_id) {
        $Hi = TRUE;
        $zb = '';
        if ($j9) {
            goto g8;
        }
        $zb = $blog_id;
        goto L5;
        g8:
        $zb = 0;
        L5:
        $A7 = get_site_option("\x73\x61\x6d\154\137\163\163\157\137\x73\145\x74\x74\151\x6e\x67\163");
        if (!empty($A7[$blog_id])) {
            goto Sf;
        }
        $A7[$blog_id] = $A7["\104\x45\106\x41\x55\x4c\124"];
        Sf:
        if (empty($fn)) {
            goto Mj;
        }
        if (!empty($fn[$zb])) {
            goto HR;
        }
        if (!empty($fn["\104\x45\106\x41\x55\114\x54"])) {
            goto Wo;
        }
        $qS = "\x73\165\x62\163\143\x72\151\142\x65\x72";
        $t7 = '';
        $nf = '';
        $lp = '';
        goto nh;
        Wo:
        $qS = isset($fn["\x44\105\x46\x41\x55\x4c\124"]["\x64\x65\146\141\165\154\164\137\162\x6f\x6c\145"]) ? $fn["\104\105\106\x41\x55\114\124"]["\x64\145\x66\141\x75\x6c\x74\x5f\162\157\154\x65"] : '';
        $t7 = isset($fn["\x44\105\106\101\x55\x4c\x54"]["\x64\x6f\x6e\164\137\141\x6c\x6c\157\167\x5f\165\156\154\151\x73\164\145\144\137\165\163\145\162"]) ? $fn["\104\x45\x46\x41\x55\114\124"]["\144\157\x6e\164\x5f\x61\154\154\x6f\167\x5f\x75\x6e\154\x69\x73\164\x65\x64\x5f\x75\x73\145\x72"] : '';
        $nf = array_key_exists("\x6b\x65\145\160\x5f\x65\170\151\x73\164\151\x6e\147\x5f\x75\x73\145\x72\x73\137\x72\157\154\145", $fn["\x44\x45\x46\x41\x55\x4c\x54"]) ? $fn["\x44\105\x46\101\125\114\124"]["\153\145\145\160\x5f\145\170\151\163\164\x69\156\x67\137\x75\x73\x65\x72\163\137\x72\x6f\x6c\x65"] : '';
        $lp = get_saml_roles_to_assign($fn, $zb, $YY);
        if (!(empty($lp) && strcmp($fn["\104\x45\x46\x41\125\114\124"]["\144\x6f\x6e\x74\137\143\x72\145\x61\x74\x65\137\165\x73\145\162"], "\143\x68\x65\143\x6b\145\144") == 0)) {
            goto GH;
        }
        $Hi = FALSE;
        GH:
        nh:
        goto hf;
        HR:
        $qS = isset($fn[$zb]["\144\145\x66\x61\165\154\164\137\162\x6f\x6c\145"]) ? $fn[$zb]["\144\145\x66\141\x75\x6c\x74\137\x72\157\154\x65"] : '';
        $t7 = isset($fn[$zb]["\x64\x6f\x6e\164\137\x61\154\154\157\x77\137\x75\156\154\151\163\164\145\144\x5f\x75\x73\145\162"]) ? $fn[$zb]["\x64\157\x6e\x74\x5f\141\154\154\x6f\167\137\x75\x6e\154\x69\x73\x74\x65\x64\x5f\x75\163\x65\x72"] : '';
        $nf = array_key_exists("\153\145\x65\x70\x5f\145\x78\151\163\164\151\156\x67\137\x75\x73\x65\162\163\137\x72\157\154\x65", $fn[$zb]) ? $fn[$zb]["\x6b\x65\145\160\x5f\145\x78\x69\163\164\151\x6e\x67\137\x75\163\145\162\163\x5f\162\x6f\154\145"] : '';
        $lp = get_saml_roles_to_assign($fn, $zb, $YY);
        if (!(empty($lp) && strcmp($fn[$zb]["\x64\157\156\164\x5f\143\x72\145\x61\x74\145\137\165\163\x65\x72"], "\143\x68\x65\143\153\x65\144") == 0)) {
            goto Cz;
        }
        $Hi = FALSE;
        Cz:
        hf:
        Mj:
        if (!$Hi) {
            goto bfx;
        }
        $Tw = NULL;
        switch_to_blog($blog_id);
        $Tw = mo_saml_add_user_to_blog($eY, $Bb, $blog_id);
        $user = get_user_by("\151\144", $Tw);
        $vP = assign_roles_to_user($user, $fn, $blog_id, $YY, $zb);
        if ($vP !== true && !empty($t7) && $t7 == "\x63\x68\x65\x63\153\145\x64") {
            goto kro;
        }
        if ($vP !== true && !empty($qS) && $qS !== "\146\x61\154\x73\145") {
            goto SxN;
        }
        if ($vP !== true) {
            goto fDC;
        }
        goto syd;
        kro:
        $Tw = wp_update_user(array("\x49\x44" => $Tw, "\x72\157\x6c\145" => false));
        goto syd;
        SxN:
        $Tw = wp_update_user(array("\x49\104" => $Tw, "\x72\157\x6c\x65" => $qS));
        goto syd;
        fDC:
        $ZQ = get_site_option("\144\145\146\141\x75\x6c\x74\137\x72\x6f\154\x65");
        $Tw = wp_update_user(array("\111\x44" => $Tw, "\162\157\154\x65" => $ZQ));
        syd:
        $dD = $user->{$wpdb->prefix . "\143\141\x70\x61\142\x69\x6c\x69\x74\151\145\x73"};
        if (isset($wp_roles)) {
            goto TWI;
        }
        $wp_roles = new WP_Roles($zb);
        TWI:
        bfx:
        dX:
    }
    KO:
    if (!empty($user)) {
        goto loA;
    }
    return;
    goto UnP;
    loA:
    return $user->ID;
    UnP:
}
function mo_saml_sanitize_username($Bb)
{
    $T_ = sanitize_user($Bb, true);
    $sp = apply_filters("\x70\162\x65\x5f\x75\163\x65\x72\137\154\157\147\151\156", $T_);
    $Bb = trim($sp);
    return $Bb;
}
function mo_saml_map_basic_attributes($user, $ED, $oc, $kd)
{
    $Tw = $user->ID;
    if (empty($ED)) {
        goto tVR;
    }
    $Tw = wp_update_user(array("\111\x44" => $Tw, "\x66\151\162\163\x74\x5f\x6e\x61\x6d\x65" => $ED));
    tVR:
    if (empty($oc)) {
        goto oF1;
    }
    $Tw = wp_update_user(array("\111\104" => $Tw, "\x6c\141\x73\164\137\156\x61\x6d\145" => $oc));
    oF1:
    if (is_null($kd)) {
        goto Ldq;
    }
    update_user_meta($Tw, "\155\157\137\163\141\x6d\x6c\x5f\x75\163\145\162\137\x61\164\x74\x72\x69\x62\165\x74\145\x73", $kd);
    $Tk = get_site_option("\x73\x61\155\154\137\x61\x6d\137\144\151\163\x70\x6c\141\x79\137\156\x61\155\145");
    if (empty($Tk)) {
        goto i6y;
    }
    if (strcmp($Tk, "\125\123\105\x52\116\101\x4d\105") == 0) {
        goto Ab2;
    }
    if (strcmp($Tk, "\x46\x4e\x41\x4d\x45") == 0 && !empty($ED)) {
        goto O_t;
    }
    if (strcmp($Tk, "\114\116\x41\x4d\105") == 0 && !empty($oc)) {
        goto EbD;
    }
    if (strcmp($Tk, "\x46\x4e\101\x4d\105\137\114\x4e\101\x4d\x45") == 0 && !empty($oc) && !empty($ED)) {
        goto xvE;
    }
    if (!(strcmp($Tk, "\x4c\116\x41\115\105\137\x46\116\x41\x4d\x45") == 0 && !empty($oc) && !empty($ED))) {
        goto hwJ;
    }
    $Tw = wp_update_user(array("\x49\104" => $Tw, "\x64\151\x73\x70\154\x61\x79\x5f\x6e\141\155\x65" => $oc . "\x20" . $ED));
    hwJ:
    goto XgA;
    xvE:
    $Tw = wp_update_user(array("\x49\x44" => $Tw, "\144\151\163\160\154\141\171\x5f\156\x61\x6d\145" => $ED . "\x20" . $oc));
    XgA:
    goto FrG;
    EbD:
    $Tw = wp_update_user(array("\111\104" => $Tw, "\x64\151\163\x70\x6c\141\x79\137\x6e\x61\155\x65" => $oc));
    FrG:
    goto gEI;
    O_t:
    $Tw = wp_update_user(array("\111\x44" => $Tw, "\x64\x69\x73\160\x6c\x61\171\137\x6e\x61\155\145" => $ED));
    gEI:
    goto oTu;
    Ab2:
    $Tw = wp_update_user(array("\111\x44" => $Tw, "\144\x69\x73\160\154\x61\x79\137\156\141\x6d\x65" => $user->user_login));
    oTu:
    i6y:
    Ldq:
}
function mo_saml_map_custom_attributes($Tw, $kd)
{
    if (!get_site_option("\155\x6f\137\x73\x61\x6d\154\137\x63\165\x73\x74\157\155\x5f\141\164\x74\x72\163\x5f\155\141\x70\160\151\x6e\x67")) {
        goto rZV;
    }
    $NW = maybe_unserialize(get_site_option("\155\x6f\137\163\x61\x6d\154\137\x63\x75\163\164\x6f\x6d\137\141\x74\x74\162\163\137\x6d\x61\160\x70\151\x6e\x67"));
    foreach ($NW as $FE => $Ng) {
        if (!array_key_exists($Ng, $kd)) {
            goto KKv;
        }
        $c2 = false;
        if (!(count($kd[$Ng]) == 1)) {
            goto Gfu;
        }
        $c2 = true;
        Gfu:
        if (!$c2) {
            goto DWy;
        }
        update_user_meta($Tw, $FE, $kd[$Ng][0]);
        goto lSl;
        DWy:
        $Kg = array();
        foreach ($kd[$Ng] as $au) {
            array_push($Kg, $au);
            sr9:
        }
        K8T:
        update_user_meta($Tw, $FE, $Kg);
        lSl:
        KKv:
        RwH:
    }
    BSh:
    rZV:
}
function mo_saml_restrict_users_based_on_domain($eY)
{
    $XS = get_site_option("\155\x6f\137\x73\x61\155\154\137\x65\156\x61\x62\x6c\145\x5f\x64\x6f\x6d\x61\x69\156\137\x72\x65\163\x74\162\151\x63\164\x69\157\156\x5f\154\x6f\147\x69\156");
    if (!$XS) {
        goto XE7;
    }
    $sn = get_site_option("\163\141\x6d\154\137\141\155\137\145\x6d\141\151\154\x5f\144\x6f\155\141\151\x6e\x73");
    $wY = explode("\73", $sn);
    $Si = explode("\x40", $eY);
    $nq = array_key_exists("\61", $Si) ? $Si[1] : '';
    $D0 = get_site_option("\x6d\157\137\x73\141\x6d\154\x5f\141\x6c\154\x6f\x77\x5f\x64\x65\156\171\x5f\x75\163\145\x72\x5f\167\x69\x74\x68\x5f\x64\x6f\x6d\141\151\x6e");
    $ck = get_site_option("\x6d\157\137\163\141\x6d\x6c\x5f\x72\145\x73\164\162\x69\143\164\x65\144\x5f\144\157\155\x61\x69\x6e\x5f\x65\162\162\x6f\162\x5f\x6d\x73\147");
    if (!empty($ck)) {
        goto HDC;
    }
    $ck = "\x59\157\165\x20\x61\162\145\x20\156\157\164\40\x61\154\154\x6f\167\145\x64\40\164\157\40\x6c\x6f\x67\x69\156\x2e\x20\120\x6c\x65\141\x73\145\40\x63\x6f\x6e\x74\x61\143\164\40\171\x6f\x75\162\x20\x41\144\155\151\156\151\x73\164\162\x61\164\157\162\x2e";
    HDC:
    if (!empty($D0) && $D0 == "\144\145\x6e\171") {
        goto YF5;
    }
    if (in_array($nq, $wY)) {
        goto Opn;
    }
    wp_die($ck, "\120\145\162\155\x69\x73\x73\x69\x6f\156\x20\x44\x65\x6e\151\145\x64\40\105\162\162\157\x72\40\x2d\40\x32");
    Opn:
    goto whr;
    YF5:
    if (!in_array($nq, $wY)) {
        goto PMl;
    }
    wp_die($ck, "\x50\x65\x72\x6d\x69\x73\x73\x69\157\156\40\104\145\156\151\x65\144\x20\x45\x72\x72\157\162\40\55\40\x31");
    PMl:
    whr:
    XE7:
}
function mo_saml_set_auth_cookie($user, $q1, $f1, $on)
{
    $Tw = $user->ID;
    do_action("\167\160\137\154\x6f\147\151\156", $user->user_login, $user);
    if (empty($q1)) {
        goto cvj;
    }
    update_user_meta($Tw, "\x6d\157\137\163\141\155\x6c\137\x73\x65\163\163\x69\x6f\x6e\137\x69\156\x64\x65\170", $q1);
    cvj:
    if (empty($f1)) {
        goto hxK;
    }
    update_user_meta($Tw, "\x6d\157\137\x73\141\155\154\x5f\x6e\x61\155\x65\x5f\151\x64", $f1);
    hxK:
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto vyd;
    }
    session_start();
    vyd:
    $_SESSION["\155\x6f\137\x73\141\x6d\x6c"]["\x6c\x6f\x67\x67\145\x64\x5f\151\x6e\137\167\x69\164\x68\x5f\151\144\x70"] = TRUE;
    update_user_meta($Tw, "\155\157\x5f\x73\x61\155\x6c\137\x69\144\x70\x5f\154\x6f\147\151\156", "\x74\162\165\x65");
    wp_set_current_user($Tw);
    $yk = false;
    $yk = apply_filters("\x6d\157\x5f\x72\x65\155\x65\x6d\142\x65\162\x5f\x6d\145", $yk);
    wp_set_auth_cookie($Tw, $yk);
    if (!$on) {
        goto w40;
    }
    do_action("\x75\163\145\x72\x5f\162\x65\147\x69\163\x74\x65\x72", $Tw);
    w40:
}
function mo_saml_post_login_redirection($jt, $gu)
{
    $pS = mo_saml_get_redirect_url($jt, $gu);
    wp_redirect($pS);
    exit;
}
function mo_saml_get_redirect_url($jt, $gu)
{
    $x5 = '';
    $A7 = get_site_option("\163\141\x6d\154\137\x73\x73\x6f\x5f\x73\x65\164\164\x69\x6e\x67\163");
    $I7 = get_current_blog_id();
    if (!(empty($A7[$I7]) && !empty($A7["\x44\105\106\x41\125\114\x54"]))) {
        goto zAg;
    }
    $A7[$I7] = $A7["\104\105\x46\101\x55\114\124"];
    zAg:
    $fD = isset($A7[$I7]["\x6d\157\137\163\x61\x6d\x6c\x5f\162\x65\x6c\141\x79\137\x73\164\x61\x74\145"]) ? $A7[$I7]["\x6d\x6f\137\163\141\155\x6c\137\x72\x65\x6c\141\x79\137\x73\164\x61\x74\145"] : '';
    if (!empty($fD)) {
        goto Mmq;
    }
    if (!empty($gu)) {
        goto UpF;
    }
    $x5 = $jt;
    goto Uj8;
    UpF:
    $x5 = $gu;
    Uj8:
    goto DMm;
    Mmq:
    $x5 = $fD;
    DMm:
    return $x5;
}
function check_if_user_allowed_to_login($user, $jt)
{
    $Tw = $user->ID;
    global $wpdb;
    if (get_user_meta($Tw, "\x6d\x6f\137\x73\x61\155\x6c\x5f\x75\163\x65\162\137\x74\171\x70\145", true)) {
        goto wcL;
    }
    if (get_site_option("\x6d\x6f\137\x73\141\x6d\154\137\165\163\x72\x5f\154\x6d\164")) {
        goto k2S;
    }
    update_user_meta($Tw, "\155\x6f\137\163\141\x6d\154\137\165\163\145\162\x5f\164\x79\x70\145", "\x73\163\x6f\x5f\x75\163\145\x72");
    goto ZZW;
    k2S:
    $FE = get_site_option("\x6d\x6f\137\163\x61\155\x6c\137\143\x75\163\x74\x6f\155\x65\x72\x5f\x74\157\153\x65\x6e");
    $JQ = AESEncryption::decrypt_data(get_site_option("\155\157\137\x73\141\155\x6c\x5f\165\x73\162\137\x6c\155\x74"), $FE);
    $FB = "\123\105\x4c\x45\x43\x54\x20\x43\117\125\x4e\124\x28\x2a\x29\x20\106\122\117\115\x20" . $wpdb->prefix . "\165\163\145\x72\x6d\x65\164\141\40\x57\x48\105\x52\x45\40\155\x65\164\x61\137\153\x65\x79\75\47\x6d\157\x5f\x73\x61\155\x6c\137\x75\163\145\162\x5f\x74\x79\160\x65\x27";
    $yx = $wpdb->get_var($FB);
    if ($yx >= $JQ) {
        goto Sxw;
    }
    update_user_meta($Tw, "\x6d\x6f\x5f\x73\141\x6d\x6c\137\x75\163\x65\x72\137\164\x79\x70\145", "\163\163\157\137\x75\163\145\x72");
    goto t40;
    Sxw:
    if (get_site_option("\165\163\145\162\x5f\141\154\145\x72\164\x5f\x65\155\x61\151\154\137\x73\145\x6e\x74")) {
        goto blf;
    }
    $nI = new Customersaml();
    $nI->mo_saml_send_user_exceeded_alert_email($JQ, $this);
    blf:
    if (is_administrator_user($user)) {
        goto kVU;
    }
    wp_redirect($jt);
    exit;
    goto NIf;
    kVU:
    update_user_meta($Tw, "\x6d\157\137\x73\141\155\154\x5f\165\163\145\x72\137\x74\171\160\x65", "\x73\163\x6f\137\165\x73\x65\x72");
    NIf:
    t40:
    ZZW:
    wcL:
}
function check_if_user_allowed_to_login_due_to_role_restriction($YY)
{
    $fn = maybe_unserialize(get_site_option("\x73\x61\x6d\x6c\x5f\141\155\137\x72\x6f\154\145\x5f\x6d\x61\x70\x70\x69\156\147"));
    $qO = Utilities::get_active_sites();
    $j9 = get_site_option("\155\x6f\x5f\x61\160\x70\x6c\171\137\x72\x6f\x6c\x65\x5f\155\x61\160\x70\x69\x6e\x67\x5f\x66\157\x72\137\163\151\x74\145\x73");
    if ($fn) {
        goto J1a;
    }
    $fn = array();
    J1a:
    if (array_key_exists("\104\x45\106\x41\x55\x4c\124", $fn)) {
        goto Y7Z;
    }
    $fn["\104\x45\106\x41\x55\114\124"] = array();
    Y7Z:
    foreach ($qO as $blog_id) {
        if ($j9) {
            goto dYb;
        }
        $zb = $blog_id;
        goto L65;
        dYb:
        $zb = 0;
        L65:
        if (isset($fn[$zb])) {
            goto lKu;
        }
        $so = $fn["\x44\x45\106\x41\125\x4c\x54"];
        goto xsu;
        lKu:
        $so = $fn[$zb];
        xsu:
        if (empty($so)) {
            goto W1j;
        }
        $sq = isset($so["\x6d\x6f\x5f\x73\141\x6d\x6c\137\x64\157\156\164\x5f\x61\x6c\154\157\167\x5f\165\163\x65\162\x5f\x74\x6f\x6c\157\x67\x69\x6e\x5f\x63\x72\145\x61\164\x65\137\x77\151\x74\150\137\147\x69\x76\145\156\137\x67\162\x6f\165\160\x73"]) ? $so["\x6d\x6f\137\163\141\155\154\137\x64\157\156\164\137\141\x6c\x6c\157\x77\x5f\x75\x73\145\162\x5f\x74\x6f\154\x6f\147\151\156\137\143\x72\145\141\x74\145\137\167\x69\164\150\x5f\147\151\x76\x65\x6e\137\x67\162\157\x75\160\x73"] : '';
        if (!($sq == "\143\x68\x65\x63\x6b\145\x64")) {
            goto nhu;
        }
        if (empty($YY)) {
            goto sYB;
        }
        $C0 = $so["\x6d\x6f\x5f\163\x61\155\154\x5f\x72\x65\163\x74\x72\151\143\x74\x5f\x75\x73\145\162\163\x5f\167\151\x74\x68\x5f\147\x72\x6f\165\x70\163"];
        $dv = explode("\x3b", $C0);
        foreach ($dv as $cR) {
            foreach ($YY as $qv) {
                $qv = trim($qv);
                if (!(!empty($qv) && $qv == $cR)) {
                    goto P5a;
                }
                wp_die("\131\157\x75\x20\141\162\x65\40\156\x6f\x74\x20\141\165\164\150\x6f\162\x69\x7a\x65\x64\x20\164\157\40\x6c\157\x67\151\156\x2e\40\x50\x6c\x65\141\x73\145\x20\x63\x6f\x6e\x74\141\143\x74\x20\x79\x6f\x75\162\40\x61\144\x6d\x69\x6e\151\x73\164\162\141\164\157\x72\56", "\105\x72\x72\x6f\162");
                P5a:
                lQc:
            }
            zCn:
            dsU:
        }
        sXB:
        sYB:
        nhu:
        W1j:
        ejJ:
    }
    S1Q:
}
function assign_roles_to_user($user, $fn, $blog_id, $YY, $zb)
{
    $vP = false;
    if (!(!empty($YY) && !empty($fn) && !is_administrator_user($user) && is_user_member_of_blog($user->ID, $blog_id))) {
        goto W0I;
    }
    if (!empty($fn[$zb])) {
        goto WIu;
    }
    if (empty($fn["\x44\x45\106\x41\125\114\x54"])) {
        goto MuA;
    }
    $so = $fn["\104\x45\106\101\125\x4c\x54"];
    MuA:
    goto BYP;
    WIu:
    $so = $fn[$zb];
    BYP:
    if (empty($so)) {
        goto wso;
    }
    $user->set_role(false);
    $nY = '';
    $vg = false;
    unset($so["\144\x65\146\141\x75\x6c\x74\x5f\x72\157\x6c\x65"]);
    unset($so["\144\x6f\156\164\137\143\162\x65\141\164\145\x5f\165\x73\145\162"]);
    unset($so["\x64\x6f\x6e\164\137\141\154\154\157\x77\137\165\156\x6c\151\163\x74\145\144\x5f\x75\163\145\162"]);
    unset($so["\x6b\145\x65\x70\137\x65\170\151\163\164\x69\x6e\x67\x5f\x75\163\x65\162\x73\x5f\162\157\154\x65"]);
    unset($so["\x6d\157\x5f\163\141\155\x6c\x5f\144\x6f\x6e\164\x5f\141\x6c\x6c\157\x77\137\165\163\x65\x72\x5f\164\x6f\x6c\157\x67\151\x6e\137\143\x72\x65\x61\164\x65\137\167\x69\164\150\x5f\x67\x69\166\x65\156\x5f\147\x72\157\165\160\163"]);
    unset($so["\155\x6f\x5f\x73\141\x6d\x6c\x5f\162\x65\x73\164\162\151\143\164\x5f\x75\x73\145\162\x73\x5f\167\151\164\x68\137\x67\162\x6f\165\x70\x73"]);
    foreach ($so as $Fi => $iU) {
        $dv = explode("\73", $iU);
        foreach ($dv as $cR) {
            if (!(!empty($cR) && in_array($cR, $YY))) {
                goto EXh;
            }
            $vP = true;
            $user->add_role($Fi);
            EXh:
            aVr:
        }
        RP2:
        zyM:
    }
    L03:
    wso:
    W0I:
    $Ul = get_site_option("\x6d\x6f\137\163\x61\x6d\x6c\x5f\x73\x75\x70\145\x72\x5f\141\x64\155\151\x6e\x5f\x72\157\154\x65\x5f\x6d\141\160\160\x69\x6e\147");
    $tM = array();
    if (empty($Ul)) {
        goto H9D;
    }
    $tM = explode("\73", $Ul);
    H9D:
    if (!(!empty($YY) && !empty($tM))) {
        goto tox;
    }
    foreach ($tM as $cR) {
        if (!in_array($cR, $YY)) {
            goto Qsi;
        }
        grant_super_admin($user->ID);
        Qsi:
        RLS:
    }
    Y00:
    tox:
    return $vP;
}
function get_saml_roles_to_assign($fn, $blog_id, $YY)
{
    $lp = array();
    if (!(!empty($YY) && !empty($fn))) {
        goto e0T;
    }
    if (!empty($fn[$blog_id])) {
        goto Xwa;
    }
    if (empty($fn["\x44\105\x46\101\125\114\124"])) {
        goto su1;
    }
    $so = $fn["\104\x45\106\101\125\x4c\124"];
    su1:
    goto mQs;
    Xwa:
    $so = $fn[$blog_id];
    mQs:
    if (empty($so)) {
        goto KAD;
    }
    unset($so["\x64\145\x66\x61\165\154\x74\137\162\157\154\145"]);
    unset($so["\144\157\156\164\x5f\x63\x72\x65\x61\164\145\x5f\165\163\x65\x72"]);
    unset($so["\144\x6f\156\x74\137\x61\154\x6c\x6f\x77\137\165\x6e\154\x69\x73\x74\x65\x64\x5f\165\x73\145\162"]);
    unset($so["\x6b\145\x65\x70\137\x65\x78\x69\x73\164\x69\156\x67\x5f\x75\x73\x65\162\x73\137\162\157\x6c\x65"]);
    unset($so["\155\157\x5f\163\x61\x6d\154\x5f\x64\157\x6e\164\x5f\x61\154\154\x6f\x77\137\x75\x73\x65\x72\x5f\164\157\154\157\x67\151\x6e\137\143\x72\x65\141\164\x65\x5f\167\151\164\x68\x5f\147\151\166\x65\156\137\x67\x72\157\165\x70\x73"]);
    unset($so["\155\157\137\163\x61\x6d\x6c\137\162\x65\x73\164\x72\x69\143\164\137\x75\163\x65\x72\163\x5f\167\x69\164\x68\137\147\x72\157\165\160\163"]);
    foreach ($so as $Fi => $iU) {
        $dv = explode("\73", $iU);
        foreach ($dv as $cR) {
            if (!(!empty($cR) and in_array($cR, $YY))) {
                goto jFy;
            }
            array_push($lp, $Fi);
            jFy:
            A9q:
        }
        fYn:
        vZW:
    }
    y7z:
    KAD:
    e0T:
    return $lp;
}
function is_administrator_user($user)
{
    $D9 = $user->roles;
    if (!is_null($D9) && in_array("\x61\144\x6d\151\x6e\x69\163\164\162\141\x74\157\162", $D9)) {
        goto zAr;
    }
    return false;
    goto sO7;
    zAr:
    return true;
    sO7:
}
function mo_saml_is_customer_registered()
{
    return 1;
    $KC = get_site_option("\155\x6f\x5f\163\x61\x6d\x6c\x5f\x61\144\155\151\156\x5f\145\155\x61\x69\x6c");
    $Pd = get_site_option("\155\157\137\x73\141\155\154\137\x61\x64\155\x69\x6e\x5f\x63\x75\163\x74\157\155\145\162\x5f\153\x65\x79");
    if (!$KC || !$Pd || !is_numeric(trim($Pd))) {
        goto KYi;
    }
    return 1;
    goto N7r;
    KYi:
    return 0;
    N7r:
}
function mo_saml_is_customer_license_verified()
{
    $DH = mo_saml_get_plugin_details();
    if ($DH !== true) {
        goto yCs;
    }
    return 1;
    goto Mm5;
    yCs:
    return 0;
    Mm5:
    $FE = get_site_option("\x6d\x6f\x5f\163\141\155\154\137\x63\x75\163\164\157\x6d\x65\x72\137\164\x6f\153\145\x6e");
    $nD = AESEncryption::decrypt_data(get_site_option("\x74\137\x73\151\x74\145\x5f\x73\164\x61\164\165\x73"), $FE);
    $hu = get_site_option("\163\x6d\154\137\x6c\x6b");
    $KC = get_site_option("\x6d\x6f\137\x73\141\155\154\x5f\x61\144\x6d\x69\x6e\x5f\145\155\141\x69\154");
    $Pd = get_site_option("\155\x6f\137\163\141\155\154\137\141\144\155\151\x6e\137\x63\x75\163\x74\x6f\155\x65\162\137\x6b\x65\x79");
    $FF = AESEncryption::decrypt_data(get_site_option("\156\157\137\163\x62\163"), $FE);
    $V1 = false;
    if (!get_site_option("\x6e\157\137\x73\142\x73")) {
        goto xmg;
    }
    $P1 = Utilities::get_sites();
    $V1 = $FF < count($P1);
    xmg:
    if ($nD != "\164\162\165\145" && !$hu || !$KC || !$Pd || !is_numeric(trim($Pd)) || $V1) {
        goto NJm;
    }
    return 1;
    goto G8w;
    NJm:
    return 0;
    G8w:
}
function show_status_error($NV, $gu)
{
    if ($gu == "\164\145\163\164\x56\x61\x6c\x69\x64\x61\164\145" or $gu == "\164\145\x73\164\x4e\x65\167\x43\145\162\x74\x69\x66\x69\x63\141\x74\x65") {
        goto G0s;
    }
    wp_die("\127\x65\x20\x63\157\165\154\x64\x20\x6e\x6f\x74\x20\163\x69\x67\156\x20\171\x6f\165\40\x69\x6e\x2e\40\x50\154\x65\x61\x73\x65\x20\143\x6f\x6e\x74\141\143\x74\x20\171\x6f\165\162\x20\x41\144\x6d\x69\x6e\151\x73\x74\162\141\164\157\162\x2e", "\105\x72\162\x6f\x72\72\x20\111\x6e\x76\x61\154\x69\144\40\123\x41\x4d\114\x20\x52\x65\x73\160\157\x6e\x73\145\40\x53\164\141\164\165\x73");
    goto w6R;
    G0s:
    echo "\74\144\x69\x76\40\163\x74\171\154\x65\75\x22\146\157\156\x74\x2d\x66\141\x6d\x69\154\171\72\x43\141\154\x69\142\162\151\73\160\141\144\x64\x69\x6e\147\72\x30\x20\x33\45\73\x22\76";
    echo "\74\144\x69\x76\40\163\x74\171\154\x65\x3d\42\143\x6f\154\157\x72\x3a\x20\43\x61\x39\64\64\x34\x32\73\x62\x61\x63\153\x67\x72\157\165\x6e\x64\x2d\x63\157\154\157\162\72\x20\43\146\62\144\145\x64\145\x3b\160\141\144\x64\151\x6e\147\72\40\x31\x35\x70\170\x3b\155\141\x72\147\151\x6e\55\x62\x6f\164\x74\157\155\x3a\40\62\60\160\170\73\164\x65\x78\164\55\141\x6c\x69\x67\x6e\x3a\143\x65\156\164\x65\x72\73\142\x6f\162\144\145\162\72\61\x70\x78\x20\x73\157\154\x69\x64\40\43\105\66\x42\63\x42\x32\73\x66\x6f\x6e\164\x2d\x73\151\172\x65\72\61\x38\x70\164\x3b\x22\x3e\x20\105\122\x52\x4f\122\x3c\57\x64\x69\x76\76\xd\xa\x9\11\11\11\11\11\x9\74\x64\x69\166\40\x73\x74\171\x6c\145\75\42\x63\157\x6c\x6f\x72\72\x20\x23\x61\x39\x34\x34\x34\x32\73\x66\x6f\156\164\55\163\151\x7a\x65\72\x31\x34\x70\164\x3b\x20\x6d\141\x72\147\151\156\x2d\142\157\x74\x74\x6f\155\x3a\x32\x30\160\x78\73\42\76\x3c\x70\76\x3c\163\x74\162\157\156\147\x3e\x45\162\x72\157\162\72\40\74\57\163\164\162\x6f\156\147\76\x20\x49\156\166\x61\x6c\151\144\40\x53\x41\115\x4c\x20\x52\145\x73\x70\x6f\156\163\145\40\123\x74\141\164\165\x73\56\74\x2f\x70\x3e\15\12\x9\11\x9\11\x9\11\11\11\x3c\160\x3e\74\x73\x74\x72\x6f\x6e\147\76\103\141\165\x73\x65\163\74\x2f\x73\164\162\157\x6e\x67\76\72\x20\111\144\x65\156\164\151\164\x79\40\120\x72\x6f\166\x69\x64\145\162\40\x68\141\163\40\x73\145\x6e\164\x20\47" . $NV . "\47\40\163\x74\x61\x74\x75\163\40\143\157\x64\145\x20\x69\156\x20\x53\x41\x4d\x4c\40\x52\145\x73\x70\x6f\156\163\145\56\40\74\x2f\x70\x3e\xd\12\11\11\11\x9\11\x9\11\x9\74\160\x3e\74\163\164\162\157\x6e\x67\76\x52\145\x61\163\157\x6e\x3c\57\x73\x74\x72\157\x6e\147\x3e\72\40" . get_status_message($NV) . "\74\57\x70\76\74\142\162\76";
    if (empty($uk)) {
        goto MlU;
    }
    echo "\x3c\x70\76\74\x73\x74\162\157\x6e\x67\76\x53\x74\141\x74\x75\163\x20\x4d\145\x73\163\x61\147\x65\40\151\x6e\x20\x74\150\145\x20\123\x41\x4d\x4c\40\122\x65\x73\160\x6f\x6e\x73\145\x3a\74\x2f\163\x74\x72\x6f\156\147\76\40\x3c\x62\x72\x2f\76" . $uk . "\74\57\x70\76\74\x62\x72\76";
    MlU:
    echo "\15\xa\11\11\x9\11\11\x9\11\x3c\x2f\144\151\x76\x3e\xd\xa\xd\xa\x9\x9\x9\11\11\11\x9\74\x64\x69\x76\x20\163\164\171\x6c\145\75\x22\x6d\x61\x72\x67\151\x6e\x3a\63\x25\x3b\x64\151\x73\160\154\x61\171\72\x62\x6c\x6f\143\153\73\x74\x65\x78\164\x2d\x61\x6c\151\147\x6e\x3a\x63\x65\x6e\x74\x65\x72\73\x22\76\xd\12\x9\x9\x9\x9\11\x9\x9\11\x3c\x64\151\x76\40\163\164\171\x6c\145\75\x22\x6d\x61\162\147\x69\x6e\x3a\x33\45\73\144\151\x73\x70\x6c\141\171\72\142\154\x6f\143\153\x3b\x74\x65\170\164\55\141\154\x69\147\156\72\x63\145\156\164\145\162\x3b\x22\76\74\151\x6e\160\x75\164\x20\x73\x74\171\x6c\145\75\42\160\141\x64\144\x69\x6e\x67\72\x31\x25\x3b\167\151\x64\x74\150\x3a\61\60\60\x70\x78\x3b\142\x61\143\x6b\x67\x72\157\165\156\144\x3a\40\x23\60\x30\x39\x31\x43\x44\40\156\157\x6e\145\40\x72\145\x70\x65\141\164\40\x73\x63\x72\157\x6c\x6c\x20\60\45\40\60\45\73\143\x75\x72\163\157\x72\72\x20\x70\x6f\151\x6e\164\x65\x72\x3b\x66\157\x6e\x74\x2d\163\151\x7a\145\x3a\x31\x35\160\x78\73\x62\x6f\x72\x64\x65\162\55\x77\151\144\164\x68\72\x20\61\x70\170\73\142\157\162\144\x65\162\x2d\x73\x74\171\x6c\145\72\40\x73\x6f\x6c\151\144\x3b\142\157\x72\x64\x65\162\x2d\162\141\144\151\x75\163\x3a\x20\x33\x70\170\73\167\x68\151\x74\x65\55\x73\160\x61\x63\145\72\40\x6e\157\167\162\141\x70\x3b\142\157\170\55\163\x69\x7a\x69\156\147\x3a\x20\x62\x6f\162\x64\145\x72\x2d\x62\157\x78\x3b\142\157\162\144\x65\x72\x2d\143\157\154\157\x72\72\x20\x23\60\x30\67\x33\101\101\73\142\x6f\170\x2d\163\x68\x61\144\157\167\x3a\40\60\x70\170\40\x31\160\x78\x20\60\160\x78\40\x72\147\x62\x61\50\61\x32\60\54\40\62\60\60\54\40\x32\63\x30\54\x20\x30\x2e\x36\x29\40\151\156\163\x65\164\x3b\143\x6f\154\x6f\162\x3a\x20\43\106\106\106\73\x22\x74\171\160\145\x3d\x22\142\x75\x74\164\x6f\156\x22\40\x76\x61\x6c\165\145\75\x22\x44\x6f\156\145\42\x20\x6f\156\103\154\151\x63\x6b\75\42\163\145\154\146\x2e\143\154\157\x73\145\50\x29\73\42\x3e\x3c\57\x64\x69\166\76";
    exit;
    w6R:
}
function addLink($Wu, $ZJ)
{
    $WS = "\74\x61\40\150\162\145\x66\x3d\x22" . $ZJ . "\42\76" . $Wu . "\x3c\57\141\x3e";
    return $WS;
}
function get_status_message($NV)
{
    switch ($NV) {
        case "\122\145\161\165\145\x73\x74\x65\x72":
            return "\124\150\x65\x20\162\x65\x71\x75\x65\163\164\40\143\x6f\x75\x6c\x64\x20\x6e\157\164\40\142\x65\x20\160\145\162\x66\x6f\x72\155\x65\144\x20\144\x75\145\40\x74\157\x20\x61\x6e\40\x65\162\x72\x6f\162\40\x6f\x6e\40\164\150\x65\x20\x70\141\x72\x74\40\x6f\146\x20\164\150\145\x20\x72\x65\x71\x75\x65\163\x74\145\x72\56";
            goto kh4;
        case "\122\145\163\x70\157\156\144\145\162":
            return "\x54\150\x65\x20\162\145\x71\x75\145\x73\164\x20\143\157\165\x6c\144\40\156\157\164\40\x62\145\40\x70\145\162\x66\x6f\162\155\145\x64\40\x64\x75\x65\40\164\x6f\40\141\x6e\40\x65\162\162\x6f\162\40\x6f\156\x20\x74\x68\x65\40\x70\141\162\164\40\x6f\146\40\164\150\x65\40\123\101\x4d\x4c\40\x72\x65\x73\x70\157\x6e\x64\x65\x72\x20\157\x72\40\x53\x41\x4d\x4c\x20\x61\165\x74\150\x6f\x72\x69\164\x79\56";
            goto kh4;
        case "\x56\145\162\x73\x69\157\156\115\x69\x73\x6d\x61\164\143\150":
            return "\124\x68\145\40\123\101\x4d\x4c\40\x72\x65\x73\x70\157\156\144\x65\162\40\x63\x6f\x75\x6c\144\x20\x6e\157\x74\x20\160\x72\157\x63\x65\x73\x73\x20\164\150\145\40\162\145\161\165\145\x73\164\40\142\145\x63\141\165\x73\145\x20\x74\x68\145\40\166\145\162\163\151\x6f\156\40\x6f\x66\40\x74\x68\145\40\162\x65\161\165\145\163\x74\40\155\145\163\x73\141\147\x65\x20\167\141\x73\40\x69\156\143\x6f\x72\162\x65\x63\164\x2e";
            goto kh4;
        default:
            return "\x55\156\153\x6e\157\x77\156";
    }
    Sm3:
    kh4:
}
function saml_get_current_page_url()
{
    $AO = $_SERVER["\x48\x54\124\x50\x5f\x48\117\x53\124"];
    if (!(substr($AO, -1) == "\x2f")) {
        goto HX2;
    }
    $AO = substr($AO, 0, -1);
    HX2:
    $c0 = $_SERVER["\x52\x45\121\125\105\123\x54\137\125\x52\111"];
    if (!(substr($c0, 0, 1) == "\57")) {
        goto aW8;
    }
    $c0 = substr($c0, 1);
    aW8:
    $w0 = isset($_SERVER["\110\124\x54\120\x53"]) && strcasecmp($_SERVER["\x48\124\124\120\x53"], "\157\x6e") == 0;
    $GH = "\150\164\x74\160" . ($w0 ? "\x73" : '') . "\x3a\x2f\x2f" . $AO . "\x2f" . $c0;
    return $GH;
}
function get_network_site_url()
{
    $yO = network_site_url();
    if (!(substr($yO, -1) == "\x2f")) {
        goto HqU;
    }
    $yO = substr($yO, 0, -1);
    HqU:
    return $yO;
}
function get_current_base_url()
{
    return sprintf("\45\x73\x3a\57\x2f\x25\x73\57", isset($_SERVER["\110\x54\124\120\x53"]) && $_SERVER["\x48\124\x54\x50\x53"] != "\157\146\x66" ? "\x68\164\164\160\163" : "\150\x74\164\160", $_SERVER["\x48\124\x54\x50\137\110\x4f\x53\124"]);
}
add_action("\167\x69\144\147\145\164\163\137\151\156\151\164", function () {
    register_widget("\x6d\x6f\x5f\x6c\x6f\147\151\156\137\x77\151\144");
});
add_action("\151\x6e\x69\164", "\155\157\137\x6c\x6f\x67\151\x6e\137\x76\x61\x6c\151\144\x61\164\x65");
