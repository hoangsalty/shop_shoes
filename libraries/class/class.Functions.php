<?php
class Functions
{
    private $d;

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

        $token = (!empty($_SESSION['admin']['user_token'])) ? $_SESSION['admin']['user_token'] : '';
        $row = $d->rawQuery("select user_token from table_user where user_token = ? and find_in_set('hienthi',status)", array($token));
        if (!empty($row)) {
            return true;
        } else {
            unset($_SESSION['admin']);
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
    public function uploadImage($file = '', $folder = '', $newname = '')
    {
        if (isset($_FILES[$file]) && !$_FILES[$file]['error']) {
            $postMaxSize = ini_get('post_max_size');
            $MaxSize = explode('M', $postMaxSize);
            $MaxSize = $MaxSize[0];

            if ($_FILES[$file]['size'] > $MaxSize * 1048576) {
                echo ('Dung lượng file không được vượt quá ' . $postMaxSize);
                return false;
            }

            $ext = explode('.', $_FILES[$file]['name']);
            $ext = strtolower(end($ext));
            $allowed_ext = ".jpg|.gif|.png|.jpeg|.gif";
            if (strpos($allowed_ext, $ext) === false) {
                echo ('Chỉ hỗ trợ upload file dạng ' . $allowed_ext);
                return false;
            }

            $name = basename($_FILES[$file]['name'], '.' . $ext);
            if ($newname == '' && file_exists($folder . $_FILES[$file]['name']))
                for ($i = 0; $i < 100; $i++) {
                    if (!file_exists($folder . $name . $i . '.' . $ext)) {
                        $_FILES[$file]['name'] = $name . $i . '.' . $ext;
                        break;
                    }
                }
            else {
                $_FILES[$file]['name'] = $newname . '.' . $ext;
            }
            if (!copy($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                if (!move_uploaded_file($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                    return false;
                }
            }

            return $_FILES[$file]['name'];
        }
        return false;
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
    public function transfer($msg = '', $page = '', $numb1 = true)
    {
        global $configBase;
        $basehref = $configBase;
        $showtext = $msg;
        $page_transfer = $page;
        $numb = $numb1;
        include("../templates/layout/transfer.php");
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
        $adjacents = "2";
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
            $pagination .= "<ul class='pagination flex-wrap justify-content-center mb-0'>";
            if ($page > 1) {
                $pagination .= "<li class='page-item'><a class='page-link' href='{$this->getCurrentPageURL()}'>{$firstlabel}</a></li>";
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$prev}'>{$prevlabel}</a></li>";
            }
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                    else
                        $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$counter}'>{$counter}</a></li>";
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else
                            $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>...</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else
                            $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>...</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
                } else {
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else
                            $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                }
            }
            if ($page < $counter - 1) {
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$next}'>{$nextlabel}</a></li>";
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }
            $pagination .= "</ul>";
        }
        return $pagination;
    }

    /* Get category by link */
    public function getLinkCategory($table = '', $level = '', $title_select = 'Chọn danh mục')
    {
        global $d;

        $where = '';
        $id_parent = 'id_' . $level;

        $rows = $d->rawQuery("select name, id from table_" . $table . "_" . $level . " where id > 0 " . $where . " order by numb,id desc", array());
        $str = '<select id="' . $id_parent . '" name="' . $id_parent . '" onchange="onchangeCategory($(this))" class="form-control filter-category select2"><option value="0">' . $title_select . '</option>';
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
    /* Get category by ajax */
    public function getAjaxCategory($table = '', $level = '', $title_select = 'Chọn danh mục', $class_select = 'select-category')
    {
        global $d;

        $where = '';
        $id_parent = 'id_' . $level;

        $rows = $d->rawQuery("select name, id from table_" . $table . "_" . $level . " where id > 0 " . $where . " order by numb,id desc", array());
        $str = '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" class="form-control select2 ' . $class_select . '"><option value="0">' . $title_select . '</option>';
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
                    "table_product_brand",
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
        $row_color = $d->rawQuery("select * from table_color where date_deleted = 0 order by numb,id desc", array());

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
        $row_size = $d->rawQuery("select * from table_size where date_deleted = 0 order by numb,id desc", array());

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
    public function formatMoney($price = 0, $unit = 'đ', $html = false)
    {
        $str = '';

        if ($price) {
            $str .= number_format($price, 0, ',', '.');
            if ($unit != '') {
                if ($html) {
                    $str .= '<span>' . $unit . '</span>';
                } else {
                    $str .= $unit;
                }
            }
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

        $row = $d->rawQuery("select * from table_news where type = ? and date_deleted = 0 order by numb,id desc", array('hinh-thuc-thanh-toan'));
        $str = '<select id="order_payment" name="order_payment" class="form-control select2"><option value="0">Chọn hình thức thanh toán</option>';
        foreach ($row as $v) {
            if (isset($_REQUEST['order_payment']) && ($v["id"] == (int)$_REQUEST['order_payment']))
                $selected = "selected";
            else
                $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get place by ajax */
    public function getAjaxPlace($table = '', $title_select = 'Chọn danh mục')
    {
        global $d;

        $where = '';
        $params = array('0');
        $id_parent = 'id_' . $table;
        $data_level = '';
        $data_table = '';
        $data_child = '';
        if ($table == 'city') {
            $data_level = 'data-level="0"';
            $data_table = 'data-table="table_district"';
            $data_child = 'data-child="id_district"';
        } else if ($table == 'district') {
            $data_level = 'data-level="1"';
            $data_table = 'data-table="table_ward"';
            $data_child = 'data-child="id_ward"';
            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);
        } else if ($table == 'ward') {
            $data_level = '';
            $data_table = '';
            $data_child = '';
            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);
            $iddistrict = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
            $where .= ' and id_district = ?';
            array_push($params, $iddistrict);
        }
        $rows = $d->rawQuery("select name, id from table_" . $table . " where id <> ? " . $where . " order by id asc", $params, "result", 7200);
        $str = '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" ' . $data_level . ' ' . $data_table . ' ' . $data_child . ' class="form-control select2 select-place"><option value="0">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
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
}
