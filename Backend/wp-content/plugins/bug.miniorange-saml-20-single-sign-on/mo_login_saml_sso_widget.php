<?php


include_once dirname(__FILE__) . "\57\125\164\x69\154\x69\164\151\145\163\56\x70\150\160";
include_once dirname(__FILE__) . "\57\x52\x65\x73\160\157\156\x73\x65\x2e\160\x68\x70";
include_once dirname(__FILE__) . "\x2f\114\x6f\147\x6f\165\x74\x52\145\x71\165\145\163\164\x2e\x70\x68\x70";
require_once dirname(__FILE__) . "\x2f\151\156\x63\x6c\165\144\x65\x73\x2f\154\x69\x62\x2f\145\156\143\162\x79\160\x74\151\x6f\156\56\x70\150\160";
include_once "\170\155\154\163\145\x63\x6c\151\142\163\x2e\160\150\x70";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
class mo_login_wid extends WP_Widget
{
    public function __construct()
    {
        $da = get_site_option("\163\141\155\154\x5f\x69\144\145\x6e\x74\x69\164\171\x5f\x6e\x61\x6d\x65");
        parent::__construct("\123\x61\155\154\x5f\x4c\157\x67\x69\x6e\137\x57\151\144\x67\x65\164", "\114\x6f\x67\x69\x6e\x20\167\151\x74\x68\40" . $da, array("\x64\145\x73\x63\162\151\160\x74\x69\x6f\x6e" => __("\124\x68\x69\x73\40\x69\x73\40\x61\x20\x6d\151\156\151\x4f\162\141\x6e\x67\145\x20\123\x41\115\114\40\x6c\157\x67\x69\x6e\x20\167\151\144\147\145\x74\56", "\x6d\157\163\x61\155\x6c")));
    }
    public function widget($Tn, $xJ)
    {
        extract($Tn);
        $xC = apply_filters("\167\x69\144\x67\145\x74\x5f\x74\151\164\154\x65", $xJ["\167\x69\x64\x5f\164\x69\164\154\x65"]);
        echo $Tn["\x62\x65\146\x6f\x72\145\x5f\x77\x69\x64\147\145\164"];
        if (empty($xC)) {
            goto vG;
        }
        echo $Tn["\x62\x65\146\157\x72\x65\x5f\164\151\164\x6c\x65"] . $xC . $Tn["\x61\146\164\x65\162\137\x74\x69\x74\154\145"];
        vG:
        $this->loginForm();
        echo $Tn["\x61\x66\x74\x65\x72\137\x77\151\x64\x67\145\x74"];
    }
    public function update($jK, $Pr)
    {
        $xJ = array();
        $xJ["\x77\x69\x64\137\164\x69\x74\x6c\x65"] = strip_tags($jK["\x77\x69\144\x5f\x74\151\x74\x6c\x65"]);
        return $xJ;
    }
    public function form($xJ)
    {
        $xC = '';
        if (!array_key_exists("\x77\151\144\137\164\x69\164\x6c\x65", $xJ)) {
            goto ao;
        }
        $xC = $xJ["\x77\151\x64\137\164\151\164\x6c\x65"];
        ao:
        echo "\xd\xa\x9\x9\x3c\x70\76\74\154\x61\142\x65\154\x20\x66\157\162\x3d\42" . $this->get_field_id("\167\x69\x64\137\x74\x69\164\x6c\145") . "\x20\x22\76" . _e("\x54\151\164\154\145\x3a") . "\40\x3c\57\154\x61\x62\x65\x6c\76\xd\12\11\11\x9\74\x69\156\160\165\x74\x20\143\x6c\x61\163\163\x3d\42\167\151\144\145\146\141\x74\42\x20\x69\x64\x3d\42" . $this->get_field_id("\x77\151\144\x5f\x74\x69\x74\x6c\145") . "\x22\40\x6e\x61\x6d\x65\75\x22" . $this->get_field_name("\167\x69\x64\x5f\x74\151\x74\x6c\145") . "\x22\40\164\171\x70\145\x3d\x22\x74\x65\170\164\42\x20\166\141\x6c\x75\x65\x3d\x22" . $xC . "\x22\40\57\76\15\12\x9\x9\74\57\x70\x3e";
    }
    public function loginForm()
    {
        global $post;
        $a7 = get_site_option("\x73\141\x6d\x6c\137\x73\163\x6f\137\163\x65\x74\x74\151\156\147\x73");
        $uC = get_current_blog_id();
        $M1 = Utilities::get_active_sites();
        if (in_array($uC, $M1)) {
            goto UV;
        }
        return;
        UV:
        if (!(empty($a7[$uC]) && !empty($a7["\104\105\x46\x41\x55\114\x54"]))) {
            goto LY;
        }
        $a7[$uC] = $a7["\x44\x45\106\x41\x55\114\x54"];
        LY:
        if (!is_user_logged_in()) {
            goto Y6;
        }
        $current_user = wp_get_current_user();
        $mY = "\x48\145\x6c\154\157\54";
        if (empty($a7[$uC]["\155\x6f\137\163\x61\155\154\137\143\165\163\164\157\x6d\x5f\147\162\145\x65\x74\151\156\x67\137\x74\145\170\x74"])) {
            goto MO;
        }
        $mY = $a7[$uC]["\155\x6f\x5f\x73\141\x6d\154\x5f\143\165\x73\164\157\x6d\x5f\147\162\145\x65\x74\151\156\x67\137\x74\145\x78\164"];
        MO:
        $T2 = '';
        if (empty($a7[$uC]["\x6d\x6f\137\163\x61\x6d\x6c\137\147\162\x65\145\164\151\x6e\147\137\156\x61\155\x65"])) {
            goto Y1;
        }
        switch ($a7[$uC]["\x6d\157\137\163\x61\x6d\154\137\147\x72\145\x65\x74\151\x6e\x67\137\156\141\x6d\x65"]) {
            case "\x55\x53\x45\x52\x4e\101\x4d\x45":
                $T2 = $current_user->user_login;
                goto lb;
            case "\x45\115\101\111\114":
                $T2 = $current_user->user_email;
                goto lb;
            case "\x46\x4e\101\115\105":
                $T2 = $current_user->user_firstname;
                goto lb;
            case "\x4c\116\101\115\105":
                $T2 = $current_user->user_lastname;
                goto lb;
            case "\106\x4e\101\x4d\x45\137\x4c\116\101\x4d\105":
                $T2 = $current_user->user_firstname . "\x20" . $current_user->user_lastname;
                goto lb;
            case "\x4c\x4e\x41\115\105\137\106\116\101\x4d\x45":
                $T2 = $current_user->user_lastname . "\x20" . $current_user->user_firstname;
                goto lb;
            default:
                $T2 = $current_user->user_login;
        }
        et:
        lb:
        Y1:
        if (!empty(trim($T2))) {
            goto oU;
        }
        $T2 = $current_user->user_login;
        oU:
        $cb = $mY . "\40" . $T2;
        $ny = "\114\x6f\x67\157\165\164";
        if (empty($a7[$uC]["\155\157\x5f\163\x61\155\154\x5f\x63\x75\x73\164\157\x6d\137\154\157\x67\x6f\165\164\x5f\164\x65\170\164"])) {
            goto wq;
        }
        $ny = $a7[$uC]["\155\x6f\137\x73\x61\155\154\137\x63\x75\163\164\x6f\155\x5f\154\x6f\x67\157\165\164\137\164\145\170\164"];
        wq:
        echo $cb . "\40\174\x20\74\141\x20\x68\x72\x65\x66\75\x22" . wp_logout_url(home_url()) . "\42\40\x74\x69\x74\154\x65\x3d\42\x6c\157\147\x6f\165\164\x22\x20\76" . $ny . "\74\x2f\141\x3e\x3c\57\x6c\x69\x3e";
        goto V8;
        Y6:
        echo "\xd\xa\x9\11\x9\74\163\143\162\x69\x70\164\x3e\xd\xa\x9\11\x9\11\146\165\156\x63\164\151\157\x6e\40\163\165\x62\155\151\164\x53\x61\155\154\106\157\x72\155\50\51\173\x20\x64\x6f\x63\165\x6d\145\156\164\56\147\145\x74\x45\154\145\x6d\145\x6e\x74\102\171\x49\x64\50\x22\154\x6f\147\x69\x6e\x22\x29\x2e\x73\165\142\x6d\x69\164\x28\51\73\x20\175\15\12\x9\11\11\74\x2f\x73\143\x72\x69\x70\164\x3e\xd\xa\x9\x9\11\x3c\146\157\162\x6d\40\x6e\x61\x6d\x65\75\x22\x6c\157\x67\x69\x6e\x22\40\x69\x64\x3d\42\x6c\x6f\x67\x69\156\42\40\155\x65\x74\150\157\144\x3d\x22\x70\157\163\x74\42\40\141\x63\164\x69\157\156\75\42\x22\76\15\xa\11\x9\11\11\x3c\x69\x6e\x70\x75\x74\x20\164\171\160\x65\75\42\150\151\144\144\145\x6e\x22\40\x6e\141\x6d\x65\x3d\x22\x6f\160\x74\151\x6f\156\42\40\166\x61\154\x75\145\75\42\x73\x61\x6d\154\x5f\165\x73\x65\x72\137\154\x6f\x67\151\156\x22\40\57\76\15\xa\15\xa\x9\11\x9\x9\x3c\x66\x6f\156\x74\x20\x73\x69\172\x65\75\x22\x2b\61\x22\x20\163\164\x79\x6c\x65\x3d\42\166\145\x72\x74\151\143\x61\x6c\x2d\141\154\151\147\x6e\x3a\x74\x6f\160\73\x22\76\40\74\x2f\146\x6f\x6e\x74\76";
        $ry = get_site_option("\x73\x61\155\x6c\x5f\x69\144\145\156\164\x69\x74\171\x5f\x6e\x61\155\145");
        $nP = get_site_option("\163\x61\x6d\x6c\x5f\x78\65\60\x39\x5f\143\x65\162\164\151\x66\x69\143\x61\x74\145");
        if (!empty($ry) && !empty($nP)) {
            goto U4;
        }
        echo "\x50\x6c\145\141\163\145\x20\x63\x6f\156\146\151\x67\x75\x72\145\x20\x74\150\145\x20\155\151\x6e\x69\117\162\141\156\147\145\40\123\101\x4d\114\40\x50\x6c\165\147\151\x6e\x20\x66\x69\162\163\x74\x2e";
        goto PA;
        U4:
        $M5 = "\114\x6f\147\x69\x6e\x20\167\x69\164\x68\40\x23\x23\x49\104\x50\x23\x23";
        if (empty($a7[$uC]["\155\157\137\x73\x61\155\154\137\143\165\163\x74\157\x6d\x5f\x6c\x6f\x67\151\156\137\x74\145\170\164"])) {
            goto cT;
        }
        $M5 = $a7[$uC]["\155\157\x5f\163\141\155\154\137\143\x75\163\164\x6f\x6d\137\154\x6f\x67\x69\156\137\x74\x65\170\164"];
        cT:
        $M5 = str_replace("\43\43\111\x44\x50\x23\43", $ry, $M5);
        $MH = false;
        if (!(isset($a7[$uC]["\x6d\x6f\137\163\141\x6d\154\x5f\x75\x73\145\137\142\165\164\164\x6f\156\x5f\141\163\137\x77\151\x64\x67\145\164"]) && $a7[$uC]["\x6d\157\x5f\x73\141\x6d\154\137\x75\163\x65\x5f\x62\165\164\x74\157\156\137\141\163\x5f\167\151\144\147\x65\164"] == "\164\162\165\145")) {
            goto mP;
        }
        $MH = true;
        mP:
        if (!$MH) {
            goto Th;
        }
        $Wz = isset($a7[$uC]["\155\157\x5f\x73\141\x6d\154\x5f\142\x75\x74\x74\x6f\x6e\137\x77\x69\144\x74\x68"]) ? $a7[$uC]["\155\157\x5f\163\x61\155\154\x5f\142\165\164\164\x6f\x6e\x5f\167\x69\x64\164\150"] : "\x31\60\60";
        $fy = isset($a7[$uC]["\x6d\157\137\163\x61\155\154\137\142\x75\164\164\x6f\156\137\x68\x65\151\x67\150\x74"]) ? $a7[$uC]["\x6d\x6f\x5f\x73\x61\x6d\x6c\x5f\142\x75\x74\164\157\x6e\137\150\145\x69\147\x68\164"] : "\65\60";
        $jq = isset($a7[$uC]["\x6d\157\137\x73\141\x6d\x6c\137\x62\x75\x74\164\157\156\x5f\163\x69\x7a\145"]) ? $a7[$uC]["\155\157\137\163\x61\x6d\154\137\x62\165\164\x74\x6f\156\137\x73\x69\172\x65"] : "\65\60";
        $Oh = isset($a7[$uC]["\x6d\x6f\x5f\163\x61\155\154\x5f\x62\x75\x74\164\157\x6e\137\143\x75\162\x76\x65"]) ? $a7[$uC]["\x6d\157\x5f\x73\x61\x6d\x6c\x5f\x62\165\164\x74\157\x6e\137\x63\x75\162\x76\x65"] : "\65";
        $mD = isset($a7[$uC]["\155\x6f\137\163\x61\x6d\154\137\142\165\164\x74\x6f\x6e\137\x63\x6f\154\x6f\162"]) ? $a7[$uC]["\155\x6f\137\163\x61\x6d\154\x5f\142\165\x74\164\x6f\x6e\x5f\x63\157\x6c\x6f\162"] : "\x30\60\x38\x35\x62\141";
        $IL = isset($a7[$uC]["\155\157\x5f\163\x61\x6d\154\137\x62\165\164\164\157\156\x5f\164\x68\145\x6d\145"]) ? $a7[$uC]["\155\157\x5f\163\x61\x6d\x6c\x5f\x62\165\164\x74\x6f\156\x5f\164\x68\x65\155\x65"] : "\154\x6f\x6e\x67\142\x75\x74\x74\157\x6e";
        $Bt = isset($a7[$uC]["\x6d\x6f\137\x73\x61\x6d\x6c\x5f\142\x75\164\x74\x6f\x6e\x5f\164\145\170\164"]) ? $a7[$uC]["\x6d\x6f\x5f\163\x61\155\x6c\137\x62\165\164\x74\157\156\x5f\x74\145\x78\x74"] : (get_site_option("\x73\x61\155\x6c\x5f\151\x64\145\x6e\164\151\x74\x79\x5f\x6e\141\x6d\x65") ? get_site_option("\x73\x61\x6d\x6c\137\151\144\x65\x6e\164\x69\x74\x79\137\156\141\155\145") : "\x4c\157\147\x69\156");
        $xz = isset($a7[$uC]["\155\x6f\137\163\141\155\154\x5f\146\x6f\x6e\164\x5f\x63\157\154\x6f\x72"]) ? $a7[$uC]["\155\157\x5f\x73\x61\155\x6c\x5f\146\157\156\164\137\x63\157\x6c\x6f\x72"] : "\x66\146\146\x66\146\x66";
        $oZ = isset($a7[$uC]["\155\157\x5f\x73\x61\x6d\x6c\137\146\157\156\164\137\163\x69\172\145"]) ? $a7[$uC]["\155\157\x5f\163\x61\155\x6c\x5f\x66\x6f\x6e\164\137\163\151\172\145"] : "\x32\x30";
        $Lp = isset($a7[$uC]["\163\x73\x6f\x5f\142\x75\x74\164\157\x6e\x5f\x6c\157\x67\x69\x6e\137\x66\x6f\162\155\x5f\x70\157\163\151\x74\x69\157\156"]) ? $a7[$uC]["\x73\163\157\x5f\x62\165\x74\x74\157\156\137\154\x6f\147\x69\156\x5f\146\157\x72\155\137\160\157\x73\151\x74\151\157\156"] : "\141\x62\x6f\x76\145";
        $M5 = "\74\x69\156\x70\165\x74\40\164\x79\x70\x65\75\x22\142\x75\164\164\x6f\x6e\x22\40\156\141\155\145\75\x22\155\157\x5f\x73\x61\x6d\x6c\x5f\x77\x70\137\x73\x73\157\137\142\165\164\x74\x6f\x6e\42\40\166\141\x6c\x75\x65\75\x22" . $Bt . "\42\40\163\x74\171\154\x65\75\42";
        $dH = '';
        if ($IL == "\154\157\156\x67\142\x75\164\x74\x6f\x6e") {
            goto iw;
        }
        if ($IL == "\143\151\x72\143\154\145") {
            goto im;
        }
        if ($IL == "\x6f\166\x61\154") {
            goto Ep;
        }
        if ($IL == "\163\161\x75\141\x72\145") {
            goto VV;
        }
        goto Nc;
        im:
        $dH = $dH . "\167\151\x64\x74\150\72" . $jq . "\x70\x78\73";
        $dH = $dH . "\x68\145\151\147\150\x74\72" . $jq . "\x70\x78\73";
        $dH = $dH . "\x62\157\162\x64\145\x72\x2d\162\x61\x64\151\x75\163\72\71\71\x39\160\x78\73";
        goto Nc;
        Ep:
        $dH = $dH . "\x77\151\x64\164\x68\x3a" . $jq . "\x70\170\73";
        $dH = $dH . "\150\x65\151\147\x68\164\x3a" . $jq . "\x70\170\73";
        $dH = $dH . "\x62\157\x72\144\x65\x72\55\x72\x61\x64\151\165\x73\x3a\x35\160\170\73";
        goto Nc;
        VV:
        $dH = $dH . "\x77\151\144\x74\x68\x3a" . $jq . "\160\x78\x3b";
        $dH = $dH . "\150\x65\151\x67\x68\x74\x3a" . $jq . "\160\x78\x3b";
        $dH = $dH . "\x62\x6f\x72\x64\x65\162\55\x72\x61\144\151\x75\x73\x3a\60\160\170\x3b";
        Nc:
        goto n0;
        iw:
        $dH = $dH . "\x77\151\x64\x74\150\x3a" . $Wz . "\160\x78\73";
        $dH = $dH . "\150\145\x69\147\150\x74\x3a" . $fy . "\160\x78\73";
        $dH = $dH . "\x62\157\x72\x64\x65\x72\55\162\141\144\x69\165\163\x3a" . $Oh . "\160\170\x3b";
        n0:
        $dH = $dH . "\x62\141\143\x6b\147\x72\157\165\156\x64\x2d\143\x6f\154\157\162\x3a\43" . $mD . "\x3b";
        $dH = $dH . "\142\157\x72\x64\x65\162\x2d\x63\x6f\x6c\x6f\162\x3a\x74\x72\x61\x6e\163\160\x61\x72\145\156\164\x3b";
        $dH = $dH . "\143\157\x6c\157\x72\72\x23" . $xz . "\x3b";
        $dH = $dH . "\146\x6f\156\x74\x2d\163\151\x7a\x65\x3a" . $oZ . "\160\x78\73";
        $dH = $dH . "\x70\141\144\144\x69\156\x67\x3a\60\x70\170\x3b";
        $M5 = $M5 . $dH . "\42\57\76";
        Th:
        echo "\40\74\x61\x20\150\162\145\146\x3d\42\x23\42\x20\x6f\x6e\103\154\151\143\153\75\x22\163\x75\x62\155\151\164\x53\141\x6d\154\106\x6f\162\x6d\50\51\42\76";
        echo $M5;
        echo "\74\57\x61\x3e\74\57\146\157\x72\x6d\x3e\x20";
        PA:
        if ($this->mo_saml_check_empty_or_null_val(get_site_option("\x6d\157\137\163\141\155\154\x5f\162\x65\x64\151\162\145\143\x74\137\x65\162\x72\157\x72\137\x63\x6f\x64\145"))) {
            goto zb;
        }
        echo "\x3c\144\x69\166\x3e\x3c\57\144\151\166\x3e\x3c\144\x69\x76\40\164\151\164\x6c\145\75\42\x4c\x6f\147\x69\x6e\40\105\162\162\157\162\x22\76\74\x66\x6f\x6e\x74\40\x63\157\x6c\x6f\x72\x3d\42\162\145\144\42\x3e\x57\145\40\x63\x6f\165\154\x64\40\x6e\x6f\x74\x20\163\x69\147\156\x20\171\x6f\x75\x20\x69\156\x2e\40\x50\154\x65\x61\163\145\x20\143\157\156\x74\141\143\164\40\x79\x6f\165\162\x20\x41\144\x6d\151\156\x69\x73\x74\162\x61\x74\157\x72\56\74\57\146\x6f\x6e\164\x3e\x3c\x2f\x64\x69\166\76";
        delete_site_option("\155\x6f\137\163\x61\155\x6c\137\x72\x65\x64\x69\x72\x65\x63\164\137\145\162\162\157\162\137\143\x6f\x64\145");
        delete_site_option("\x6d\x6f\x5f\163\x61\155\154\137\162\x65\144\x69\x72\145\143\x74\x5f\145\x72\162\x6f\x72\x5f\x72\145\x61\x73\157\x6e");
        zb:
        echo "\x3c\141\40\150\x72\145\x66\x3d\42\150\x74\164\x70\72\57\x2f\155\151\156\151\157\162\x61\156\x67\145\x2e\143\157\x6d\57\167\x6f\x72\144\x70\x72\145\x73\x73\55\154\x64\141\160\x2d\154\x6f\x67\x69\156\42\x20\163\164\171\x6c\145\x3d\42\x64\x69\x73\160\154\141\x79\x3a\156\x6f\x6e\x65\x22\x3e\x4c\x6f\147\x69\156\x20\x74\157\40\127\157\x72\x64\120\x72\x65\163\x73\x20\x75\x73\151\156\x67\40\114\x44\x41\120\74\x2f\x61\76\15\xa\x9\11\11\11\74\141\x20\150\162\x65\146\75\x22\150\164\x74\x70\x3a\57\x2f\155\x69\x6e\151\157\162\x61\156\147\145\56\143\157\155\57\x63\154\x6f\165\144\55\x69\x64\145\x6e\164\151\164\171\x2d\142\162\x6f\x6b\145\x72\55\163\145\x72\x76\x69\x63\145\42\40\163\164\171\154\145\75\42\x64\x69\163\160\x6c\141\171\x3a\x6e\x6f\x6e\145\x22\76\x43\154\x6f\x75\x64\x20\x49\144\x65\x6e\x74\151\164\x79\x20\x62\x72\x6f\153\145\x72\x20\x73\145\162\166\151\x63\x65\x3c\x2f\x61\x3e\xd\xa\x9\x9\11\x9\74\x61\40\x68\162\x65\146\x3d\42\x68\164\x74\160\72\x2f\x2f\155\x69\156\151\157\x72\141\156\147\x65\56\143\157\155\57\163\164\x72\x6f\x6e\x67\x5f\141\x75\164\150\x22\40\x73\x74\171\154\x65\x3d\42\144\151\163\160\154\x61\x79\72\x6e\x6f\156\145\x3b\x22\x3e\x3c\x2f\x61\x3e\15\12\x9\x9\x9\11\74\141\40\150\162\145\146\75\42\150\164\x74\160\x3a\x2f\x2f\x6d\x69\x6e\151\157\x72\x61\x6e\147\145\56\x63\157\155\x2f\x73\x69\x6e\147\154\145\x2d\163\151\147\156\x2d\x6f\x6e\x2d\x73\163\x6f\x22\x20\163\164\x79\x6c\145\x3d\x22\144\x69\163\x70\x6c\141\x79\x3a\x6e\157\x6e\145\x3b\42\x3e\74\x2f\x61\x3e\15\xa\x9\x9\x9\x9\74\x61\40\150\x72\145\x66\75\x22\x68\164\164\x70\72\57\57\x6d\151\x6e\151\157\x72\141\x6e\147\x65\x2e\143\x6f\155\x2f\146\162\x61\x75\x64\x22\40\163\164\x79\154\145\x3d\x22\144\151\x73\x70\x6c\141\171\x3a\156\157\x6e\145\x3b\42\76\x3c\57\x61\76\15\xa\15\xa\11\x9\x9\x3c\57\165\x6c\76\15\xa\11\x9\74\57\146\x6f\162\155\x3e";
        V8:
    }
    public function mo_saml_check_empty_or_null_val($T5)
    {
        if (!(!isset($T5) || empty($T5))) {
            goto CF;
        }
        return true;
        CF:
        return false;
    }
    function mo_saml_logout($QK)
    {
        $user = get_user_by("\x69\x64", $QK);
        $As = get_site_option("\x73\141\x6d\154\137\154\157\x67\x6f\165\164\137\165\162\x6c");
        $T8 = get_site_option("\163\141\x6d\x6c\x5f\154\157\x67\x6f\165\x74\x5f\142\151\x6e\x64\151\x6e\x67\x5f\164\x79\x70\x65");
        $current_user = $user;
        $ic = get_user_meta($current_user->ID, "\x6d\157\137\163\x61\155\x6c\x5f\151\144\x70\x5f\x6c\x6f\x67\151\156");
        $ic = isset($ic[0]) ? $ic[0] : '';
        $fq = wp_get_referer();
        if (!empty($fq)) {
            goto WE;
        }
        $fq = !empty(get_site_option("\x6d\157\137\163\141\x6d\x6c\x5f\x73\160\x5f\142\141\x73\x65\137\165\x72\x6c")) ? get_site_option("\155\157\x5f\x73\x61\x6d\x6c\137\163\x70\x5f\142\141\x73\x65\x5f\165\x72\x6c") : get_network_site_url();
        WE:
        if (empty($As)) {
            goto T2i;
        }
        if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
            goto iq;
        }
        session_start();
        iq:
        if (isset($_SESSION["\x6d\x6f\x5f\163\141\x6d\154\137\154\157\x67\157\x75\x74\x5f\x72\x65\x71\x75\x65\163\x74"])) {
            goto WdM;
        }
        if ($ic == "\164\162\x75\x65") {
            goto Rgt;
        }
        goto ag6;
        WdM:
        self::createLogoutResponseAndRedirect($As, $T8);
        exit;
        goto ag6;
        Rgt:
        delete_user_meta($current_user->ID, "\x6d\157\137\163\141\155\154\x5f\151\x64\160\137\154\157\147\151\156");
        $k9 = get_user_meta($current_user->ID, "\155\157\137\163\141\155\x6c\x5f\156\141\155\x65\x5f\151\144");
        $ri = get_user_meta($current_user->ID, "\155\x6f\x5f\x73\x61\x6d\x6c\137\163\145\163\x73\151\x6f\x6e\137\151\156\x64\145\x78");
        mo_saml_create_logout_request($k9, $ri, $As, $T8, $fq);
        ag6:
        T2i:
        wp_redirect($fq);
        exit;
    }
    function createLogoutResponseAndRedirect($As, $T8)
    {
        $QU = get_site_option("\x6d\157\x5f\163\x61\155\x6c\x5f\163\x70\137\142\x61\163\145\137\165\x72\154");
        if (!empty($QU)) {
            goto CvQ;
        }
        $QU = get_network_site_url();
        CvQ:
        $S4 = $_SESSION["\x6d\x6f\137\163\x61\x6d\x6c\137\x6c\x6f\147\x6f\165\164\x5f\162\145\161\x75\145\x73\164"];
        $WN = $_SESSION["\155\x6f\x5f\x73\141\x6d\x6c\137\154\x6f\x67\x6f\165\164\137\x72\x65\x6c\141\171\x5f\x73\x74\141\x74\x65"];
        unset($_SESSION["\x6d\x6f\137\163\141\155\x6c\137\154\x6f\147\x6f\165\164\137\x72\x65\161\x75\145\163\x74"]);
        unset($_SESSION["\155\x6f\x5f\163\x61\x6d\x6c\x5f\154\157\147\157\165\x74\137\162\x65\x6c\141\171\x5f\163\x74\141\x74\x65"]);
        $x4 = new DOMDocument();
        $x4->loadXML($S4);
        $S4 = $x4->firstChild;
        if (!($S4->localName == "\x4c\x6f\147\157\165\x74\x52\x65\x71\165\145\x73\164")) {
            goto F5_;
        }
        $mN = new SAML2_LogoutRequest($S4);
        $xo = get_site_option("\155\157\137\x73\141\x6d\154\137\163\x70\137\x65\x6e\164\x69\x74\x79\x5f\151\x64");
        if (!empty($xo)) {
            goto BoJ;
        }
        $xo = $QU . "\57\167\x70\x2d\143\x6f\x6e\x74\145\156\x74\x2f\x70\154\x75\147\151\156\163\x2f\x6d\x69\x6e\x69\157\162\141\156\147\x65\55\x73\x61\x6d\x6c\x2d\62\x30\55\163\x69\156\147\x6c\x65\x2d\163\151\x67\x6e\x2d\157\x6e\x2f";
        BoJ:
        $c9 = $As;
        $N8 = Utilities::createLogoutResponse($mN->getId(), $xo, $c9, $T8);
        if (empty($T8) || $T8 == "\110\164\x74\160\122\145\x64\x69\x72\x65\143\x74") {
            goto cT5;
        }
        if (!(get_site_option("\163\141\155\154\x5f\x72\145\161\165\145\x73\164\137\x73\151\x67\156\x65\144") == "\x75\156\x63\150\145\143\x6b\145\144")) {
            goto Mw2;
        }
        $zv = base64_encode($N8);
        Utilities::postSAMLResponse($As, $zv, $WN);
        exit;
        Mw2:
        $pr = '';
        $MG = '';
        $zv = Utilities::signXML($N8, "\123\x74\x61\x74\165\163");
        Utilities::postSAMLResponse($As, $zv, $WN);
        goto G9K;
        cT5:
        $af = $As;
        if (strpos($As, "\x3f") !== false) {
            goto JP2;
        }
        $af .= "\x3f";
        goto OTz;
        JP2:
        $af .= "\46";
        OTz:
        if (!(get_site_option("\163\141\155\x6c\137\162\x65\161\x75\x65\163\164\137\x73\151\x67\156\x65\x64") == "\165\156\143\150\x65\143\x6b\145\144")) {
            goto WKt;
        }
        $af .= "\123\101\115\114\x52\145\163\160\157\x6e\163\145\75" . $N8 . "\x26\x52\145\x6c\141\x79\x53\x74\x61\164\145\x3d" . urlencode($WN);
        header("\114\x6f\x63\141\x74\151\x6f\156\72\40" . $af);
        exit;
        WKt:
        $af .= "\x53\101\115\114\122\145\163\160\x6f\156\163\x65\75" . $N8 . "\46\x52\x65\x6c\141\x79\123\x74\141\164\145\75" . urlencode($WN);
        header("\x4c\157\x63\x61\164\x69\157\156\72\x20" . $af);
        exit;
        G9K:
        F5_:
    }
}
function mo_saml_create_logout_request($k9, $ri, $As, $T8, $fq)
{
    $QU = get_site_option("\x6d\157\137\x73\x61\x6d\154\x5f\163\160\x5f\142\141\163\145\x5f\x75\162\x6c");
    if (!empty($QU)) {
        goto pSS;
    }
    $QU = get_network_site_url();
    pSS:
    $xo = get_site_option("\155\157\137\163\x61\155\154\137\163\160\137\x65\x6e\164\x69\164\x79\x5f\151\144");
    if (!empty($xo)) {
        goto VAM;
    }
    $xo = $QU . "\x2f\x77\x70\x2d\143\x6f\156\x74\x65\x6e\x74\x2f\160\x6c\x75\147\151\156\163\57\155\x69\x6e\x69\x6f\x72\141\x6e\x67\x65\x2d\x73\141\155\x6c\55\62\60\55\x73\151\156\147\x6c\x65\55\x73\151\147\156\55\x6f\156\x2f";
    VAM:
    $c9 = $As;
    $NE = $fq;
    if (!empty($NE)) {
        goto mSJ;
    }
    $NE = saml_get_current_page_url();
    if (!strpos($NE, "\77")) {
        goto VJK;
    }
    $NE = get_network_site_url();
    VJK:
    mSJ:
    $NE = mo_saml_relaystate_url($NE);
    $Td = Utilities::createLogoutRequest($k9, $xo, $c9, $ri, $T8);
    if (empty($T8) || $T8 == "\x48\x74\164\x70\122\x65\144\151\x72\x65\x63\164") {
        goto hha;
    }
    if (!(get_site_option("\x73\x61\155\154\x5f\x72\x65\161\x75\x65\x73\x74\x5f\163\x69\x67\x6e\x65\144") == "\165\x6e\x63\150\x65\x63\153\x65\144")) {
        goto i2N;
    }
    $zv = base64_encode($Td);
    Utilities::postSAMLRequest($As, $zv, $NE);
    exit;
    i2N:
    $pr = '';
    $MG = '';
    $zv = Utilities::signXML($Td, "\116\141\155\x65\x49\x44\120\x6f\x6c\x69\143\x79");
    Utilities::postSAMLRequest($As, $zv, $NE);
    goto OZq;
    hha:
    $af = $As;
    if (strpos($As, "\77") !== false) {
        goto gKC;
    }
    $af .= "\77";
    goto IEX;
    gKC:
    $af .= "\x26";
    IEX:
    if (!(get_site_option("\163\x61\x6d\x6c\137\162\145\161\165\145\x73\x74\137\x73\x69\147\x6e\145\x64") == "\165\156\x63\x68\145\x63\x6b\145\x64")) {
        goto aUY;
    }
    $af .= "\123\101\115\114\122\145\x71\165\145\163\x74\75" . $Td . "\x26\x52\x65\x6c\141\x79\x53\x74\141\164\x65\75" . urlencode($NE);
    header("\x4c\x6f\143\x61\x74\151\x6f\x6e\72\40" . $af);
    exit;
    aUY:
    $Td = "\x53\x41\x4d\114\122\x65\161\165\x65\163\x74\x3d" . $Td . "\46\122\x65\154\x61\x79\123\164\141\x74\145\75" . urlencode($NE) . "\46\123\x69\x67\101\x6c\x67\75" . urlencode(XMLSecurityKey::RSA_SHA256);
    $N7 = array("\x74\171\160\145" => "\x70\x72\x69\x76\141\x74\x65");
    $ez = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $N7);
    $Ow = get_site_option("\155\x6f\137\x73\x61\x6d\154\x5f\x63\165\x72\x72\x65\x6e\164\137\x63\145\162\x74\137\160\x72\151\x76\141\164\x65\137\153\145\x79");
    $ez->loadKey($Ow, FALSE);
    $ew = new XMLSecurityDSig();
    $AF = $ez->signData($Td);
    $AF = base64_encode($AF);
    $af .= $Td . "\x26\123\151\x67\x6e\141\164\x75\x72\x65\75" . urlencode($AF);
    header("\x4c\157\x63\141\x74\151\x6f\156\x3a" . $af);
    exit;
    OZq:
}
function mo_login_validate()
{
    if (!(isset($_REQUEST["\x6f\160\x74\151\157\x6e"]) && $_REQUEST["\157\160\x74\151\x6f\x6e"] == "\x6d\x6f\163\141\155\x6c\x5f\155\145\x74\141\x64\141\x74\141")) {
        goto n77;
    }
    miniorange_generate_metadata();
    n77:
    if (!mo_saml_is_customer_license_verified()) {
        goto xfx;
    }
    if (!(isset($_REQUEST["\x6f\x70\164\x69\157\x6e"]) && $_REQUEST["\x6f\x70\x74\151\157\156"] == "\x73\141\x6d\154\137\165\x73\x65\x72\x5f\x6c\x6f\147\x69\156" || isset($_REQUEST["\157\x70\164\151\x6f\156"]) && $_REQUEST["\x6f\x70\164\151\157\x6e"] == "\164\145\x73\164\103\157\156\146\x69\147" || isset($_REQUEST["\157\x70\x74\151\157\x6e"]) && $_REQUEST["\x6f\x70\164\151\x6f\x6e"] == "\x67\145\164\x73\x61\x6d\154\162\145\x71\165\145\x73\x74" || isset($_REQUEST["\157\x70\x74\151\157\x6e"]) && $_REQUEST["\157\x70\164\x69\x6f\156"] == "\x67\145\164\x73\141\x6d\x6c\162\145\x73\160\x6f\x6e\163\145")) {
        goto jmJ;
    }
    if (mo_saml_is_sp_configured()) {
        goto EaN;
    }
    if (!is_user_logged_in()) {
        goto QpY;
    }
    if (!isset($_REQUEST["\x72\145\x64\x69\162\145\143\x74\137\164\157"])) {
        goto lUQ;
    }
    $Mk = htmlspecialchars($_REQUEST["\162\x65\x64\151\x72\x65\143\x74\137\x74\157"]);
    header("\114\x6f\x63\x61\164\151\157\156\72\x20" . $Mk);
    exit;
    lUQ:
    QpY:
    goto I8d;
    EaN:
    if (!(is_user_logged_in() and $_REQUEST["\157\x70\164\x69\x6f\x6e"] == "\x73\141\155\154\137\165\163\145\x72\x5f\x6c\157\147\151\x6e")) {
        goto PoO;
    }
    if (!isset($_REQUEST["\x72\145\144\x69\x72\x65\143\164\x5f\164\x6f"])) {
        goto KGL;
    }
    $Mk = htmlspecialchars($_REQUEST["\162\145\144\151\162\145\x63\164\137\164\x6f"]);
    header("\114\x6f\x63\141\164\x69\x6f\x6e\x3a\x20" . $Mk);
    exit;
    KGL:
    return;
    PoO:
    $QU = get_site_option("\155\157\x5f\x73\x61\155\x6c\137\x73\x70\137\x62\x61\x73\x65\x5f\x75\x72\154");
    if (!empty($QU)) {
        goto j3y;
    }
    $QU = get_network_site_url();
    j3y:
    $a7 = get_site_option("\x73\x61\x6d\154\x5f\x73\x73\157\x5f\x73\145\x74\164\x69\x6e\x67\x73");
    $uC = get_current_blog_id();
    $M1 = Utilities::get_active_sites();
    if (in_array($uC, $M1)) {
        goto iM_;
    }
    return;
    iM_:
    if (!(empty($a7[$uC]) && !empty($a7["\104\105\106\x41\125\114\x54"]))) {
        goto QT0;
    }
    $a7[$uC] = $a7["\104\x45\x46\101\x55\x4c\124"];
    QT0:
    if ($_REQUEST["\157\160\x74\x69\x6f\x6e"] == "\164\145\x73\164\103\x6f\x6e\146\151\x67" and array_key_exists("\x6e\145\167\143\x65\x72\164", $_REQUEST)) {
        goto Rqt;
    }
    if ($_REQUEST["\157\x70\164\x69\157\x6e"] == "\164\145\x73\x74\103\157\156\x66\151\147") {
        goto CP_;
    }
    if ($_REQUEST["\157\160\164\151\x6f\156"] == "\147\145\164\163\x61\x6d\x6c\162\x65\x71\x75\x65\x73\x74") {
        goto Z6u;
    }
    if ($_REQUEST["\x6f\x70\164\151\157\x6e"] == "\147\145\164\x73\141\155\x6c\x72\x65\163\160\157\x6e\163\x65") {
        goto guk;
    }
    if (!empty($a7[$uC]["\x6d\x6f\x5f\x73\141\x6d\x6c\137\x72\x65\x6c\x61\x79\x5f\163\x74\141\164\x65"])) {
        goto xvz;
    }
    if (isset($_REQUEST["\162\x65\144\x69\162\145\x63\x74\x5f\164\157"])) {
        goto Wrw;
    }
    $NE = saml_get_current_page_url();
    goto fcH;
    Wrw:
    $NE = $_REQUEST["\x72\x65\x64\x69\162\145\143\164\137\x74\157"];
    fcH:
    goto pOg;
    xvz:
    $NE = $a7[$uC]["\x6d\157\137\163\141\155\154\137\162\145\154\x61\171\137\163\x74\x61\164\145"];
    pOg:
    goto cWI;
    guk:
    $NE = "\x64\151\163\160\154\x61\x79\x53\x41\115\x4c\x52\145\x73\x70\157\x6e\x73\145";
    cWI:
    goto UOx;
    Z6u:
    $NE = "\144\151\163\160\154\x61\x79\123\101\x4d\114\x52\x65\x71\165\145\x73\164";
    UOx:
    goto CPd;
    CP_:
    $NE = "\x74\x65\163\164\126\141\154\151\144\x61\164\x65";
    CPd:
    goto LO5;
    Rqt:
    $NE = "\x74\145\163\164\x4e\x65\167\103\x65\x72\164\x69\x66\151\143\x61\x74\145";
    LO5:
    $Kg = get_site_option("\x73\x61\155\x6c\x5f\154\157\147\x69\x6e\x5f\165\162\x6c");
    $FY = !empty(get_site_option("\x73\x61\155\x6c\x5f\x6c\x6f\147\151\156\137\142\x69\x6e\x64\x69\156\x67\137\x74\171\x70\x65")) ? get_site_option("\163\141\155\154\137\154\x6f\x67\151\156\x5f\142\x69\x6e\144\151\156\147\137\x74\x79\x70\145") : "\110\x74\164\160\120\x6f\163\x74";
    $a7 = get_site_option("\x73\x61\x6d\x6c\x5f\x73\x73\x6f\x5f\163\x65\164\164\x69\156\x67\x73");
    $uC = get_current_blog_id();
    $M1 = Utilities::get_active_sites();
    if (in_array($uC, $M1)) {
        goto Mr_;
    }
    return;
    Mr_:
    if (!(empty($a7[$uC]) && !empty($a7["\x44\105\106\101\125\x4c\x54"]))) {
        goto vhw;
    }
    $a7[$uC] = $a7["\104\x45\106\101\x55\x4c\x54"];
    vhw:
    $r9 = isset($a7[$uC]["\155\157\x5f\163\141\155\x6c\137\146\157\162\x63\145\x5f\x61\165\x74\x68\x65\156\164\x69\x63\141\x74\x69\157\x6e"]) ? $a7[$uC]["\x6d\157\x5f\x73\141\x6d\x6c\137\146\157\x72\143\x65\x5f\141\165\x74\150\x65\156\x74\x69\143\141\164\x69\x6f\x6e"] : '';
    $T1 = $QU . "\x2f";
    $xo = get_site_option("\x6d\x6f\x5f\163\141\155\154\x5f\163\x70\x5f\x65\x6e\x74\151\164\171\x5f\x69\144");
    $zD = get_site_option("\x73\x61\x6d\154\137\156\141\155\x65\x69\144\x5f\146\157\x72\x6d\x61\164");
    if (!empty($zD)) {
        goto OJ7;
    }
    $zD = "\x31\x2e\x31\72\156\141\155\145\x69\x64\55\x66\157\x72\155\141\x74\x3a\x75\x6e\x73\x70\145\143\151\146\x69\x65\x64";
    OJ7:
    if (!empty($xo)) {
        goto by9;
    }
    $xo = $QU . "\57\167\x70\55\143\157\x6e\164\x65\156\x74\57\x70\154\165\147\151\156\163\57\155\x69\x6e\151\x6f\162\x61\x6e\x67\x65\55\x73\141\x6d\x6c\55\x32\x30\x2d\x73\x69\156\147\154\x65\55\x73\151\x67\x6e\55\157\x6e\57";
    by9:
    $Td = Utilities::createAuthnRequest($T1, $xo, $Kg, $r9, $FY, $zD);
    if (!($NE == "\x64\x69\x73\x70\x6c\141\171\x53\x41\x4d\114\122\145\x71\x75\x65\163\164")) {
        goto BHD;
    }
    mo_saml_show_SAML_log(Utilities::createAuthnRequest($T1, $xo, $Kg, $r9, "\110\164\164\x70\120\x6f\163\164", $zD), $NE);
    BHD:
    $af = htmlspecialchars_decode($Kg);
    if (strpos($Kg, "\x3f") !== false) {
        goto rmD;
    }
    $af .= "\77";
    goto dR_;
    rmD:
    $af .= "\46";
    dR_:
    $NE = mo_saml_relaystate_url($NE);
    if ($FY == "\x48\164\x74\x70\122\x65\144\151\x72\x65\143\x74") {
        goto lto;
    }
    if (!(get_site_option("\x73\x61\155\x6c\137\x72\145\x71\x75\x65\163\164\137\x73\x69\x67\156\x65\x64") == "\165\x6e\143\x68\145\x63\x6b\145\x64")) {
        goto Grs;
    }
    $zv = base64_encode($Td);
    Utilities::postSAMLRequest($Kg, $zv, $NE);
    exit;
    Grs:
    $pr = '';
    $MG = '';
    if ($_REQUEST["\x6f\x70\x74\x69\157\156"] == "\x74\145\163\x74\x43\157\x6e\146\x69\147" && array_key_exists("\156\145\x77\143\145\x72\x74", $_REQUEST)) {
        goto q2a;
    }
    $zv = Utilities::signXML($Td, "\116\x61\x6d\x65\111\x44\x50\x6f\154\151\143\x79");
    goto rHO;
    q2a:
    $zv = Utilities::signXML($Td, "\116\141\x6d\x65\x49\104\120\157\x6c\x69\x63\x79", true);
    rHO:
    Utilities::postSAMLRequest($Kg, $zv, $NE);
    update_site_option("\x6d\x6f\137\163\141\155\x6c\x5f\x6e\x65\x77\x5f\143\145\x72\x74\x5f\164\x65\x73\x74", true);
    goto Lno;
    lto:
    if (!(get_site_option("\163\141\x6d\x6c\x5f\x72\145\161\165\x65\163\x74\x5f\163\x69\x67\x6e\x65\144") == "\x75\x6e\x63\x68\145\143\x6b\x65\144")) {
        goto znb;
    }
    $af .= "\x53\x41\x4d\114\x52\145\x71\165\145\163\164\75" . $Td . "\x26\x52\x65\x6c\141\171\x53\164\x61\164\145\75" . urlencode($NE);
    header("\114\x6f\143\x61\x74\151\x6f\156\72\40" . $af);
    exit;
    znb:
    $Td = "\123\x41\x4d\x4c\122\145\x71\x75\145\x73\164\75" . $Td . "\x26\122\145\154\x61\x79\x53\x74\x61\164\145\75" . urlencode($NE) . "\x26\x53\151\x67\101\154\147\75" . urlencode(XMLSecurityKey::RSA_SHA256);
    $N7 = array("\x74\x79\x70\145" => "\160\x72\x69\x76\141\164\x65");
    $ez = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $N7);
    if ($_REQUEST["\157\160\x74\151\157\x6e"] == "\164\x65\163\164\103\157\x6e\x66\151\147" && array_key_exists("\x6e\145\167\x63\x65\x72\164", $_REQUEST)) {
        goto rIj;
    }
    $Ow = get_site_option("\155\x6f\x5f\x73\141\x6d\x6c\137\143\165\x72\162\x65\x6e\x74\x5f\x63\x65\162\x74\137\x70\162\x69\x76\141\x74\145\x5f\153\x65\171");
    goto la0;
    rIj:
    $Ow = file_get_contents(plugin_dir_path(__FILE__) . "\x72\x65\x73\x6f\x75\x72\x63\x65\x73" . DIRECTORY_SEPARATOR . mo_options_enum_default_sp_certificate::SP_Private_Key);
    la0:
    $ez->loadKey($Ow, FALSE);
    $ew = new XMLSecurityDSig();
    $AF = $ez->signData($Td);
    $AF = base64_encode($AF);
    $af .= $Td . "\46\x53\151\147\x6e\x61\x74\165\162\145\75" . urlencode($AF);
    header("\114\157\143\x61\x74\151\x6f\x6e\x3a\40" . $af);
    exit;
    Lno:
    I8d:
    jmJ:
    if (!(array_key_exists("\123\x41\x4d\x4c\x52\145\x73\x70\x6f\156\x73\x65", $_REQUEST) && !empty($_REQUEST["\x53\101\115\x4c\x52\145\x73\x70\157\156\x73\145"]))) {
        goto Obv;
    }
    if (array_key_exists("\x52\x65\154\x61\171\x53\164\141\164\x65", $_POST) && !empty($_POST["\122\145\154\x61\171\123\164\141\x74\x65"]) && $_POST["\122\145\x6c\141\x79\123\x74\x61\x74\145"] != "\57") {
        goto bqB;
    }
    $fG = '';
    goto BPn;
    bqB:
    $fG = $_POST["\122\x65\x6c\141\171\123\164\x61\x74\x65"];
    BPn:
    $fG = mo_saml_parse_url($fG);
    $QU = get_site_option("\x6d\157\137\163\141\x6d\154\x5f\163\x70\x5f\142\x61\163\145\137\x75\162\154");
    if (!empty($QU)) {
        goto DUX;
    }
    $QU = get_network_site_url();
    DUX:
    $Be = $_REQUEST["\123\101\x4d\x4c\122\x65\x73\x70\x6f\x6e\x73\x65"];
    $Be = base64_decode($Be);
    if (!($fG == "\x64\x69\x73\x70\154\141\171\123\101\115\114\122\x65\x73\x70\157\x6e\x73\145")) {
        goto BKJ;
    }
    mo_saml_show_SAML_log($Be, $fG);
    BKJ:
    if (!(array_key_exists("\123\101\115\114\122\x65\163\160\x6f\156\x73\145", $_GET) && !empty($_GET["\x53\x41\115\x4c\122\x65\163\x70\157\156\163\x65"]))) {
        goto k9p;
    }
    $Be = gzinflate($Be);
    k9p:
    $x4 = new DOMDocument();
    $x4->loadXML($Be);
    $nT = $x4->firstChild;
    $gQ = $x4->documentElement;
    $bg = new DOMXpath($x4);
    $bg->registerNamespace("\163\x61\155\x6c\x70", "\165\x72\156\72\x6f\141\163\x69\x73\72\156\141\155\145\x73\x3a\164\x63\72\x53\101\x4d\114\x3a\x32\x2e\60\x3a\x70\162\157\164\157\143\x6f\154");
    $bg->registerNamespace("\x73\141\x6d\154", "\x75\x72\x6e\72\157\x61\x73\151\163\72\x6e\x61\155\145\163\72\164\143\72\123\x41\115\114\x3a\62\x2e\x30\72\x61\163\163\145\162\164\151\x6f\x6e");
    if ($nT->localName == "\114\157\147\x6f\165\x74\122\x65\163\160\x6f\156\163\x65") {
        goto eNZ;
    }
    $HC = $bg->query("\57\x73\x61\x6d\x6c\x70\x3a\x52\145\x73\160\157\156\163\x65\57\x73\141\x6d\154\160\x3a\x53\164\141\x74\x75\x73\x2f\163\x61\155\154\160\72\x53\164\141\x74\165\x73\x43\157\144\x65", $gQ);
    $t4 = isset($HC) ? $HC->item(0)->getAttribute("\x56\x61\x6c\x75\x65") : '';
    $pn = explode("\72", $t4);
    if (!array_key_exists(7, $pn)) {
        goto Je1;
    }
    $HC = $pn[7];
    Je1:
    $vR = $bg->query("\57\163\141\155\x6c\160\x3a\x52\145\x73\160\157\x6e\163\145\57\163\x61\155\154\160\x3a\x53\164\141\x74\165\163\57\x73\x61\x6d\x6c\160\72\x53\164\x61\164\x75\163\115\x65\163\163\141\x67\145", $gQ);
    $uo = isset($vR) ? $vR->item(0) : '';
    if (empty($uo)) {
        goto EqK;
    }
    $uo = $uo->nodeValue;
    EqK:
    if (array_key_exists("\122\145\154\x61\171\123\164\141\x74\145", $_POST) && !empty($_POST["\x52\145\154\141\171\123\164\x61\164\x65"]) && $_POST["\x52\145\x6c\141\x79\x53\164\141\x74\x65"] != "\x2f") {
        goto Rvi;
    }
    $fG = '';
    goto ygn;
    Rvi:
    $fG = $_POST["\x52\x65\154\141\x79\123\x74\141\164\x65"];
    $fG = mo_saml_parse_url($fG);
    ygn:
    if (!($HC != "\123\165\143\143\x65\x73\x73")) {
        goto dyC;
    }
    show_status_error($HC, $fG, $uo);
    dyC:
    if (!($fG !== "\x74\145\163\164\126\x61\x6c\151\144\x61\x74\x65" && $fG !== "\164\x65\x73\164\116\145\x77\103\x65\x72\x74\151\146\151\x63\141\x74\x65")) {
        goto CWc;
    }
    $cC = parse_url($fG, PHP_URL_HOST);
    $C0 = parse_url($QU, PHP_URL_HOST);
    $Gy = parse_url(get_current_base_url(), PHP_URL_HOST);
    if (!empty($fG)) {
        goto IMW;
    }
    $fG = "\x2f";
    goto C5a;
    IMW:
    $fG = mo_saml_parse_url($fG);
    C5a:
    if (!(!empty($cC) && $cC != $Gy)) {
        goto djw;
    }
    Utilities::postSAMLResponse($fG, $_REQUEST["\x53\101\x4d\x4c\x52\x65\x73\160\x6f\156\163\145"], mo_saml_relaystate_url($fG));
    djw:
    CWc:
    $S0 = maybe_unserialize(get_site_option("\x73\x61\x6d\154\x5f\x78\65\x30\x39\137\x63\145\162\164\x69\x66\x69\143\x61\x74\x65"));
    update_site_option("\155\157\137\163\141\155\154\x5f\x72\145\x73\x70\x6f\x6e\163\145", base64_encode($Be));
    foreach ($S0 as $ez => $T5) {
        if (@openssl_x509_read($T5)) {
            goto BCJ;
        }
        unset($S0[$ez]);
        BCJ:
        vhJ:
    }
    R6V:
    $T1 = $QU . "\57";
    if ($fG == "\x74\x65\x73\x74\x4e\x65\x77\x43\145\162\164\x69\x66\151\143\x61\164\145") {
        goto sgR;
    }
    $Be = new SAML2_Response($nT, get_site_option("\155\x6f\x5f\x73\x61\x6d\x6c\137\143\165\162\x72\145\156\x74\x5f\143\145\x72\x74\137\x70\162\x69\x76\141\164\145\137\153\145\x79"));
    goto dPr;
    sgR:
    $o_ = file_get_contents(plugin_dir_path(__FILE__) . "\162\x65\163\157\x75\x72\143\145\x73" . DIRECTORY_SEPARATOR . mo_options_enum_default_sp_certificate::SP_Private_Key);
    $Be = new SAML2_Response($nT, $o_);
    dPr:
    $F3 = $Be->getSignatureData();
    $Im = current($Be->getAssertions())->getSignatureData();
    if (!(empty($Im) && empty($F3))) {
        goto X6H;
    }
    if ($fG == "\x74\x65\x73\x74\x56\141\154\151\x64\x61\x74\145" or $fG == "\x74\x65\163\164\x4e\145\x77\103\145\x72\x74\151\146\151\143\141\x74\145") {
        goto qM6;
    }
    wp_die("\x57\x65\x20\x63\157\x75\x6c\x64\40\x6e\157\x74\40\163\151\x67\156\x20\x79\x6f\x75\40\x69\x6e\56\40\120\154\x65\141\x73\145\40\143\x6f\156\x74\x61\x63\x74\40\x61\x64\x6d\x69\x6e\151\163\x74\x72\141\164\x6f\162", "\105\162\162\157\162\72\x20\111\x6e\x76\141\154\151\144\x20\x53\x41\115\x4c\x20\x52\x65\x73\160\157\156\x73\x65");
    goto DQy;
    qM6:
    $iV = mo_options_error_constants::Error_no_certificate;
    $Se = mo_options_error_constants::Cause_no_certificate;
    echo "\x3c\144\x69\166\40\163\x74\171\x6c\x65\75\42\x66\157\156\x74\x2d\146\141\155\151\154\x79\72\x43\141\x6c\151\x62\162\x69\x3b\160\x61\144\144\151\156\147\72\x30\x20\x33\45\x3b\42\76\xd\xa\x9\11\x9\11\11\x9\x3c\x64\151\x76\40\x73\164\x79\154\145\x3d\42\143\x6f\x6c\157\162\72\x20\x23\141\71\x34\x34\64\62\x3b\x62\141\143\153\x67\162\157\x75\x6e\144\55\143\x6f\x6c\x6f\x72\x3a\x20\x23\146\62\144\145\144\x65\73\160\141\144\144\151\156\x67\x3a\40\61\x35\160\170\73\155\x61\162\x67\151\156\x2d\142\157\164\164\157\155\72\40\x32\x30\x70\170\73\164\145\170\x74\x2d\141\x6c\151\147\156\72\x63\x65\156\164\x65\162\73\x62\157\162\144\x65\162\x3a\61\160\x78\40\163\157\x6c\151\x64\x20\43\x45\66\x42\63\x42\62\73\x66\x6f\156\164\55\163\151\172\145\72\61\70\160\164\x3b\x22\76\x20\x45\122\122\x4f\x52\x3c\57\144\x69\166\76\15\12\x9\11\x9\x9\x9\11\x3c\144\x69\x76\40\x73\164\171\154\145\x3d\42\x63\157\x6c\157\x72\x3a\x20\x23\141\x39\x34\64\x34\62\x3b\146\157\x6e\x74\55\163\x69\x7a\145\72\x31\x34\x70\164\x3b\x20\155\141\162\147\151\156\55\x62\157\164\164\157\x6d\x3a\x32\x30\x70\x78\73\42\x3e\74\x70\x3e\74\163\x74\x72\157\156\147\76\x45\162\x72\157\x72\x20\40\72" . $iV . "\40\x3c\57\163\x74\162\157\x6e\147\x3e\74\57\x70\76\15\xa\11\x9\x9\x9\x9\11\15\12\x9\11\11\x9\11\x9\x3c\160\x3e\74\x73\164\162\x6f\156\147\x3e\x50\x6f\163\x73\x69\142\x6c\145\40\x43\x61\x75\x73\145\72\x20" . $Se . "\x3c\x2f\163\x74\x72\x6f\156\147\x3e\74\57\160\x3e\15\12\11\11\x9\x9\11\x9\xd\12\11\11\11\x9\x9\11\74\x2f\x64\151\166\x3e\74\57\x64\151\x76\76";
    mo_saml_download_logs($iV, $Se);
    exit;
    DQy:
    X6H:
    $s3 = '';
    if (is_array($S0)) {
        goto SLu;
    }
    $z0 = XMLSecurityKey::getRawThumbprint($S0);
    $z0 = mo_saml_convert_to_windows_iconv($z0);
    $z0 = preg_replace("\x2f\134\x73\x2b\57", '', $z0);
    if (empty($F3)) {
        goto Adr;
    }
    $s3 = Utilities::processResponse($T1, $z0, $F3, $Be, 0, $fG);
    Adr:
    if (empty($Im)) {
        goto BN6;
    }
    $s3 = Utilities::processResponse($T1, $z0, $Im, $Be, 0, $fG);
    BN6:
    goto iId;
    SLu:
    foreach ($S0 as $ez => $T5) {
        $z0 = XMLSecurityKey::getRawThumbprint($T5);
        $z0 = mo_saml_convert_to_windows_iconv($z0);
        $z0 = preg_replace("\57\x5c\x73\x2b\57", '', $z0);
        if (empty($F3)) {
            goto owZ;
        }
        $s3 = Utilities::processResponse($T1, $z0, $F3, $Be, $ez, $fG);
        owZ:
        if (empty($Im)) {
            goto Je5;
        }
        $s3 = Utilities::processResponse($T1, $z0, $Im, $Be, $ez, $fG);
        Je5:
        if (!$s3) {
            goto RqK;
        }
        goto BPM;
        RqK:
        DOJ:
    }
    BPM:
    iId:
    if (empty($F3)) {
        goto DMb;
    }
    $IT = $F3["\103\x65\x72\164\x69\x66\x69\143\x61\x74\x65\x73"][0];
    goto bLK;
    DMb:
    $IT = $Im["\x43\145\162\164\151\x66\x69\143\x61\x74\x65\163"][0];
    bLK:
    if ($s3) {
        goto fdI;
    }
    if ($fG == "\x74\x65\x73\164\x56\x61\x6c\x69\x64\x61\164\x65" or $fG == "\164\145\x73\164\116\145\167\103\x65\162\164\x69\x66\151\143\x61\x74\145") {
        goto Qng;
    }
    wp_die("\x57\145\x20\143\x6f\165\154\x64\40\x6e\x6f\164\40\x73\x69\147\156\40\x79\157\x75\40\151\x6e\56\x20\x50\x6c\x65\x61\x73\x65\x20\x63\x6f\156\x74\141\x63\x74\40\x79\157\165\x72\x20\x41\x64\x6d\151\156\151\163\x74\162\x61\x74\x6f\x72", "\x45\x72\162\x6f\162\40\x3a\x43\x65\162\x74\x69\146\x69\x63\x61\164\x65\x20\x6e\157\x74\x20\x66\157\x75\156\144");
    goto pW2;
    Qng:
    $iV = mo_options_error_constants::Error_wrong_certificate;
    $Se = mo_options_error_constants::Cause_wrong_certificate;
    $J2 = "\55\x2d\55\55\x2d\x42\x45\107\111\x4e\x20\x43\105\122\124\111\x46\111\x43\101\x54\105\55\55\55\55\55\74\x62\x72\x3e" . chunk_split($IT, 64) . "\x3c\x62\x72\76\x2d\55\x2d\55\55\x45\x4e\x44\40\103\105\122\124\111\x46\x49\x43\101\124\105\x2d\x2d\55\55\55";
    echo "\74\144\151\166\40\x73\164\171\154\145\75\42\146\157\x6e\x74\55\146\141\155\x69\x6c\171\72\x43\x61\154\x69\x62\162\x69\x3b\160\141\144\x64\x69\x6e\147\72\x30\x20\63\x25\73\x22\76";
    echo "\x3c\144\x69\166\40\163\164\171\x6c\145\75\42\143\x6f\154\x6f\162\72\40\x23\x61\71\x34\x34\64\x32\73\x62\141\143\153\x67\x72\157\165\156\144\55\143\157\x6c\x6f\162\72\40\x23\x66\x32\144\145\144\145\x3b\x70\141\x64\144\151\156\147\72\x20\61\x35\160\x78\73\x6d\141\x72\147\151\x6e\x2d\142\x6f\164\164\x6f\x6d\72\40\x32\60\x70\170\x3b\164\x65\170\x74\x2d\141\x6c\151\147\156\x3a\143\x65\x6e\164\145\x72\x3b\142\x6f\162\144\145\162\x3a\61\x70\x78\x20\163\x6f\x6c\x69\144\40\x23\105\66\x42\63\x42\x32\73\146\157\x6e\164\55\x73\151\172\x65\72\x31\70\160\164\x3b\x22\76\x20\105\122\122\117\122\x3c\x2f\144\151\x76\x3e\15\12\x20\40\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\40\40\40\x20\40\40\40\74\144\151\166\40\x73\164\x79\x6c\145\75\42\x63\x6f\x6c\157\162\72\x20\x23\x61\71\x34\64\64\x32\73\x66\x6f\x6e\164\x2d\163\x69\x7a\145\x3a\x31\x34\160\164\x3b\40\x6d\x61\x72\147\x69\x6e\55\x62\x6f\x74\164\x6f\x6d\x3a\x32\x30\160\x78\x3b\x22\x3e\x3c\x70\x3e\74\x73\x74\162\x6f\x6e\x67\76\105\162\x72\x6f\162\x3a\40\x3c\x2f\163\164\162\157\156\x67\76\x55\156\x61\x62\x6c\145\40\x74\x6f\x20\146\151\156\x64\40\x61\40\x63\x65\x72\164\x69\x66\x69\x63\x61\x74\145\x20\x6d\x61\x74\143\150\151\x6e\147\x20\164\150\x65\x20\143\157\x6e\x66\x69\147\x75\162\x65\x64\x20\146\x69\156\x67\x65\x72\160\162\151\156\x74\56\x3c\x2f\160\x3e\xd\xa\40\x20\40\x20\40\40\40\x20\x20\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\40\x20\40\x20\74\160\x3e\x50\154\x65\x61\x73\x65\40\143\x6f\156\164\x61\x63\x74\40\171\x6f\x75\162\x20\x61\144\155\x69\156\151\163\x74\x72\x61\x74\x6f\162\40\141\x6e\144\x20\162\x65\160\x6f\162\164\40\164\150\145\x20\146\157\154\x6c\157\167\151\x6e\147\x20\145\162\x72\157\x72\72\74\57\x70\x3e\xd\12\x20\x20\x20\x20\40\x20\x20\40\x20\x20\x20\x20\40\40\40\x20\40\x20\x20\x20\x20\40\40\40\40\x20\x20\x20\x3c\160\x3e\x3c\163\164\x72\x6f\156\147\76\x50\x6f\163\163\x69\142\154\x65\40\x43\x61\165\163\145\72\x20\74\x2f\x73\x74\x72\157\156\x67\x3e\x27\x58\x2e\65\x30\71\40\103\x65\x72\164\x69\146\x69\x63\x61\x74\x65\x27\x20\x66\x69\x65\154\144\40\151\x6e\x20\160\x6c\x75\x67\151\x6e\x20\144\x6f\x65\x73\x20\156\157\164\x20\155\141\x74\143\x68\40\x74\150\145\40\143\145\x72\164\x69\x66\151\x63\141\164\145\x20\146\x6f\165\156\144\x20\151\x6e\40\x53\101\x4d\x4c\x20\x52\145\163\x70\157\156\163\x65\x2e\x3c\57\x70\x3e\xd\12\x20\x20\40\40\x20\40\40\x20\40\x20\40\x20\x20\x20\40\40\40\40\40\40\x20\40\x20\x20\40\x20\40\x20\74\x70\x3e\x3c\163\x74\162\x6f\x6e\147\76\103\x65\x72\x74\151\146\151\x63\141\164\x65\x20\x66\x6f\165\x6e\144\x20\x69\156\x20\123\101\x4d\x4c\x20\122\x65\163\160\x6f\156\x73\x65\72\x20\x3c\x2f\163\x74\x72\157\156\147\76\74\146\157\156\x74\40\146\x61\143\145\75\42\x43\x6f\165\162\x69\x65\162\40\x4e\x65\x77\42\76\x3c\x62\x72\x3e\74\x62\162\76" . $J2 . "\74\x2f\x70\76\x3c\57\x66\157\x6e\164\x3e\15\xa\x20\x20\x20\40\x20\40\40\40\x20\x20\40\40\40\x20\x20\40\40\x20\40\x20\x20\40\x20\40\40\40\40\40\x3c\160\76\74\x73\x74\x72\157\x6e\147\76\123\157\154\x75\164\x69\x6f\x6e\72\x20\x3c\x2f\163\x74\x72\x6f\x6e\147\x3e\x3c\x2f\x70\76\15\xa\x20\40\40\x20\40\40\40\x20\x20\x20\x20\40\x20\40\40\x20\40\x20\40\40\40\x20\40\x20\x20\40\40\40\74\x6f\x6c\x3e\xd\12\40\x20\40\x20\40\x20\40\x20\40\40\40\40\40\x20\40\40\x20\40\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\x20\40\74\x6c\151\76\x43\x6f\x70\171\40\160\x61\x73\164\145\40\x74\x68\x65\x20\x63\145\162\x74\x69\x66\151\143\141\164\x65\x20\160\x72\x6f\x76\151\144\x65\144\x20\141\x62\x6f\166\145\40\151\156\x20\x58\65\x30\71\40\103\x65\x72\x74\x69\x66\x69\143\x61\x74\145\x20\165\x6e\144\x65\162\x20\123\x65\x72\x76\151\x63\145\x20\x50\x72\x6f\x76\x69\144\145\162\x20\123\145\x74\x75\x70\x20\164\141\142\56\74\x2f\x6c\x69\76\xd\xa\x20\40\x20\x20\40\x20\x20\x20\x20\40\40\40\40\x20\40\x20\x20\40\x20\40\40\40\x20\40\x20\40\x20\x20\x20\40\40\x3c\x6c\x69\x3e\111\x66\x20\151\163\x73\165\145\x20\x70\x65\x72\163\x69\x73\164\x73\40\144\151\x73\x61\x62\x6c\x65\x20\x3c\142\x3e\x43\150\141\x72\141\143\164\145\162\x20\145\156\143\157\144\x69\x6e\147\x3c\x2f\x62\76\40\165\x6e\x64\145\162\x20\123\x65\x72\x76\x69\x63\145\x20\120\x72\x6f\x76\144\x65\162\x20\x53\145\x74\x75\160\x20\164\141\142\56\x3c\57\154\x69\x3e\15\xa\40\x20\40\40\40\x20\x20\40\x20\40\40\x20\x20\x20\x20\x20\x20\x20\40\40\40\x20\40\x20\x20\40\x20\40\x3c\57\x6f\154\76\xd\xa\x20\x20\40\x20\40\x20\40\40\x20\40\40\40\40\40\x20\40\40\40\x20\x20\40\x20\x20\40\40\x20\x20\x20\74\x2f\x64\x69\x76\76\15\xa\40\40\40\x20\x20\40\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\x3c\144\x69\166\40\x73\164\x79\x6c\145\75\x22\155\x61\x72\x67\151\x6e\x3a\x33\x25\x3b\x64\151\163\x70\x6c\141\171\72\x62\x6c\157\x63\153\x3b\164\x65\170\164\55\x61\x6c\151\147\156\x3a\x63\145\x6e\164\x65\162\x3b\42\76\xd\12\40\40\x20\40\40\x20\40\40\40\40\x20\x20\40\40\x20\x20\40\40\x20\x20\x20\40\40\40\40\40\40\x20\x20\x20\40\x20\x3c\144\151\166\x20\x73\164\x79\x6c\x65\x3d\42\x6d\141\162\x67\x69\x6e\72\x33\x25\73\144\151\163\x70\x6c\x61\171\x3a\142\x6c\157\x63\153\x3b\164\x65\170\164\x2d\x61\x6c\x69\147\x6e\x3a\143\x65\156\164\x65\162\73\x22\76\x3c\x69\156\160\165\164\40\163\164\x79\x6c\x65\x3d\42\x70\x61\x64\144\151\156\x67\72\x31\x25\73\167\x69\144\164\150\x3a\61\60\60\160\170\73\142\x61\143\153\x67\162\157\x75\156\x64\x3a\40\x23\60\60\71\61\x43\x44\x20\156\157\156\x65\40\162\145\160\145\141\x74\40\163\143\x72\157\154\154\40\x30\45\x20\x30\45\73\x63\x75\x72\x73\x6f\x72\72\x20\160\157\x69\x6e\x74\x65\162\x3b\146\157\156\x74\x2d\163\151\172\145\72\61\x35\x70\x78\x3b\142\157\162\144\x65\x72\55\x77\151\144\x74\x68\x3a\40\61\160\x78\x3b\x62\157\162\144\145\x72\x2d\163\164\x79\x6c\x65\x3a\x20\163\x6f\x6c\x69\x64\x3b\142\157\x72\144\145\x72\55\x72\x61\144\151\x75\x73\x3a\40\x33\160\x78\x3b\x77\x68\151\x74\x65\x2d\163\160\x61\143\145\x3a\x20\156\x6f\167\x72\141\160\73\x62\x6f\x78\55\163\x69\172\x69\x6e\147\x3a\40\142\x6f\162\144\145\x72\x2d\142\157\170\x3b\142\157\162\x64\145\x72\x2d\143\157\154\x6f\x72\72\x20\43\60\60\x37\x33\x41\x41\x3b\x62\x6f\x78\55\x73\150\x61\144\157\x77\72\40\60\x70\x78\40\61\x70\170\x20\x30\x70\x78\40\x72\x67\142\141\50\61\62\x30\x2c\x20\62\60\60\x2c\40\62\x33\x30\54\x20\60\x2e\66\51\x20\151\x6e\163\x65\x74\x3b\143\157\154\x6f\x72\x3a\x20\x23\x46\x46\x46\73\x22\164\171\x70\x65\x3d\x22\x62\165\164\164\157\156\42\x20\166\141\154\165\145\x3d\42\x44\x6f\x6e\x65\x22\x20\157\156\x43\154\151\x63\153\x3d\42\x73\145\x6c\x66\56\143\x6c\157\x73\145\x28\x29\73\42\x3e\x3c\57\144\151\x76\x3e";
    mo_saml_download_logs($iV, $Se);
    exit;
    pW2:
    fdI:
    $NK = get_site_option("\x73\x61\x6d\x6c\x5f\151\163\163\165\145\162");
    $xo = get_site_option("\x6d\x6f\x5f\x73\141\155\x6c\137\x73\x70\137\145\x6e\x74\x69\164\x79\x5f\151\144");
    if (!empty($xo)) {
        goto xrR;
    }
    $xo = $QU . "\57\167\x70\x2d\x63\x6f\156\164\145\156\x74\57\160\x6c\165\147\x69\156\163\x2f\x6d\151\156\x69\157\x72\141\156\x67\145\55\x73\141\x6d\x6c\x2d\x32\60\55\x73\x69\x6e\147\x6c\x65\x2d\x73\x69\x67\x6e\x2d\157\156\x2f";
    xrR:
    Utilities::validateIssuerAndAudience($Be, $xo, $NK, $fG);
    $M9 = current(current($Be->getAssertions())->getNameId());
    $Mr = current($Be->getAssertions())->getAttributes();
    $Mr["\x4e\141\x6d\x65\x49\104"] = array("\x30" => $M9);
    $ri = current($Be->getAssertions())->getSessionIndex();
    mo_saml_checkMapping($Mr, $fG, $ri);
    goto aJm;
    eNZ:
    if (!isset($_REQUEST["\x52\x65\154\x61\x79\x53\164\x61\164\145"])) {
        goto t9W;
    }
    $WN = $_REQUEST["\122\145\154\141\171\x53\164\x61\x74\x65"];
    t9W:
    if (!is_user_logged_in()) {
        goto uO8;
    }
    wp_logout();
    uO8:
    if (empty($WN)) {
        goto sgZ;
    }
    $WN = mo_saml_parse_url($WN);
    goto WOK;
    sgZ:
    $WN = $QU;
    WOK:
    header("\x4c\157\143\141\x74\151\x6f\156\72" . $WN);
    exit;
    aJm:
    Obv:
    if (!(array_key_exists("\x53\101\115\114\x52\145\161\x75\x65\163\164", $_REQUEST) && !empty($_REQUEST["\123\x41\115\x4c\122\x65\161\x75\x65\x73\x74"]))) {
        goto Mmy;
    }
    $Td = $_REQUEST["\x53\x41\115\x4c\x52\x65\161\x75\145\x73\164"];
    $fG = "\x2f";
    if (!array_key_exists("\122\x65\154\141\171\x53\164\x61\164\x65", $_REQUEST)) {
        goto tBj;
    }
    $fG = $_REQUEST["\x52\x65\x6c\141\171\x53\164\141\x74\x65"];
    tBj:
    $Td = base64_decode($Td);
    if (!(array_key_exists("\x53\101\115\x4c\122\x65\161\165\145\163\164", $_GET) && !empty($_GET["\123\101\x4d\114\122\145\161\x75\145\163\164"]))) {
        goto LlK;
    }
    $Td = gzinflate($Td);
    LlK:
    $x4 = new DOMDocument();
    $x4->loadXML($Td);
    $b8 = $x4->firstChild;
    if (!($b8->localName == "\x4c\157\147\x6f\x75\x74\x52\x65\161\x75\145\163\164")) {
        goto wIJ;
    }
    $mN = new SAML2_LogoutRequest($b8);
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto vUk;
    }
    session_start();
    vUk:
    $_SESSION["\x6d\157\137\x73\x61\155\x6c\137\154\157\147\157\x75\x74\x5f\162\x65\161\165\x65\x73\x74"] = $Td;
    $_SESSION["\155\x6f\x5f\163\141\155\154\137\154\x6f\147\x6f\165\164\137\x72\x65\154\141\x79\137\163\x74\x61\x74\x65"] = $fG;
    wp_redirect(htmlspecialchars_decode(wp_logout_url()));
    exit;
    wIJ:
    Mmy:
    if (!(isset($_REQUEST["\157\x70\164\x69\157\x6e"]) and !is_array($_REQUEST["\x6f\x70\164\x69\157\x6e"]) and strpos($_REQUEST["\x6f\x70\x74\151\157\156"], "\x72\x65\x61\144\x73\x61\155\x6c\154\157\147\x69\x6e") !== false)) {
        goto EUv;
    }
    require_once dirname(__FILE__) . "\57\151\x6e\x63\x6c\165\144\145\163\57\154\151\142\x2f\145\x6e\143\x72\x79\160\x74\x69\157\156\56\x70\x68\x70";
    if (isset($_POST["\123\124\101\x54\125\x53"]) && $_POST["\x53\124\x41\124\x55\123"] == "\105\122\x52\117\x52") {
        goto Zyy;
    }
    if (!(isset($_POST["\x53\x54\101\x54\x55\x53"]) && $_POST["\123\x54\101\124\x55\123"] == "\x53\125\x43\x43\x45\123\123")) {
        goto R2V;
    }
    $dA = '';
    if (!(isset($_REQUEST["\x72\145\x64\151\x72\145\143\164\x5f\x74\x6f"]) && !empty($_REQUEST["\162\145\144\151\x72\x65\x63\164\x5f\x74\157"]) && $_REQUEST["\x72\145\x64\151\162\145\x63\x74\x5f\164\157"] != "\x2f")) {
        goto wH9;
    }
    $dA = $_REQUEST["\x72\x65\x64\x69\162\145\143\164\137\x74\x6f"];
    wH9:
    delete_site_option("\x6d\x6f\x5f\163\x61\x6d\154\x5f\162\x65\x64\151\x72\145\x63\x74\x5f\145\x72\162\157\162\x5f\143\x6f\x64\145");
    delete_site_option("\155\x6f\x5f\163\x61\x6d\154\137\162\145\x64\151\162\x65\143\x74\x5f\x65\x72\162\x6f\162\137\x72\145\x61\x73\157\x6e");
    try {
        $Iy = get_site_option("\x73\141\x6d\x6c\137\x61\x6d\x5f\145\x6d\141\151\x6c");
        $fj = get_site_option("\x73\x61\155\x6c\x5f\x61\x6d\137\x75\163\x65\x72\156\141\155\x65");
        $C3 = get_site_option("\163\x61\x6d\x6c\x5f\x61\x6d\x5f\146\151\162\163\164\137\156\x61\155\x65");
        $w6 = get_site_option("\163\x61\x6d\154\x5f\x61\155\137\154\x61\x73\164\137\x6e\x61\155\x65");
        $cg = get_site_option("\x73\x61\155\x6c\x5f\x61\155\x5f\147\162\157\x75\x70\x5f\x6e\141\x6d\145");
        $BN = get_site_option("\163\x61\x6d\x6c\137\141\x6d\x5f\144\145\x66\141\165\x6c\x74\x5f\x75\163\145\x72\x5f\x72\157\x6c\x65");
        $xZ = get_site_option("\x73\141\155\154\137\x61\155\137\x64\x6f\x6e\x74\137\141\x6c\x6c\x6f\x77\137\x75\156\x6c\x69\x73\164\x65\x64\x5f\x75\x73\145\162\x5f\162\x6f\x6c\x65");
        $zl = get_site_option("\x73\141\x6d\x6c\137\141\x6d\137\141\x63\143\x6f\165\x6e\164\x5f\x6d\141\x74\143\x68\145\162");
        $JY = '';
        $c2 = '';
        $C3 = str_replace("\56", "\137", $C3);
        $C3 = str_replace("\x20", "\x5f", $C3);
        if (!(!empty($C3) && array_key_exists($C3, $_POST))) {
            goto KXr;
        }
        $C3 = $_POST[$C3];
        KXr:
        $w6 = str_replace("\x2e", "\x5f", $w6);
        $w6 = str_replace("\40", "\137", $w6);
        if (!(!empty($w6) && array_key_exists($w6, $_POST))) {
            goto ZSN;
        }
        $w6 = $_POST[$w6];
        ZSN:
        $fj = str_replace("\x2e", "\x5f", $fj);
        $fj = str_replace("\40", "\x5f", $fj);
        if (!empty($fj) && array_key_exists($fj, $_POST)) {
            goto SlC;
        }
        $c2 = $_POST["\116\x61\155\145\111\104"];
        goto XID;
        SlC:
        $c2 = $_POST[$fj];
        XID:
        $JY = str_replace("\56", "\137", $Iy);
        $JY = str_replace("\40", "\137", $Iy);
        if (!empty($Iy) && array_key_exists($Iy, $_POST)) {
            goto Zqy;
        }
        $JY = $_POST["\x4e\141\155\x65\x49\104"];
        goto nxw;
        Zqy:
        $JY = $_POST[$Iy];
        nxw:
        $cg = str_replace("\56", "\x5f", $cg);
        $cg = str_replace("\x20", "\137", $cg);
        if (!(!empty($cg) && array_key_exists($cg, $_POST))) {
            goto k02;
        }
        $cg = $_POST[$cg];
        k02:
        if (!empty($zl)) {
            goto ge3;
        }
        $zl = "\145\155\x61\x69\154";
        ge3:
        $ez = get_site_option("\155\x6f\137\163\141\155\154\x5f\143\165\x73\164\157\x6d\x65\162\x5f\164\x6f\153\145\x6e");
        if (!(isset($ez) || trim($ez) != '')) {
            goto c4B;
        }
        $ZY = AESEncryption::decrypt_data($JY, $ez);
        $JY = $ZY;
        c4B:
        if (!(!empty($C3) && !empty($ez))) {
            goto mlx;
        }
        $y5 = AESEncryption::decrypt_data($C3, $ez);
        $C3 = $y5;
        mlx:
        if (!(!empty($w6) && !empty($ez))) {
            goto zGT;
        }
        $JF = AESEncryption::decrypt_data($w6, $ez);
        $w6 = $JF;
        zGT:
        if (!(!empty($c2) && !empty($ez))) {
            goto CgJ;
        }
        $sq = AESEncryption::decrypt_data($c2, $ez);
        $c2 = $sq;
        CgJ:
        if (!(!empty($cg) && !empty($ez))) {
            goto hkt;
        }
        $qn = AESEncryption::decrypt_data($cg, $ez);
        $cg = $qn;
        hkt:
    } catch (Exception $aW) {
        echo sprintf("\x41\x6e\40\x65\x72\162\x6f\162\40\x6f\x63\143\x75\162\x72\x65\144\x20\x77\x68\x69\154\145\x20\160\162\157\x63\x65\x73\163\151\x6e\147\x20\x74\x68\145\x20\x53\101\115\x4c\x20\x52\145\163\x70\x6f\156\163\x65\56");
        exit;
    }
    $Kh = array($cg);
    mo_saml_login_user($JY, $C3, $w6, $c2, $Kh, $xZ, $BN, $dA, $zl);
    R2V:
    goto FeE;
    Zyy:
    update_site_option("\x6d\157\137\x73\141\155\154\137\162\x65\x64\x69\162\x65\x63\164\137\145\162\162\157\162\x5f\143\x6f\x64\145", $_POST["\105\122\122\117\122\x5f\x52\x45\x41\123\x4f\116"]);
    update_site_option("\x6d\157\137\x73\141\155\x6c\137\x72\145\144\x69\162\145\143\x74\x5f\x65\162\x72\157\162\x5f\x72\x65\141\163\x6f\156", $_POST["\x45\122\x52\117\122\x5f\115\x45\123\123\101\x47\105"]);
    FeE:
    EUv:
    xfx:
}
function mo_saml_relaystate_url($fG)
{
    $OD = parse_url($fG, PHP_URL_SCHEME);
    $fG = str_replace($OD . "\72\57\57", '', $fG);
    return $fG;
}
function mo_saml_hash_relaystate($fG)
{
    $OD = parse_url($fG, PHP_URL_SCHEME);
    $fG = str_replace($OD . "\x3a\x2f\x2f", '', $fG);
    $fG = base64_encode($fG);
    $qR = cdjsurkhh($fG);
    $fG = $fG . "\x2e" . $qR;
    return $fG;
}
function mo_saml_get_relaystate($fG)
{
    if (!filter_var($fG, FILTER_VALIDATE_URL)) {
        goto Rw2;
    }
    return $fG;
    Rw2:
    $du = strpos($fG, "\56");
    if ($du) {
        goto CWB;
    }
    wp_die("\101\156\40\145\162\162\157\x72\40\157\x63\143\x75\x72\x65\144\x2e\x20\120\x6c\x65\141\x73\145\40\x63\x6f\x6e\164\141\143\x74\x20\x79\157\165\x72\40\x61\x64\x6d\x69\x6e\151\x73\164\162\x61\164\157\162\56", "\105\x72\162\x6f\162\x20\72\x20\x4e\157\164\x20\141\40\164\x72\x75\163\164\x65\x64\40\x73\x6f\165\162\x63\x65\x20\x6f\x66\x20\164\150\145\40\x53\x41\x4d\x4c\x20\162\x65\163\160\x6f\x6e\x73\x65");
    exit;
    CWB:
    $WN = substr($fG, 0, $du);
    $OM = substr($fG, $du + 1);
    $fs = cdjsurkhh($WN);
    if (!($OM !== $fs)) {
        goto ELd;
    }
    wp_die("\x41\156\40\x65\x72\x72\x6f\162\x20\157\x63\x63\165\x72\145\x64\x2e\40\x50\x6c\145\141\x73\145\x20\x63\157\x6e\x74\x61\143\x74\40\x79\157\165\162\40\x61\144\x6d\151\x6e\151\163\164\x72\141\x74\x6f\162\56", "\x45\x72\162\157\x72\x20\x3a\x20\x4e\157\164\x20\141\x20\x74\162\x75\163\x74\145\x64\x20\x73\157\x75\x72\x63\x65\40\157\146\40\164\x68\x65\x20\123\101\x4d\x4c\40\x72\145\163\160\157\x6e\x73\145");
    exit;
    ELd:
    $WN = base64_decode($WN);
    return $WN;
}
function cdjsurkhh($ok)
{
    $qR = hash("\163\x68\141\x35\61\x32", $ok);
    $wB = substr($qR, 7, 14);
    return $wB;
}
function mo_saml_parse_url($fG)
{
    if (!($fG != "\164\x65\163\164\x56\141\154\151\144\x61\x74\145" && $fG != "\164\145\x73\164\116\x65\x77\x43\x65\x72\x74\x69\146\151\143\x61\164\x65")) {
        goto NT8;
    }
    $QU = get_site_option("\155\157\137\x73\x61\x6d\154\x5f\163\160\137\x62\141\163\x65\137\x75\162\154");
    if (!empty($QU)) {
        goto WqN;
    }
    $QU = get_network_site_url();
    WqN:
    $OD = parse_url($QU, PHP_URL_SCHEME);
    if (filter_var($fG, FILTER_VALIDATE_URL)) {
        goto WBG;
    }
    $fG = $OD . "\72\57\x2f" . $fG;
    WBG:
    NT8:
    return $fG;
}
function mo_saml_is_subsite($fG)
{
    $kN = parse_url($fG, PHP_URL_HOST);
    $ot = parse_url($fG, PHP_URL_PATH);
    if (is_subdomain_install()) {
        goto aE7;
    }
    $OY = strpos($ot, "\x2f", 1) != false ? strpos($ot, "\57", 1) : strlen($ot) - 1;
    $ot = substr($ot, 0, $OY + 1);
    $blog_id = get_blog_id_from_url($kN, $ot);
    goto s6S;
    aE7:
    $blog_id = get_blog_id_from_url($kN);
    s6S:
    if ($blog_id !== 0) {
        goto B4P;
    }
    return false;
    goto TeZ;
    B4P:
    return true;
    TeZ:
}
function mo_saml_show_SAML_log($b8, $Si)
{
    header("\x43\157\156\164\145\156\164\55\124\171\160\145\x3a\x20\x74\145\170\164\57\x68\x74\x6d\154");
    $gQ = new DOMDocument();
    $gQ->preserveWhiteSpace = false;
    $gQ->formatOutput = true;
    $gQ->loadXML($b8);
    if ($Si == "\144\x69\163\160\x6c\x61\171\x53\x41\115\114\122\x65\x71\x75\145\x73\164") {
        goto XrM;
    }
    $bH = "\123\x41\115\x4c\40\122\145\163\160\x6f\156\x73\145";
    goto yFX;
    XrM:
    $bH = "\123\101\x4d\x4c\40\x52\145\161\165\x65\163\x74";
    yFX:
    $X0 = $gQ->saveXML();
    $R4 = htmlentities($X0);
    $R4 = rtrim($R4);
    $DH = simplexml_load_string($X0);
    $X3 = json_encode($DH);
    $zP = json_decode($X3);
    $dK = plugins_url("\x69\x6e\143\154\165\144\x65\x73\x2f\x63\163\163\x2f\163\164\171\x6c\x65\137\163\145\x74\x74\x69\156\147\163\x2e\143\163\163\77\166\x65\x72\x3d\x34\x2e\70\56\64\60", __FILE__);
    echo "\x3c\154\x69\x6e\x6b\x20\x72\145\154\75\47\163\164\171\x6c\145\163\x68\x65\145\x74\47\40\x69\144\x3d\x27\155\x6f\137\163\x61\155\154\137\141\x64\155\151\x6e\x5f\x73\x65\x74\x74\151\x6e\x67\163\137\163\164\171\154\145\55\143\163\163\47\x20\x20\150\x72\145\146\75\47" . $dK . "\x27\x20\164\x79\160\145\x3d\47\164\x65\170\x74\57\143\163\x73\47\x20\x6d\145\x64\151\141\x3d\x27\x61\x6c\x6c\x27\40\57\76\xd\12\xd\12\x3c\144\151\x76\x20\143\x6c\x61\163\163\75\x22\155\x6f\55\144\x69\x73\160\154\141\x79\x2d\x6c\157\147\163\x22\40\76\x3c\160\40\164\x79\x70\x65\75\42\164\145\170\164\x22\x20\40\x20\151\144\x3d\42\123\x41\x4d\x4c\x5f\x74\x79\160\145\x22\x3e" . $bH . "\74\57\160\x3e\x3c\x2f\144\151\166\76\xd\12\15\12\x3c\x64\x69\166\x20\x74\171\160\145\x3d\42\x74\x65\170\x74\x22\40\x69\144\x3d\42\x53\x41\x4d\114\137\x64\x69\163\x70\x6c\141\x79\42\x20\143\x6c\x61\x73\x73\x3d\42\x6d\157\55\144\x69\163\x70\x6c\141\171\x2d\142\x6c\x6f\143\153\42\x3e\x3c\160\162\x65\x20\x63\x6c\x61\163\163\75\x27\x62\x72\165\x73\150\x3a\40\170\x6d\154\73\x27\x3e" . $R4 . "\74\x2f\x70\x72\145\x3e\x3c\57\x64\151\x76\76\15\xa\x3c\142\x72\76\15\xa\x3c\x64\151\x76\x9\40\x73\x74\171\154\145\75\42\x6d\141\x72\147\151\156\72\63\x25\73\144\x69\163\160\x6c\141\x79\x3a\142\x6c\x6f\143\x6b\73\164\x65\170\164\55\141\154\151\x67\x6e\72\143\x65\156\x74\145\x72\x3b\42\x3e\15\xa\xd\xa\x3c\144\151\x76\x20\163\x74\x79\x6c\x65\x3d\x22\x6d\141\162\147\151\156\x3a\x33\45\x3b\144\x69\x73\160\x6c\x61\171\x3a\142\154\157\x63\153\x3b\164\145\170\x74\x2d\141\x6c\x69\x67\x6e\x3a\143\x65\156\164\145\162\73\x22\40\76\xd\12\15\12\x3c\57\x64\151\x76\x3e\xd\12\x3c\x62\165\x74\x74\x6f\156\x20\x69\144\x3d\x22\x63\x6f\160\x79\x22\x20\x6f\156\143\x6c\x69\143\153\x3d\42\143\x6f\x70\171\104\151\x76\x54\x6f\x43\154\151\x70\142\x6f\x61\x72\x64\50\x29\x22\40\x20\163\164\x79\154\145\x3d\x22\160\141\144\x64\151\x6e\x67\x3a\61\45\73\167\151\144\164\150\72\x31\60\x30\160\170\73\142\141\143\x6b\147\162\x6f\165\x6e\x64\x3a\40\43\60\60\x39\61\103\x44\40\x6e\x6f\156\x65\x20\162\x65\x70\x65\141\164\x20\x73\x63\x72\x6f\154\154\40\x30\45\x20\60\x25\73\x63\165\162\163\157\162\x3a\40\x70\x6f\151\156\164\145\x72\73\146\157\156\164\55\163\151\172\145\x3a\61\65\160\170\x3b\142\x6f\x72\144\x65\x72\x2d\167\x69\144\164\x68\72\x20\61\x70\170\73\142\x6f\x72\144\145\162\x2d\x73\164\x79\x6c\x65\x3a\x20\163\x6f\x6c\x69\144\x3b\x62\157\x72\x64\145\162\55\162\x61\x64\x69\165\163\x3a\40\x33\x70\x78\x3b\167\x68\x69\x74\x65\55\163\160\141\x63\x65\72\x20\x6e\x6f\x77\x72\x61\x70\73\x62\x6f\170\55\x73\151\x7a\151\x6e\147\x3a\x20\142\x6f\162\x64\145\162\x2d\x62\x6f\x78\73\142\157\162\x64\145\x72\55\143\157\154\x6f\x72\x3a\x20\x23\60\60\67\x33\101\101\73\142\157\x78\55\x73\150\141\144\157\167\72\x20\60\160\x78\40\x31\160\170\x20\60\160\170\40\x72\x67\142\x61\50\61\x32\60\x2c\x20\x32\x30\60\x2c\x20\62\63\60\x2c\x20\60\56\66\x29\40\x69\156\x73\145\164\73\x63\x6f\154\x6f\162\x3a\40\43\x46\106\106\x3b\x22\x20\x3e\103\x6f\160\171\74\x2f\142\165\164\x74\x6f\156\x3e\xd\12\46\x6e\x62\x73\x70\73\xd\xa\74\151\156\x70\x75\164\40\151\144\75\42\x64\x77\156\55\142\x74\x6e\x22\x20\x73\164\x79\154\x65\75\42\160\141\144\144\x69\x6e\x67\72\61\45\73\x77\151\x64\164\x68\72\61\60\60\x70\x78\x3b\x62\141\x63\153\147\162\x6f\x75\156\144\x3a\x20\x23\60\60\71\61\x43\104\40\156\157\x6e\145\x20\162\x65\x70\x65\x61\164\x20\163\x63\162\157\x6c\x6c\40\x30\45\x20\x30\x25\x3b\143\x75\x72\x73\x6f\162\72\x20\x70\x6f\x69\x6e\164\x65\162\x3b\x66\x6f\x6e\164\x2d\163\151\x7a\x65\x3a\61\65\x70\x78\73\x62\157\x72\x64\x65\x72\55\167\x69\x64\164\x68\72\40\61\160\170\73\142\157\x72\x64\145\x72\55\163\164\x79\154\x65\x3a\x20\x73\157\154\x69\x64\x3b\142\157\x72\144\x65\x72\x2d\x72\x61\x64\x69\x75\163\x3a\x20\63\x70\170\x3b\167\150\151\164\145\55\163\160\141\143\x65\x3a\x20\x6e\157\167\162\141\x70\x3b\x62\157\x78\x2d\x73\x69\172\151\156\x67\72\40\142\x6f\162\x64\145\x72\x2d\x62\x6f\170\73\x62\x6f\x72\x64\145\x72\55\x63\x6f\x6c\157\x72\x3a\x20\x23\60\x30\x37\x33\101\101\73\x62\x6f\170\x2d\163\x68\x61\144\x6f\167\72\x20\x30\x70\170\x20\x31\160\170\x20\60\160\170\x20\x72\147\x62\141\x28\61\62\x30\54\x20\62\60\60\x2c\40\x32\x33\60\54\40\x30\56\66\51\40\x69\x6e\163\145\x74\x3b\x63\157\154\157\x72\x3a\40\x23\106\x46\106\73\42\164\171\x70\x65\x3d\x22\142\x75\x74\x74\x6f\x6e\x22\x20\x76\141\x6c\165\x65\x3d\x22\104\157\x77\156\154\157\x61\x64\x22\x20\xd\xa\42\76\15\12\74\x2f\x64\151\166\x3e\15\xa\x3c\57\144\151\x76\76\xd\12\xd\xa\15\12";
    ob_end_flush();
    echo "\xd\12\x3c\163\143\162\151\x70\x74\76\xd\12\xd\xa\146\x75\156\143\164\151\157\156\x20\x63\x6f\x70\x79\104\151\166\x54\x6f\103\x6c\x69\160\x62\x6f\x61\x72\144\50\51\x20\x7b\xd\12\166\141\x72\x20\141\165\x78\40\x3d\x20\x64\157\x63\x75\155\x65\x6e\164\56\143\162\145\x61\164\x65\105\x6c\x65\x6d\145\156\x74\50\x22\151\x6e\160\x75\164\42\x29\x3b\15\12\x61\x75\170\x2e\x73\x65\164\x41\x74\164\x72\x69\142\x75\x74\145\x28\x22\x76\141\x6c\165\x65\42\54\40\144\x6f\x63\165\155\x65\156\x74\56\x67\145\x74\105\154\145\155\x65\156\164\102\171\x49\144\50\x22\123\x41\115\x4c\x5f\144\151\163\160\154\x61\171\42\x29\x2e\164\145\170\x74\x43\x6f\x6e\x74\x65\x6e\164\x29\73\15\xa\x64\157\143\165\x6d\145\156\164\56\142\x6f\144\x79\56\x61\160\x70\145\156\x64\103\x68\151\154\x64\x28\141\165\170\51\73\15\xa\x61\165\x78\56\x73\145\154\145\x63\x74\50\x29\x3b\15\xa\x64\x6f\x63\165\x6d\x65\156\x74\56\145\x78\145\x63\103\157\155\155\141\156\x64\50\42\x63\157\x70\171\42\51\73\xd\xa\144\157\143\165\155\x65\x6e\164\56\142\157\144\171\x2e\162\145\x6d\157\x76\145\x43\150\x69\x6c\x64\x28\x61\165\x78\51\73\xd\12\144\x6f\x63\165\155\x65\156\x74\x2e\x67\x65\164\x45\x6c\145\155\145\156\x74\102\x79\111\144\x28\47\x63\157\x70\x79\47\51\x2e\164\x65\x78\x74\103\x6f\156\x74\145\x6e\x74\40\75\40\x22\x43\x6f\x70\x69\145\x64\42\73\xd\12\144\x6f\143\x75\155\145\156\x74\56\x67\145\x74\x45\154\x65\155\145\156\164\x42\171\x49\x64\x28\x27\143\157\160\x79\47\51\56\x73\x74\171\x6c\145\56\x62\x61\x63\153\147\x72\157\x75\156\x64\x20\75\40\42\147\x72\145\171\42\73\15\12\167\151\x6e\144\x6f\x77\56\147\145\x74\x53\x65\x6c\145\x63\x74\151\x6f\x6e\50\51\x2e\x73\145\x6c\x65\x63\x74\101\154\x6c\103\x68\151\154\144\162\145\156\50\40\144\x6f\x63\x75\x6d\145\x6e\164\56\147\x65\x74\105\154\x65\155\145\x6e\x74\x42\x79\x49\144\50\40\x22\x53\101\x4d\x4c\137\144\151\x73\x70\x6c\141\171\x22\x20\51\x20\x29\73\15\xa\15\12\175\15\12\15\xa\x66\x75\x6e\143\164\x69\157\x6e\x20\x64\x6f\x77\x6e\x6c\x6f\x61\144\50\146\151\154\x65\156\x61\155\x65\x2c\x20\164\x65\x78\x74\x29\x20\173\15\xa\166\141\x72\40\145\154\x65\155\145\x6e\x74\x20\x3d\x20\144\x6f\x63\x75\155\145\x6e\x74\x2e\143\162\x65\141\x74\x65\105\x6c\145\155\x65\x6e\x74\50\x27\x61\x27\x29\73\xd\xa\x65\154\145\x6d\145\x6e\164\56\x73\x65\164\101\x74\x74\162\x69\142\x75\x74\x65\x28\x27\150\162\145\x66\x27\x2c\40\x27\x64\141\x74\141\72\101\160\160\154\151\x63\141\x74\151\157\x6e\x2f\157\x63\x74\x65\164\x2d\x73\164\x72\x65\x61\x6d\x3b\143\x68\x61\162\x73\x65\x74\x3d\x75\164\x66\x2d\x38\54\47\40\53\x20\145\156\143\x6f\x64\145\x55\x52\111\103\x6f\155\160\x6f\x6e\145\x6e\164\x28\x74\145\170\164\51\51\73\15\12\x65\x6c\x65\x6d\145\156\x74\x2e\163\x65\164\x41\x74\164\x72\x69\142\x75\164\145\50\x27\144\157\167\156\154\x6f\141\144\x27\x2c\x20\146\x69\x6c\x65\156\141\x6d\x65\x29\x3b\15\xa\xd\xa\145\x6c\145\155\x65\x6e\164\56\163\x74\171\x6c\145\56\144\151\x73\160\x6c\x61\171\x20\75\40\x27\x6e\157\x6e\x65\47\x3b\xd\xa\144\157\143\165\155\x65\156\x74\x2e\x62\157\x64\x79\56\x61\x70\x70\145\156\144\x43\150\151\x6c\144\x28\145\154\145\x6d\145\x6e\x74\x29\x3b\xd\12\15\xa\145\154\145\x6d\145\156\x74\56\143\154\151\x63\x6b\x28\x29\73\15\12\15\xa\144\157\143\x75\155\145\x6e\164\56\142\157\x64\x79\56\162\x65\x6d\x6f\x76\145\x43\150\151\x6c\x64\x28\x65\154\145\x6d\x65\156\164\51\73\15\12\175\15\xa\xd\12\144\x6f\143\165\155\145\156\164\56\x67\145\x74\x45\154\x65\x6d\x65\156\x74\102\171\x49\x64\50\x22\144\167\156\55\x62\x74\x6e\x22\51\56\x61\x64\144\x45\x76\x65\156\x74\x4c\151\x73\x74\x65\x6e\x65\162\x28\x22\x63\154\x69\143\153\x22\x2c\40\146\x75\x6e\143\x74\151\x6f\156\x20\x28\51\40\173\15\12\xd\12\166\x61\162\40\146\x69\154\x65\x6e\141\x6d\145\40\75\x20\x64\157\x63\x75\x6d\145\156\164\56\x67\145\164\105\154\x65\x6d\x65\156\164\x42\171\111\x64\50\42\x53\101\x4d\x4c\137\x74\x79\160\145\x22\x29\56\164\145\x78\164\x43\157\156\164\x65\x6e\x74\x2b\x22\56\x78\155\x6c\42\x3b\xd\xa\x76\141\x72\40\x6e\157\144\x65\x20\x3d\40\144\x6f\x63\x75\x6d\x65\156\x74\x2e\147\x65\x74\105\154\x65\155\x65\x6e\164\x42\171\111\x64\50\42\x53\101\x4d\x4c\x5f\x64\151\163\160\154\141\x79\42\x29\x3b\xd\12\150\x74\x6d\x6c\103\157\x6e\x74\x65\156\x74\x20\75\40\x6e\x6f\144\145\56\x69\156\x6e\145\162\110\124\115\114\73\15\xa\x74\x65\x78\164\x20\x3d\x20\x6e\157\144\x65\x2e\164\145\x78\164\103\157\x6e\164\145\156\x74\x3b\xd\12\x64\x6f\167\156\x6c\157\x61\144\x28\146\x69\x6c\145\156\x61\x6d\x65\54\40\x74\145\170\x74\51\x3b\xd\xa\175\x2c\x20\x66\141\x6c\x73\145\x29\73\xd\12\xd\xa\xd\xa\xd\xa\15\12\xd\xa\x3c\57\x73\x63\162\x69\160\164\76\15\xa";
    exit;
}
function mo_saml_checkMapping($Mr, $fG, $ri)
{
    try {
        $Iy = get_site_option("\x73\141\x6d\x6c\x5f\x61\x6d\137\x65\155\141\x69\154");
        $fj = get_site_option("\163\x61\x6d\154\137\141\x6d\x5f\x75\163\x65\x72\x6e\141\155\145");
        $C3 = get_site_option("\163\141\x6d\154\137\x61\155\137\146\x69\162\x73\x74\137\x6e\141\155\145");
        $w6 = get_site_option("\x73\x61\x6d\x6c\137\141\155\x5f\154\x61\x73\164\x5f\156\x61\x6d\x65");
        $cg = get_site_option("\163\x61\155\x6c\137\141\x6d\137\x67\x72\157\x75\160\x5f\x6e\x61\155\145");
        $ZF = array();
        $ZF = maybe_unserialize(get_site_option("\x73\x61\x6d\154\x5f\x61\x6d\137\x72\157\x6c\145\137\x6d\141\x70\x70\151\x6e\147"));
        $zl = get_site_option("\163\141\155\154\x5f\141\x6d\x5f\x61\x63\143\157\165\x6e\x74\x5f\155\141\x74\143\x68\x65\162");
        $JY = '';
        $c2 = '';
        if (empty($Mr)) {
            goto CSA;
        }
        if (!empty($C3) && array_key_exists($C3, $Mr)) {
            goto b6A;
        }
        $C3 = '';
        goto SyA;
        b6A:
        $C3 = $Mr[$C3][0];
        SyA:
        if (!empty($w6) && array_key_exists($w6, $Mr)) {
            goto jJR;
        }
        $w6 = '';
        goto Qtj;
        jJR:
        $w6 = $Mr[$w6][0];
        Qtj:
        if (!empty($fj) && array_key_exists($fj, $Mr)) {
            goto eLu;
        }
        $c2 = $Mr["\x4e\x61\x6d\145\111\104"][0];
        goto aHL;
        eLu:
        $c2 = $Mr[$fj][0];
        aHL:
        if (!empty($Iy) && array_key_exists($Iy, $Mr)) {
            goto mRY;
        }
        $JY = $Mr["\x4e\141\x6d\145\111\x44"][0];
        goto PlV;
        mRY:
        $JY = $Mr[$Iy][0];
        PlV:
        if (!empty($cg) && array_key_exists($cg, $Mr)) {
            goto xbY;
        }
        $cg = array();
        goto hvr;
        xbY:
        $cg = $Mr[$cg];
        hvr:
        if (!empty($zl)) {
            goto yEa;
        }
        $zl = "\x65\155\141\x69\x6c";
        yEa:
        CSA:
        if ($fG == "\164\x65\x73\164\x56\141\154\x69\x64\141\164\145") {
            goto Szf;
        }
        if ($fG == "\164\145\163\164\116\145\167\103\145\162\x74\151\x66\x69\143\x61\x74\145") {
            goto G0G;
        }
        mo_saml_login_user($JY, $C3, $w6, $c2, $cg, $ZF, $fG, $zl, $ri, $Mr["\116\141\155\145\111\104"][0], $Mr);
        goto ksC;
        Szf:
        update_site_option("\155\x6f\137\163\141\x6d\x6c\137\164\145\x73\164", "\x54\x65\x73\164\x20\x53\x75\x63\x63\x65\163\163\146\x75\x6c");
        mo_saml_show_test_result($C3, $w6, $JY, $cg, $Mr, $fG);
        goto ksC;
        G0G:
        update_site_option("\155\x6f\x5f\163\141\x6d\x6c\x5f\164\145\163\164\x5f\x6e\145\x77\x5f\143\x65\162\164", "\124\x65\163\164\40\163\165\x63\x63\x65\163\x73\x66\165\154");
        mo_saml_show_test_result($C3, $w6, $JY, $cg, $Mr, $fG);
        ksC:
    } catch (Exception $aW) {
        echo sprintf("\101\156\40\145\162\x72\x6f\162\40\x6f\x63\x63\x75\162\162\145\x64\x20\167\150\151\154\x65\40\x70\x72\157\x63\x65\x73\x73\151\x6e\147\40\x74\150\145\40\123\x41\115\x4c\40\x52\145\x73\x70\x6f\156\163\145\x2e");
        exit;
    }
}
function mo_saml_show_test_result($C3, $w6, $JY, $cg, $Mr, $fG)
{
    echo "\x3c\x64\151\x76\x20\163\164\171\x6c\145\75\42\146\x6f\156\x74\55\x66\x61\155\151\x6c\x79\72\103\x61\154\151\142\x72\x69\x3b\160\141\144\144\151\x6e\147\x3a\x30\x20\x33\x25\73\42\x3e";
    if (!empty($JY)) {
        goto PEX;
    }
    echo "\74\144\151\x76\x20\x73\x74\171\154\x65\75\42\x63\x6f\154\157\x72\x3a\40\43\x61\x39\64\x34\x34\x32\73\x62\x61\x63\x6b\x67\162\157\x75\x6e\x64\55\143\x6f\x6c\157\162\x3a\40\43\146\62\x64\145\x64\x65\x3b\x70\x61\144\144\x69\156\x67\72\x20\61\x35\160\x78\73\155\141\x72\147\151\x6e\x2d\x62\157\164\164\x6f\155\x3a\40\x32\x30\x70\170\x3b\164\x65\x78\164\x2d\141\x6c\x69\x67\x6e\72\143\145\156\x74\145\162\x3b\x62\157\162\x64\x65\x72\72\61\160\x78\40\163\157\x6c\x69\x64\x20\43\x45\x36\x42\x33\102\62\x3b\x66\x6f\156\x74\55\163\x69\x7a\145\72\x31\x38\160\x74\x3b\x22\x3e\x54\x45\123\124\x20\106\101\111\x4c\105\104\74\x2f\x64\151\x76\x3e\xd\12\40\40\x20\40\x20\40\x20\x20\74\144\151\166\x20\x73\164\x79\x6c\145\75\x22\143\x6f\154\x6f\x72\72\x20\43\x61\71\64\64\x34\62\x3b\x66\157\x6e\164\55\163\151\x7a\145\x3a\61\64\x70\x74\73\x20\155\x61\x72\x67\x69\x6e\55\142\157\x74\x74\x6f\x6d\72\x32\60\160\x78\73\x22\76\127\x41\x52\x4e\111\x4e\107\72\40\x53\x6f\155\145\x20\x41\x74\x74\x72\x69\142\165\x74\x65\x73\x20\x44\151\144\40\x4e\x6f\x74\x20\115\141\x74\143\150\x2e\74\x2f\x64\x69\166\x3e\15\xa\x20\40\x20\40\x20\x20\40\x20\x3c\x64\x69\x76\x20\x73\x74\x79\x6c\145\75\42\x64\x69\x73\160\x6c\141\x79\72\x62\154\x6f\143\x6b\x3b\164\145\170\164\x2d\x61\x6c\x69\147\x6e\72\143\x65\156\x74\145\x72\73\155\141\162\x67\151\156\55\142\157\x74\164\x6f\155\72\64\x25\x3b\x22\x3e\74\x69\x6d\x67\x20\x73\x74\x79\154\145\x3d\x22\x77\151\x64\x74\x68\72\61\65\x25\x3b\x22\x73\162\x63\x3d\x22" . plugin_dir_url(__FILE__) . "\151\x6d\141\147\x65\x73\57\x77\162\157\x6e\147\x2e\x70\x6e\x67\x22\x3e\74\57\144\151\166\76";
    goto jj7;
    PEX:
    update_site_option("\155\157\137\x73\141\155\x6c\137\164\x65\163\164\x5f\143\157\156\x66\x69\x67\137\141\x74\164\x72\x73", $Mr);
    echo "\74\144\151\166\x20\163\164\x79\x6c\145\75\42\x63\157\154\x6f\x72\x3a\x20\43\x33\143\x37\66\x33\x64\x3b\xd\12\x20\40\x20\x20\x20\40\x20\40\142\141\x63\x6b\147\162\x6f\x75\156\x64\x2d\143\x6f\x6c\x6f\x72\x3a\40\x23\x64\146\x66\60\144\x38\73\x20\x70\x61\144\x64\x69\156\x67\x3a\x32\45\x3b\155\141\x72\x67\x69\x6e\55\x62\157\x74\164\x6f\x6d\x3a\x32\x30\x70\x78\x3b\x74\x65\170\164\x2d\x61\x6c\151\147\156\72\143\145\156\x74\x65\x72\73\40\x62\x6f\x72\x64\145\162\72\x31\160\x78\40\163\157\x6c\151\x64\40\x23\101\105\104\102\x39\x41\73\40\146\157\x6e\x74\x2d\163\x69\172\145\72\x31\70\160\164\x3b\x22\76\124\x45\x53\x54\40\x53\x55\103\x43\x45\123\x53\x46\125\x4c\74\x2f\144\x69\x76\x3e\xd\12\40\40\x20\x20\40\40\x20\x20\x3c\144\x69\166\x20\x73\x74\x79\154\145\x3d\42\x64\151\163\160\154\x61\171\72\142\154\157\143\x6b\73\164\145\x78\164\x2d\x61\154\x69\147\x6e\72\143\145\x6e\164\145\162\73\x6d\x61\x72\x67\x69\156\x2d\142\x6f\x74\x74\x6f\155\72\64\45\x3b\x22\76\x3c\151\155\x67\x20\x73\164\x79\154\x65\x3d\x22\167\151\144\x74\150\72\61\65\45\73\x22\163\162\x63\75\x22" . plugin_dir_url(__FILE__) . "\x69\155\141\x67\145\x73\x2f\x67\162\145\x65\156\137\x63\150\145\143\x6b\56\x70\x6e\147\42\x3e\x3c\x2f\x64\151\x76\x3e";
    jj7:
    $RN = $fG == "\x74\145\x73\x74\x4e\x65\x77\103\x65\x72\164\x69\x66\151\143\x61\x74\145" ? "\144\151\x73\x70\x6c\141\x79\x3a\x6e\157\156\x65" : '';
    $xU = get_site_option("\x73\x61\x6d\154\137\141\x6d\x5f\141\x63\x63\x6f\x75\x6e\x74\137\x6d\141\164\143\x68\x65\x72") ? get_site_option("\x73\141\155\154\137\x61\x6d\137\141\143\x63\x6f\x75\156\x74\137\155\x61\164\x63\x68\x65\x72") : "\145\155\x61\x69\x6c";
    if (!($xU == "\x65\x6d\x61\x69\x6c" && !filter_var($Mr["\x4e\141\155\x65\111\104"][0], FILTER_VALIDATE_EMAIL))) {
        goto umb;
    }
    echo "\74\x70\x3e\74\146\x6f\156\x74\x20\x63\157\154\157\x72\75\42\x23\106\106\x30\x30\60\x30\x22\x20\163\x74\171\154\x65\75\x22\x66\157\156\164\x2d\163\x69\172\x65\72\x31\64\160\x74\x22\x3e\x28\127\141\162\156\x69\x6e\147\72\40\124\150\145\x20\116\x61\155\145\x49\104\40\x76\x61\x6c\x75\145\x20\151\163\40\156\157\164\x20\x61\40\x76\x61\154\151\x64\40\105\x6d\141\151\154\x20\111\104\x29\74\57\146\157\156\164\x3e\74\57\x70\x3e";
    umb:
    echo "\x3c\163\x70\x61\x6e\x20\x73\x74\x79\x6c\145\75\42\146\157\x6e\x74\55\x73\151\x7a\x65\72\x31\x34\x70\x74\73\x22\x3e\74\142\x3e\110\x65\154\x6c\x6f\74\57\142\x3e\x2c\40" . $JY . "\74\57\x73\160\x61\x6e\x3e\74\142\162\57\x3e\74\160\40\x73\x74\x79\154\x65\x3d\x22\x66\157\156\164\55\167\145\x69\147\x68\x74\x3a\x62\x6f\x6c\x64\x3b\146\x6f\156\164\x2d\163\x69\172\145\72\x31\x34\160\x74\x3b\x6d\141\x72\x67\151\156\55\154\145\x66\164\x3a\61\45\73\x22\x3e\x41\x54\x54\x52\111\102\125\124\105\123\40\x52\x45\103\105\x49\126\105\104\x3a\x3c\57\x70\76\xd\12\40\40\x20\40\74\164\x61\142\154\x65\x20\163\164\x79\154\x65\x3d\x22\x62\157\162\x64\145\162\x2d\x63\x6f\154\x6c\141\160\x73\145\72\x63\x6f\x6c\x6c\141\160\163\x65\73\142\157\162\144\x65\162\x2d\x73\x70\x61\x63\151\156\x67\72\60\x3b\x20\144\151\x73\x70\154\x61\x79\72\x74\141\142\154\x65\x3b\x77\x69\x64\164\150\72\61\x30\x30\x25\x3b\40\146\157\x6e\x74\55\x73\151\x7a\x65\72\x31\x34\x70\x74\73\x62\141\143\x6b\147\162\157\x75\x6e\x64\55\x63\157\154\x6f\x72\x3a\43\105\104\105\104\105\104\x3b\42\x3e\15\12\x20\40\x20\x20\40\40\40\x20\74\164\x72\40\x73\164\171\x6c\x65\x3d\42\x74\x65\170\164\55\x61\154\x69\147\x6e\72\143\x65\156\x74\145\x72\73\42\x3e\x3c\x74\144\40\x73\x74\x79\x6c\x65\75\x22\x66\157\156\x74\55\x77\145\151\x67\x68\x74\72\x62\x6f\x6c\x64\x3b\x62\x6f\x72\x64\x65\162\72\62\160\x78\40\163\157\x6c\151\x64\x20\x23\71\64\x39\x30\x39\x30\x3b\160\141\x64\144\151\x6e\147\x3a\62\45\x3b\x22\x3e\101\x54\x54\122\x49\102\x55\124\105\40\116\101\x4d\x45\x3c\57\x74\144\x3e\74\164\144\x20\163\x74\x79\154\x65\x3d\42\146\157\156\x74\x2d\x77\145\151\147\x68\164\x3a\x62\x6f\154\144\73\160\x61\144\144\151\156\x67\x3a\x32\45\x3b\142\157\x72\144\145\162\72\x32\x70\x78\x20\163\x6f\x6c\x69\x64\40\x23\71\x34\x39\60\71\60\x3b\40\167\157\x72\x64\55\167\162\x61\160\72\142\162\x65\141\x6b\x2d\x77\x6f\x72\x64\x3b\42\76\x41\x54\124\122\111\x42\x55\124\x45\40\x56\101\114\125\x45\x3c\x2f\164\x64\76\74\x2f\164\x72\x3e";
    if (!empty($Mr)) {
        goto rO8;
    }
    echo "\116\157\40\x41\x74\x74\x72\151\x62\165\164\145\x73\40\x52\145\x63\x65\151\166\x65\x64\56";
    goto rYp;
    rO8:
    foreach ($Mr as $ez => $T5) {
        echo "\74\x74\x72\76\74\x74\144\x20\x73\164\171\x6c\145\75\47\x66\157\156\x74\55\x77\x65\x69\147\x68\x74\72\x62\157\x6c\144\73\x62\157\162\144\145\162\x3a\62\x70\x78\40\163\x6f\154\x69\x64\40\43\71\x34\71\60\x39\x30\73\160\x61\144\x64\x69\156\147\72\x32\x25\73\47\76" . $ez . "\74\57\x74\144\x3e\74\x74\x64\x20\x73\x74\x79\154\145\75\47\x70\141\x64\x64\x69\156\x67\x3a\62\45\x3b\142\x6f\162\144\x65\162\72\x32\160\x78\x20\x73\157\154\151\x64\x20\x23\x39\64\x39\x30\71\x30\73\40\x77\x6f\x72\x64\55\167\x72\x61\x70\72\x62\x72\145\x61\x6b\55\167\x6f\162\x64\73\x27\x3e" . implode("\x3c\150\x72\x2f\76", $T5) . "\x3c\57\x74\144\76\74\57\x74\x72\76";
        xlt:
    }
    p4Y:
    rYp:
    echo "\74\57\164\x61\x62\154\145\x3e\74\x2f\144\x69\x76\76";
    echo "\x3c\x64\151\166\40\x73\x74\171\x6c\x65\75\42\155\141\162\x67\151\x6e\x3a\x33\x25\73\x64\151\x73\160\154\x61\171\x3a\x62\154\157\x63\x6b\x3b\x74\x65\170\x74\55\x61\154\x69\x67\156\72\143\x65\x6e\164\x65\x72\x3b\x22\76\xd\12\x20\40\40\40\x20\40\40\40\40\40\x20\40\x3c\151\156\x70\x75\164\40\163\164\171\154\x65\75\x22\x70\x61\x64\x64\151\156\147\x3a\x31\x25\73\x77\151\144\x74\150\72\62\65\60\x70\x78\x3b\142\141\x63\x6b\147\162\x6f\x75\x6e\144\72\40\x23\x30\60\x39\61\x43\x44\x20\156\x6f\x6e\145\40\x72\145\160\145\141\164\x20\163\143\x72\157\x6c\154\x20\60\45\40\60\45\73\15\12\40\40\x20\x20\40\x20\x20\40\x20\x20\40\x20\x63\165\x72\x73\157\162\x3a\40\160\157\x69\x6e\x74\x65\162\73\x66\x6f\x6e\x74\55\163\151\x7a\x65\x3a\61\x35\x70\170\73\142\x6f\162\144\145\162\55\167\151\x64\164\150\72\x20\x31\x70\170\73\x62\157\x72\x64\x65\x72\x2d\x73\164\x79\154\145\72\40\x73\x6f\x6c\151\144\x3b\142\x6f\x72\x64\x65\162\55\x72\x61\x64\x69\165\x73\x3a\40\63\160\170\x3b\x77\x68\151\x74\145\x2d\x73\160\141\x63\145\x3a\15\12\40\40\x20\40\40\40\40\40\40\x20\40\40\156\157\167\x72\x61\x70\x3b\142\157\170\55\x73\x69\x7a\x69\156\x67\72\x20\x62\157\x72\x64\145\x72\55\142\x6f\170\73\x62\157\162\x64\145\x72\x2d\x63\157\x6c\x6f\162\72\40\x23\x30\x30\x37\63\101\x41\x3b\142\x6f\170\55\163\x68\x61\x64\x6f\167\72\x20\x30\160\170\x20\x31\x70\170\40\x30\160\x78\40\x72\147\142\x61\50\x31\62\x30\54\x20\x32\60\60\x2c\x20\62\x33\60\x2c\40\x30\x2e\x36\51\40\x69\156\x73\x65\x74\x3b\x63\157\x6c\x6f\162\72\40\x23\106\x46\x46\73" . $RN . "\x22\xd\12\x20\40\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\x20\40\x20\x74\x79\160\145\75\42\142\165\x74\x74\157\156\42\40\166\141\x6c\x75\x65\x3d\x22\x43\157\x6e\146\151\x67\x75\162\x65\x20\101\x74\x74\x72\151\142\x75\164\145\x2f\122\157\154\145\x20\x4d\141\160\x70\151\156\147\42\x20\x6f\x6e\x43\154\151\x63\153\75\42\x63\x6c\157\x73\145\137\x61\156\x64\x5f\x72\145\x64\151\x72\x65\143\x74\50\x29\73\x22\76\x20\46\156\x62\163\160\73\40\xd\12\x20\x20\40\40\x20\x20\40\x20\x20\x20\40\x20\x20\40\40\40\15\12\x20\x20\40\40\x20\x20\40\x20\x20\40\40\40\x3c\151\156\x70\x75\x74\x20\163\164\x79\154\x65\x3d\x22\x70\141\x64\144\x69\156\x67\72\61\x25\x3b\x77\x69\x64\164\150\72\x31\60\x30\x70\x78\x3b\142\x61\x63\x6b\x67\x72\157\165\156\144\72\x20\43\60\x30\71\x31\103\104\x20\x6e\157\x6e\145\40\x72\145\160\x65\x61\164\x20\163\x63\x72\x6f\154\x6c\x20\x30\x25\40\60\x25\x3b\143\x75\162\x73\x6f\x72\x3a\40\160\157\151\x6e\x74\145\162\73\146\157\x6e\164\x2d\x73\x69\172\x65\72\61\65\x70\170\x3b\142\x6f\162\x64\145\162\55\x77\x69\144\164\x68\x3a\40\x31\x70\170\x3b\x62\x6f\x72\144\x65\162\55\163\164\171\x6c\145\x3a\x20\163\157\154\151\x64\x3b\142\x6f\162\x64\x65\162\55\162\x61\144\151\x75\163\x3a\40\63\x70\170\73\167\x68\x69\x74\145\x2d\163\x70\141\143\x65\x3a\x20\156\x6f\x77\162\x61\x70\x3b\142\x6f\x78\x2d\x73\x69\x7a\151\x6e\147\x3a\x20\142\x6f\162\144\145\x72\x2d\x62\x6f\x78\x3b\142\x6f\x72\144\145\x72\55\143\157\x6c\x6f\x72\x3a\40\x23\60\60\x37\x33\x41\x41\x3b\142\x6f\x78\x2d\163\150\x61\x64\x6f\167\x3a\40\60\x70\x78\x20\61\160\x78\x20\60\160\x78\40\162\x67\142\x61\x28\x31\62\x30\x2c\40\x32\x30\60\x2c\40\62\63\60\x2c\40\60\x2e\x36\51\40\x69\x6e\x73\145\x74\x3b\x63\157\154\x6f\162\72\40\43\x46\x46\106\73\x22\x74\x79\160\145\x3d\42\142\x75\164\164\x6f\156\42\40\166\x61\x6c\165\x65\75\42\x44\157\x6e\145\x22\40\x6f\x6e\x43\x6c\x69\143\x6b\75\x22\163\145\x6c\x66\x2e\x63\154\x6f\163\x65\50\x29\73\42\x3e\x3c\57\x64\151\166\x3e\15\xa\x20\40\x20\40\40\40\40\x20\40\40\40\x20\x20\x20\x20\40\x20\40\40\x20\40\x20\x20\40\40\x20\x20\40\x20\40\x20\40\x3c\163\143\162\x69\160\x74\76\15\12\15\xa\40\40\x20\40\x20\x20\40\x20\40\40\40\40\x66\x75\x6e\x63\164\x69\x6f\x6e\40\x63\x6c\157\x73\145\x5f\141\x6e\x64\137\162\145\x64\x69\x72\145\143\164\50\x29\x7b\15\12\x20\40\x20\40\40\x20\40\40\40\x20\x20\40\40\x20\x20\x20\167\x69\156\x64\x6f\167\x2e\157\160\x65\156\x65\x72\x2e\162\145\x64\151\162\x65\x63\164\x5f\164\157\137\141\x74\164\162\x69\x62\165\164\x65\137\x6d\x61\160\160\151\156\x67\x28\x29\x3b\15\xa\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\x20\x20\x20\40\40\163\145\x6c\146\56\x63\154\157\163\x65\x28\x29\73\xd\12\x20\40\40\40\40\x20\40\40\40\40\40\40\x7d\xd\xa\40\40\40\x20\40\x20\x20\x20\x20\40\40\40\15\xa\40\x20\x20\40\x20\x20\40\x20\40\x20\40\40\146\x75\156\143\x74\151\157\x6e\40\x72\x65\x66\x72\x65\x73\x68\120\141\162\x65\x6e\x74\50\51\x20\173\15\12\40\40\40\x20\40\40\x20\40\x20\40\x20\40\x20\x20\40\40\167\151\156\144\x6f\x77\56\157\x70\x65\156\145\x72\x2e\x6c\x6f\x63\x61\164\151\157\156\x2e\x72\145\154\x6f\141\x64\50\51\73\15\12\x20\x20\x20\x20\x20\x20\40\x20\x20\40\40\x20\175\xd\12\x20\x20\40\x20\x20\40\40\40\40\40\40\40\x3c\x2f\163\x63\162\151\160\164\x3e";
    exit;
}
function mo_saml_convert_to_windows_iconv($z0)
{
    $BA = get_site_option("\x6d\157\137\163\x61\x6d\x6c\137\x65\156\143\x6f\144\151\156\x67\x5f\145\156\141\142\x6c\x65\x64");
    if (!($BA !== "\143\150\145\x63\x6b\145\x64")) {
        goto xoC;
    }
    return $z0;
    xoC:
    return iconv("\x55\124\x46\x2d\x38", "\x43\120\61\62\65\62\x2f\x2f\111\107\116\117\x52\105", $z0);
}
function mo_saml_login_user($JY, $C3, $w6, $c2, $cg, $ZF, $fG, $zl, $ri = '', $k9 = '', $Mr = null)
{
    do_action("\x6d\157\x5f\141\x62\162\x5f\x66\151\x6c\x74\145\x72\137\154\157\x67\151\156", $Mr);
    $c2 = mo_saml_sanitize_username($c2);
    if (get_site_option("\x6d\157\x5f\163\x61\x6d\x6c\137\x64\x69\x73\x61\142\x6c\x65\x5f\x72\157\x6c\x65\x5f\155\x61\160\160\x69\x6e\x67")) {
        goto it8;
    }
    check_if_user_allowed_to_login_due_to_role_restriction($cg);
    it8:
    $QU = get_site_option("\155\157\137\163\x61\155\154\137\x73\160\137\x62\x61\x73\x65\137\165\162\154");
    mo_saml_restrict_users_based_on_domain($JY);
    if (!empty($ZF)) {
        goto pNu;
    }
    $ZF["\104\105\106\101\x55\x4c\124"]["\144\145\x66\141\x75\154\164\x5f\162\x6f\154\145"] = "\x73\x75\142\163\x63\162\x69\142\x65\x72";
    $ZF["\104\x45\106\101\125\114\x54"]["\x64\157\x6e\x74\x5f\x61\154\x6c\x6f\167\137\x75\x6e\154\x69\163\164\145\144\x5f\x75\163\x65\162"] = '';
    $ZF["\x44\105\106\101\x55\x4c\124"]["\144\157\156\x74\x5f\x63\x72\145\141\164\x65\137\165\x73\x65\162"] = '';
    $ZF["\104\x45\106\101\x55\114\124"]["\153\145\145\160\x5f\145\170\x69\x73\164\x69\x6e\147\x5f\165\163\x65\x72\163\137\162\157\154\145"] = '';
    $ZF["\x44\105\x46\x41\x55\114\124"]["\155\x6f\x5f\x73\141\x6d\154\137\144\157\156\x74\137\141\154\154\157\x77\x5f\x75\163\145\x72\x5f\x74\157\x6c\x6f\147\151\x6e\137\x63\162\x65\x61\x74\x65\137\167\151\x74\x68\137\x67\x69\166\x65\x6e\137\x67\x72\x6f\x75\x70\163"] = '';
    $ZF["\x44\x45\x46\x41\125\x4c\124"]["\x6d\x6f\x5f\163\x61\x6d\x6c\137\x72\145\163\x74\x72\151\143\164\137\x75\x73\x65\162\163\137\x77\151\164\150\137\x67\x72\157\165\x70\163"] = '';
    pNu:
    global $wpdb;
    $Y3 = get_current_blog_id();
    $Ky = "\165\156\x63\150\145\x63\x6b\145\x64";
    if (!empty($QU)) {
        goto bu5;
    }
    $QU = get_network_site_url();
    bu5:
    if (email_exists($JY) || username_exists($c2)) {
        goto z2_;
    }
    $KX = Utilities::get_active_sites();
    $HL = get_site_option("\155\157\137\141\x70\160\154\x79\x5f\162\x6f\x6c\x65\x5f\x6d\x61\x70\160\151\156\147\137\146\157\162\137\x73\x69\164\x65\163");
    if (!get_site_option("\x6d\157\137\163\141\155\x6c\137\144\151\x73\141\x62\x6c\145\137\x72\x6f\x6c\145\137\155\x61\x70\x70\x69\156\x67")) {
        goto CTt;
    }
    $KI = wp_generate_password(12, false);
    $QK = wpmu_create_user($c2, $KI, $JY);
    goto z4a;
    CTt:
    $QK = mo_saml_assign_roles_to_new_user($KX, $HL, $ZF, $cg, $c2, $JY);
    z4a:
    switch_to_blog($Y3);
    if (!empty($QK)) {
        goto vgm;
    }
    if (!get_site_option("\x6d\157\x5f\x73\141\x6d\x6c\137\x64\151\x73\x61\x62\154\145\137\162\x6f\x6c\145\x5f\155\x61\160\x70\x69\156\147")) {
        goto HZJ;
    }
    wp_die("\x57\x65\x20\143\x6f\165\154\144\x20\156\x6f\164\40\163\x69\x67\156\x20\x79\x6f\165\x20\151\156\56\40\x50\154\145\x61\163\x65\40\x63\157\156\x74\141\x63\164\40\x61\x64\x6d\151\x6e\151\163\x74\x72\141\164\157\x72", "\114\x6f\x67\x69\156\40\106\141\151\x6c\145\x64\41");
    goto WWS;
    HZJ:
    $I7 = get_site_option("\x6d\157\137\163\141\x6d\x6c\x5f\x61\143\143\x6f\x75\x6e\x74\x5f\143\x72\x65\141\x74\151\157\156\137\x64\151\x73\141\142\x6c\x65\x64\137\x6d\163\x67");
    if (!empty($I7)) {
        goto kJY;
    }
    $I7 = "\127\145\x20\143\157\x75\x6c\x64\x20\156\x6f\x74\40\163\x69\x67\156\x20\171\157\165\40\x69\156\56\40\x50\154\145\141\x73\x65\40\143\157\156\x74\x61\x63\x74\40\171\157\165\x72\40\101\144\155\x69\156\151\163\x74\162\x61\164\157\162\x2e";
    kJY:
    wp_die($I7, "\105\x72\162\157\162\x3a\40\x4e\x6f\164\x20\141\x20\127\157\162\144\x50\162\145\163\163\x20\115\x65\x6d\142\x65\x72");
    WWS:
    vgm:
    $user = get_user_by("\151\144", $QK);
    mo_saml_map_basic_attributes($user, $C3, $w6, $Mr);
    mo_saml_map_custom_attributes($QK, $Mr);
    $GG = mo_saml_get_redirect_url($QU, $fG);
    do_action("\155\x69\x6e\151\157\x72\x61\x6e\147\x65\137\x70\x6f\x73\x74\x5f\141\x75\164\150\145\156\x74\151\x63\x61\164\145\137\x75\x73\145\162\x5f\x6c\157\x67\151\156", $user, null, $GG, true);
    mo_saml_set_auth_cookie($user, $ri, $k9, true);
    do_action("\x6d\157\x5f\163\141\x6d\154\137\x61\x74\x74\x72\x69\x62\x75\x74\x65\x73", $c2, $JY, $C3, $w6, $cg, null, true);
    goto qZW;
    z2_:
    if (email_exists($JY)) {
        goto qD3;
    }
    $user = get_user_by("\154\157\147\151\156", $c2);
    goto glg;
    qD3:
    $user = get_user_by("\145\155\x61\151\x6c", $JY);
    glg:
    $QK = $user->ID;
    if (!(!empty($JY) and strcasecmp($JY, $user->user_email) != 0)) {
        goto f1U;
    }
    $QK = wp_update_user(array("\x49\104" => $QK, "\x75\x73\x65\x72\x5f\x65\155\x61\151\x6c" => $JY));
    f1U:
    mo_saml_map_basic_attributes($user, $C3, $w6, $Mr);
    mo_saml_map_custom_attributes($QK, $Mr);
    $KX = Utilities::get_active_sites();
    $HL = get_site_option("\155\x6f\x5f\141\x70\160\x6c\x79\x5f\x72\157\x6c\145\137\155\x61\160\160\151\x6e\x67\x5f\146\x6f\162\137\163\151\x74\145\163");
    if (get_site_option("\155\157\137\163\x61\x6d\x6c\x5f\144\151\x73\x61\x62\x6c\145\x5f\162\x6f\x6c\145\x5f\x6d\141\x70\160\151\x6e\147")) {
        goto Lqp;
    }
    foreach ($KX as $blog_id) {
        switch_to_blog($blog_id);
        $user = get_user_by("\x69\144", $QK);
        $rj = '';
        if ($HL) {
            goto nwe;
        }
        $rj = $blog_id;
        goto IMC;
        nwe:
        $rj = 0;
        IMC:
        if (empty($ZF)) {
            goto N4a;
        }
        if (!empty($ZF[$rj])) {
            goto Af5;
        }
        if (!empty($ZF["\104\x45\x46\x41\x55\x4c\x54"])) {
            goto zhR;
        }
        $BN = "\x73\165\x62\163\143\162\151\142\x65\162";
        $xZ = '';
        $Ky = '';
        $lv = '';
        goto rPh;
        zhR:
        $BN = isset($ZF["\x44\x45\x46\101\x55\114\124"]["\144\145\146\x61\165\154\164\137\162\x6f\x6c\145"]) ? $ZF["\x44\105\106\x41\125\x4c\x54"]["\144\x65\x66\141\x75\154\164\137\162\157\x6c\145"] : "\163\165\142\x73\x63\x72\151\x62\x65\x72";
        $xZ = isset($ZF["\x44\x45\x46\101\x55\114\124"]["\x64\x6f\156\x74\x5f\141\x6c\x6c\157\167\137\x75\x6e\x6c\151\163\164\x65\x64\137\x75\x73\145\162"]) ? $ZF["\x44\105\x46\101\x55\x4c\x54"]["\x64\x6f\x6e\164\x5f\x61\x6c\154\157\x77\x5f\x75\156\x6c\x69\163\x74\145\x64\x5f\x75\x73\x65\x72"] : '';
        $Ky = isset($ZF["\104\105\x46\101\x55\114\x54"]["\144\157\x6e\164\137\x63\162\x65\141\x74\145\137\165\163\145\x72"]) ? $ZF["\x44\x45\106\x41\x55\x4c\x54"]["\x64\157\156\x74\137\x63\x72\145\x61\x74\145\x5f\x75\x73\x65\x72"] : '';
        $lv = isset($ZF["\x44\105\106\101\x55\114\124"]["\153\x65\145\x70\137\145\170\151\163\x74\x69\x6e\x67\137\x75\x73\x65\162\x73\x5f\x72\157\x6c\x65"]) ? $ZF["\x44\x45\106\101\125\114\124"]["\x6b\x65\145\x70\137\145\170\151\163\164\x69\x6e\147\137\165\163\x65\162\163\137\x72\157\x6c\145"] : '';
        rPh:
        goto r5D;
        Af5:
        $BN = isset($ZF[$rj]["\144\x65\x66\x61\x75\154\164\x5f\162\x6f\x6c\x65"]) ? $ZF[$rj]["\144\145\x66\141\165\x6c\164\x5f\x72\157\x6c\x65"] : '';
        $xZ = isset($ZF[$rj]["\x64\x6f\x6e\x74\x5f\141\154\x6c\157\x77\x5f\165\156\154\151\x73\x74\x65\144\137\165\163\x65\x72"]) ? $ZF[$rj]["\x64\157\x6e\164\x5f\141\154\154\157\167\x5f\x75\156\x6c\x69\163\164\145\x64\x5f\x75\163\145\162"] : '';
        $Ky = isset($ZF[$rj]["\x64\x6f\156\x74\x5f\143\x72\145\141\164\x65\x5f\x75\x73\x65\162"]) ? $ZF[$rj]["\x64\157\x6e\x74\x5f\x63\162\x65\x61\x74\x65\137\165\163\145\x72"] : '';
        $lv = isset($ZF[$rj]["\153\145\x65\160\137\145\170\151\x73\x74\x69\156\x67\x5f\x75\x73\x65\x72\163\137\x72\157\154\x65"]) ? $ZF[$rj]["\153\145\x65\x70\137\x65\x78\151\163\x74\x69\x6e\147\137\165\x73\x65\x72\163\137\x72\x6f\154\x65"] : '';
        r5D:
        N4a:
        if (!is_user_member_of_blog($QK, $blog_id)) {
            goto IaC;
        }
        if (isset($lv) && $lv == "\143\150\145\x63\x6b\x65\144") {
            goto HZW;
        }
        $ob = assign_roles_to_user($user, $ZF, $blog_id, $cg, $rj);
        goto kmo;
        HZW:
        $ob = false;
        kmo:
        if (is_administrator_user($user)) {
            goto nLv;
        }
        if (isset($lv) && $lv == "\143\x68\145\x63\x6b\145\144") {
            goto N1E;
        }
        if ($ob !== true && !empty($xZ) && $xZ == "\x63\150\x65\x63\153\x65\144") {
            goto h3U;
        }
        if ($ob !== true && !empty($BN) && $BN !== "\x66\x61\x6c\163\145") {
            goto l7K;
        }
        if ($ob !== true && is_user_member_of_blog($QK, $blog_id)) {
            goto xEg;
        }
        goto pGd;
        N1E:
        goto pGd;
        h3U:
        $QK = wp_update_user(array("\x49\x44" => $QK, "\162\x6f\154\x65" => false));
        goto pGd;
        l7K:
        $QK = wp_update_user(array("\x49\104" => $QK, "\162\157\154\x65" => $BN));
        goto pGd;
        xEg:
        $lS = get_site_option("\144\145\146\x61\x75\x6c\164\137\162\x6f\154\145");
        $QK = wp_update_user(array("\111\104" => $QK, "\x72\157\154\145" => $lS));
        pGd:
        nLv:
        goto QER;
        IaC:
        $pf = TRUE;
        $a7 = get_site_option("\163\141\155\154\x5f\x73\x73\157\x5f\163\145\164\x74\x69\x6e\x67\x73");
        if (!empty($a7[$blog_id])) {
            goto so9;
        }
        $a7[$blog_id] = $a7["\104\x45\106\x41\125\114\124"];
        so9:
        if (empty($ZF)) {
            goto AHe;
        }
        if (array_key_exists($rj, $ZF)) {
            goto SUu;
        }
        if (!array_key_exists("\104\x45\106\x41\x55\x4c\124", $ZF)) {
            goto TpI;
        }
        $im = get_saml_roles_to_assign($ZF, $rj, $cg);
        if (!(empty($im) && strcmp($ZF["\x44\x45\x46\101\125\114\x54"]["\144\x6f\156\164\x5f\143\x72\x65\141\x74\x65\137\165\x73\x65\x72"], "\x63\x68\145\143\x6b\x65\x64") == 0)) {
            goto lFZ;
        }
        $pf = FALSE;
        lFZ:
        TpI:
        goto CO3;
        SUu:
        $im = get_saml_roles_to_assign($ZF, $rj, $cg);
        if (!(empty($im) && strcmp($ZF[$rj]["\144\157\156\x74\137\143\162\145\x61\x74\x65\x5f\x75\x73\x65\x72"], "\143\150\145\x63\x6b\145\144") == 0)) {
            goto dj9;
        }
        $pf = FALSE;
        dj9:
        CO3:
        AHe:
        if (!$pf) {
            goto SzG;
        }
        add_user_to_blog($blog_id, $QK, false);
        $ob = assign_roles_to_user($user, $ZF, $blog_id, $cg, $rj);
        if ($ob !== true && !empty($xZ) && $xZ == "\143\x68\x65\143\153\x65\x64") {
            goto mJx;
        }
        if ($ob !== true && !empty($BN) && $BN !== "\146\141\x6c\163\145") {
            goto e91;
        }
        if ($ob !== true) {
            goto jLI;
        }
        goto KSH;
        mJx:
        $QK = wp_update_user(array("\x49\x44" => $QK, "\162\x6f\x6c\145" => false));
        goto KSH;
        e91:
        $QK = wp_update_user(array("\111\x44" => $QK, "\x72\157\154\145" => $BN));
        goto KSH;
        jLI:
        $lS = get_site_option("\144\145\146\141\x75\154\164\137\162\x6f\x6c\x65");
        $QK = wp_update_user(array("\x49\x44" => $QK, "\x72\157\154\x65" => $lS));
        KSH:
        SzG:
        QER:
        EeR:
    }
    u5p:
    Lqp:
    switch_to_blog($Y3);
    if ($QK) {
        goto nlx;
    }
    wp_die("\x49\156\x76\x61\x6c\151\x64\40\x75\x73\145\162\56\x20\x50\x6c\x65\x61\163\x65\40\164\162\171\x20\141\147\x61\x69\x6e\x2e");
    nlx:
    $user = get_user_by("\151\144", $QK);
    mo_saml_set_auth_cookie($user, $ri, $k9, true);
    do_action("\x6d\157\x5f\x73\x61\x6d\154\x5f\141\x74\164\162\151\142\x75\164\145\x73", $c2, $JY, $C3, $w6, $cg);
    qZW:
    mo_saml_post_login_redirection($QU, $fG);
}
function mo_saml_add_user_to_blog($JY, $c2, $blog_id = 0)
{
    if (email_exists($JY)) {
        goto Ucj;
    }
    if (!empty($c2)) {
        goto rzX;
    }
    $QK = mo_saml_create_user($JY, $JY, $blog_id);
    goto fYr;
    rzX:
    $QK = mo_saml_create_user($c2, $JY, $blog_id);
    fYr:
    goto msI;
    Ucj:
    $user = get_user_by("\145\155\x61\151\x6c", $JY);
    $QK = $user->ID;
    if (empty($blog_id)) {
        goto lJx;
    }
    add_user_to_blog($blog_id, $QK, false);
    lJx:
    msI:
    return $QK;
}
function mo_saml_create_user($c2, $JY, $blog_id)
{
    $rc = wp_generate_password(10, false);
    if (username_exists($c2)) {
        goto t0m;
    }
    $QK = wp_create_user($c2, $rc, $JY);
    goto hGo;
    t0m:
    $user = get_user_by("\x6c\157\x67\151\x6e", $c2);
    $QK = $user->ID;
    if (!$blog_id) {
        goto w7u;
    }
    add_user_to_blog($blog_id, $QK, false);
    w7u:
    hGo:
    if (!is_wp_error($QK)) {
        goto Bo2;
    }
    echo "\x3c\163\x74\162\x6f\156\x67\76\x45\122\x52\117\x52\x3c\x2f\163\164\162\157\x6e\147\x3e\x3a\40\x45\x6d\x70\164\x79\40\125\163\x65\x72\40\x4e\141\x6d\x65\40\x61\156\x64\40\x45\155\141\151\x6c\56\40\120\x6c\145\x61\x73\145\x20\143\x6f\x6e\164\x61\x63\164\40\171\x6f\165\x72\x20\141\x64\x6d\151\156\x69\x73\164\x72\x61\164\x6f\x72\x2e";
    exit;
    Bo2:
    return $QK;
}
function mo_saml_assign_roles_to_new_user($KX, $HL, $ZF, $cg, $c2, $JY)
{
    global $wpdb;
    $user = NULL;
    $KZ = false;
    foreach ($KX as $blog_id) {
        $QG = TRUE;
        $rj = '';
        if ($HL) {
            goto U3o;
        }
        $rj = $blog_id;
        goto HTK;
        U3o:
        $rj = 0;
        HTK:
        $a7 = get_site_option("\x73\141\155\154\x5f\x73\x73\157\137\x73\145\164\164\x69\156\x67\x73");
        if (!empty($a7[$blog_id])) {
            goto xwX;
        }
        $a7[$blog_id] = $a7["\x44\105\x46\x41\125\114\124"];
        xwX:
        if (empty($ZF)) {
            goto CBu;
        }
        if (!empty($ZF[$rj])) {
            goto Puh;
        }
        if (!empty($ZF["\104\105\x46\x41\x55\x4c\124"])) {
            goto zmD;
        }
        $BN = "\x73\165\142\163\143\162\x69\142\145\162";
        $xZ = '';
        $lv = '';
        $im = '';
        goto MRc;
        zmD:
        $BN = isset($ZF["\x44\x45\x46\101\125\x4c\x54"]["\x64\x65\x66\x61\165\154\164\x5f\162\157\x6c\x65"]) ? $ZF["\104\x45\x46\x41\125\114\x54"]["\x64\x65\146\141\x75\x6c\x74\x5f\162\x6f\154\x65"] : '';
        $xZ = isset($ZF["\x44\x45\106\x41\x55\114\124"]["\x64\157\156\164\137\141\x6c\x6c\x6f\167\137\x75\x6e\x6c\151\x73\164\x65\x64\x5f\x75\x73\145\x72"]) ? $ZF["\104\x45\106\101\125\x4c\124"]["\144\157\156\x74\x5f\141\154\154\x6f\x77\137\165\x6e\x6c\x69\163\x74\x65\x64\x5f\x75\x73\145\162"] : '';
        $lv = array_key_exists("\153\145\x65\160\x5f\145\170\151\163\164\x69\156\x67\x5f\165\x73\x65\162\163\137\162\x6f\154\145", $ZF["\104\105\106\x41\x55\x4c\124"]) ? $ZF["\x44\x45\106\101\x55\114\124"]["\x6b\x65\x65\160\137\145\170\x69\163\164\x69\x6e\x67\137\x75\163\145\x72\x73\137\162\157\x6c\145"] : '';
        $im = get_saml_roles_to_assign($ZF, $rj, $cg);
        if (!(empty($im) && strcmp($ZF["\104\x45\x46\x41\x55\x4c\124"]["\144\x6f\156\x74\137\x63\162\x65\141\x74\x65\x5f\x75\x73\x65\162"], "\x63\x68\x65\143\153\x65\144") == 0)) {
            goto yUi;
        }
        $QG = FALSE;
        yUi:
        MRc:
        goto Xby;
        Puh:
        $BN = isset($ZF[$rj]["\x64\145\146\x61\x75\154\164\x5f\x72\x6f\x6c\145"]) ? $ZF[$rj]["\144\x65\x66\141\165\154\164\x5f\162\157\154\x65"] : '';
        $xZ = isset($ZF[$rj]["\x64\x6f\156\x74\x5f\141\154\x6c\157\167\x5f\x75\156\x6c\x69\163\164\x65\x64\137\165\163\x65\162"]) ? $ZF[$rj]["\x64\x6f\x6e\x74\x5f\141\x6c\154\x6f\167\x5f\x75\156\x6c\x69\163\x74\x65\x64\137\165\x73\x65\162"] : '';
        $lv = array_key_exists("\x6b\145\145\160\x5f\x65\170\151\x73\164\151\156\x67\x5f\165\x73\x65\162\x73\x5f\162\157\x6c\145", $ZF[$rj]) ? $ZF[$rj]["\x6b\x65\x65\160\x5f\145\170\x69\163\x74\151\x6e\x67\x5f\165\x73\145\162\x73\x5f\x72\x6f\x6c\x65"] : '';
        $im = get_saml_roles_to_assign($ZF, $rj, $cg);
        if (!(empty($im) && strcmp($ZF[$rj]["\x64\157\x6e\x74\137\x63\162\x65\141\x74\x65\137\x75\x73\145\x72"], "\143\150\145\x63\153\145\x64") == 0)) {
            goto rbq;
        }
        $QG = FALSE;
        rbq:
        Xby:
        CBu:
        if (!$QG) {
            goto lJp;
        }
        $QK = NULL;
        switch_to_blog($blog_id);
        $QK = mo_saml_add_user_to_blog($JY, $c2, $blog_id);
        $user = get_user_by("\151\x64", $QK);
        $ob = assign_roles_to_user($user, $ZF, $blog_id, $cg, $rj);
        if ($ob !== true && !empty($xZ) && $xZ == "\143\150\x65\143\153\x65\144") {
            goto U0c;
        }
        if ($ob !== true && !empty($BN) && $BN !== "\146\x61\x6c\x73\x65") {
            goto mfm;
        }
        if ($ob !== true) {
            goto UkB;
        }
        goto MC2;
        U0c:
        $QK = wp_update_user(array("\111\x44" => $QK, "\162\157\x6c\145" => false));
        goto MC2;
        mfm:
        $QK = wp_update_user(array("\111\104" => $QK, "\x72\157\x6c\x65" => $BN));
        goto MC2;
        UkB:
        $lS = get_site_option("\x64\145\x66\x61\165\x6c\x74\x5f\x72\157\x6c\145");
        $QK = wp_update_user(array("\111\x44" => $QK, "\x72\157\154\x65" => $lS));
        MC2:
        $Eo = $user->{$wpdb->prefix . "\x63\x61\160\x61\x62\x69\154\x69\164\x69\145\x73"};
        if (isset($wp_roles)) {
            goto s6m;
        }
        $wp_roles = new WP_Roles($rj);
        s6m:
        lJp:
        jPG:
    }
    v72:
    if (!empty($user)) {
        goto NBJ;
    }
    return;
    goto w6f;
    NBJ:
    return $user->ID;
    w6f:
}
function mo_saml_sanitize_username($c2)
{
    $BQ = sanitize_user($c2, true);
    $zx = apply_filters("\x70\162\145\137\x75\x73\145\x72\137\x6c\x6f\x67\151\x6e", $BQ);
    $c2 = trim($zx);
    return $c2;
}
function mo_saml_map_basic_attributes($user, $C3, $w6, $Mr)
{
    $QK = $user->ID;
    if (empty($C3)) {
        goto OTY;
    }
    $QK = wp_update_user(array("\111\x44" => $QK, "\146\x69\x72\x73\x74\x5f\x6e\141\x6d\145" => $C3));
    OTY:
    if (empty($w6)) {
        goto v9F;
    }
    $QK = wp_update_user(array("\x49\104" => $QK, "\154\x61\163\164\137\156\x61\x6d\x65" => $w6));
    v9F:
    if (is_null($Mr)) {
        goto KQP;
    }
    update_user_meta($QK, "\155\157\137\163\141\155\154\x5f\165\163\145\x72\137\x61\x74\164\x72\x69\142\165\164\145\163", $Mr);
    $cy = get_site_option("\x73\141\155\x6c\x5f\x61\x6d\137\144\151\x73\x70\154\141\x79\137\156\141\x6d\x65");
    if (empty($cy)) {
        goto lDu;
    }
    if (strcmp($cy, "\x55\123\x45\x52\x4e\x41\115\105") == 0) {
        goto JtM;
    }
    if (strcmp($cy, "\106\116\101\115\x45") == 0 && !empty($C3)) {
        goto hj1;
    }
    if (strcmp($cy, "\114\116\101\115\x45") == 0 && !empty($w6)) {
        goto dvg;
    }
    if (strcmp($cy, "\x46\116\101\x4d\x45\137\114\x4e\x41\115\105") == 0 && !empty($w6) && !empty($C3)) {
        goto K95;
    }
    if (!(strcmp($cy, "\x4c\x4e\x41\115\x45\x5f\106\x4e\101\115\105") == 0 && !empty($w6) && !empty($C3))) {
        goto IRo;
    }
    $QK = wp_update_user(array("\x49\104" => $QK, "\x64\151\163\x70\154\x61\x79\x5f\156\x61\x6d\x65" => $w6 . "\x20" . $C3));
    IRo:
    goto hVw;
    K95:
    $QK = wp_update_user(array("\x49\x44" => $QK, "\x64\151\x73\160\x6c\141\x79\137\x6e\141\x6d\145" => $C3 . "\x20" . $w6));
    hVw:
    goto nQP;
    dvg:
    $QK = wp_update_user(array("\111\x44" => $QK, "\144\x69\x73\160\x6c\x61\x79\x5f\x6e\141\x6d\x65" => $w6));
    nQP:
    goto nju;
    hj1:
    $QK = wp_update_user(array("\111\104" => $QK, "\x64\x69\x73\x70\154\x61\171\137\x6e\141\155\x65" => $C3));
    nju:
    goto Ral;
    JtM:
    $QK = wp_update_user(array("\x49\x44" => $QK, "\144\x69\x73\160\154\x61\171\137\x6e\x61\x6d\x65" => $user->user_login));
    Ral:
    lDu:
    KQP:
}
function mo_saml_map_custom_attributes($QK, $Mr)
{
    if (!get_site_option("\155\157\x5f\x73\x61\155\154\x5f\x63\x75\163\164\x6f\x6d\x5f\x61\164\x74\x72\163\137\x6d\141\160\x70\x69\x6e\147")) {
        goto D1m;
    }
    $lp = maybe_unserialize(get_site_option("\x6d\x6f\137\x73\x61\x6d\154\x5f\143\x75\163\164\157\x6d\137\x61\164\164\x72\163\137\x6d\x61\160\160\x69\156\x67"));
    foreach ($lp as $ez => $T5) {
        if (!array_key_exists($T5, $Mr)) {
            goto cIB;
        }
        $Dw = false;
        if (!(count($Mr[$T5]) == 1)) {
            goto jEd;
        }
        $Dw = true;
        jEd:
        if (!$Dw) {
            goto ZKE;
        }
        update_user_meta($QK, $ez, $Mr[$T5][0]);
        goto zZO;
        ZKE:
        $wr = array();
        foreach ($Mr[$T5] as $YX) {
            array_push($wr, $YX);
            M1k:
        }
        yX1:
        update_user_meta($QK, $ez, $wr);
        zZO:
        cIB:
        CcK:
    }
    i1f:
    D1m:
}
function mo_saml_restrict_users_based_on_domain($JY)
{
    $Z_ = get_site_option("\x6d\x6f\x5f\x73\x61\x6d\x6c\137\145\x6e\x61\x62\x6c\145\x5f\144\157\155\141\151\x6e\137\x72\145\x73\164\x72\151\143\164\x69\157\156\x5f\154\x6f\147\x69\156");
    if (!$Z_) {
        goto X70;
    }
    $Q_ = get_site_option("\163\x61\x6d\x6c\x5f\x61\155\x5f\145\x6d\141\x69\x6c\x5f\144\157\x6d\141\x69\x6e\x73");
    $eH = explode("\x3b", $Q_);
    $R_ = explode("\100", $JY);
    $nx = array_key_exists("\x31", $R_) ? $R_[1] : '';
    $Cv = get_site_option("\x6d\x6f\137\x73\141\155\154\x5f\x61\154\154\x6f\x77\x5f\x64\x65\156\171\x5f\x75\x73\145\162\x5f\167\x69\164\150\137\x64\157\155\141\151\x6e");
    $I7 = get_site_option("\x6d\x6f\137\163\x61\155\154\137\162\x65\x73\164\x72\x69\143\164\145\x64\x5f\x64\x6f\155\141\x69\156\137\145\162\x72\157\162\137\155\x73\147");
    if (!empty($I7)) {
        goto VQV;
    }
    $I7 = "\131\x6f\165\x20\141\162\145\40\156\x6f\x74\x20\141\x6c\154\x6f\167\145\144\40\x74\x6f\40\154\157\147\x69\x6e\56\x20\120\154\145\x61\163\x65\x20\143\157\156\x74\141\143\164\40\x79\157\x75\162\40\101\x64\x6d\x69\x6e\151\163\164\162\141\164\x6f\x72\x2e";
    VQV:
    if (!empty($Cv) && $Cv == "\144\x65\x6e\x79") {
        goto iEm;
    }
    if (in_array($nx, $eH)) {
        goto hHQ;
    }
    wp_die($I7, "\x50\x65\162\x6d\x69\x73\x73\x69\x6f\x6e\40\x44\145\x6e\x69\x65\x64\x20\x45\162\162\157\x72\x20\55\40\62");
    hHQ:
    goto CAh;
    iEm:
    if (!in_array($nx, $eH)) {
        goto F2t;
    }
    wp_die($I7, "\120\145\x72\x6d\x69\163\x73\x69\157\156\x20\104\145\x6e\151\x65\144\x20\105\162\162\x6f\x72\40\55\x20\x31");
    F2t:
    CAh:
    X70:
}
function mo_saml_set_auth_cookie($user, $ri, $k9, $t3)
{
    $QK = $user->ID;
    do_action("\x77\x70\x5f\x6c\x6f\x67\151\156", $user->user_login, $user);
    if (empty($ri)) {
        goto o0q;
    }
    update_user_meta($QK, "\155\x6f\x5f\x73\141\155\154\137\163\145\163\x73\151\x6f\156\x5f\x69\x6e\x64\145\x78", $ri);
    o0q:
    if (empty($k9)) {
        goto DtK;
    }
    update_user_meta($QK, "\155\157\137\x73\141\x6d\154\x5f\x6e\x61\x6d\x65\x5f\151\144", $k9);
    DtK:
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto s9Y;
    }
    session_start();
    s9Y:
    $_SESSION["\x6d\157\137\163\141\x6d\154"]["\x6c\x6f\147\x67\x65\144\x5f\x69\156\x5f\x77\x69\x74\x68\x5f\151\x64\x70"] = TRUE;
    update_user_meta($QK, "\155\157\x5f\x73\x61\155\x6c\x5f\x69\x64\x70\137\154\x6f\x67\x69\156", "\x74\x72\165\145");
    wp_set_current_user($QK);
    $C_ = false;
    $C_ = apply_filters("\155\x6f\137\x72\145\x6d\x65\155\142\145\x72\137\155\145", $C_);
    wp_set_auth_cookie($QK, $C_);
    if (!$t3) {
        goto X0I;
    }
    do_action("\165\163\145\x72\137\x72\145\x67\151\163\164\145\x72", $QK);
    X0I:
}
function mo_saml_post_login_redirection($QU, $fG)
{
    $Mk = mo_saml_get_redirect_url($QU, $fG);
    wp_redirect($Mk);
    exit;
}
function mo_saml_get_redirect_url($QU, $fG)
{
    $GG = '';
    $a7 = get_site_option("\x73\x61\155\x6c\x5f\163\x73\x6f\137\x73\145\x74\164\151\156\x67\x73");
    $uC = get_current_blog_id();
    if (!(empty($a7[$uC]) && !empty($a7["\104\105\106\101\x55\x4c\124"]))) {
        goto lIP;
    }
    $a7[$uC] = $a7["\104\x45\x46\101\125\x4c\124"];
    lIP:
    $Ns = isset($a7[$uC]["\x6d\x6f\x5f\x73\141\x6d\x6c\x5f\x72\145\x6c\141\171\137\163\x74\x61\164\x65"]) ? $a7[$uC]["\x6d\157\137\163\141\x6d\x6c\137\x72\x65\x6c\x61\x79\x5f\163\x74\141\x74\145"] : '';
    if (!empty($Ns)) {
        goto as6;
    }
    if (!empty($fG)) {
        goto qld;
    }
    $GG = $QU;
    goto uGM;
    qld:
    $GG = $fG;
    uGM:
    goto Wxk;
    as6:
    $GG = $Ns;
    Wxk:
    return $GG;
}
function check_if_user_allowed_to_login($user, $QU)
{
    $QK = $user->ID;
    global $wpdb;
    if (get_user_meta($QK, "\155\157\137\163\x61\155\154\137\165\x73\x65\x72\137\x74\171\160\145", true)) {
        goto aVO;
    }
    if (get_site_option("\155\x6f\x5f\163\141\x6d\154\137\x75\x73\x72\x5f\154\x6d\x74")) {
        goto hFv;
    }
    update_user_meta($QK, "\155\157\137\x73\x61\x6d\154\137\x75\163\145\162\137\164\171\x70\x65", "\163\x73\x6f\x5f\x75\163\145\162");
    goto zXL;
    hFv:
    $ez = get_site_option("\155\157\x5f\x73\x61\x6d\154\x5f\x63\x75\x73\164\x6f\x6d\x65\x72\137\x74\x6f\153\145\156");
    $Nn = AESEncryption::decrypt_data(get_site_option("\155\157\x5f\163\141\155\154\x5f\x75\163\162\x5f\x6c\155\x74"), $ez);
    $p4 = "\123\105\114\x45\103\124\x20\x43\117\x55\x4e\124\x28\52\51\x20\106\x52\x4f\x4d\x20" . $wpdb->prefix . "\165\163\145\162\155\145\x74\x61\40\x57\x48\x45\x52\105\40\155\145\164\x61\137\153\x65\171\75\47\155\x6f\x5f\x73\141\x6d\x6c\x5f\165\x73\x65\162\137\x74\x79\x70\145\47";
    $YL = $wpdb->get_var($p4);
    if ($YL >= $Nn) {
        goto VEp;
    }
    update_user_meta($QK, "\x6d\x6f\x5f\x73\141\x6d\154\137\x75\x73\x65\x72\137\164\x79\160\x65", "\x73\163\157\x5f\165\163\145\162");
    goto UCs;
    VEp:
    if (get_site_option("\165\163\x65\162\x5f\141\154\x65\x72\164\x5f\x65\x6d\141\x69\154\x5f\163\x65\156\x74")) {
        goto n6h;
    }
    $hE = new Customersaml();
    $hE->mo_saml_send_user_exceeded_alert_email($Nn, $this);
    n6h:
    if (is_administrator_user($user)) {
        goto T6G;
    }
    wp_redirect($QU);
    exit;
    goto ovV;
    T6G:
    update_user_meta($QK, "\155\157\x5f\163\x61\x6d\154\137\165\163\x65\162\x5f\x74\x79\160\x65", "\x73\x73\x6f\137\x75\163\x65\x72");
    ovV:
    UCs:
    zXL:
    aVO:
}
function check_if_user_allowed_to_login_due_to_role_restriction($cg)
{
    $ZF = maybe_unserialize(get_site_option("\163\141\x6d\154\x5f\141\x6d\137\x72\x6f\x6c\145\137\x6d\141\160\x70\151\x6e\x67"));
    $KX = Utilities::get_active_sites();
    $HL = get_site_option("\x6d\157\x5f\x61\x70\x70\154\x79\x5f\162\x6f\154\x65\x5f\155\141\x70\x70\151\x6e\147\137\146\x6f\x72\137\x73\151\164\145\163");
    if ($ZF) {
        goto Dey;
    }
    $ZF = array();
    Dey:
    if (array_key_exists("\104\x45\x46\x41\x55\x4c\x54", $ZF)) {
        goto Uds;
    }
    $ZF["\104\105\106\101\125\114\124"] = array();
    Uds:
    foreach ($KX as $blog_id) {
        if ($HL) {
            goto DS6;
        }
        $rj = $blog_id;
        goto apD;
        DS6:
        $rj = 0;
        apD:
        if (isset($ZF[$rj])) {
            goto man;
        }
        $v4 = $ZF["\104\105\x46\x41\125\114\124"];
        goto YiT;
        man:
        $v4 = $ZF[$rj];
        YiT:
        if (empty($v4)) {
            goto L1B;
        }
        $FD = isset($v4["\155\x6f\x5f\163\141\x6d\154\137\144\157\156\x74\x5f\141\x6c\x6c\157\167\x5f\x75\163\x65\x72\137\x74\x6f\154\157\147\151\156\137\x63\162\145\x61\x74\145\x5f\167\x69\164\x68\137\x67\x69\x76\145\x6e\x5f\147\x72\x6f\165\x70\x73"]) ? $v4["\x6d\x6f\137\163\141\x6d\x6c\x5f\x64\157\x6e\164\x5f\x61\154\x6c\157\x77\x5f\x75\x73\145\x72\x5f\164\157\x6c\157\147\x69\x6e\x5f\143\162\x65\141\x74\x65\137\x77\151\x74\x68\137\147\151\x76\145\x6e\137\147\x72\x6f\165\x70\163"] : '';
        if (!($FD == "\x63\x68\x65\143\x6b\145\144")) {
            goto d0u;
        }
        if (empty($cg)) {
            goto ARK;
        }
        $TP = $v4["\x6d\x6f\137\163\x61\x6d\154\x5f\162\145\163\x74\x72\151\x63\x74\137\x75\163\145\x72\163\137\x77\x69\x74\x68\x5f\x67\x72\x6f\x75\160\x73"];
        $YQ = explode("\73", $TP);
        foreach ($YQ as $f9) {
            foreach ($cg as $W_) {
                $W_ = trim($W_);
                if (!(!empty($W_) && $W_ == $f9)) {
                    goto QNr;
                }
                wp_die("\x59\157\165\40\141\162\145\40\x6e\157\164\x20\141\x75\164\150\157\162\x69\172\145\144\40\x74\x6f\x20\x6c\x6f\x67\x69\156\56\x20\x50\154\145\x61\163\145\40\143\x6f\156\164\141\143\x74\40\x79\x6f\x75\162\x20\141\x64\155\x69\x6e\x69\x73\x74\162\x61\x74\x6f\x72\x2e", "\x45\x72\162\157\162");
                QNr:
                HyT:
            }
            j2r:
            WVM:
        }
        Qcm:
        ARK:
        d0u:
        L1B:
        UR6:
    }
    Fi3:
}
function assign_roles_to_user($user, $ZF, $blog_id, $cg, $rj)
{
    $ob = false;
    if (!(!empty($cg) && !empty($ZF) && !is_administrator_user($user) && is_user_member_of_blog($user->ID, $blog_id))) {
        goto vlj;
    }
    if (!empty($ZF[$rj])) {
        goto R8C;
    }
    if (empty($ZF["\x44\105\x46\101\x55\x4c\124"])) {
        goto sio;
    }
    $v4 = $ZF["\104\x45\106\101\125\x4c\124"];
    sio:
    goto xWO;
    R8C:
    $v4 = $ZF[$rj];
    xWO:
    if (empty($v4)) {
        goto JYc;
    }
    $user->set_role(false);
    $kk = '';
    $uy = false;
    unset($v4["\144\x65\x66\141\x75\x6c\164\137\x72\x6f\154\145"]);
    unset($v4["\144\x6f\156\164\x5f\x63\162\145\x61\164\x65\137\165\163\145\x72"]);
    unset($v4["\144\157\x6e\x74\137\x61\x6c\x6c\157\x77\x5f\x75\x6e\x6c\x69\x73\164\x65\x64\x5f\165\x73\145\x72"]);
    unset($v4["\153\145\145\160\x5f\145\x78\x69\163\164\x69\x6e\147\137\165\163\x65\x72\163\x5f\x72\x6f\154\x65"]);
    unset($v4["\x6d\x6f\137\163\x61\155\154\137\x64\157\156\164\x5f\x61\154\x6c\157\x77\137\165\163\145\162\137\x74\x6f\x6c\157\147\x69\x6e\137\143\x72\x65\141\x74\145\137\x77\151\x74\150\137\x67\x69\x76\x65\x6e\137\x67\x72\x6f\x75\160\163"]);
    unset($v4["\x6d\157\137\163\141\x6d\154\137\x72\x65\163\x74\162\x69\143\x74\137\x75\x73\145\162\163\137\x77\x69\x74\150\x5f\x67\x72\157\x75\160\163"]);
    foreach ($v4 as $Ks => $C2) {
        $YQ = explode("\x3b", $C2);
        foreach ($YQ as $f9) {
            if (!(!empty($f9) && in_array($f9, $cg))) {
                goto sRo;
            }
            $ob = true;
            $user->add_role($Ks);
            sRo:
            Udw:
        }
        Q8a:
        SK1:
    }
    Ify:
    JYc:
    vlj:
    $B3 = get_site_option("\155\157\137\x73\141\155\x6c\137\x73\165\160\x65\x72\137\x61\144\155\151\x6e\137\162\x6f\x6c\145\137\155\141\x70\160\x69\x6e\147");
    $Zv = array();
    if (empty($B3)) {
        goto vdL;
    }
    $Zv = explode("\73", $B3);
    vdL:
    if (!(!empty($cg) && !empty($Zv))) {
        goto sf9;
    }
    foreach ($Zv as $f9) {
        if (!in_array($f9, $cg)) {
            goto fkv;
        }
        grant_super_admin($user->ID);
        fkv:
        HLj:
    }
    MPD:
    sf9:
    return $ob;
}
function get_saml_roles_to_assign($ZF, $blog_id, $cg)
{
    $im = array();
    if (!(!empty($cg) && !empty($ZF))) {
        goto LEa;
    }
    if (!empty($ZF[$blog_id])) {
        goto ziN;
    }
    if (empty($ZF["\x44\105\x46\101\x55\114\124"])) {
        goto WH9;
    }
    $v4 = $ZF["\104\105\x46\101\x55\114\124"];
    WH9:
    goto IMk;
    ziN:
    $v4 = $ZF[$blog_id];
    IMk:
    if (empty($v4)) {
        goto H3l;
    }
    unset($v4["\144\145\x66\x61\165\154\164\x5f\162\157\x6c\x65"]);
    unset($v4["\144\x6f\x6e\x74\x5f\143\162\x65\141\x74\145\137\x75\163\x65\162"]);
    unset($v4["\144\157\x6e\x74\x5f\x61\154\x6c\157\167\137\165\x6e\154\151\x73\x74\145\144\137\x75\x73\145\162"]);
    unset($v4["\153\145\145\160\x5f\x65\170\151\x73\x74\x69\156\x67\x5f\165\163\145\162\x73\x5f\162\x6f\x6c\x65"]);
    unset($v4["\x6d\x6f\x5f\x73\141\x6d\154\x5f\144\x6f\x6e\164\x5f\x61\x6c\154\157\x77\137\165\x73\x65\x72\x5f\164\x6f\154\157\147\151\156\137\143\x72\145\x61\x74\145\x5f\x77\151\164\150\x5f\x67\151\x76\145\156\137\147\162\x6f\165\160\163"]);
    unset($v4["\x6d\157\137\163\x61\x6d\x6c\137\x72\x65\163\x74\x72\151\143\164\x5f\x75\163\145\162\x73\137\x77\151\x74\150\137\147\x72\157\x75\x70\163"]);
    foreach ($v4 as $Ks => $C2) {
        $YQ = explode("\x3b", $C2);
        foreach ($YQ as $f9) {
            if (!(!empty($f9) and in_array($f9, $cg))) {
                goto l8b;
            }
            array_push($im, $Ks);
            l8b:
            taC:
        }
        dsS:
        Fp2:
    }
    JC4:
    H3l:
    LEa:
    return $im;
}
function is_administrator_user($user)
{
    $e7 = $user->roles;
    if (!is_null($e7) && in_array("\x61\144\155\151\156\x69\x73\x74\162\141\164\157\162", $e7)) {
        goto s07;
    }
    return false;
    goto ep4;
    s07:
    return true;
    ep4:
}
function mo_saml_is_customer_registered()
{
    $ik = get_site_option("\155\x6f\137\163\141\155\x6c\x5f\x61\144\x6d\151\156\x5f\145\155\141\x69\154");
    $sN = get_site_option("\x6d\157\x5f\163\141\x6d\x6c\x5f\x61\x64\155\151\156\x5f\143\165\x73\164\157\x6d\x65\162\x5f\x6b\x65\x79");
    if (!$ik || !$sN || !is_numeric(trim($sN))) {
        goto OdN;
    }
    return 1;
    goto JL1;
    OdN:
    return 0;
    JL1:
}
function mo_saml_is_customer_license_verified()
{
    $ez = get_site_option("\x6d\x6f\x5f\x73\x61\x6d\154\137\143\x75\x73\x74\x6f\155\x65\162\x5f\164\157\x6b\145\x6e");
    $yl = AESEncryption::decrypt_data(get_site_option("\164\137\163\x69\164\145\x5f\x73\164\x61\164\165\163"), $ez);
    $Bw = get_site_option("\163\x6d\154\137\x6c\x6b");
    $ik = get_site_option("\x6d\157\137\x73\x61\x6d\154\x5f\141\x64\155\x69\156\x5f\145\155\x61\x69\154");
    $sN = get_site_option("\155\157\137\x73\x61\x6d\x6c\137\x61\144\155\151\156\137\143\165\163\x74\157\x6d\x65\x72\137\x6b\x65\171");
    $dD = AESEncryption::decrypt_data(get_site_option("\156\157\x5f\163\142\x73"), $ez);
    $Fv = false;
    if (!get_site_option("\x6e\157\x5f\163\x62\x73")) {
        goto w3f;
    }
    $dM = Utilities::get_sites();
    $Fv = $dD < count($dM);
    w3f:
    if ($yl != "\x74\162\x75\145" && !$Bw || !$ik || !$sN || !is_numeric(trim($sN)) || $Fv) {
        goto QN7;
    }
    return 1;
    goto ms6;
    QN7:
    return 0;
    ms6:
}
function show_status_error($jt, $fG)
{
    if ($fG == "\x74\145\x73\164\126\x61\154\x69\x64\141\x74\145" or $fG == "\164\x65\x73\164\x4e\x65\167\103\145\162\x74\x69\x66\151\143\x61\164\145") {
        goto Yy7;
    }
    wp_die("\127\x65\40\143\157\x75\x6c\x64\x20\x6e\x6f\164\x20\x73\x69\147\156\40\171\157\165\40\x69\x6e\56\40\120\x6c\x65\141\163\x65\40\x63\157\156\x74\141\x63\x74\40\171\x6f\165\x72\40\101\144\155\x69\x6e\x69\163\x74\x72\x61\x74\x6f\x72\x2e", "\105\x72\x72\x6f\162\72\40\x49\156\x76\x61\154\x69\x64\40\x53\101\115\114\x20\122\x65\163\x70\157\156\163\x65\x20\123\164\x61\164\x75\x73");
    goto fND;
    Yy7:
    echo "\x3c\x64\x69\x76\x20\163\x74\x79\154\145\x3d\42\x66\x6f\x6e\x74\x2d\x66\x61\x6d\151\x6c\171\x3a\x43\x61\x6c\x69\142\x72\x69\x3b\160\x61\144\144\151\x6e\147\x3a\x30\x20\63\45\73\x22\x3e";
    echo "\x3c\144\x69\166\x20\163\x74\x79\x6c\x65\75\42\143\x6f\x6c\x6f\x72\x3a\x20\x23\x61\x39\x34\64\x34\62\x3b\142\141\x63\x6b\x67\162\x6f\x75\x6e\144\55\143\x6f\x6c\x6f\x72\x3a\40\x23\146\x32\144\145\x64\x65\x3b\x70\141\144\x64\x69\156\x67\72\40\x31\65\160\170\73\x6d\141\x72\147\151\156\x2d\142\x6f\164\x74\157\155\x3a\40\x32\x30\160\x78\x3b\164\145\170\164\55\x61\x6c\x69\147\156\x3a\143\x65\x6e\x74\x65\162\73\x62\157\162\144\x65\x72\72\x31\160\170\40\x73\x6f\x6c\x69\144\x20\x23\x45\66\102\63\x42\x32\73\x66\157\x6e\x74\55\163\151\x7a\145\x3a\61\70\x70\164\73\x22\76\x20\105\x52\x52\x4f\x52\74\x2f\x64\151\x76\76\15\12\40\x20\x20\40\x20\40\40\x20\74\x64\x69\x76\x20\163\164\x79\x6c\145\x3d\42\143\x6f\x6c\x6f\162\72\x20\x23\x61\71\64\64\x34\x32\73\146\x6f\156\x74\x2d\x73\x69\172\x65\x3a\x31\64\160\x74\73\40\155\x61\x72\147\x69\x6e\x2d\x62\x6f\x74\x74\x6f\x6d\72\x32\60\160\170\x3b\x22\76\x3c\x70\76\x3c\163\164\162\157\x6e\x67\76\x45\x72\x72\157\162\72\40\74\x2f\163\x74\162\x6f\x6e\x67\76\x20\x49\x6e\166\141\x6c\x69\144\40\x53\101\115\114\40\x52\x65\163\160\x6f\156\x73\145\x20\123\164\141\x74\165\x73\x2e\x3c\x2f\160\x3e\xd\12\40\x20\x20\x20\40\x20\x20\40\x20\x20\x20\x20\x3c\x70\x3e\74\163\164\162\x6f\156\x67\x3e\x43\141\165\163\145\163\x3c\57\x73\164\x72\x6f\x6e\147\76\72\40\111\x64\145\156\164\151\x74\x79\40\x50\162\157\166\151\x64\145\x72\x20\x68\x61\163\x20\x73\145\x6e\164\x20\x27" . $jt . "\47\40\163\x74\x61\x74\x75\x73\x20\143\x6f\x64\145\x20\151\156\40\x53\101\115\114\40\122\145\x73\x70\x6f\x6e\163\145\x2e\40\x3c\x2f\160\x3e\xd\12\x20\40\x20\x20\x20\40\x20\40\x20\40\40\x20\x3c\x70\x3e\x3c\x73\164\162\x6f\x6e\x67\76\122\x65\x61\163\x6f\x6e\x3c\57\163\164\162\157\x6e\x67\x3e\72\40" . get_status_message($jt) . "\x3c\57\x70\76\x3c\x62\x72\x3e";
    if (empty($jo)) {
        goto eJt;
    }
    echo "\x3c\160\76\x3c\x73\164\x72\x6f\x6e\x67\x3e\x53\x74\x61\164\165\163\40\x4d\145\x73\163\141\147\145\x20\x69\156\40\x74\x68\145\x20\x53\101\x4d\x4c\x20\x52\x65\x73\x70\x6f\x6e\163\x65\72\x3c\x2f\163\164\x72\157\x6e\x67\x3e\40\74\x62\x72\x2f\76" . $jo . "\74\x2f\160\76\x3c\142\x72\76";
    eJt:
    echo "\xd\12\40\x20\40\x20\40\x20\40\x20\74\x2f\144\151\x76\x3e\xd\xa\xd\12\x20\40\x20\x20\40\40\40\x20\x3c\x64\151\166\x20\163\x74\171\154\x65\75\42\155\141\x72\147\151\x6e\72\63\x25\73\144\151\163\160\154\x61\171\72\142\x6c\x6f\143\x6b\73\x74\x65\x78\164\x2d\141\x6c\151\147\x6e\x3a\x63\x65\x6e\164\145\162\73\42\x3e\xd\xa\x20\40\x20\40\40\40\x20\40\40\40\40\x20\74\x64\x69\x76\x20\163\164\x79\x6c\x65\75\x22\155\x61\162\147\x69\156\x3a\63\x25\x3b\x64\x69\x73\160\x6c\141\x79\72\x62\x6c\157\x63\153\73\164\x65\170\x74\x2d\x61\x6c\151\147\x6e\72\x63\145\x6e\x74\145\162\x3b\42\76\74\151\156\x70\165\164\x20\163\x74\171\154\x65\x3d\42\160\x61\x64\x64\151\x6e\147\72\x31\45\x3b\x77\151\144\x74\150\72\61\x30\x30\x70\170\73\x62\141\x63\153\x67\x72\157\x75\156\x64\x3a\40\43\x30\60\x39\61\x43\104\x20\x6e\x6f\x6e\145\x20\162\x65\160\x65\x61\164\x20\163\x63\x72\x6f\154\154\40\x30\45\40\60\x25\73\x63\165\x72\x73\x6f\x72\x3a\x20\x70\157\151\156\x74\145\162\73\146\x6f\x6e\164\55\163\x69\x7a\145\72\61\65\160\x78\x3b\142\157\x72\144\145\162\x2d\167\x69\x64\x74\x68\x3a\40\x31\x70\x78\73\x62\x6f\x72\144\x65\x72\55\163\x74\171\154\145\72\40\163\x6f\154\x69\x64\73\142\x6f\162\144\x65\162\55\162\141\x64\x69\165\x73\72\x20\x33\160\170\73\x77\x68\x69\164\x65\x2d\x73\x70\x61\143\x65\x3a\40\156\157\x77\x72\x61\160\x3b\x62\x6f\170\55\163\x69\x7a\x69\x6e\x67\72\x20\x62\157\x72\144\145\x72\x2d\142\157\x78\x3b\142\157\162\x64\145\162\55\143\157\154\x6f\x72\x3a\40\43\x30\60\x37\63\x41\101\73\142\x6f\x78\55\x73\150\141\144\x6f\x77\72\x20\x30\x70\x78\40\61\x70\170\40\60\x70\x78\x20\x72\147\x62\x61\50\x31\x32\60\x2c\x20\62\x30\60\54\x20\62\x33\60\x2c\x20\x30\x2e\66\x29\40\151\x6e\163\145\x74\x3b\143\x6f\154\x6f\162\x3a\40\x23\106\x46\106\x3b\42\x74\x79\160\145\75\x22\x62\x75\x74\x74\157\156\x22\x20\x76\141\154\165\x65\x3d\x22\104\x6f\x6e\x65\x22\40\157\x6e\x43\x6c\x69\x63\153\x3d\x22\x73\x65\154\146\56\143\x6c\x6f\163\145\50\x29\x3b\42\76\x3c\57\144\151\x76\76";
    exit;
    fND:
}
function addLink($et, $Dh)
{
    $DX = "\74\141\40\150\162\145\x66\x3d\x22" . $Dh . "\x22\x3e" . $et . "\x3c\57\x61\76";
    return $DX;
}
function get_status_message($jt)
{
    switch ($jt) {
        case "\122\x65\161\165\x65\163\x74\x65\x72":
            return "\x54\150\x65\40\162\x65\x71\165\x65\163\164\40\x63\x6f\165\x6c\x64\x20\156\x6f\x74\x20\x62\145\40\x70\145\162\x66\157\162\155\145\144\40\x64\x75\x65\x20\164\157\x20\x61\156\x20\x65\x72\x72\x6f\x72\x20\x6f\156\x20\x74\150\x65\40\x70\x61\162\164\x20\x6f\x66\40\164\x68\x65\40\x72\x65\161\165\145\x73\x74\x65\x72\x2e";
            goto tui;
        case "\122\x65\163\x70\x6f\x6e\x64\x65\x72":
            return "\124\x68\145\40\x72\x65\x71\165\145\x73\164\x20\143\157\x75\154\144\40\156\157\x74\40\x62\145\40\160\145\x72\146\x6f\x72\155\145\144\x20\x64\x75\x65\x20\164\x6f\40\x61\156\x20\145\x72\162\x6f\162\x20\x6f\156\x20\x74\x68\145\x20\160\141\162\x74\x20\x6f\x66\40\x74\x68\145\40\x53\101\115\114\x20\162\x65\163\x70\x6f\x6e\x64\x65\x72\x20\x6f\x72\x20\x53\x41\115\x4c\x20\141\x75\x74\x68\157\x72\151\164\x79\56";
            goto tui;
        case "\126\145\162\163\151\157\156\115\x69\163\x6d\141\x74\143\x68":
            return "\x54\150\145\x20\x53\101\x4d\x4c\40\x72\145\x73\x70\x6f\x6e\144\x65\x72\x20\x63\x6f\165\154\x64\x20\156\157\164\40\160\x72\x6f\x63\145\163\163\x20\164\150\145\x20\x72\x65\x71\165\145\x73\x74\x20\142\145\143\141\165\x73\x65\40\164\x68\145\x20\166\145\x72\163\151\157\156\40\x6f\x66\x20\x74\150\145\40\x72\x65\x71\x75\145\163\x74\40\x6d\x65\163\163\141\147\x65\40\167\141\x73\x20\x69\x6e\x63\x6f\x72\x72\145\x63\x74\x2e";
            goto tui;
        default:
            return "\x55\156\x6b\156\157\x77\156";
    }
    a_j:
    tui:
}
function saml_get_current_page_url()
{
    $e3 = $_SERVER["\110\124\x54\x50\137\110\x4f\123\x54"];
    if (!(substr($e3, -1) == "\x2f")) {
        goto gkE;
    }
    $e3 = substr($e3, 0, -1);
    gkE:
    $t7 = $_SERVER["\x52\x45\x51\x55\x45\x53\x54\137\x55\122\x49"];
    if (!(substr($t7, 0, 1) == "\x2f")) {
        goto gK5;
    }
    $t7 = substr($t7, 1);
    gK5:
    $oq = isset($_SERVER["\x48\124\x54\120\123"]) && strcasecmp($_SERVER["\110\124\124\120\123"], "\157\x6e") == 0;
    $WN = "\x68\164\x74\x70" . ($oq ? "\x73" : '') . "\72\57\57" . $e3 . "\57" . $t7;
    return $WN;
}
function get_network_site_url()
{
    $dK = network_site_url();
    if (!(substr($dK, -1) == "\57")) {
        goto wj1;
    }
    $dK = substr($dK, 0, -1);
    wj1:
    return $dK;
}
function get_current_base_url()
{
    return sprintf("\x25\x73\x3a\x2f\x2f\45\163\x2f", isset($_SERVER["\x48\124\124\x50\123"]) && $_SERVER["\110\124\124\120\x53"] != "\157\x66\x66" ? "\150\164\164\160\163" : "\150\164\164\160", $_SERVER["\110\124\x54\120\137\x48\x4f\123\124"]);
}
add_action("\167\x69\144\147\145\x74\x73\137\x69\156\151\164", function () {
    register_widget("\155\157\x5f\154\157\x67\x69\x6e\x5f\167\151\x64");
});
add_action("\x69\x6e\x69\x74", "\x6d\x6f\x5f\x6c\x6f\147\x69\156\x5f\166\x61\154\x69\144\141\x74\145");
