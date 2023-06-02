<?php
/* Check login */
$func->checkLogin();

/* Router */
$router->setBasePath($config['database']['url']);
$router->map('GET', ADMIN, function () {
    global $config;
    $this->redirect($config['database']['url'] . ADMIN . "/index.php");
    exit;
});
$router->map('GET|POST', '', 'index', '');
$router->map('GET|POST', 'index.php', 'index', 'index');
$router->map('GET|POST', '[a:com]', 'allpage', 'show');
$router->map('GET|POST', '[a:com]/[a:action]', 'account', 'account');

/* Router match */
$match = $router->match();

/* Router check */
if (is_array($match)) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $com = (!empty($match['params']['com'])) ? htmlspecialchars($match['params']['com']) : htmlspecialchars($match['target']);
        $getPage = !empty($_GET['page']) ? htmlspecialchars($_GET['page']) : 1;
    }
} else {
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit;
}

/* Setting */
$setting = $d->rawQueryOne('select * from table_setting', array());
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;

/* Tối ưu link */
$requick = array(
    /* Sản phẩm */
    array("tbl" => "product_list", "field" => "idl", "source" => "product", "com" => "san-pham"),
    array("tbl" => "product_brand", "field" => "idb", "source" => "product", "com" => "san-pham"),
    array("tbl" => "product", "field" => "id", "source" => "product", "com" => "san-pham"),

    /* Thư viện ảnh */
    array("field" => "id", "source" => "album", "com" => "thu-vien-anh"),

    /* Video */
    array("field" => "id", "source" => "video", "com" => "video"),

    /* Bài viết */
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "tin-tuc"),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "chinh-sach"),

    /* Trang tĩnh */
    array("tbl" => "static", "field" => "id", "source" => "static", "com" => "gioi-thieu"),

);

/* Find data */
if (!empty($com) && !in_array($com, ['tim-kiem', 'account'])) {
    foreach ($requick as $k => $v) {
        $urlTbl = (!empty($v['tbl'])) ? $v['tbl'] : '';
        $urlType = (!empty($v['type'])) ? $v['type'] : '';
        $urlField = (!empty($v['field'])) ? $v['field'] : '';
        $urlCom = (!empty($v['com'])) ? $v['com'] : '';
        if (!empty($urlTbl)) {
            $row = $d->rawQueryOne("select id from table_$urlTbl where slug = ? and find_in_set('hienthi',status) limit 0,1", array($com));

            if (!empty($row['id'])) {
                $_GET[$urlField] = $row['id'];
                $com = $urlCom;
                break;
            }
        }
    }
}

switch ($com) {
    case 'index':
        $source = "index";
        $template = "index/index";
        break;

    case 'gioi-thieu':
        $source = "static";
        $template = "static/static";
        $type = $com;
        $titleMain = "Giới thiệu";
        break;

    case 'tin-tuc':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "news/news";
        $type = $com;
        $titleMain = "Tin tức";
        break;

    case 'san-pham':
        $source = "product";
        $template = isset($_GET['id']) ? "product/product_detail" : "product/product";
        $type = $com;
        $titleMain = "Sản phẩm";
        break;

    case 'thu-vien-anh':
        $source = "album";
        $template = isset($_GET['id']) ? "album/album_detail" : "album/album";
        $type = $com;
        $titleMain = "Thư viện ảnh";
        break;

    case 'tim-kiem':
        $source = "search";
        $template = "product/product";
        $titleMain = "Tìm kiếm";
        break;

    case 'video':
        $source = "video";
        $template = "video/video";
        $type = $com;
        $titleMain = "Video";
        break;

    case 'gio-hang':
        $source = "order";
        $template = 'order/order';
        break;

    case 'account':
        $source = "user";
        $titleMain = "Tài khoản";
        break;

    case 'momo-status':
        $source = "momo";
        $template = "payment/momo";
        break;

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}

/* Get datas for all page */
require_once SOURCES . "allpage.php";

/* Include sources */
if (!empty($source)) {
    include SOURCES . $source . ".php";
}
