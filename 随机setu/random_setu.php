<?php

/**
 * 发送request请求
 * @param $url
 * @param bool $ssl
 * @param string $type
 * @param null $data
 * @return bool|mixed
 */
function is_request($url, $ssl = true, $type = 'GET', $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    $user_agent = isset($_SERVER['HTTP_USERAGENT']) ? $_SERVER['HTTP_USERAGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';
    curl_setopt($curl, CURLOPT_USERAGENT, $user_agent); //请求代理信息
    curl_setopt($curl, CURLOPT_AUTOREFERER, true); //referer头 请求来源
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); //请求超时
    curl_setopt($curl, CURLOPT_HEADER, false); //是否处理响应头
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //curl_exec()是否返回响应
    if ($ssl) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //禁用后curl将终止从服务端进行验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //检查服务器ssl证书中是否存在一个公用名（common name）
    }
    if ($type == "GET") {
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'content-type :application/x-www-form-urlencoded; charset=UTF-8'//使用UTF-8配合urlencode函数解决中文参数乱码问题
        ));
    }
    if ($type == "POST") {
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    //发出请求
    $response = curl_exec($curl);
    if ($response === false) {
        return false;
    }
    return $response;
}
?>
<?php
function loadImg(){
    if (!empty($_GET)) {
        if($_GET['r18'] == 1){
            $response = is_request("https://api.lolicon.app/setu/v2?r18=1&tag=".urlencode("萝莉"));
        }
    }else{
        $response = is_request("https://api.lolicon.app/setu/v2?r18=0&tag=".urlencode("萝莉"));//不要问为什么是萝莉，个人XP（
    }

    $arr = json_decode($response, true);
    //var_dump($arr["data"][0]["r18"]);//测试内容
    $img_url = $arr["data"][0]["urls"]["original"];
    return $img_url;
}
?>
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
    <p><img src="<?php echo loadImg(); ?>"></p>
    <footer>
        <p>使用API:<a href="https://api.lolicon.app/#/">LoliconAPI</a></p>
        <p>返回<a href="https://www.kaze-blog.co">风子的blog</a></p>
    </footer>
</body>

</html>
