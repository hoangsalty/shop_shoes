<?php
class Comments
{
    public $total;
    public $total_star;
    public $count_star;
    public $star;
    public $lists = [];
    public $params = [];
    public $hasMedia;
    private $d;
    private $func;
    private $id_parent;
    private $errors = [];
    private $response = [];

    public function __construct($d, $func, $id = 0, $is_admin = false)
    {
        $this->d = $d;
        $this->func = $func;
        $this->hasMedia = true;

        if (!empty($id)) {
            $this->id_parent = $id;
            $this->total = $this->total($is_admin);
            $this->count_star = $this->countStar();
            $this->star = (!empty($this->count_star)) ? json_decode($this->count_star, true) : null;
            $this->total_star = $this->totalStar();
            $this->lists = $this->lists($is_admin);
        }
    }

    private function response()
    {
        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        } else {
            $response['success'] = true;
        }

        return json_encode($response);
    }

    public function countStar()
    {
        $count = array();

        for ($i = 1; $i <= 5; $i++) {
            $count[$i] = $this->getStar($i);
        }

        return json_encode($count);
    }

    private function getStar($star = 1)
    {
        $row = $this->d->rawQueryOne("select count(id) as num from table_comment where find_in_set('hienthi',status) and id_parent = ? and star = ?", array($this->id_parent, $star));
        return (!empty($row)) ? $row['num'] : 0;
    }

    private function totalStar()
    {
        $row = $this->d->rawQueryOne("select sum(star) as total_star from table_comment where find_in_set('hienthi',status) and id_parent = ?", array($this->id_parent));
        return !empty($row) ? $row['total_star'] : 0;
    }

    private function total($is_admin = false)
    {
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $rows = $this->d->rawQuery("select * from table_comment where $where id_parent = ? order by date_posted desc", array($this->id_parent));
        return (!empty($rows)) ? count($rows) : 0;
    }

    public function totalByID($id_parent = 0, $is_admin = false)
    {
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $row = $this->d->rawQueryOne("select count(id) as num from table_comment where $where id_parent = ? limit 0,1", array($id_parent));
        return (!empty($row)) ? $row['num'] : 0;
    }

    public function newPost($id_parent = 0, $status = '')
    {
        $row = $this->d->rawQuery("select id_parent from table_comment where id_parent = ? and find_in_set(?,status)", array($id_parent, $status));
        return (!empty($row)) ? count($row) : 0;
    }

    public function lists($is_admin = false)
    {
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $rows = $this->d->rawQuery("select * from table_comment where $where id_parent = ? order by date_posted desc", array($this->id_parent));
        return $rows;
    }

    public function photo($id_parent = 0)
    {
        $rows = $this->d->rawQuery("select id, photo from table_comment_photo where id_parent = ?", array($id_parent));
        return $rows;
    }

    public function poster($id_poster = 0)
    {
        $rows = $this->d->rawQueryOne("select * from table_user where id = ? limit 0,1", array($id_poster));
        return $rows;
    }

    public function perScore($num = 1)
    {
        return (!empty($this->total)) ? round(($this->star[$num] * 100) / $this->total, 1) : 0;
    }

    public function avgPoint()
    {
        return (!empty($this->total)) ? round((($this->total_star) / $this->total), 1) : 0;
    }

    public function avgStar()
    {
        return (!empty($this->total)) ? ($this->total_star * 100) / ($this->total * 5) : 0;
    }

    public function scoreStar($star = 0)
    {
        return (!empty($star)) ? ($star * 100) / 5 : 0;
    }

    public function subName($str = '')
    {
        $result = '';

        if (!empty($str)) {
            $arr = explode(' ', $str);

            if (count($arr) > 1) {
                $result = substr($arr[0], 0, 1) . substr(end($arr), 0, 1);
            } else {
                $result = substr($arr[0], 0, 1);
            }
        }

        return $result;
    }

    public function add()
    {
        global $config;

        $data = (!empty($_POST['dataReview'])) ? $_POST['dataReview'] : null;

        if (!empty($data)) {
            foreach ($data as $column => $value) {
                $data[$column] = htmlspecialchars($this->func->checkInput($value));
            }

            $data['status'] = 'new-admin';
            $data['date_posted'] = time();

            if ($this->d->insert('table_comment', $data)) {
                $id_insert = $this->d->getLastInsertId();

                /* Photo */
                if (!empty($_FILES['review-file-photo'])) {
                    $myFile = $_FILES['review-file-photo'];
                    $fileCount = count($myFile["name"]);

                    for ($i = 0; $i < $fileCount; $i++) {
                        $_FILES['file-uploader-temp'] = array(
                            'name' => $myFile['name'][$i],
                            'type' => $myFile['type'][$i],
                            'tmp_name' => $myFile['tmp_name'][$i],
                            'error' => $myFile['error'][$i],
                            'size' => $myFile['size'][$i]
                        );
                        if ($photo = $this->func->uploadImage("file-uploader-temp", UPLOAD_PHOTO)) {
                            $dataTemp = array();
                            $dataTemp['id_parent'] = $id_insert;
                            $dataTemp['photo'] = $photo;
                            $this->d->insert('table_comment_photo', $dataTemp);
                        }
                    }
                }
            }
        }

        return $this->response();
    }

    public function status()
    {
        /* Request data */
        $id = (!empty($_POST['id'])) ? $this->func->decodeHtmlChars($_POST['id']) : 0;
        $status = (!empty($_POST['status'])) ? $this->func->decodeHtmlChars($_POST['status']) : '';

        /* Get detail */
        if (!empty($id)) {
            $row = $this->d->rawQueryOne("select id, status from table_comment where id = ? limit 0,1", array($id));

            /* Check detail */
            if (!empty($row['id'])) {
                $status_array = (!empty($row['status'])) ? explode(',', $row['status']) : array();

                if (array_search($status, $status_array) !== false) {
                    $key = array_search($status, $status_array);
                    unset($status_array[$key]);
                } else {
                    array_push($status_array, $status);
                }

                if (array_search('new-admin', $status_array) !== false) {
                    unset($status_array[array_search('new-admin', $status_array)]);
                }

                /* Update status */
                $data = array();
                $data['status'] = (!empty($status_array)) ? implode(',', $status_array) : "";
                $this->d->where('id', $id);
                if (!$this->d->update('table_comment', $data)) {
                    $this->errors[] = 'Cập nhật trạng thái thất bại. Vui lòng thử lại sau';
                }
            } else {
                $this->errors[] = 'Dữ liệu không hợp lệ';
            }
        } else {
            $this->errors[] = 'Dữ liệu không hợp lệ';
        }

        return $this->response();
    }

    public function delete()
    {
        /* Request data */
        $id = (!empty($_POST['id'])) ? $this->func->decodeHtmlChars($_POST['id']) : 0;

        /* Get detail */
        if (!empty($id)) {
            $row = $this->d->rawQueryOne("select id, id_parent from table_comment where id = ? limit 0,1", array($id));

            /* Check detail */
            if (!empty($row['id'])) {
                /* Delete photo */
                $photo = $this->photo($row['id']);
                if (!empty($photo)) {
                    $this->d->rawQuery("delete from table_comment_photo where id_parent = ?", array($row['id']));
                }

                /* Delete main */
                $result = $this->d->rawQuery("delete from table_comment where id = ?", array($id));

                if (!empty($result)) {
                    $this->errors[] = 'Xóa bình luận thất bại. Vui lòng thử lại sau';
                }
            } else {
                $this->errors[] = 'Dữ liệu không hợp lệ';
            }
        } else {
            $this->errors[] = 'Dữ liệu không hợp lệ';
        }

        return $this->response();
    }

    public function timeAgo($time = 0)
    {
        $result = '';
        $lang = [
            'now' => 'Vài giây trước',
            'ago' => 'trước',
            'vi' => [
                'y' => 'năm',
                'm' => 'tháng',
                'd' => 'ngày',
                'h' => 'giờ',
                'm' => 'phút',
                's' => 'giây'
            ]
        ];

        $ago = time() - $time;

        if ($ago < 1) {
            $result = $lang['now'];
        } else {
            $unit = [
                365 * 24 * 60 * 60  =>  'y',
                30 * 24 * 60 * 60  =>  'm',
                24 * 60 * 60  =>  'd',
                60 * 60  =>  'h',
                60  =>  'm',
                1  =>  's'
            ];

            foreach ($unit as $secs => $key) {
                $time = $ago / $secs;

                if ($time >= 1) {
                    $time = round($time);
                    $result = $time . ' ' . ($time > 1 ? $lang['vi'][$key] : $lang['vi'][$key]) . ' ' . $lang['ago'];
                    break;
                }
            }
        }

        return $result;
    }
}
