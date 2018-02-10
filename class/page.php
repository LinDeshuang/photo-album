<?php  
  
/* * *********************************************  
 * @类名:   page  
 * @参数:   $p_total - 总记录数  
 *          $p_size - 一页显示的记录数  
 *          $p_page - 当前页  
 *          $p_url - 获取当前的url  
 * @功能:   分页实现   
 */  
  
class page {  
  
    private $p_total;          //总记录数  
    private $p_size;           //一页显示的记录数  
    private $p_page;           //当前页  
    private $p_page_count;     //总页数  
    private $p_i;              //起头页数  
    private $p_en;             //结尾页数  
    private $p_url;            //获取当前的url  
    /*  
     * $show_pages  
     * 页面显示的格式，显示链接的页数为2*$show_pages+1。  
     * 如$show_pages=2那么页面上显示就是[首页] [上页] 1 2 3 4 5 [下页] [尾页]   
     */  
    private $show_pages;  
  
    public function __construct($p_total = 1, $p_size = 1, $p_page = 1, $p_url, $show_pages = 2) {  
        $this->p_total = $this->numeric($p_total);  
        $this->p_size = $this->numeric($p_size);  
        $this->p_page = $this->numeric($p_page);  
        $this->p_page_count = ceil($this->p_total / $this->p_size);  
        $this->p_url = $p_url;  
        if ($this->p_total < 0)  
            $this->p_total = 0;  
        if ($this->p_page < 1)  
            $this->p_page = 1;  
        if ($this->p_page_count < 1)  
            $this->p_page_count = 1;  
        if ($this->p_page > $this->p_page_count)  
            $this->p_page = $this->p_page_count;  
        $this->limit = ($this->p_page - 1) * $this->p_size;  
        $this->p_i = $this->p_page - $show_pages;  
        $this->p_en = $this->p_page + $show_pages;  
        if ($this->p_i < 1) {  
            $this->p_en = $this->p_en + (1 - $this->p_i);  
            $this->p_i = 1;  
        }  
        if ($this->p_en > $this->p_page_count) {  
            $this->p_i = $this->p_i - ($this->p_en - $this->p_page_count);  
            $this->p_en = $this->p_page_count;  
        }  
        if ($this->p_i < 1)  
            $this->p_i = 1;  
    }  
  
    //检测是否为数字  
    private function numeric($num) {  
        if (strlen($num)) {  
            if (!preg_match("/^[0-9]+$/", $num)) {  
                $num = 1;  
            } else {  
                $num = substr($num, 0, 11);  
            }  
        } else {  
            $num = 1;  
        }  
        return $num;  
    }  
  
    //地址替换  
    private function page_replace($page) {  
        return str_replace("{page}", $page, $this->p_url);  
    }  
  
    //首页  
    private function p_home() {  
        if ($this->p_page != 1) {  
            return "<a href='" . $this->page_replace(1) . "' title='首页'>首页</a>";  
        } else {  
            return "<p>首页</p>";  
        }  
    }  
  
    //上一页  
    private function p_prev() {  
        if ($this->p_page != 1) {  
            return "<a href='" . $this->page_replace($this->p_page - 1) . "' title='上一页'>上一页</a>";  
        } else {  
            return "<p>上一页</p>";  
        }  
    }  
  
    //下一页  
    private function p_next() {  
        if ($this->p_page != $this->p_page_count) {  
            return "<a href='" . $this->page_replace($this->p_page + 1) . "' title='下一页'>下一页</a>";  
        } else {  
            return"<p>下一页</p>";  
        }  
    }  
  
    //尾页  
    private function p_last() {  
        if ($this->p_page != $this->p_page_count) {  
            return "<a href='" . $this->page_replace($this->p_page_count) . "' title='尾页'>尾页</a>";  
        } else {  
            return "<p>尾页</p>";  
        }  
    }  
  
    //输出  
    public function p_write($id = 'page') {  
        $str = "<div id=" . $id . ">";  
        $str.=$this->p_home();  
        $str.=$this->p_prev();  
        if ($this->p_i > 1) {  
            $str.="<p class='pageEllipsis'>...</p>";  
        }  
        for ($i = $this->p_i; $i <= $this->p_en; $i++) {  
            if ($i == $this->p_page) {  
                $str.="<a href='" . $this->page_replace($i) . "' title='第" . $i . "页' class='cur'>$i</a>";  
            } else {  
                $str.="<a href='" . $this->page_replace($i) . "' title='第" . $i . "页'>$i</a>";  
            }  
        }  
        if ($this->p_en < $this->p_page_count) {  
            $str.="<p class='pageEllipsis'>...</p>";  
        }  
        $str.=$this->p_next();  
        $str.=$this->p_last();  
        $str.="<p class='pageRemark'>共<b>" . $this->p_page_count .  
                "</b>页<b>" . $this->p_total . "</b>条数据</p>";  
        $str.="</div>";  
        return $str;  
    }  
  
}  
  
?>  