<!DOCTYPE html>
<html>
    <head>
        <title><?php echo lang ("Operation panel","admin"); ?> | Image CMS</title>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <meta name="description" content="<?php echo lang ("Operation panel","admin"); ?> - Image CMS" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="generator" content="ImageCMS">

        <link rel="icon" type="image/x-icon" href="<?php if(isset($THEME)){ echo $THEME; } ?>images/favicon.png"/>
		<link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/shadowbox.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/bootstrap_complete.css">
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/bootstrap-responsive.css">
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/jquery.treeview.css">
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/colorbox/colorbox.css">
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>alerts/jquery.alerts.css">
        <!--
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/bootstrap-notify.css">
        -->

        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/jquery/custom-theme/jquery-ui-1.8.16.custom.css">
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/jquery/custom-theme/jquery.ui.1.8.16.ie.css">


        <link rel="stylesheet" type="text/css" href="/js/elfinder-2.0/css/Aristo/css/Aristo/Aristo.css" media="screen" charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/js/elrte-1.3/css/elrte.min.css" media="screen" charset="utf-8">

        <link rel="stylesheet" type="text/css" href="/js/elfinder-2.0/css/elfinder.min.css" media="screen" charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/js/elfinder-2.0/css/theme.css" media="screen" charset="utf-8">


    </head>
    <body>
        <?php $this->include_tpl('inc/javascriptVars', 'D:\server\www\imghost.vit\templates\administrator'); ?>
        <?php $this->include_tpl('inc/jsLangs.tpl', 'D:\server\www\imghost.vit\templates\administrator'); ?>
        <?php $langDomain = $CI->land->gettext_domain?>
        <?php $CI->lang->load('admin')?>
        <div class="main_body">
            <div id="fixPage"></div>
            <!-- Here be notifications -->
            <div class="notifications top-right"></div>

            <header>
                <section class="container">
                     <?php if(SHOP_INSTALLED): ?>
                        <a href="<?php echo base_url ('admin/components/run/shop/dashboard'); ?>" class="logo pull-left pjax">
                        <?php else:?>
                            <a href="/admin/dashboard" class="logo pull-left pjax">
                            <?php endif; ?>
                            <img src="<?php if(isset($THEME)){ echo $THEME; } ?>img/logo.png"/>
                        </a>

                        <?php if($CI->dx_auth->is_logged_in()): ?>
                            <div class="pull-right span4">
                                <div class="clearfix">
                                    <span class="m-r_10">
                                        <?php echo lang ("Hello","admin"); ?>,
                                        <?php if($CI->dx_auth->get_username()): ?>
                                            <a href="
                                               <?php if(SHOP_INSTALLED): ?>/admin/components/run/shop/users/edit/<?php echo $CI->dx_auth->get_user_id()?>
                                               <?php else:?>/admin/components/cp/user_manager/edit_user/<?php echo $CI->dx_auth->get_user_id()?>
                                               <?php endif; ?>"
                                               id="user_name">
                                                <?php echo $CI->dx_auth->get_username()?>
                                            </a>
                                            <a href="/admin/logout">
                                                <i class="my_icon exit_ico"></i>
                                            </a>
                                        <?php else:?>
                                            <?php echo lang("Guest","admin")?>
                                        <?php endif; ?>
                                    </span>
                                    <span class="m-l_10"><?php echo lang ('Preview','admin'); ?> <a href="<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?>" target="_blank"><?php echo lang ('site','admin'); ?> <span class="f-s_14">→</span></a></span>
                                </div>
                                <form method="get" action="<?php if($ADMIN_URL): ?>/admin/components/run/shop/search/advanced<?php else:?>/admin/admin_search<?php endif; ?>" id="adminAdvancedSearch">
                                    <div class="input-append search">
                                        <button id="adminSearchSubmit" type="submit" class="btn pull-right"><i class="icon-search"></i></button>
                                        <div class="o_h">
                                            <input id="<?php if($ADMIN_URL): ?>shopSearch<?php else:?>baseSearch<?php endif; ?>" name="q" size="16" type="text"  autocomplete="off" tabindex="1" value="<?php echo $_GET['q']; ?>">
                                        </div>
                                    </div>
                                </form>
                            </div>



                            <?php if(SHOP_INSTALLED): ?>
                                <div class="btn-group" id="topPanelNotifications" style="display: block;">
                                    <div class="span4 d-i_b">
                                        <a href="/admin/components/run/shop/orders/index" class=" pjax btn btn-large" data-title="<?php echo lang ('Orders','admin'); ?>" data-rel="tooltip" data-original-title="<?php echo lang ('Orders','admin'); ?>">
                                            <i class="icon-bask "></i>
                                        </a>
                                        <a href="#" class="btn btn-large pjax" data-title="<?php echo lang ("Products without icons","admin"); ?>" data-rel="tooltip" data-original-title="">
                                            <i class="icon-report_exists"></i>
                                        </a>
                                        <a href="#" class="btn btn-large pjax" data-title="Callback" data-rel="tooltip" data-original-title="Callback">
                                            <i class="icon-callback "></i>
                                        </a>
                                        <a href="/admin/components/cp/comments" class="btn btn-large pjax" data-title="<?php echo lang ("Latest/recent  comments"); ?>" data-rel="tooltip" data-original-title="<?php echo lang ("Latest/recent  comments"); ?>">
                                            <i class="icon-comment_head "></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>


                </section>
            </header>

            <?php if($CI->dx_auth->is_logged_in()): ?>
                <div class="frame_nav">
                   <?php include('templates/administrator/inc/menus.php');?>
                    <?php if(!SHOP_INSTALLED): ?>
                    <div class="container" id="baseAdminMenu">
                        <nav class="navbar navbar-inverse">


                            

                            <ul class="nav">
                                <?php if(is_true_array($baseMenu)){ foreach ($baseMenu as $li){ ?>
                                    <li class="<?php echo $li['class']; ?> <?php if($li['subMenu']): ?> dropdown<?php endif; ?>">
                                        <?php if($li['subMenu']): ?>
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="<?php echo $li['icon']; ?>"></i><?php echo (bool)lang( $li['text'] )?lang( $li['text'] ): $li['text']    ?><b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <?php if(is_true_array($li['subMenu'])){ foreach ($li['subMenu'] as $sli){ ?>
                                                    <?php if($sli['menusList']): ?>
                                                        <?php if(!$menus): ?>
                                                            <?php $CI->load->module('menu'); $menus=$CI->menu->get_all_menus()?>
                                                        <?php endif; ?>

                                                        <li><a href="/admin/components/cp/menu/index" class="pjax"><?php echo lang ("Management","admin"); ?></a></li>
                                                        <li class="divider"></li>
                                                            <?php if(is_true_array($menus)){ foreach ($menus as $menu){ ?>
                                                            <li><a href="/admin/components/cp/menu/menu_item/<?php echo $menu['name']; ?>" class="pjax"><?php echo $menu['main_title']; ?></a></li>
                                                            <?php }} ?>
                                                        <?php endif; ?>
                                                        <?php if($sli['modulesList']): ?>
                                                            <?php if(!$components): ?>
                                                                <?php $CI->load->module('admin/components'); $components = $CI->components->find_components_for_menu_list(TRUE)?>
                                                            <?php endif; ?>
                                                            <?php if(is_true_array($components)){ foreach ($components as $component){ ?>
                                                            <li><a href="/admin/components/cp/<?php echo $component['name']?>" class="pjax"><?php echo $component['menu_name']?></a></li>
                                                            <?php }} ?>
                                                        <?php endif; ?>
                                                    <li <?php if($sli['divider']): ?> class="divider"<?php endif; ?><?php if($sli['header']): ?> class="nav-header"<?php endif; ?>><?php if($sli['link']): ?><a href="<?php echo $sli['link']; ?>" class="pjax"><?php echo (bool) $sli['text']  ?  $sli['text']  :  $sli['text']    ?></a><?php else:?><?php echo (bool) $sli['text']  ?  $sli['text']  :  $sli['text']    ?><?php endif; ?></li>


                                                <?php }} ?>
                                            </ul>
                                        <?php else:?>
                                            <a href="<?php echo $li['link']; ?>" class="pjax">
                                                <i class="<?php echo $li['icon']; ?>"></i>
                                                <span><?php echo $li['text']; ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </li>
                                <?php }} ?>
                            </ul>

                            <?php //if SHOP_INSTALLED?>
                               <!-- <a class="btn btn-small pull-right btn-info" onclick="loadShopInterface();" href="#"><?php echo lang ('Manage shop','admin'); ?><span class="f-s_14">→</span></a>-->
                            <?php ///if?>
                            <?php $CI->lang->load($langDomain)?>
                        </nav>
                    </div>
                        <?php endif; ?>
                    <?php if(SHOP_INSTALLED): ?>
                        <div class="container" >
                            <nav class="navbar navbar-inverse">
                                <ul class="nav">
                                    <?php if(is_true_array($shopMenu)){ foreach ($shopMenu as $li){ ?>
                                        <li class="<?php echo $li['class']; ?> <?php if($li['subMenu']): ?> dropdown<?php endif; ?>">
                                            <?php if($li['subMenu']): ?>
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="<?php echo $li['icon']; ?>"></i><?php echo (bool)lang( $li['text'] )?lang( $li['text'] ): $li['text']    ?><b class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                    <?php if(is_true_array($li['subMenu'])){ foreach ($li['subMenu'] as $sli){ ?>
                                                        <li <?php if($sli['divider']): ?> class="divider"<?php endif; ?><?php if($sli['header']): ?> class="nav-header"<?php endif; ?>>
                                                            <?php if($sli['link']): ?>
                                                                <a href="<?php echo site_url ( $sli['link'] ); ?>" class="pjax"><?php echo (bool) $sli['text'] ?lang( $sli['text'] ): $sli['text']    ?></a>
                                                            <?php else:?>
                                                                <?php echo  $sli['text'] ?lang( $sli['text'] ): $sli['text']    ?>
                                                            <?php endif; ?>

                                                        </li>
                                                        <?php if($sli['modulesList']): ?>
                                                            <?php if(!$components): ?>
                                                                <?php $CI->load->module('admin/components'); $components = $CI->components->find_components_for_menu_list(TRUE)?>
                                                            <?php endif; ?>
                                                            <?php if(is_true_array($components)){ foreach ($components as $component){ ?>
                                                                    <li><a href="/admin/components/cp/<?php echo $component['name']?>" class="pjax"><?php echo $component['menu_name']?></a></li>
                                                            <?php }} ?>
                                                            <li class="divider"></li>
                                                            <li><a href="/admin/components/modules_table" class="pjax"><?php echo lang ('All modules', 'admin'); ?></a></li>
                                                            <?php endif; ?>

                                                    <?php }} ?>
                                                </ul>
                                            <?php else:?>
                                                <a href="<?php echo $li['link']; ?>" class="pjax">
                                                    <i class="<?php echo $li['icon']; ?>"></i>
                                                    <span><?php echo $li['text']; ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    <?php }} ?>
                                </ul>
                                <!--<a class="btn btn-small pull-right btn-info" onclick=" loadBaseInterface();"  href="#"><span class="f-s_14">←</span> <?php echo lang ('Manage site','admin'); ?> </a>-->
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div id="loading"></div>
            <?php $CI->lang->load($langDomain)?>
            <div class="container" id="mainContent">
                <?php if(isset($content)){ echo $content; } ?>
            </div>
            <?php $CI->lang->load('admin')?>
            <div class="hfooter"></div>
        </div>
        <footer>
            <div class="container">
                <div class="row-fluid">
                    <div class="span4">
                        <?php echo lang ('Interface','admin'); ?>:
                        <div class="dropup d-i_b">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                <?php echo lang (ucwords($this->CI->config->item('language')), 'admin'); ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="/admin/settings/switch_admin_lang/english"><?php echo lang ("English","admin"); ?> (beta)</a></li>
                                <li><a href="/admin/settings/switch_admin_lang/russian"><?php echo lang ("Russian","admin"); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="span4 t-a_c">
                        <?php echo lang ("Version","admin"); ?>: <b><?php echo getCMSNumber()?></b>
                        <div class="muted"><?php echo lang ('Help us get better','admin'); ?> - <a href="#" id="rep_bug"><?php echo lang ('report an error','admin'); ?></a></div>
                    </div>
                    <div class="span4 t-a_r">
                        <div class="muted">Copyright © ImageCMS 2013</div>
                        <a href="http://wiki.imagecms.net" target="blank"><?php echo lang ('Documentation','admin'); ?></a>
                    </div>
                </div>
            </div>
        </footer>
        <div id="elfinder"></div>
        <div class="standart_form frame_rep_bug">
            <form method="post" action="">
                <label>
                    <?php echo lang ('Your Name','admin'); ?>:
                    <input type=text name="name"/>
                </label>
                <label>
                    <?php echo lang ('Your Email','admin'); ?>:
                    <input type=text name="email"/>
                </label>
                <label>
                    <?php echo lang ('Your remark', "admin"); ?>:
                    <textarea></textarea>
                </label>
                <input type="submit" value="<?php echo lang ("Send","admin"); ?>" class="btn btn-info"/>
                <input type="button" value="<?php echo lang ("Cancel","admin"); ?>" class="btn btn-info" style="float:right" name="cancel_button"/>
                <input type="hidden" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" id="ip_address"/>
            </form>
        </div>
        <script>
            <?php $settings = $CI->cms_admin->get_settings();?>
                                    var textEditor = '<?php echo $settings['text_editor']; ?>';
            <?php if($CI->dx_auth->is_logged_in()): ?>
                                    var userLogined = true;
            <?php else:?>
                                    var userLogined = false;
            <?php endif; ?>

                                    var locale = '<?php echo $this->CI->config->item('language')?>';
                                    var base_url = "<?php echo site_url (); ?>";
        </script>

        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery-1.8.2.min.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/pjax/jquery.pjax.min.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/bootstrap.min.js" type="text/javascript"></script>
        <script async="async" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/bootstrap-notify.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery.form.js" type="text/javascript"></script>

        <script async="async" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery-validate/jquery.validate.min.js" type="text/javascript"></script>
        <script async="async" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery-validate/jquery.validate.i18n.js" type="text/javascript"></script>


        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/functions.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/scripts.js" type="text/javascript"></script>

        <script type="text/javascript" src="/js/elrte-1.3/js/elrte.min.js"></script>
        <script type="text/javascript" src="/js/elfinder-2.0/js/elfinder.min.js"></script>


        <?php if($this->CI->config->item('language') == 'russian'): ?>
            <script async="async" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery-validate/messages_ru.js" type="text/javascript"></script>
            <script type="text/javascript" src="/js/elrte-1.3/js/i18n/elrte.ru.js"></script>
            <script type="text/javascript" src="/js/elfinder-2.0/js/i18n/elfinder.ru.js"></script>
        <?php endif; ?>


        <!--
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/admin_base.min.js" type="text/javascript"></script>
        -->

        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/admin_base_i.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/admin_base_m.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/admin_base_r.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/admin_base_v.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/admin_base_y.js" type="text/javascript"></script>
        <script type="text/javascript" src="/js/tiny_mce/jquery.tinymce.js"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/autosearch.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery.treeview.js" type="text/javascript"></script>
        <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery.cookie.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery.colorbox.js"></script>
		<script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery.alerts.js"></script>

        <script>
            <?php if($CI->uri->segment('4') == 'shop'): ?>
                                    var isShop = true;
            <?php else:?>
                                    var isShop = false;
            <?php endif; ?>
                                    var lang_only_number = "<?php echo lang ("numbers only","admin"); ?>";
                                    var show_tovar_text = "<?php echo lang ("show","admin"); ?>";
                                    var hide_tovar_text = "<?php echo lang ("don't show", 'admin'); ?>";
                $(document).ready(function() {
                    if (!isShop)
                    {
                        $('#shopAdminMenu').hide();
                        //$('#topPanelNotifications').hide();
                    }
                    else
                        $('#baseAdminMenu').hide();
                })

                function number_tooltip_live() {
                    $('.number input').each(function() {
                        $(this).attr({
                            'data-placement': 'top',
                            'data-title': lang_only_number
                        });
                    })
                    number_tooltip();
                }
                function prod_on_off() {
                    $('.prod-on_off').die('click').live('click', function() {
                        var $this = $(this);
                        if (!$this.hasClass('disabled')) {
                            if ($this.hasClass('disable_tovar')) {
                                $this.animate({
                                    'left': '0'
                                }, 200).removeClass('disable_tovar');
                                if ($this.parent().data('only-original-title') == undefined) {
                                    $this.parent().attr('data-original-title', show_tovar_text)
                                    $('.tooltip-inner').text(show_tovar_text);
                                }
                                $this.next().attr('checked', true).end().closest('td').next().children().removeClass('disabled').removeAttr('disabled');
                                if ($this.attr('data-page') != undefined)
                                    $('.setHit, .setHot, .setAction').removeClass('disabled').removeAttr('disabled');
                            }
                            else {
                                $this.animate({
                                    'left': '-28px'
                                }, 200).addClass('disable_tovar');
                                if ($this.parent().data('only-original-title') == undefined) {
                                    $this.parent().attr('data-original-title', hide_tovar_text)
                                    $('.tooltip-inner').text(hide_tovar_text);
                                }
                                $this.next().attr('checked', false).end().closest('td').next().children().addClass('disabled').attr('disabled', 'disabled');
                                if ($this.attr('data-page') != undefined)
                                    $('.setHit, .setHot, .setAction').addClass('disabled').attr('disabled', 'disabled')
                            }
                        }
                    });
                }
                $(window).load(function() {
                    number_tooltip_live();
                    prod_on_off();
                })
                base_url = '<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?>';

                var elfToken = '<?php echo $CI->lib_csrf->get_token()?>';
            </script>
            <div id="jsOutput" style="display: none;"></div>
        </body>
    </html>
<?php $mabilis_ttl=1480753591; $mabilis_last_modified=1412272280; //D:\server\www\imghost.vit\templates/administrator/main.tpl ?>