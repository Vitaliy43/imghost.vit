<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_hook($hook_id)
{
$cms_hooks = array (
    'admin_update_category' => '$data[\'field_group\'] = $this->input->post(\'field_group\');
	$data[\'category_field_group\'] = $this->input->post(\'category_field_group\');

    $this->load->module(\'cfcm\')->save_item_data($cat_id, \'category\');
    $this->cache->delete(\'cfcm_field_\'.$cat_id.\'category\');


    $this->db->select(\'id\');
    $this->db->where(\'parent_id\', $cat_id);
    $cats = $this->db->get(\'category\');

    if($cats->num_rows() > 0)
    {
        foreach($cats->result_array() as $c)
        {
            $id = $c[\'id\'];

            if($_POST[\'apply_for_subcats\'])
            {
                $this->db->where(\'id\', $id);
                $this->db->update(\'category\', array(\'field_group\'=>$data[\'field_group\']));
            }
            if($_POST[\'category_apply_for_subcats\'])
            {
                $this->db->where(\'id\', $id);
                $this->db->update(\'category\', array(\'category_field_group\'=>$data[\'category_field_group\']));
            }
        }
    }',
'cfcm_set_rules' => '$fields = $this->db
                ->where("content_fields.data like \'%required%\'")
                ->or_where("content_fields.data like \'%validation%\'")
                ->where(\'group_id\', $groupId)
                ->join(\'content_fields\', \'content_fields.field_name = content_fields_groups_relations.field_name\')
                ->get(\'content_fields_groups_relations\')
                ->result_array();
        
        foreach ($fields as $field)
        {
            $data = unserialize ($field[\'data\']);
            $str = \'\';
            if ($data[\'required\'])
                $str .= \'required|\';
            if ($data[\'validation\'])
                $str .= $data[\'validation\'];
                
            $this->form_validation->set_rules($field[\'field_name\'], $data[\'label\'], $str);
        }',
'admin_create_category' => '$data[\'field_group\'] = $this->input->post(\'field_group\');
    $data[\'category_field_group\'] = $this->input->post(\'category_field_group\');

    $this->db->select(\'id\');
    $this->db->where(\'parent_id\', $cat_id);
    $cats = $this->db->get(\'category\');

    if($cats->num_rows() > 0)
    {
        foreach($cats->result_array() as $c)
        {
            $id = $c[\'id\'];

            if($_POST[\'apply_for_subcats\'])
            {
                $this->db->where(\'id\', $id);
                $this->db->update(\'category\', array(\'field_group\'=>$data[\'field_group\']));
            }
            if($_POST[\'category_apply_for_subcats\'])
            {
                $this->db->where(\'id\', $id);
                $this->db->update(\'category\', array(\'category_field_group\'=>$data[\'category_field_group\']));
            }
        }
    }',
'admin_page_update' => '$this->load->module(\'cfcm\')->save_item_data($page_id, \'page\');
    $this->cache->delete(\'cfcm_field_\'.$page_id.\'page\');',
'admin_on_page_add' => '$this->load->module(\'cfcm\')->save_item_data($page[\'id\'], \'page\');',
'admin_page_insert' => '$this->load->module(\'cfcm\')->save_item_data(\'0\', \'page\');',
'core_set_page_data' => '$this->page_content = $this->load->module(\'cfcm\')->connect_fields($this->page_content, \'page\');',
'core_read_main_page_tpl' => '$page = $this->load->module(\'cfcm\')->connect_fields($page, \'page\');',
'core_return_category_pages' => 'if (count($pages) > 0 AND is_array($pages))
{
    $n = 0;
    foreach ($pages as $p)
    {
        $pages[$n] = $this->load->module(\'cfcm\')->connect_fields($p, \'page\');
        $n++;
    }
}',
'cmsbase_return_categories' => '$n = 0;
    $ci =& get_instance();
    $ci->load->library(\'DX_Auth\');
    foreach ($categories as $c)
    {
        $categories[$n] = $ci->load->module(\'cfcm\')->connect_fields($c, \'category\');
        $n++;
    }',
'admin_on_page_delete' => '$this->db->where(\'item_id\', $page_id);
    $this->db->where(\'item_type\', \'page\');
    $this->db->delete(\'content_fields_data\');

    $this->cache->delete(\'cfcm_field_\'.$page_id.\'page\');',
'admin_category_delete' => '$this->db->where(\'item_id\', $cat_id);
    $this->db->where(\'item_type\', \'category\');
    $this->db->delete(\'content_fields_data\');',
'admin_sub_category_delete' => '$this->db->where(\'item_id\', $cat_id);
    $this->db->where(\'item_type\', \'category\');
    $this->db->delete(\'content_fields_data\');',
'admin_tpl_add_page' => 'echo \'<h4>\'.lang("Additional fields").\'</h4>\';
	echo \'<div style="padding:8px;" id="cfcm_fields_block"></div>\';

    echo \'
    <script type="text/javascript">
           $("category_selectbox").addEvent("change", function(event){
            category_id = $("category_selectbox").value;
            ajax_div("cfcm_fields_block",  base_url + "admin/components/cp/cfcm/form_from_category_group/" + category_id + "/0/page");
           });

            // Load current category fields
            window.addEvent("domready", function(){
                category_id = $("category_selectbox").value;
                ajax_div("cfcm_fields_block",  base_url + "admin/components/cp/cfcm/form_from_category_group/" + category_id + "/0/page");
            });
    </script>
    \';',
'admin_tpl_edit_page' => 'echo \'<h4>\'.lang("Additional fields").\'</h4>\';
	echo \'<div style="padding:8px;" id="cfcm_fields_block"></div>\';

    echo \'
    <script type="text/javascript">
           var update_page_id = \'.$update_page_id.\';

           $("category_selectbox").addEvent("change", function(event){
            category_id = $("category_selectbox").value;
            ajax_div("cfcm_fields_block",  base_url + "admin/components/cp/cfcm/form_from_category_group/" + category_id + "/" + update_page_id + "/page");
           });

            // Load current category fields
            window.addEvent("domready", function(){
                category_id = $("category_selectbox").value;
                ajax_div("cfcm_fields_block",  base_url + "admin/components/cp/cfcm/form_from_category_group/" + category_id + "/" + update_page_id + "/page");
            });
    </script>
    \';',
'admin_tpl_edit_category' => 'echo $this->CI->load->module(\'cfcm/admin\')->form_from_category_group($id, $id, \'category\');',
'comments_read_com_tpl' => 'if (isset($_POST[\'comment_text\']))
{
    modules::run(\'comments/add\');
}',
'core_init' => '',
'render_google_analytics' => '$GACode = "     
<script type=\'text/javascript\'>
            var _gaq = _gaq || [];
          _gaq.push([\'_setAccount\', \'" . $this->settings[\'google_analytics_id\'] . "\']);
          _gaq.push ([\'_addOrganic\', \'images.yandex.ru\', \'text\']);
          _gaq.push ([\'_addOrganic\', \'blogs.yandex.ru\', \'text\']);
          _gaq.push ([\'_addOrganic\', \'video.yandex.ru\', \'text\']);
          _gaq.push ([\'_addOrganic\', \'meta.ua\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'search.bigmir.net\', \'z\']);
          _gaq.push ([\'_addOrganic\', \'search.i.ua\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'mail.ru\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'go.mail.ru\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'google.com.ua\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'images.google.com.ua\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'maps.google.com.ua\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'images.google.ru\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'maps.google.ru\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'rambler.ru\', \'words\']);
          _gaq.push ([\'_addOrganic\', \'nova.rambler.ru\', \'query\']);
          _gaq.push ([\'_addOrganic\', \'nova.rambler.ru\', \'words\']);
          _gaq.push ([\'_addOrganic\', \'gogo.ru\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'nigma.ru\', \'s\']);
          _gaq.push ([\'_addOrganic\', \'poisk.ru\', \'text\']);
          _gaq.push ([\'_addOrganic\', \'go.km.ru\', \'sq\']);
          _gaq.push ([\'_addOrganic\', \'liveinternet.ru\', \'ask\']);
          _gaq.push ([\'_addOrganic\', \'gde.ru\', \'keywords\']);
          _gaq.push ([\'_addOrganic\', \'search.qip.ru\', \'query\']);
          _gaq.push ([\'_addOrganic\', \'webalta.ru\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'sm.aport.ru\', \'r\']);
          _gaq.push ([\'_addOrganic\', \'index.online.ua\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'web20.a.ua\', \'query\']);
          _gaq.push ([\'_addOrganic\', \'search.ukr.net\', \'search_query\']);
          _gaq.push ([\'_addOrganic\', \'search.com.ua\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'search.ua\', \'q\']);
          _gaq.push ([\'_addOrganic\', \'affiliates.quintura.com\', \'request\']);
          _gaq.push ([\'_addOrganic\', \'akavita.by\', \'z\']);
          _gaq.push ([\'_addOrganic\', \'search.tut.by\', \'query\']);
          _gaq.push ([\'_addOrganic\', \'all.by\', \'query\']);
          _gaq.push([\'_trackPageview\']);
        </script>";


/*if ($this->session->flashdata(\'makeOrder\') === true) {
    $GACode = "
        <script type=\'text/javascript\'>
            _gaq.push([\'_addTrans\',
                \'$model->id\',
                \'\',
                \'$model->getTotalPrice()\',
                \'\',
                \'$model->getSDeliveryMethods()->name\',
                \'\',
                \'\',
                \'\'
            ]);";

    foreach ($model->getSOrderProductss() as $item) {
        $total = $total + $item->getQuantity() * $item->toCurrency();
        $product = $item->getSProducts();

        $GACode = "_gaq.push([\'_addItem\',
                \'$model->id\',
                \'$product->getUrl()\',
                \' encode(ShopCore::encode($product->getName())) encode($item->getVariantName())\',
                \'encode($product->getMainCategory()->name)\',
                \'$item->toCurrency()\',
                \'$item->getQuantity()\'
            ]);";
    }

    $GACode = "_gaq . push([\'_trackTrans\']);</script>";
}*/

$GACode = "<script type=\'text/javascript\'>
    (function() {
        var ga = document.createElement(\'script\');
        ga.type = \'text/javascript\';
        ga.async = true;
        ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
        var s = document.getElementsByTagName(\'script\')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>
";
$this->tpl_data[\'renderGA\'] = $GACode;',
'render_google_webmaster' => '$GWebmaster = \'
        <meta name="google-site-verification" content="\'.$this->settings[\'google_webmaster\'].\'" />\';
    $this->tpl_data[\'gmeta\'] = $GWebmaster;',
'render_yandex_webmaster' => '$YaWebmaster = \'<meta name="yandex-verification" content="\'.$this->settings[\'yandex_webmaster\'].\'" />\';
    $this->tpl_data[\'yameta\'] = $YaWebmaster;',
'render_yandex_metrik' => '$YandexMetrik = \'<!-- Yandex.Metrika counter -->

                    <script type="text/javascript">
                        (function (d, w, c) {
                            (w[c] = w[c] || []).push(function() {
                            try {
                                w.yaCounter4788157 = new Ya.Metrika({id:\'.$this->settings[\'yandex_metric\'].\', enableAll: true, webvisor:true,params:window.yaParams||{ }});
                            } catch(e) { }
                        });

                        var n = d.getElementsByTagName("script")[0],
                            s = d.createElement("script"),
                            f = function () { n.parentNode.insertBefore(s, n); };
                        s.type = "text/javascript";
                        s.async = true;
                        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                        if (w.opera == "[object Opera]") {
                            d.addEventListener("DOMContentLoaded", f);
                        } else { f(); }
                        })(document, window, "yandex_metrika_callbacks");
                    </script>
                    <noscript><div><img src="//mc.yandex.ru/watch/\'. $this->settings[\'yandex_metric\'] .\'" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                    <!-- /Yandex.Metrika counter -->\';
                    $this->tpl_data[\'ymetric\'] = $YandexMetrik;',

);

    if (isset($cms_hooks[$hook_id]))
    {
        return $cms_hooks[$hook_id];
    }
    else
    {
       return FALSE;
    }
}

