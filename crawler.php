<?php

    $types = [
        'reality',
        'vless',
        'ss',
        'hy2',
        'trojan',
        'tuic',
        'vmess',
    ];
    $getList = file_get_contents('https://raw.githubusercontent.com/yebekhe/TVC/main/api/allConfigs.json?v1.'.time());
    $allConfigs = json_decode($getList, true);

    $i = 1;
    $list = [];
    foreach($types as $type) {
        $list[$type] = [];
        foreach ( $allConfigs as $config) {
            if ( $i > 50 ) {
                $i = 1;
                break;
            }
            if ($config['type'] === $type) {
                $list[$type][] = $config['config'];
                $i++;
            }
        }
    }

    $z = 1;
    $mix = "//profile-title: base64:TUlYIChBbWlyaW52ZW50b3IyMDEwLUZORVQwMCkg\n";
    $mix .= "//profile-update-interval: 6\n";
    $mix .= "//subscription-userinfo: upload=0; download=0; total=10737418240000000; expire=0\n";
    $mix .= "//support-url: https://x.com/Amirinventor201\n";
    $mix .= "//profile-web-page-url: https://Amirinventor2010.bio.link\n\n";
    foreach ( $allConfigs as $k => $config) {
        if ( $z > 50 ) {
            break;
        }
        if ( empty($config['config']) ) {
            continue;
        }
        $mix .= $config['config'].( $k !== end($allConfigs) ? "\n" : "");
        $z++;
    }
    file_put_contents("sub/mix", $mix);

    $html = "";
    foreach($types as $type) {
        $html .= "//profile-title: base64:".base64_encode(strtoupper($type)." (Amirinventor2010-FNET00)")."\n";
        $html .= "//profile-update-interval: 6\n";
        $html .= "//subscription-userinfo: upload=0; download=0; total=10737418240000000; expire=0\n";
        $html .= "//support-url: https://x.com/Amirinventor201\n";
        $html .= "//profile-web-page-url: https://Amirinventor2010.bio.link\n\n";
        foreach ( $list[$type] as $key => $l) {
            if ( empty($l) ) {
                continue;
            }
            $html .= $l.( $key !== end($list[$type]) ? "\n" : "");
        }
        file_put_contents("sub/".$type, $html);
        $html = '';
    }
