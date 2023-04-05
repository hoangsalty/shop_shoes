<?php
/* Router */
$router->setBasePath($config['database']['url']);
$router->map('GET', ADMIN, function () {
    global $config;
    $this->redirect($config['database']['url'] . ADMIN . "/index.php");
    exit;
});
$router->map('GET|POST', '', 'index', 'home');
$router->map('GET|POST', 'index.php', 'index', 'index');
$router->map('GET|POST', '[a:com]', 'allpage', 'show');

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
    array("tbl" => "product", "field" => "id", "source" => "product", "com" => "san-pham"),

    /* Trang tĩnh */
    array("tbl" => "static", "field" => "id", "source" => "static", "com" => "gioi-thieu"),
);

/* Find data */
if (!empty($com)) {
    foreach ($requick as $k => $v) {
        $urlTbl = (!empty($v['tbl'])) ? $v['tbl'] : '';
        $urlType = (!empty($v['type'])) ? $v['type'] : '';
        $urlField = (!empty($v['field'])) ? $v['field'] : '';
        $urlCom = (!empty($v['com'])) ? $v['com'] : '';

        if (!empty($urlTbl)) {
            $row = $d->rawQueryOne("select id from table_$urlTbl where slug = ? and find_in_set('hienthi',status) limit 0,1", array($com));

            if (!empty($row)) {
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

    case 'san-pham':
        $source = "product";
        $template = isset($_GET['id']) ? "product/product_detail" : "product/product";
        $type = $com;
        $titleMain = "Sản phẩm";
        break;

    case 'khuyen-mai':
        $source = "product";
        $template = "product/product";
        $type = 'san-pham';
        $titleMain = "Khuyến mãi";
        break;

    case 'tim-kiem':
        $source = "search";
        $template = "product/product";
        $titleMain = "Tìm kiếm";
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
