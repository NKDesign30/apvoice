<?php


require_once ABSPATH . "\x77\160\x2d\141\x64\155\x69\156\x2f\151\156\143\154\x75\x64\145\163\x2f\143\154\141\x73\163\x2d\x77\x70\x2d\154\151\163\x74\x2d\x74\x61\x62\x6c\145\56\x70\x68\x70";
require_once ABSPATH . "\x77\x70\x2d\141\144\155\x69\156\x2f\x69\156\143\154\x75\144\x65\x73\x2f\x63\x6c\141\163\163\55\167\160\55\155\x73\55\x73\x69\164\145\x73\55\x6c\x69\x73\x74\x2d\164\141\x62\x6c\x65\x2e\160\150\x70";
class MO_Sites_List extends WP_MS_Sites_List_Table
{
    private $items_per_page = 10;
    public function __construct()
    {
        parent::__construct();
    }
    function get_columns()
    {
        $I_ = array("\x73\x69\164\x65\156\141\155\x65" => "\x53\151\x74\145\40\116\x61\x6d\145", "\142\154\157\x67\156\x61\155\145" => "\x55\122\114", "\145\x6e\141\x62\x6c\145\x73\x73\157" => "\105\x6e\141\142\154\x65\40\x53\x53\x4f");
        return $I_;
    }
    public function prepare_items()
    {
        $wf = $this->get_pagenum();
        $this->items = Utilities::get_sites();
    }
    public function display_rows()
    {
        global $wpdb;
        echo "\x3c\146\157\x72\155\x20\141\x63\164\x69\157\156\75\42\42\40\x6d\145\x74\150\x6f\x64\75\x22\160\157\163\x74\42\40\156\141\155\145\75\42\155\x6f\137\155\x61\x6e\x61\x67\x65\137\163\x75\x62\163\x69\x74\145\163\42\76\15\12\x20\x20\x20\40\40\40\40\40\40\40\40\40\40\x20\x20\40\x3c\x69\x6e\x70\165\x74\40\164\171\160\x65\x3d\x22\x68\x69\x64\x64\x65\x6e\x22\40\156\x61\x6d\145\x3d\42\157\x70\164\x69\x6f\x6e\x22\x20\x76\x61\x6c\165\145\75\42\x6d\141\x6e\141\x67\x65\x5f\163\163\x6f\x5f\163\x69\164\x65\x73\42\x3e\15\xa\40\40\40\40\x20\40\40\x20\40\x20\40\40\x20\x20\40\x20";
        wp_nonce_field("\x6d\x61\156\141\x67\145\137\163\x73\x6f\137\163\151\164\x65\x73");
        $dZ = $this->get_pagenum();
        echo "\74\164\162\40\x73\164\x79\154\x65\75\42\x74\x65\x78\x74\55\141\154\x69\147\156\72\40\x63\145\156\164\x65\x72\73\x66\x6f\156\x74\55\167\145\151\x67\150\x74\72\x20\142\x6f\154\x64\x22\x3e\x3c\x74\144\x3e\x53\x69\x74\145\40\x4e\141\x6d\x65\74\57\164\144\x3e\x3c\164\144\x3e\123\x69\164\145\40\x55\122\114\x3c\57\164\144\x3e\74\x74\x64\76\105\x6e\x61\142\154\145\x20\x53\123\x4f\74\142\162\57\x3e\15\12\x20\x20\x20\x20\40\x20\x20\40\x20\40\40\40\74\x73\160\141\156\40\x73\164\171\154\145\75\x22\x70\141\x64\144\x69\156\147\55\x72\x69\147\x68\x74\x3a\61\60\x70\x78\73\x20\x66\x6f\156\164\x2d\167\x65\x69\x67\150\x74\x3a\40\156\x6f\x72\x6d\x61\154\42\76\x3c\x69\156\160\x75\x74\40\164\171\x70\x65\75\42\x63\x68\x65\x63\x6b\x62\157\x78\x22\x20\x69\x64\75\x22\x65\156\x61\142\154\x65\x41\x6c\154\42\x20\x6e\x61\155\x65\75\x22\145\156\141\142\x6c\x65\101\154\x6c\x22\40\166\141\x6c\x75\x65\75\x22\164\162\x75\x65\x22\x20\x6f\156\143\154\x69\143\153\x3d\x22\145\156\141\142\154\145\x41\154\154\x53\x75\x62\x73\x69\164\145\163\50\51\73\42\x2f\76\x45\156\x61\142\154\145\x20\141\x6c\154\x3c\x2f\163\x70\x61\156\76\15\xa\x20\x20\x20\x20\x20\x20\40\40\40\40\40\40\x3c\x73\160\141\156\40\x73\x74\171\x6c\x65\x3d\42\160\x61\x64\x64\151\156\147\55\x6c\x65\x66\x74\72\40\x31\x30\160\170\x3b\40\x66\x6f\x6e\164\x2d\x77\145\x69\x67\150\164\x3a\x20\156\157\x72\x6d\x61\154\42\x3e\x3c\151\x6e\x70\165\x74\x20\x74\171\x70\145\75\x22\143\150\x65\x63\153\142\x6f\x78\x22\x20\x69\x64\x3d\42\x64\x69\x73\141\142\154\x65\x41\x6c\x6c\42\40\156\141\x6d\x65\x3d\x22\144\151\163\x61\142\154\145\x41\x6c\x6c\x22\40\166\141\x6c\x75\x65\x3d\x22\164\162\165\x65\x22\40\157\x6e\x63\154\x69\143\153\75\x22\x64\151\x73\x61\x62\154\145\101\x6c\154\123\165\x62\x73\x69\164\145\163\50\51\x3b\42\x2f\x3e\x44\x69\x73\x61\x62\x6c\145\40\141\x6c\x6c\x3c\57\163\x70\141\156\76\15\xa\40\x20\x20\40\40\x20\x20\40\x20\x20\40\40\74\57\x74\144\76\74\57\164\x72\76";
        $oQ = $this->items;
        if (!(isset($_POST["\x73"]) and !empty($_POST["\163"]))) {
            goto RLV;
        }
        $Yv = $_POST["\x73"];
        $oQ = array();
        RLV:
        if (empty($Yv)) {
            goto RCj;
        }
        foreach ($this->items as $uC) {
            $sG = $uC->domain . $uC->path;
            if (!(strpos($sG, $Yv) != false)) {
                goto Dpf;
            }
            array_push($oQ, $uC);
            Dpf:
            A9U:
        }
        rHu:
        if (!empty($oQ)) {
            goto L_L;
        }
        echo "\x3c\164\162\40\143\154\x61\x73\163\75\x22\156\157\x2d\x69\x74\x65\x6d\x73\42\x3e\74\164\x64\x20\x63\x6c\141\x73\163\x3d\42\x63\157\154\163\x70\x61\156\x63\150\x61\x6e\147\x65\x22\40\143\157\x6c\x73\160\141\x6e\x3d\42" . $this->get_column_count() . "\x22\76";
        $this->no_items();
        echo "\74\x2f\164\144\76\74\x2f\164\162\x3e";
        return;
        L_L:
        RCj:
        $this->set_pagination_args(array("\164\x6f\x74\141\x6c\137\151\x74\145\x6d\x73" => count($oQ), "\160\145\x72\137\x70\x61\147\x65" => $this->get_items_per_page("\163\151\164\x65\x73\137\160\x65\x72\x5f\160\x61\x67\145", $this->items_per_page)));
        $AH = Utilities::get_active_sites();
        foreach ($oQ as $ez => $uC) {
            if (!((int) ($ez / $this->items_per_page) + 1 != $dZ)) {
                goto TUI;
            }
            goto Qlx;
            TUI:
            $Ht = get_blog_details(array("\x62\x6c\x6f\147\x5f\x69\x64" => $uC->blog_id));
            $FB = Utilities::get_main_subsite_id();
            echo "\74\x74\x72\x20\x73\164\171\x6c\145\x3d\42\x74\145\x78\164\55\141\x6c\x69\x67\x6e\72\40\x63\x65\156\x74\x65\162\42\76\x3c\x74\144\76" . $Ht->blogname . "\x3c\x2f\164\144\76\x3c\x74\144\x3e" . $uC->domain . $uC->path . "\74\57\x74\x64\76\x3c\164\144\76\74\x69\x6e\x70\x75\164\40\164\171\160\x65\75\42\143\x68\145\x63\153\x62\157\170\x22\x20\156\141\155\x65\x3d\42\x63\150\x65\x63\x6b\x73\x69\x74\x65\42\40\x69\x64\x3d\42" . $uC->blog_id . "\x22";
            if ($uC->blog_id == $FB) {
                goto xKB;
            }
            checked(in_array($uC->blog_id, $AH));
            goto KeN;
            xKB:
            echo "\40\143\150\x65\x63\153\x65\144\x20\x64\x69\x73\x61\142\154\145\144\40\164\x69\x74\x6c\145\75\x22\x43\x61\x6e\x6e\x6f\164\40\x64\151\x73\141\142\154\x65\40\164\150\x65\x20\x6d\x61\151\x6e\x20\x73\151\164\145\x22";
            KeN:
            echo "\x3e\x3c\x69\156\160\165\164\x20\x74\171\160\x65\x3d\x22\x68\x69\144\x64\145\156\x22\40\156\141\x6d\145\x3d\42" . $uC->blog_id . "\x22\x20\x76\141\154\165\145\x3d\42\x74\x72\165\145\x22\76\x3c\x2f\x74\x64\x3e\x3c\57\164\x72\x3e";
            Qlx:
        }
        ry_:
        echo "\x3c\x2f\146\x6f\162\x6d\76";
    }
    public function view_switcher($Sn = "\x6c\151\x73\164")
    {
        return;
    }
    public function get_bulk_actions()
    {
        return;
    }
    public function no_items()
    {
        _e("\x4e\x6f\x20\x73\151\x74\x65\163\40\146\x6f\x75\156\144\56");
    }
}
