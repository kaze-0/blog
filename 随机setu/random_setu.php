<?php
    function geturl($url){
        $headerArray =array("Content-type:application/x-www-form-urlencoded;","Accept:application/json","charset=UTF-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
        return $output;
    }
    function loadImg(){
        $r18 = 0;
        if(!empty($_GET)){
            if($_GET['r18'] == 1){
                $r18 = 1; 
            }
        }
        $response = geturl("https://api.lolicon.app/setu/v2?r18=$r18&tag=".urlencode("萝莉"));

        $img[0] = $response["data"][0]["urls"]["original"];
        $img[1] = $response["data"][0]["author"];
        return $img;
    }
    $img = loadImg();?>

<html>

<head>
    <style>
        img {height: 100%;}
        p {text-align:center;}
    </style>
    <meta name='robots' content='noindex,nofollow' />
    <title>随机loli setu</title>
</head>
<body>
    
    <p>画师：<?php echo $img[1]; ?><br></p>
    <p><img src="<?php echo $img[0]; ?>"></p>
    
    <footer>
        <p>使用API:<a href="https://api.lolicon.app/#/">LoliconAPI</a></p>
        <p>返回<a href="https://www.kaze-blog.co">风子的blog</a></p>
    </footer>
</body>

</html>
