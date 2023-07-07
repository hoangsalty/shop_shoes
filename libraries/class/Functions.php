<?php
class Functions
{
    private $d;

    public function getCurrentPageURL_Sort()
    {
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        $pageURL = explode("&", $pageURL);
        return $pageURL[0];
    }

    function __construct($d)
    {
        $this->d = $d;
    }
    /* Is fanpage */
    public function isFanpage($str)
    {
        if (preg_match('/^(https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is date */
    public function isDate($str)
    {
        if (preg_match('/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is phone */
    public function isPhone($number)
    {
        $number = str_replace(" ", "", $number);;
        if (preg_match_all('/^(0|84)(2(0[3-9]|1[0-6|8|9]|2[0-2|5-9]|3[2-9]|4[0-9]|5[1|2|4-9]|6[0-3|9]|7[0-7]|8[0-9]|9[0-4|6|7|9])|3[2-9]|5[5|6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])([0-9]{7})$/m', $number, $matches, PREG_SET_ORDER, 0)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is email */
    public function isEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is match */
    public function isMatch($value1, $value2)
    {
        if ($value1 == $value2) {
            return true;
        } else {
            return false;
        }
    }
    /* Account exists */
    public function checkExist($data = '', $type = '', $tbl = '', $id = 0)
    {
        global $d;

        if (!empty($data) && !empty($type) && !empty($tbl)) {
            $where = (!empty($id)) ? ' and id != ' . $id : '';
            $row = $d->rawQueryOne("select id from table_$tbl where $type = ? $where limit 0,1", array($data));
            if (!empty($row)) {
                return true;
            }
        }
        return false;
    }
    /* Check letters and nums */
    public function isAlphaNum($str)
    {
        if (preg_match('/^[a-z0-9]+$/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is url youtube */
    public function isYoutube($str)
    {
        if (preg_match('/https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube\.com\/watch\?)((?:[\w\d\-\_\=]+&amp;(?:amp;)?)*v(?:&lt;[A-Z]+&gt;)?=([0-9a-zA-Z\-\_]+))/i', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is url */
    public function isUrl($str)
    {
        if (preg_match('/^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is number */
    public function isNumber($numbs)
    {
        if (preg_match('/^[0-9]+$/', $numbs)) {
            return true;
        }

        return false;
    }
    /* Lấy youtube */
    public function getYoutube($url = '')
    {
        if ($url != '') {
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);

            if ($matches[1] != '')
                return $matches[1];
        }
        return false;
    }

    function var_dump($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    /* Kiểm tra đăng nhập */
    public function checkLoginAdmin()
    {
        global $d;

        $token = (!empty($_SESSION['account']['user_token'])) ? $_SESSION['account']['user_token'] : '';
        $row = $d->rawQuery("select user_token from table_user where user_token = ? and find_in_set('hienthi',status)", array($token));
        if (!empty($row)) {
            return true;
        } else {
            unset($_SESSION['account']);
            return false;
        }
    }

    /* Kiểm tra dữ liệu nhập vào */
    public function cleanInput($input = '', $type = '')
    {
        $output = '';
        if ($input != '') {
            // Loại bỏ HTML tags
            /* '@<[\/\!]*?[^<>]*?>@si', */
            $search = array(
                'script' => '@<script[^>]*?>.*?</script>@si',
                'style' => '@<style[^>]*?>.*?</style>@siU',
                'blank' => '@<![\s\S]*?--[ \t\n\r]*>@',
                'iframe' => '/<iframe(.*?)<\/iframe>/is',
                'title' => '/<title(.*?)<\/title>/is',
                'pre' => '/<pre(.*?)<\/pre>/is',
                'frame' => '/<frame(.*?)<\/frame>/is',
                'frameset' => '/<frameset(.*?)<\/frameset>/is',
                'object' => '/<object(.*?)<\/object>/is',
                'embed' => '/<embed(.*?)<\/embed>/is',
                'applet' => '/<applet(.*?)<\/applet>/is',
                'meta' => '/<meta(.*?)<\/meta>/is',
                'doctype' => '/<!doctype(.*?)>/is',
                'link' => '/<link(.*?)>/is',
                'body' => '/<body(.*?)<\/body>/is',
                'html' => '/<html(.*?)<\/html>/is',
                'head' => '/<head(.*?)<\/head>/is',
                'onclick' => '/onclick="(.*?)"/is',
                'ondbclick' => '/ondbclick="(.*?)"/is',
                'onchange' => '/onchange="(.*?)"/is',
                'onmouseover' => '/onmouseover="(.*?)"/is',
                'onmouseout' => '/onmouseout="(.*?)"/is',
                'onmouseenter' => '/onmouseenter="(.*?)"/is',
                'onmouseleave' => '/onmouseleave="(.*?)"/is',
                'onmousemove' => '/onmousemove="(.*?)"/is',
                'onkeydown' => '/onkeydown="(.*?)"/is',
                'onload' => '/onload="(.*?)"/is',
                'onunload' => '/onunload="(.*?)"/is',
                'onkeyup' => '/onkeyup="(.*?)"/is',
                'onkeypress' => '/onkeypress="(.*?)"/is',
                'onblur' => '/onblur="(.*?)"/is',
                'oncopy' => '/oncopy="(.*?)"/is',
                'oncut' => '/oncut="(.*?)"/is',
                'onpaste' => '/onpaste="(.*?)"/is',
                'php-tag' => '/<(\?|\%)\=?(php)?/',
                'php-short-tag' => '/(\%|\?)>/'
            );
            if (!empty($type)) {
                unset($search[$type]);
            }
            $output = preg_replace($search, '', $input);
        }
        return $output;
    }
    /* Kiểm tra dữ liệu nhập vào */
    public function checkInput($input = '', $type = '')
    {
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = $this->checkInput($val, $type);
            }
        } else {
            $output = $this->cleanInput($input, $type);
        }
        return $output;
    }
    /* UTF8 convert */
    public function utf8Convert($str = '')
    {
        if ($str != '') {
            $utf8 = array(
                'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'd' => 'đ|Đ',
                'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
                'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
                '' => '`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\“|\”|\:|\;|_',
            );
            foreach ($utf8 as $ascii => $uni) {
                $str = preg_replace("/($uni)/i", $ascii, $str);
            }
        }
        return $str;
    }
    /* Chuyển đổi tên thành slug link (vd: Hoàng Phạm -> hoang-pham) */
    public function changeTitle($text = '')
    {
        if ($text != '') {
            $text = strtolower($this->utf8Convert($text));
            $text = preg_replace("/[^a-z0-9-\s]/", "", $text);
            $text = preg_replace('/([\s]+)/', '-', $text);
            $text = str_replace(array('%20', ' '), '-', $text);
            $text = preg_replace("/\-\-\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-/", "-", $text);
            $text = '@' . $text . '@';
            $text = preg_replace('/\@\-|\-\@|\@/', '', $text);
        }
        return $text;
    }
    /* Has file */
    public function hasFile($file)
    {
        if (isset($_FILES[$file])) {
            if ($_FILES[$file]['error'] == 4) {
                return false;
            } else if ($_FILES[$file]['error'] == 0) {
                return true;
            }
        }

        return false;
    }
    /* Upload name */
    public function uploadName($name = '')
    {
        $result = '';
        if ($name != '') {
            $rand = rand(1000, 9999);
            $new_name = pathinfo($name, PATHINFO_FILENAME);
            $result = $this->changeTitle($new_name) . "-" . $rand;
        }
        return $result;
    }
    /* Upload images */
    public function uploadImage($file = '', $folder = '')
    {
        if (isset($_FILES[$file]) && !$_FILES[$file]['error']) {
            $postMaxSize = ini_get('post_max_size');
            $MaxSize = explode('G', $postMaxSize);
            $MaxSize = $MaxSize[0];

            if ($_FILES[$file]['size'] > $MaxSize * 1048576) {
                echo ('Dung lượng file không được vượt quá ' . $postMaxSize);
                return false;
            }

            $ext = explode('.', $_FILES[$file]['name']);
            $ext = strtolower(end($ext));
            $allowed_ext = ".jpg|.png|.jpeg";
            if (strpos($allowed_ext, $ext) === false) {
                echo ('Chỉ hỗ trợ upload file dạng ' . $allowed_ext);
                return false;
            }

            if (!copy($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                if (!move_uploaded_file($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                    return false;
                }
            }

            return $_FILES[$file]['name'];
        }
    }
    /* Get image */
    public function getImage($data = array())
    {
        global $config;
        /* Defaults */
        $defaults = [
            'class' => 'lazy',
            'width' => '',
            'height' => '',
            'upload' => '',
            'image' => '',
            'upload-error' => 'assets/images/',
            'image-error' => 'noimage.png',
            'alt' => ''
        ];
        /* Data */
        $info = array_merge($defaults, $data);
        /* Upload - Image */
        if (empty($info['upload']) || empty($info['image'])) {
            $info['upload'] = $info['upload-error'];
            $info['image'] = $info['image-error'];
        }
        /* Path error */
        $info['pathError'] = $info['upload-error'] . $info['image-error'];
        /* Path origin */
        $info['pathOrigin'] = $info['upload'] . $info['image'];
        /* Path src */
        $info['pathSrc'] = $info['pathOrigin'];
        /* Src */
        $info['src'] = "src='" . $info['pathSrc'] . "'";
        /* Class */
        $info['class'] = (!empty($info['class'])) ? "class='" . $info['class'] . "'" : "";

        /* Image */
        $result = "<img " . $info['class'] . " style='width:" . $info['width'] . "px; height:" . $info['height'] . "px' onerror=\"this.src='" . $info['pathError'] . "';\" " . $info['src'] . " alt='" . $info['alt'] . "'/>";
        return $result;
    }
    /* Redirect */
    public function redirect($url = '')
    {
        header("location:$url", true);
        exit();
    }
    /* Transfer */
    public function transferAdmin($msg = '', $page = '', $numb1 = true)
    {
        global $configBase;
        $basehref = $configBase;
        $showtext = $msg;
        $page_transfer = ADMIN . '/' . $page;
        $numb = $numb1;
        include("../templates/layout/transfer.php");
        exit();
    }
    public function transfer($msg = '', $page = '', $numb1 = true)
    {
        global $configBase;
        $basehref = $configBase;
        $showtext = $msg;
        $page_transfer = $page;
        $numb = $numb1;
        include("./templates/layout/transfer.php");
        exit();
    }
    /* Lấy link page hiện tại */
    public function getCurrentPageURL()
    {
        $pageURL = 'http://';
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        $urlpos = strpos($pageURL, "?page");
        $pageURL = ($urlpos) ? explode("?page=", $pageURL) : explode("&page=", $pageURL);
        return $pageURL[0];
    }

    /* Pagination */
    public function pagination($totalq = 0, $perPage = 10, $page = 1, $url = '?')
    {
        $urlpos = strpos($url, "?");
        $url = ($urlpos) ? $url . "&" : $url . "?";
        $total = $totalq;
        $adjacents = 2;
        $firstlabel = "First";
        $prevlabel = "Prev";
        $nextlabel = "Next";
        $lastlabel = "Last";
        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $perPage;
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total / $perPage);
        $lpm1 = $lastpage - 1;

        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<div class='pagination flex-wrap justify-content-center mb-0'>";
            $pagination .= "<a class='page-link first' href='{$this->getCurrentPageURL()}'>{$firstlabel}</a>";
            $pagination .= "<a class='page-link prev' href='{$url}page={$prev}'>{$prevlabel}</a>";

            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<a class='page-link active'>{$counter}</a>";
                    else
                        $pagination .= "<a class='page-link' href='{$url}page={$counter}'>{$counter}</a>";
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $pagination .= "<a class='page-link active'>{$counter}</a>";
                        else
                            $pagination .= "<a class='page-link' href='{$url}page={$counter}'>{$counter}</a>";
                    }
                    $pagination .= "<a class='page-link' href='{$url}page=1'>...</a>";
                    $pagination .= "<a class='page-link' href='{$url}page={$lpm1}'>{$lpm1}</a>";
                    $pagination .= "<a class='page-link' href='{$url}page={$lastpage}'>{$lastpage}</a>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<a class='page-link' href='{$url}page=1'>1</a>";
                    $pagination .= "<a class='page-link' href='{$url}page=2'>2</a>";
                    $pagination .= "<a class='page-link' href='{$url}page=1'>...</a>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<a class='page-link active'>{$counter}</a>";
                        else
                            $pagination .= "<a class='page-link' href='{$url}page={$counter}'>{$counter}</a>";
                    }
                    $pagination .= "<a class='page-link' href='{$url}page=1'>...</a>";
                    $pagination .= "<a class='page-link' href='{$url}page={$lpm1}'>{$lpm1}</a>";
                    $pagination .= "<a class='page-link' href='{$url}page={$lastpage}'>{$lastpage}</a>";
                } else {
                    $pagination .= "<a class='page-link' href='{$url}page=1'>1</a>";
                    $pagination .= "<a class='page-link' href='{$url}page=2'>2</a>";
                    $pagination .= "<a class='page-link' href='{$url}page=1'>...</a>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<a class='page-link active'>{$counter}</a>";
                        else
                            $pagination .= "<a class='page-link' href='{$url}page={$counter}'>{$counter}</a>";
                    }
                }
            }

            $pagination .= "<a class='page-link next' href='{$url}page={$next}'>{$nextlabel}</a>";
            $pagination .= "<a class='page-link last' href='{$url}page=$lastpage'>{$lastlabel}</a>";
            $pagination .= "</div>";
        }
        return $pagination;
    }

    /* Get category by ajax */
    public function getAjaxCategory($level = '', $title_select = 'Chọn danh mục', $class_select = 'select-category')
    {
        global $d;

        $where = '';
        $params = array();
        $id_parent = 'id_' . $level;
        $data_table = '';
        $data_child = '';

        if ($level == 'list') {
            $data_table = 'data-table="table_product_cat"';
            $data_child = 'data-child="id_cat"';
        } else if ($level == 'cat') {
            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);
        }

        $rows = $d->rawQuery("select name, id from table_product_" . $level . " where id > 0 " . $where . " order by id desc", $params);
        $str = '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" ' . $data_table . ' ' . $data_child . ' class="form-control select2 ' . $class_select . '"><option value="0">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int) $_REQUEST[$id_parent]))
                $selected = "selected";
            else
                $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Decode html characters */
    public function decodeHtmlChars($htmlChars)
    {
        return htmlspecialchars_decode($htmlChars ?: '');
    }
    /* Check title */
    public function checkTitle($data = array())
    {
        $result = array();
        if (isset($data['name'])) {
            $title = trim($data['name']);
            if (empty($title)) {
                $result[] = 'Tiêu đề không được trống';
            }
        }
        return $result;
    }
    /* Check slug */
    public function checkSlug($data = array())
    {
        global $d;

        $result = 'valid';
        if (isset($data['slug'])) {
            $slug = trim($data['slug']);
            if (!empty($slug)) {
                $table = array(
                    "table_product_list",
                    "table_product",
                    "table_news",
                    "table_static",
                );
                $where = (!empty($data['id'])) ? "id != " . $data['id'] . " and " : "";
                foreach ($table as $v) {
                    $check = $d->rawQueryOne("select id from $v where $where slug = ? limit 0,1", array($data['slug']));
                    if (!empty($check['id'])) {
                        $result = 'exist';
                        break;
                    }
                }
            } else {
                $result = 'empty';
            }
        }
        return $result;
    }
    /* Join column */
    public function joinCols($array = null, $column = null)
    {
        $str = '';
        $arrayTemp = array();
        if ($array && $column) {
            foreach ($array as $k => $v) {
                if (!empty($v[$column])) {
                    $arrayTemp[] = $v[$column];
                }
            }
            if (!empty($arrayTemp)) {
                $arrayTemp = array_unique($arrayTemp);
                $str = implode(",", $arrayTemp);
            }
        }
        return $str;
    }
    /* Get color */
    public function getColor($id = 0)
    {
        global $d;
        if ($id) {
            $temps = $d->rawQuery("select id_color from table_product_color where id_product = ?", array($id));
            $temps = (!empty($temps)) ? $this->joinCols($temps, 'id_color') : array();
            $temps = (!empty($temps)) ? explode(",", $temps) : array();
        }
        $row_color = $d->rawQuery("select * from table_color where find_in_set('hienthi',status) order by id desc");

        $str = '<select id="dataColor" name="dataColor[]" class="select multiselect" multiple="multiple" >';
        for ($i = 0; $i < count($row_color); $i++) {
            if (!empty($temps)) {
                if (in_array($row_color[$i]['id'], $temps))
                    $selected = 'selected="selected"';
                else
                    $selected = '';
            } else {
                $selected = '';
            }
            $str .= '<option value="' . $row_color[$i]["id"] . '" ' . $selected . ' /> ' . $row_color[$i]["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get size */
    public function getSize($id = 0)
    {
        global $d;
        if ($id) {
            $temps = $d->rawQuery("select id_size from table_product_size where id_product = ?", array($id));
            $temps = (!empty($temps)) ? $this->joinCols($temps, 'id_size') : array();
            $temps = (!empty($temps)) ? explode(",", $temps) : array();
        }
        $row_size = $d->rawQuery("select * from table_size where find_in_set('hienthi',status) order by id desc");

        $str = '<select id="dataSize" name="dataSize[]" class="select multiselect" multiple="multiple" >';
        for ($i = 0; $i < count($row_size); $i++) {
            if (!empty($temps)) {
                if (in_array($row_size[$i]['id'], $temps))
                    $selected = 'selected="selected"';
                else
                    $selected = '';
            } else {
                $selected = '';
            }
            $str .= '<option value="' . $row_size[$i]["id"] . '" ' . $selected . ' /> ' . $row_size[$i]["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }

    /* Format money */
    public function formatMoney($price = 0, $unit = ' ₫')
    {
        $str = '';

        $str .= number_format($price, 0, ',', '.');
        if ($unit != '') {
            $str .= $unit;
        }

        return $str;
    }
    /* Get permission */
    public function getPermission($permission = '')
    {
        $row = array(
            array('id' => 'admin', 'name' => 'Nhóm quyền admin'),
            array('id' => 'user', 'name' => 'Nhóm quyền người dùng'),
        );
        $str = '<select id="permission" name="data[permission]" class="form-control select2"><option value="">Nhóm quyền</option>';
        foreach ($row as $v) {
            if ($v["id"] == $permission)
                $selected = "selected";
            else
                $selected = "";

            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    public function getPermissionName($permission = '')
    {
        $str = '';
        $row = array(
            array('id' => 'admin', 'name' => 'Nhóm quyền admin'),
            array('id' => 'user', 'name' => 'Nhóm quyền người dùng'),
        );
        foreach ($row as $v) {
            if ($v["id"] == $permission) {
                $str = $v['name'];
                break;
            }
        }

        return $str;
    }
    /* Get status order */
    public function orderStatus($status = '')
    {
        global $d;

        $row = array(
            array('id' => 'moidat', 'name' => 'Mới đặt'),
            array('id' => 'daxacnhan', 'name' => 'Đã xác nhận'),
            array('id' => 'danggiaohang', 'name' => 'Đang giao hàng'),
            array('id' => 'dagiao', 'name' => 'Đã giao'),
            array('id' => 'dahuy', 'name' => 'Đã hủy'),
        );

        $str = '<select id="order_status" name="data[order_status]" class="form-control select2"><option value="">Chọn tình trạng</option>';
        foreach ($row as $v) {
            if (isset($_REQUEST['order_status']) && ($v["id"] == $_REQUEST['order_status']) || ($v["id"] == $status))
                $selected = "selected";
            else
                $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get payments order */
    function orderPayments()
    {
        global $d;

        //$momoPayment = array('slug' => 'momo', 'name' => 'Momo');
        $vnpayPayment = array('slug' => 'vnpay', 'name' => 'VNPAY');

        $row = $d->rawQuery("select * from table_news where type = ? order by id desc", array('hinh-thuc-thanh-toan'));
        //array_push($row, $momoPayment);
        array_push($row, $vnpayPayment);

        $str = '<select id="order_payment" name="order_payment" class="form-control select2"><option value="0">Chọn hình thức thanh toán</option>';
        foreach ($row as $v) {
            if (isset($_REQUEST['order_payment']) && ($v["slug"] == $_REQUEST['order_payment']))
                $selected = "selected";
            else
                $selected = "";
            $str .= '<option value=' . $v["slug"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Lấy thông tin chi tiết */
    public function getInfoDetail($cols = '', $table = '', $id = 0)
    {
        global $d;

        $row = array();
        if (!empty($cols) && !empty($table) && !empty($id)) {
            $row = $d->rawQueryOne("select $cols from table_$table where id = ? limit 0,1", array($id));
        }
        return $row;
    }
    public function getInfoDetailSlug($cols = '', $table = '', $slug = '')
    {
        global $d;

        $row = array();
        if (!empty($cols) && !empty($table) && !empty($slug)) {
            $row = $d->rawQueryOne("select $cols from table_$table where slug = ? limit 0,1", array($slug));
        }
        return $row;
    }
    /* String random */
    public function stringRandom($sokytu = 10)
    {
        $str = '';
        if ($sokytu > 0) {
            $chuoi = 'ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789';
            for ($i = 0; $i < $sokytu; $i++) {
                $vitri = mt_rand(0, strlen($chuoi));
                $str = $str . substr($chuoi, $vitri, 1);
            }
        }
        return $str;
    }

    public function checkLogin()
    {
        global $configBase, $d;

        if (empty($_COOKIE['login_account_id']) && empty($_COOKIE['login_account_session'])) {
            unset($_SESSION['account']);
            setcookie('login_account_id', "", -1, '/');
            setcookie('login_account_session', "", -1, '/');
        }
    }

    public function convertOrderStatus($status)
    {
        if ($status == 'moidat') return 'Mới đặt';
        if ($status == 'daxacnhan') return 'Đã xác nhận';
        if ($status == 'danggiaohang') return 'Đang giao hàng';
        if ($status == 'dagiao') return 'Đã giao';
        if ($status == 'dahuy') return 'Đã hủy';
    }

    //Momo
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    function getProvince()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/master-data/province',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'token: 534caacb-1284-11ee-b0c6-a260851ba65c'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true)["data"];
    }

    function getDistrict($province_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/master-data/district',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array('province_id' => $province_id),
            CURLOPT_HTTPHEADER => array(
                'token: 534caacb-1284-11ee-b0c6-a260851ba65c'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true)["data"];
    }

    function getWard($district_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id=' . $district_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'token: 534caacb-1284-11ee-b0c6-a260851ba65c'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true)["data"];
    }

    function currentGHNShop()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/v2/shop/all',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array('offset' => '0', 'limit' => '1', 'client_phone' => ''),
            CURLOPT_HTTPHEADER => array(
                'token: 534caacb-1284-11ee-b0c6-a260851ba65c'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true)["data"]['shops'][0];
    }

    function getGHNShipPrice($districtID, $wardID)
    {
        $shopDistrict = $this->currentGHNShop()['district_id'];
        $shopWard = $this->currentGHNShop()['ward_code'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '{
                "service_type_id": 2,
                "from_district_id": ' . $shopDistrict . ',
                "from_ward_code": "' . $shopWard . '",
                "to_district_id": ' . $districtID . ',
                "to_ward_code": "' . $wardID . '",
                "weight": 1
            }',
            CURLOPT_HTTPHEADER => array(
                'token: 534caacb-1284-11ee-b0c6-a260851ba65c',
                'shop_id: 4277742',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true)["data"]["total"];
    }

    public function GetProducts($items)
    {
        global $func, $config; ?>
        <div class="boxProduct">
            <?php foreach ($items as $k => $v) { ?>
                <div class="product">
                    <div class="box-product">
                        <div class="box-image">
                            <a class="pic-product scale-img" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                                <?= $func->getImage(['class' => 'w-100', 'width' => $config['product']['width'], 'height' => $config['product']['height'], 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                            </a>
                            <p class="social-product transition">
                                <a href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>" class="view-product">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="cart-add addcart" data-id="<?= $v['id'] ?>" data-action="addnow">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </p>
                        </div>
                        <div class="info-product">
                            <a class="name-product text-split" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                            <p class="price-product">
                                <?php if ($v['sale_price'] > 0) { ?>
                                    <span class="price-new"><?= $func->formatMoney($v['sale_price']) ?></span>
                                    <span class="price-old"><?= $func->formatMoney($v['regular_price']) ?></span>
                                    <span class="price-per"><?= '-' . round(100 - ($v['sale_price'] / $v['regular_price'] * 100)) . '%' ?></span>
                                <?php } else { ?>
                                    <?php if ($v['regular_price'] != 0) $giapro = $func->formatMoney($v['regular_price']);
                                    else $giapro = 'Liên hệ'; ?>
                                    <span class="price-text">Giá: </span>
                                    <span class="price-new"><?= $giapro ?></span>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php }
}
