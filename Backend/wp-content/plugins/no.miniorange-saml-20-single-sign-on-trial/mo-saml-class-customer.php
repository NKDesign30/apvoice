<?php


class Customersaml
{
    public $email;
    public $phone;
    private $defaultCustomerKey = "\61\66\x35\x35\x35";
    private $defaultApiKey = "\146\x46\x64\62\x58\x63\166\124\x47\104\145\155\x5a\x76\x62\x77\x31\x62\x63\x55\x65\x73\116\112\x57\105\161\113\x62\x62\x55\161";
    function create_customer($Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\57\x6d\157\x61\x73\57\162\145\163\x74\57\x63\x75\x73\x74\x6f\155\145\162\57\x61\x64\x64";
        $current_user = wp_get_current_user();
        $this->email = get_site_option("\155\x6f\137\x73\x61\155\x6c\137\141\144\x6d\151\156\137\145\x6d\x61\151\154");
        $this->phone = get_site_option("\155\157\137\x73\x61\x6d\154\x5f\141\144\x6d\x69\156\x5f\160\150\x6f\156\145");
        $fK = get_site_option("\x6d\157\x5f\163\141\155\x6c\137\x61\x64\155\x69\156\x5f\160\141\163\163\x77\157\162\144");
        $pi = array("\143\x6f\155\160\x61\x6e\x79\116\x61\x6d\x65" => $_SERVER["\123\105\x52\126\105\x52\x5f\116\x41\x4d\105"], "\x61\x72\145\141\117\x66\111\156\164\x65\162\145\163\164" => "\x57\x50\40\155\x69\156\x69\117\x72\141\x6e\x67\x65\40\123\x41\115\x4c\40\62\x2e\x30\x20\123\x53\117\40\120\154\x75\x67\151\156", "\146\151\x72\163\x74\x6e\141\x6d\145" => $current_user->user_firstname, "\x6c\141\x73\x74\156\x61\155\145" => $current_user->user_lastname, "\145\x6d\141\x69\x6c" => $this->email, "\x70\150\x6f\156\145" => $this->phone, "\x70\141\163\163\167\x6f\x72\144" => $fK);
        $ai = json_encode($pi);
        $qU = array("\103\157\x6e\164\x65\x6e\x74\55\x54\x79\160\145" => "\141\x70\160\154\x69\143\141\x74\x69\157\156\x2f\x6a\163\x6f\x6e", "\143\x68\141\x72\163\145\x74" => "\125\x54\106\55\70", "\x41\x75\x74\x68\x6f\162\x69\x7a\141\164\x69\157\x6e" => "\x42\141\163\151\143");
        $qW = array("\x6d\x65\164\x68\157\144" => "\120\x4f\x53\124", "\x62\157\x64\171" => $ai, "\x74\x69\x6d\145\x6f\x75\164" => "\65", "\x72\x65\x64\x69\x72\x65\143\164\x69\x6f\156" => "\65", "\150\164\x74\160\x76\x65\x72\163\151\x6f\x6e" => "\61\56\60", "\142\154\x6f\143\153\151\156\x67" => true, "\x68\145\x61\144\145\162\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function get_customer_key($Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\57\155\x6f\x61\163\57\162\145\163\x74\57\143\165\x73\164\x6f\x6d\x65\x72\x2f\x6b\x65\x79";
        $KC = get_site_option("\155\x6f\x5f\x73\x61\155\154\x5f\141\x64\155\x69\156\137\145\x6d\141\x69\154");
        $fK = get_site_option("\x6d\157\137\163\x61\x6d\154\137\x61\x64\155\x69\x6e\x5f\160\x61\163\x73\x77\x6f\162\144");
        $pi = array("\x65\155\x61\151\154" => $KC, "\160\x61\163\x73\167\157\x72\144" => $fK);
        $ai = json_encode($pi);
        $qU = array("\103\x6f\x6e\x74\x65\x6e\164\55\124\x79\x70\145" => "\x61\160\160\154\151\143\141\164\x69\157\x6e\57\x6a\x73\157\x6e", "\x63\x68\x61\x72\x73\x65\164" => "\125\x54\x46\x2d\70", "\x41\165\x74\x68\157\162\151\x7a\x61\x74\x69\x6f\x6e" => "\x42\x61\x73\x69\x63");
        $qW = array("\x6d\145\x74\x68\157\x64" => "\x50\117\123\x54", "\x62\157\x64\x79" => $ai, "\x74\151\155\145\157\x75\164" => "\65", "\x72\145\x64\x69\x72\145\143\164\151\157\156" => "\65", "\150\x74\x74\x70\x76\145\x72\163\x69\x6f\156" => "\x31\x2e\x30", "\x62\x6c\157\x63\x6b\151\x6e\x67" => true, "\150\x65\141\144\x65\x72\163" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function check_customer($Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\57\155\157\x61\163\57\162\x65\163\164\57\143\x75\x73\164\157\155\145\x72\57\143\150\x65\143\153\55\x69\146\55\x65\170\x69\x73\164\163";
        $KC = get_site_option("\155\157\137\x73\x61\x6d\154\137\141\144\155\x69\156\x5f\145\155\141\x69\x6c");
        $pi = array("\x65\155\x61\x69\x6c" => $KC);
        $ai = json_encode($pi);
        $qU = array("\x43\x6f\x6e\x74\x65\x6e\164\55\124\171\x70\x65" => "\x61\x70\x70\x6c\151\143\x61\x74\151\157\x6e\57\152\163\x6f\x6e", "\x63\x68\x61\x72\163\x65\x74" => "\x55\124\106\55\x38", "\x41\x75\164\x68\x6f\162\151\172\x61\x74\x69\x6f\156" => "\102\x61\x73\151\x63");
        $qW = array("\155\x65\x74\x68\x6f\144" => "\x50\117\x53\124", "\x62\157\144\171" => $ai, "\x74\x69\x6d\x65\157\x75\164" => "\65", "\x72\x65\x64\151\x72\145\143\x74\151\157\156" => "\x35", "\150\x74\164\x70\x76\x65\x72\x73\151\157\156" => "\61\x2e\x30", "\142\x6c\157\143\153\151\156\x67" => true, "\x68\145\141\x64\145\x72\163" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function send_otp_token($KC, $sR, $Cv, $wF = TRUE, $NQ = FALSE)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\57\155\157\141\x73\x2f\x61\x70\151\57\141\165\x74\x68\57\x63\x68\x61\154\154\x65\x6e\147\x65";
        $Pd = $this->defaultCustomerKey;
        $kI = $this->defaultApiKey;
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\163\150\x61\65\x31\62", $MP);
        $Pk = number_format($Pk, 0, '', '');
        if ($wF) {
            goto EL;
        }
        $pi = array("\143\165\x73\x74\157\x6d\145\162\113\x65\x79" => $Pd, "\160\150\157\x6e\145" => $sR, "\x61\165\164\x68\124\x79\x70\x65" => "\123\115\x53", "\164\162\141\x6e\163\x61\x63\x74\151\x6f\x6e\116\141\155\145" => "\x57\x50\40\155\x69\156\x69\117\x72\141\156\147\x65\x20\123\101\x4d\x4c\x20\62\56\60\40\123\123\x4f\40\120\x6c\165\x67\151\x6e");
        goto V2;
        EL:
        $pi = array("\x63\165\163\164\157\155\x65\x72\113\145\x79" => $Pd, "\x65\155\141\x69\x6c" => $KC, "\141\x75\164\x68\124\x79\160\145" => "\x45\115\101\111\x4c", "\164\162\141\x6e\163\141\143\164\151\157\x6e\x4e\x61\x6d\145" => "\127\x50\40\155\151\156\x69\x4f\162\x61\x6e\147\x65\40\123\101\x4d\x4c\x20\x32\x2e\60\x20\x53\x53\117\40\x50\x6c\x75\147\x69\156");
        V2:
        $ai = json_encode($pi);
        $qU = array("\x43\157\x6e\x74\145\156\x74\55\x54\x79\160\x65" => "\x61\160\160\x6c\x69\x63\x61\164\151\157\156\x2f\152\163\x6f\156", "\103\x75\163\164\157\x6d\x65\x72\x2d\x4b\x65\x79" => $Pd, "\124\151\155\145\163\x74\x61\x6d\160" => $Pk, "\x41\165\x74\x68\157\x72\x69\x7a\141\x74\x69\x6f\156" => $Hv);
        $qW = array("\155\145\164\150\x6f\144" => "\x50\x4f\123\x54", "\x62\x6f\x64\171" => $ai, "\x74\151\155\x65\157\165\x74" => "\65", "\x72\x65\x64\x69\x72\x65\143\x74\x69\x6f\x6e" => "\x35", "\x68\x74\164\160\166\145\162\163\x69\x6f\156" => "\61\56\x30", "\142\x6c\x6f\143\x6b\x69\x6e\x67" => true, "\x68\x65\141\144\x65\162\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function validate_otp_token($sI, $x3, $Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\x2f\155\x6f\141\163\57\x61\x70\x69\57\141\x75\164\x68\57\166\141\154\x69\x64\x61\164\x65";
        $Pd = $this->defaultCustomerKey;
        $kI = $this->defaultApiKey;
        $fi = get_site_option("\155\x6f\x5f\163\141\x6d\154\137\x61\144\x6d\151\x6e\x5f\x65\155\141\151\x6c");
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\163\150\x61\65\61\62", $MP);
        $Pk = number_format($Pk, 0, '', '');
        $pi = '';
        $pi = array("\164\x78\111\x64" => $sI, "\164\x6f\153\145\156" => $x3);
        $ai = json_encode($pi);
        $qU = array("\103\157\x6e\x74\145\x6e\164\55\124\171\160\145" => "\141\160\160\x6c\151\143\x61\164\151\x6f\x6e\x2f\152\163\x6f\156", "\x43\x75\x73\x74\157\x6d\x65\162\x2d\x4b\x65\x79" => $Pd, "\124\x69\x6d\x65\163\x74\x61\x6d\x70" => $Pk, "\101\165\164\150\x6f\x72\151\172\x61\164\151\x6f\156" => $Hv);
        $qW = array("\x6d\x65\x74\x68\x6f\x64" => "\120\x4f\x53\x54", "\142\157\x64\x79" => $ai, "\x74\151\x6d\145\157\x75\x74" => "\65", "\162\145\144\x69\x72\145\x63\164\x69\157\x6e" => "\x35", "\150\164\x74\160\x76\x65\162\163\151\157\156" => "\x31\x2e\x30", "\x62\154\x6f\x63\153\151\156\147" => true, "\x68\x65\x61\x64\x65\162\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function submit_contact_us($KC, $sR, $FB, $Cv)
    {
        $current_user = wp_get_current_user();
        $FB = "\x5b\127\x50\40\123\101\x4d\x4c\x20\62\56\x30\x20\x53\x65\x72\166\x69\143\x65\x20\120\162\x6f\166\151\144\145\162\40\x53\123\x4f\x20\114\x6f\x67\x69\x6e\x20\x50\x6c\x75\x67\x69\156\135\40" . $FB;
        $pi = array("\146\x69\x72\x73\164\x4e\141\x6d\x65" => $current_user->user_firstname, "\x6c\141\x73\164\116\141\x6d\145" => $current_user->user_lastname, "\143\x6f\x6d\x70\141\x6e\x79" => $_SERVER["\123\105\122\x56\x45\x52\137\116\101\115\105"], "\145\x6d\141\151\x6c" => $KC, "\160\150\157\x6e\x65" => $sR, "\x71\x75\145\162\x79" => $FB);
        $ai = json_encode($pi);
        $yO = mo_options_plugin_constants::HOSTNAME . "\x2f\155\157\x61\x73\57\162\x65\x73\x74\x2f\143\x75\163\164\157\155\x65\162\x2f\x63\x6f\156\164\x61\143\164\55\x75\x73";
        $qU = array("\103\157\x6e\164\x65\x6e\164\x2d\x54\171\160\x65" => "\141\x70\x70\x6c\x69\143\x61\x74\x69\157\x6e\x2f\x6a\x73\x6f\x6e", "\x63\x68\x61\x72\163\x65\164" => "\125\124\x46\55\x38", "\x41\x75\x74\150\x6f\162\x69\172\141\x74\x69\157\156" => "\102\x61\x73\151\x63");
        $qW = array("\x6d\x65\x74\150\157\144" => "\120\x4f\x53\x54", "\142\157\144\171" => $ai, "\x74\x69\155\145\157\165\164" => "\x35", "\162\x65\144\x69\x72\x65\143\x74\x69\x6f\156" => "\65", "\x68\164\164\x70\x76\145\x72\163\x69\157\x6e" => "\61\56\x30", "\x62\154\x6f\143\153\x69\x6e\147" => true, "\150\145\x61\x64\x65\x72\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function mo_saml_send_alert_email($Dr, $Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\x6f\141\163\57\141\x70\151\x2f\x6e\157\164\x69\x66\x79\57\x73\145\156\x64";
        $Pd = get_site_option("\155\157\137\163\141\x6d\154\137\x61\x64\155\151\x6e\137\143\x75\x73\x74\157\155\145\162\x5f\x6b\x65\x79");
        $kI = get_site_option("\155\157\x5f\163\141\x6d\x6c\137\141\144\155\x69\156\x5f\x61\x70\x69\137\153\x65\171");
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\163\x68\141\x35\x31\62", $MP);
        $Pk = number_format($Pk, 0, '', '');
        $GK = get_site_option("\155\x6f\137\x73\141\155\x6c\137\141\x64\x6d\x69\156\x5f\145\x6d\x61\151\154");
        $sb = "\x48\145\x6c\x6c\x6f\x2c\74\x62\x72\76\74\142\x72\x3e\x59\x6f\x75\162\40\74\142\76\x46\x52\x45\x45\x20\x54\x72\x69\x61\x6c\x3c\x2f\142\76\40\x77\x69\x6c\x6c\40\x65\x78\x70\x69\162\x65\x20\x69\156\x20" . $Dr . "\x20\x64\141\171\x73\40\x66\157\x72\x20\155\x69\x6e\151\117\x72\141\156\147\x65\x20\123\x41\115\114\40\x70\x6c\165\147\x69\156\x20\157\x6e\40\171\x6f\165\162\40\x77\145\142\163\x69\164\x65\x20\x3c\142\x3e" . get_bloginfo() . "\x3c\x2f\x62\x3e\56\x3c\142\x72\76\74\x62\x72\x3e\74\x61\40\x68\162\145\x66\75\47\x68\164\164\160\x73\72\57\x2f\154\157\147\151\156\56\170\x65\143\x75\x72\x69\x66\171\x2e\143\x6f\x6d\57\155\x6f\x61\163\57\x6c\157\x67\151\156\77\162\x65\144\x69\x72\x65\143\x74\125\162\154\x3d\x68\164\x74\x70\x73\72\x2f\57\x6c\x6f\x67\x69\156\56\x78\145\143\165\162\x69\x66\171\56\x63\x6f\x6d\57\155\x6f\141\x73\57\x69\156\x69\x74\x69\x61\x6c\151\172\145\160\141\171\155\x65\156\164\x26\x72\x65\161\165\145\x73\x74\117\162\x69\147\151\156\x3d\167\160\x5f\163\x61\155\x6c\x5f\x73\163\x6f\137\142\141\163\x69\143\x5f\x70\154\141\x6e\47\x3e\x43\154\151\143\153\x20\x68\x65\x72\145\x3c\x2f\x61\76\40\164\x6f\40\165\x70\147\x72\x61\x64\x65\40\164\157\40\x6f\x75\162\40\x70\x72\x65\x6d\151\165\x6d\x20\160\x6c\141\156\x20\x73\157\157\x6e\x20\x69\146\x20\171\157\x75\x20\167\141\156\164\x20\164\157\40\x63\x6f\156\x74\x69\x6e\165\145\40\165\163\151\x6e\147\40\x6f\x75\x72\x20\160\154\x75\x67\x69\x6e\x2e\x20\131\x6f\x75\x20\x63\x61\156\x20\162\145\146\145\162\40\114\151\143\x65\x6e\x73\151\156\147\x20\164\141\x62\x20\146\157\x72\x20\157\x75\x72\40\x70\162\x65\155\x69\x75\x6d\40\160\x6c\141\156\163\56\x3c\x62\x72\76\x3c\x62\162\x3e\x54\150\x61\156\x6b\x73\54\74\x62\162\76\155\x69\156\151\117\162\x61\x6e\147\x65";
        $CJ = "\x54\162\151\141\154\x20\166\145\162\x73\151\157\x6e\40\x65\x78\160\151\x72\151\156\147\x20\151\156\x20" . $Dr . "\x20\144\141\x79\163\x20\x66\157\x72\40\x6d\x69\x6e\x69\x4f\x72\141\156\x67\x65\x20\123\101\x4d\x4c\40\x70\x6c\x75\147\x69\156\40\x7c\x20" . get_bloginfo();
        if (!($Dr == 1)) {
            goto lj;
        }
        $sb = str_replace("\x64\141\171\x73", "\144\x61\171", $sb);
        $CJ = str_replace("\144\x61\x79\163", "\144\x61\171", $CJ);
        lj:
        $pi = array("\x63\x75\x73\x74\157\x6d\145\x72\x4b\145\171" => $Pd, "\163\145\x6e\144\105\155\141\x69\x6c" => true, "\x65\155\x61\151\154" => array("\x63\x75\x73\x74\157\x6d\x65\162\113\145\x79" => $Pd, "\x66\x72\x6f\x6d\105\x6d\141\151\154" => "\151\156\146\x6f\x40\170\145\x63\165\162\x69\146\171\x2e\143\x6f\155", "\x62\x63\143\x45\155\x61\151\x6c" => "\x61\156\151\x72\142\x61\156\x40\x78\x65\143\x75\162\x69\146\171\x2e\143\157\x6d", "\146\162\157\155\x4e\x61\x6d\x65" => "\x6d\151\x6e\151\117\x72\141\156\147\145", "\x74\157\x45\155\x61\x69\x6c" => $GK, "\164\x6f\x4e\141\x6d\x65" => $GK, "\x73\165\142\x6a\x65\x63\164" => $CJ, "\x63\x6f\x6e\x74\x65\156\x74" => $sb));
        $ai = json_encode($pi);
        $qU = array("\x43\x6f\156\164\145\156\x74\55\124\171\x70\145" => "\x61\160\160\154\x69\143\x61\164\151\157\x6e\x2f\152\163\157\156", "\x43\x75\163\x74\x6f\x6d\145\x72\55\x4b\x65\x79" => $Pd, "\x54\151\x6d\145\x73\x74\141\155\160" => $Pk, "\101\x75\x74\150\x6f\x72\151\x7a\141\x74\151\157\156" => $Hv);
        $qW = array("\155\x65\x74\150\157\144" => "\x50\117\x53\124", "\142\157\144\x79" => $ai, "\x74\x69\x6d\145\x6f\165\164" => "\x35", "\162\x65\x64\151\162\x65\x63\x74\151\157\156" => "\65", "\x68\164\164\x70\166\x65\162\163\x69\157\156" => "\61\56\x30", "\x62\x6c\157\143\x6b\x69\156\x67" => true, "\x68\145\141\x64\x65\162\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function mo_saml_forgot_password($KC, $Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\57\155\x6f\x61\x73\57\162\x65\x73\164\57\x63\x75\163\164\x6f\x6d\145\162\x2f\160\x61\163\163\x77\157\x72\x64\x2d\162\145\x73\x65\164";
        $Pd = get_site_option("\155\157\137\x73\x61\x6d\154\137\141\x64\155\x69\156\x5f\x63\x75\x73\164\x6f\x6d\145\162\137\x6b\x65\x79");
        $kI = get_site_option("\x6d\157\137\x73\x61\155\154\137\x61\x64\155\151\156\137\x61\160\x69\x5f\153\145\171");
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\x73\x68\x61\65\61\x32", $MP);
        $Pk = number_format($Pk, 0, '', '');
        $pi = '';
        $pi = array("\145\x6d\x61\x69\x6c" => $KC);
        $ai = json_encode($pi);
        $qU = array("\x43\157\x6e\x74\x65\156\164\x2d\124\171\x70\x65" => "\x61\x70\x70\154\x69\143\141\164\x69\157\156\x2f\152\163\x6f\156", "\x43\165\163\x74\x6f\x6d\145\x72\55\113\145\x79" => $Pd, "\x54\x69\155\x65\x73\x74\x61\155\x70" => $Pk, "\x41\x75\x74\x68\x6f\x72\151\x7a\x61\164\x69\157\156" => $Hv);
        $qW = array("\x6d\x65\164\x68\x6f\x64" => "\x50\x4f\123\124", "\x62\157\144\171" => $ai, "\x74\151\155\145\x6f\x75\164" => "\65", "\x72\x65\144\151\162\145\x63\x74\x69\x6f\x6e" => "\65", "\x68\164\164\x70\x76\145\x72\163\151\157\x6e" => "\61\56\60", "\142\154\x6f\143\153\151\156\x67" => true, "\x68\x65\x61\x64\145\x72\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function mo_saml_verify_license($wk, $Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\x2f\155\x6f\141\163\x2f\141\160\151\x2f\x62\141\143\153\165\160\x63\157\x64\145\x2f\x76\x65\x72\151\146\x79";
        $Pd = get_site_option("\x6d\x6f\137\163\x61\155\x6c\137\x61\x64\x6d\151\156\x5f\143\165\163\164\x6f\155\145\162\x5f\x6b\145\171");
        $kI = get_site_option("\x6d\x6f\137\x73\141\x6d\154\137\x61\144\x6d\151\156\137\x61\160\x69\x5f\x6b\145\171");
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\163\150\x61\65\61\62", $MP);
        $Pk = number_format($Pk, 0, '', '');
        $pi = '';
        $pi = array("\143\157\144\145" => $wk, "\143\x75\x73\x74\157\155\x65\x72\x4b\145\x79" => $Pd, "\141\144\144\x69\x74\151\157\x6e\x61\x6c\x46\151\x65\154\144\x73" => array("\146\x69\145\154\144\x31" => site_url()));
        $ai = json_encode($pi);
        $qU = array("\103\157\x6e\164\145\x6e\x74\55\124\171\x70\x65" => "\x61\x70\x70\154\x69\x63\x61\x74\151\x6f\x6e\57\x6a\163\157\x6e", "\x43\165\x73\164\157\155\145\x72\55\113\x65\x79" => $Pd, "\124\151\x6d\145\x73\x74\x61\155\x70" => $Pk, "\x41\165\164\150\x6f\162\151\172\x61\x74\151\x6f\x6e" => $Hv);
        $qW = array("\x6d\x65\164\150\x6f\144" => "\x50\117\x53\x54", "\x62\x6f\144\x79" => $ai, "\164\151\155\145\x6f\x75\x74" => "\65", "\x72\145\144\x69\162\x65\x63\x74\151\157\x6e" => "\65", "\150\x74\x74\x70\x76\x65\162\x73\x69\157\156" => "\61\x2e\60", "\142\x6c\157\143\153\151\156\x67" => true, "\150\145\141\144\145\x72\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function check_customer_ln($Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\x2f\155\x6f\x61\x73\x2f\162\x65\163\164\57\143\x75\x73\164\157\x6d\145\162\x2f\x6c\x69\x63\x65\x6e\163\x65";
        $Pd = get_site_option("\155\157\137\163\141\x6d\154\x5f\141\x64\x6d\x69\156\137\143\165\x73\164\x6f\155\x65\162\137\153\x65\x79");
        $kI = get_site_option("\x6d\x6f\137\x73\141\155\x6c\x5f\x61\x64\155\151\x6e\x5f\x61\160\x69\x5f\x6b\x65\x79");
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\163\150\141\x35\61\x32", $MP);
        $Pk = number_format($Pk, 0, '', '');
        $pi = '';
        $pi = array("\x63\x75\163\164\x6f\155\x65\x72\x49\x64" => $Pd, "\141\160\x70\154\151\x63\141\x74\x69\157\x6e\116\x61\x6d\145" => "\167\160\137\163\141\155\x6c\137\163\163\x6f\137\155\x75\154\164\x69\x73\151\164\x65\x5f\142\141\163\151\143\x5f\x70\x6c\x61\156");
        $ai = json_encode($pi);
        $qU = array("\x43\157\156\x74\x65\156\164\55\124\x79\x70\145" => "\141\x70\160\154\x69\x63\x61\x74\x69\157\x6e\57\152\163\157\x6e", "\103\x75\163\x74\157\x6d\x65\x72\x2d\x4b\145\171" => $Pd, "\124\x69\155\x65\x73\x74\141\x6d\160" => $Pk, "\101\x75\164\x68\x6f\162\x69\x7a\141\164\x69\157\156" => $Hv);
        $qW = array("\155\145\164\150\157\144" => "\120\117\x53\x54", "\142\x6f\144\171" => $ai, "\x74\x69\155\145\157\165\x74" => "\x35", "\x72\x65\144\x69\x72\145\x63\164\151\157\156" => "\65", "\x68\x74\164\160\166\145\162\163\151\157\x6e" => "\x31\x2e\60", "\142\154\x6f\143\x6b\x69\x6e\x67" => true, "\150\145\x61\144\x65\x72\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function mo_saml_update_status($Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\57\155\157\x61\x73\57\x61\160\151\x2f\x62\141\x63\153\165\x70\x63\x6f\x64\145\57\x75\x70\144\x61\x74\x65\163\164\x61\x74\165\163";
        $Pd = get_site_option("\x6d\x6f\137\x73\141\155\154\137\141\144\155\151\156\137\x63\165\x73\164\157\x6d\x65\162\137\x6b\145\171");
        $kI = get_site_option("\x6d\157\137\x73\x61\x6d\x6c\x5f\141\x64\155\x69\156\x5f\141\160\151\x5f\153\x65\171");
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\x73\150\x61\x35\x31\x32", $MP);
        $FE = get_site_option("\155\x6f\137\x73\x61\155\154\x5f\143\165\163\x74\x6f\x6d\x65\162\137\164\157\153\x65\x6e");
        $wk = AESEncryption::decrypt_data(get_site_option("\163\x6d\x6c\137\154\x6b"), $FE);
        $pi = array("\x63\157\144\145" => $wk, "\143\165\x73\164\x6f\155\145\162\x4b\145\x79" => $Pd);
        $ai = json_encode($pi);
        $Pk = number_format($Pk, 0, '', '');
        $qU = array("\x43\x6f\156\x74\x65\x6e\164\55\x54\x79\160\x65" => "\x61\x70\x70\154\151\143\141\x74\x69\157\x6e\x2f\152\163\157\156", "\x43\x75\163\164\x6f\x6d\x65\162\55\113\145\171" => $Pd, "\124\x69\x6d\x65\163\164\x61\x6d\x70" => $Pk, "\x41\x75\164\x68\x6f\162\x69\172\x61\164\x69\157\x6e" => $Hv);
        $qW = array("\155\145\x74\x68\x6f\144" => "\x50\117\123\124", "\x62\x6f\144\x79" => $ai, "\x74\151\155\x65\157\165\x74" => "\65", "\x72\x65\144\x69\x72\x65\x63\164\x69\157\156" => "\x35", "\150\x74\164\160\166\x65\x72\163\151\157\156" => "\61\56\x30", "\142\154\x6f\143\153\x69\156\147" => true, "\x68\x65\x61\144\145\x72\x73" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function mo_saml_send_alert_email_for_license($FF, $Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\x2f\155\157\x61\x73\x2f\141\x70\x69\x2f\156\x6f\x74\x69\146\x79\57\x73\x65\x6e\x64";
        $Pd = get_site_option("\155\157\137\163\141\x6d\x6c\137\141\144\x6d\151\156\137\143\x75\x73\164\x6f\x6d\145\x72\x5f\x6b\x65\x79");
        $kI = get_site_option("\155\157\x5f\x73\141\x6d\x6c\137\141\144\x6d\x69\x6e\x5f\141\x70\151\x5f\153\x65\x79");
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\x73\x68\141\65\61\62", $MP);
        $r2 = "\x43\165\163\x74\x6f\x6d\x65\162\x2d\113\145\171\72\40" . $Pd;
        $HX = "\124\x69\155\145\163\x74\x61\x6d\160\72\x20" . number_format($Pk, 0, '', '');
        $B9 = "\101\x75\164\150\x6f\162\x69\x7a\x61\164\151\157\156\x3a\x20" . $Hv;
        $GK = get_site_option("\155\x6f\137\x73\x61\155\154\137\141\144\x6d\x69\156\137\145\155\141\x69\154");
        if (function_exists("\147\145\x74\x5f\163\x69\164\x65\163") && class_exists("\x57\x50\x5f\x53\151\x74\x65\137\121\165\145\162\171")) {
            goto ud;
        }
        $dE = count(wp_get_sites());
        goto Gl;
        ud:
        $dE = count(get_sites());
        Gl:
        $sb = "\x48\145\x6c\154\157\x2c\x3c\142\x72\x3e\x3c\142\162\76\x59\157\165\x20\150\x61\x76\x65\40\160\x75\162\x63\150\141\163\x65\144\40\154\x69\143\x65\156\x73\145\40\146\x6f\x72\x20\x53\101\115\114\x20\x53\151\156\147\x6c\145\40\x53\151\x67\x6e\x2d\x4f\156\40\x50\154\165\147\x69\x6e\x20\x66\x6f\162\x20\x3c\142\x3e" . $FF . "\40\x73\151\x74\x65\x73\x3c\x2f\x62\x3e\56\x20\x41\163\40\x6e\165\155\x62\x65\x72\x20\157\146\x20\x73\151\x74\145\x73\40\151\x6e\x20\x79\x6f\x75\x72\x20\x6d\165\154\x74\151\163\x69\164\145\x20\x6e\145\x74\x77\157\162\153\x20\150\141\x76\145\x20\147\162\157\x77\156\x20\x74\x6f\40" . $dE . "\40\163\x69\164\145\x73\40\156\157\x77\56\40\131\x6f\x75\40\163\x68\157\x75\154\144\x20\x75\x70\x67\x72\x61\x64\145\x20\171\157\x75\x72\40\154\x69\x63\145\x6e\x73\145\40\146\157\x72\x20\155\151\x6e\x69\117\162\x61\156\x67\145\x20\123\x41\115\114\40\160\154\x75\147\x69\x6e\x20\157\x6e\40\171\157\x75\162\40\x77\x65\142\163\151\x74\x65\40\74\142\x3e" . get_bloginfo() . "\x3c\x2f\x62\x3e\x2e\x3c\x62\x72\76\x3c\142\x72\x3e\74\x61\40\x68\x72\x65\146\75\x27\150\164\164\160\x73\x3a\57\x2f\x6c\x6f\147\151\x6e\x2e\170\x65\x63\165\162\x69\x66\x79\x2e\143\157\155\57\x6d\157\x61\163\57\154\x6f\x67\x69\x6e\x3f\162\x65\x64\x69\162\145\x63\x74\x55\162\154\x3d\150\164\x74\x70\x73\72\57\x2f\154\x6f\147\151\156\56\170\145\x63\x75\162\151\146\171\56\x63\157\x6d\57\155\x6f\141\x73\x2f\x69\x6e\x69\164\x69\141\154\151\x7a\145\160\141\x79\x6d\x65\156\x74\x26\162\145\x71\x75\x65\x73\164\x4f\x72\x69\x67\151\x6e\75\x77\160\x5f\163\141\x6d\x6c\x5f\160\x72\x65\155\x69\x75\x6d\x5f\155\x75\x6c\x74\x69\163\151\164\x65\x5f\x73\x73\x6f\x5f\165\x70\147\162\141\144\145\x5f\160\x6c\141\x6e\47\x3e\103\x6c\151\143\153\40\x68\x65\162\145\x3c\x2f\141\x3e\40\164\157\40\142\x75\x79\40\x74\x68\x65\40\x6c\x69\143\145\x6e\x73\145\40\146\x6f\162\40" . $FF . "\40\163\151\164\145\x73\x20\164\x6f\x20\x63\x6f\x6e\x74\151\x6e\165\x65\40\165\x73\151\x6e\x67\40\157\165\162\x20\x70\154\165\x67\x69\x6e\x2e\x3c\142\162\76\x3c\x62\162\76\x54\x68\141\x6e\x6b\163\x2c\x3c\142\162\x3e\155\151\156\x69\117\162\x61\156\147\x65";
        $CJ = "\105\x78\x63\x65\145\144\145\144\x20\114\x69\143\145\x6e\163\x65\x20\x4c\151\x6d\151\x74\x20\106\157\162\40\x4e\x6f\x20\117\x66\x20\x53\151\164\145\163\40\x2d\x20\x57\157\162\144\x50\x72\x65\x73\x73\x20\123\101\115\x4c\x20\123\151\x6e\147\x6c\145\x20\123\151\147\x6e\x2d\x4f\156\40\x50\x72\x65\x6d\151\x75\x6d\40\x50\x6c\165\x67\151\156\x20\142\x79\40\155\151\156\x69\x4f\x72\x61\x6e\147\145\40\x7c\x20" . get_bloginfo();
        $Pk = number_format($Pk, 0, '', '');
        update_site_option("\x6c\151\x63\145\x6e\163\145\x5f\141\154\145\162\x74\137\145\x6d\x61\x69\x6c\x5f\x73\x65\156\x74", 1);
        $pi = array("\143\x75\x73\x74\157\155\145\x72\113\145\x79" => $Pd, "\x73\145\x6e\144\105\x6d\141\x69\154" => true, "\x65\x6d\141\151\x6c" => array("\143\165\x73\164\157\155\145\x72\x4b\x65\x79" => $Pd, "\x66\x72\x6f\155\105\155\141\151\x6c" => "\x69\156\146\157\100\170\x65\143\165\162\151\x66\x79\56\143\157\x6d", "\x62\143\x63\x45\155\x61\x69\154" => "\151\156\146\157\100\x78\x65\x63\x75\x72\151\x66\171\x2e\x63\157\155", "\146\x72\x6f\155\x4e\141\x6d\145" => "\155\x69\156\151\117\x72\141\156\147\x65", "\164\x6f\x45\155\x61\x69\x6c" => $GK, "\164\x6f\116\141\x6d\x65" => $GK, "\x73\165\x62\152\x65\143\164" => $CJ, "\x63\157\156\x74\145\x6e\164" => $sb));
        $ai = json_encode($pi);
        $qU = array("\x43\157\156\x74\x65\x6e\x74\55\124\171\x70\145" => "\141\160\160\x6c\x69\143\141\164\151\x6f\x6e\x2f\x6a\x73\x6f\x6e", "\x43\165\163\x74\157\x6d\145\162\x2d\113\x65\171" => $Pd, "\124\x69\x6d\x65\x73\164\141\155\160" => $Pk, "\101\x75\x74\150\157\162\151\x7a\x61\x74\151\x6f\x6e" => $Hv);
        $qW = array("\155\145\x74\x68\x6f\x64" => "\x50\117\x53\124", "\142\157\x64\171" => $ai, "\164\x69\155\145\157\165\164" => "\65", "\x72\x65\x64\x69\x72\145\x63\164\151\x6f\x6e" => "\65", "\150\164\164\160\x76\145\x72\163\x69\x6f\156" => "\61\56\x30", "\142\x6c\157\x63\153\151\156\147" => true, "\150\x65\141\144\x65\162\163" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
    function mo_saml_send_user_exceeded_alert_email($JQ, $Cv)
    {
        $yO = mo_options_plugin_constants::HOSTNAME . "\57\155\x6f\141\x73\x2f\141\x70\x69\x2f\156\157\x74\x69\x66\171\x2f\x73\x65\x6e\x64";
        $Pd = get_site_option("\155\157\137\163\x61\155\154\137\141\144\x6d\x69\156\x5f\143\x75\163\164\x6f\x6d\145\162\x5f\153\x65\171");
        $kI = get_site_option("\x6d\157\x5f\x73\141\155\154\x5f\x61\144\155\151\x6e\x5f\x61\160\151\x5f\x6b\145\x79");
        $Pk = round(microtime(true) * 1000);
        $MP = $Pd . number_format($Pk, 0, '', '') . $kI;
        $Hv = hash("\163\150\x61\65\61\62", $MP);
        $GK = get_site_option("\155\157\x5f\163\141\x6d\154\x5f\141\x64\x6d\151\x6e\137\145\x6d\x61\x69\x6c");
        $sb = "\110\145\x6c\x6c\x6f\54\x3c\142\x72\x3e\74\x62\x72\x3e\x59\x6f\x75\40\x68\141\166\145\x20\x70\x75\x72\x63\x68\x61\x73\145\x64\x20\x6c\151\143\x65\x6e\x73\x65\x20\x66\157\162\40\123\101\x4d\114\x20\123\151\156\147\x6c\x65\40\123\x69\147\x6e\x2d\x4f\156\x20\120\x6c\x75\x67\151\x6e\40\x66\x6f\x72\x20\x3c\x62\76" . $JQ . "\40\165\163\145\x72\163\74\x2f\142\76\56\40\101\x73\x20\x6e\x75\x6d\142\x65\x72\40\157\x66\x20\x75\163\145\x72\163\x20\157\x6e\x20\171\x6f\165\162\40\163\151\x74\145\x20\x68\x61\166\x65\40\147\162\157\167\x6e\x20\x74\157\40\155\157\x72\x65\x20\164\x68\x61\x6e\x20" . $JQ . "\40\165\x73\x65\x72\163\40\156\157\167\56\x20\x59\157\165\x20\163\x68\157\x75\x6c\x64\40\165\160\147\162\x61\x64\145\x20\x79\157\x75\x72\x20\154\x69\x63\x65\156\x73\x65\x20\146\157\x72\x20\x6d\151\x6e\x69\117\x72\141\156\x67\145\x20\x53\101\x4d\114\x20\x70\x6c\x75\147\151\156\40\157\156\40\171\x6f\165\162\x20\x77\145\142\x73\151\164\x65\40\x3c\x62\x3e" . get_bloginfo() . "\x3c\x2f\x62\x3e\x2e\74\x62\162\76\x3c\142\x72\76\x3c\x61\x20\x68\x72\x65\x66\x3d\x27" . mo_options_plugin_constants::HOSTNAME . "\57\155\157\x61\163\x2f\x6c\157\147\x69\156\77\162\145\x64\151\162\x65\x63\x74\125\x72\x6c\75" . mo_options_plugin_constants::HOSTNAME . "\57\151\156\x69\164\151\x61\154\151\172\x65\x70\x61\x79\x6d\x65\x6e\x74\x26\162\x65\161\165\145\163\164\x4f\x72\x69\147\151\x6e\75\167\x70\137\x73\x61\x6d\x6c\x5f\160\162\x65\155\151\165\x6d\x5f\155\165\154\164\x69\163\151\164\x65\137\x73\x73\x6f\x5f\x75\x70\147\x72\141\x64\x65\x5f\x70\154\x61\156\x27\76\x43\154\x69\x63\x6b\40\x68\145\162\145\74\57\141\x3e\40\164\x6f\40\x75\160\x67\162\141\144\x65\40\x74\x68\145\x20\x6c\151\143\145\156\x73\x65\x20\x74\157\x20\x63\157\156\164\x69\156\x75\145\40\165\x73\x69\156\x67\x20\x6f\165\162\x20\160\x6c\165\147\x69\156\56\74\142\x72\x3e\74\x62\x72\x3e\124\x68\x61\156\153\163\54\x3c\142\162\x3e\155\151\x6e\151\x4f\162\x61\x6e\147\x65";
        $CJ = "\105\x78\143\145\145\144\x65\144\x20\x4c\151\x63\145\156\163\x65\x20\114\151\155\151\x74\x20\106\157\162\40\116\157\40\x4f\146\40\125\163\145\162\163\40\55\40\127\157\162\144\x50\162\x65\163\x73\40\123\x41\115\x4c\40\x53\x69\x6e\147\x6c\x65\40\x53\x69\x67\x6e\x2d\117\156\40\120\x6c\165\x67\151\156\40\x7c\x20" . get_bloginfo();
        $Pk = number_format($Pk, 0, '', '');
        update_site_option("\165\x73\x65\x72\x5f\141\x6c\x65\162\x74\x5f\x65\155\x61\151\x6c\137\163\145\156\x74", 1);
        $pi = array("\143\x75\x73\164\x6f\x6d\x65\162\x4b\145\171" => $Pd, "\x73\x65\156\144\105\x6d\x61\x69\154" => true, "\x65\155\141\x69\154" => array("\x63\165\163\164\157\x6d\x65\x72\113\145\x79" => $Pd, "\146\162\157\x6d\x45\155\x61\151\x6c" => "\x69\x6e\x66\157\x40\x78\145\x63\x75\162\x69\x66\x79\56\143\x6f\x6d", "\142\x63\x63\105\x6d\141\x69\154" => "\x69\156\x66\x6f\x40\x78\x65\x63\165\162\x69\x66\x79\x2e\x63\x6f\x6d", "\x66\x72\x6f\x6d\116\x61\155\x65" => "\x6d\x69\156\151\x4f\162\141\156\147\x65", "\164\x6f\105\155\141\151\154" => $GK, "\164\157\116\141\x6d\x65" => $GK, "\163\165\142\x6a\145\x63\x74" => $CJ, "\x63\x6f\x6e\164\x65\x6e\164" => $sb));
        $ai = json_encode($pi);
        $qU = array("\103\x6f\x6e\164\145\156\x74\55\x54\171\160\145" => "\x61\160\160\x6c\x69\x63\x61\164\151\157\156\x2f\152\x73\157\x6e", "\103\x75\163\x74\x6f\x6d\145\162\x2d\113\145\171" => $Pd, "\124\151\155\145\163\x74\x61\x6d\160" => $Pk, "\101\165\x74\x68\x6f\x72\x69\x7a\x61\164\151\157\156" => $Hv);
        $qW = array("\x6d\145\x74\150\157\144" => "\x50\x4f\x53\x54", "\x62\157\x64\x79" => $ai, "\x74\x69\x6d\145\157\165\x74" => "\65", "\x72\145\144\151\162\145\143\x74\151\157\x6e" => "\x35", "\x68\x74\164\x70\166\145\162\163\151\x6f\x6e" => "\x31\56\60", "\x62\x6c\x6f\x63\x6b\151\x6e\x67" => true, "\x68\145\141\x64\x65\162\163" => $qU);
        $rD = Utilities::mo_saml_wp_remote_call($yO, $Cv, $qW);
        return $rD;
    }
}