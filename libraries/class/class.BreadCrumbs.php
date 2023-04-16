<?php
class BreadCrumbs
{
    private $d;
    private $data = array();

    function __construct($d)
    {
        $this->d = $d;
    }

    public function set($slug = '', $name = '')
    {
        if ($name != '') {
            $this->data[] = array('slug' => $slug, 'name' => $name);
        }
    }

    public function get()
    {
        global $configBase;

        $json = array();
        $breadcumb = '';

        if ($this->data) {
            $breadcumb .= '<ol class="breadcrumb">';
            $breadcumb .= '<li class="breadcrumb-item"><a class="text-decoration-none" href="' . $configBase . '"><span>' . "Trang chủ" . '</span></a></li>';
            $k = 1;
            foreach ($this->data as $key => $value) {
                if ($value['name'] != '') {
                    $slug = ($value['slug']) ? $configBase . $value['slug'] : '';
                    $name = $value['name'];
                    $active = ($key == count($this->data) - 1) ? "active" : "";
                    $breadcumb .= '<li class="breadcrumb-item ' . $active . '"><a class="text-decoration-none" href="' . $slug . '"><span>' . $name . '</span></a></li>';
                    $json[] = array("@type" => "ListItem", "position" => $k, "name" => $name, "item" => $slug);
                    $k++;
                }
            }
            $breadcumb .= '</ol>';
        }

        return $breadcumb;
    }
}
