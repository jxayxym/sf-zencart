<div class="centerColumn" id="">
	<div class="layout-center1000 pl25 pr25">
            <div class="mb10">
                <div class="back">
                    <div class="banner3Bg">
                    <div id="Banner_slideshowHolder">
                        <?php
//                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id=2662').'" title="Banquet handbag">'.zen_image(DIR_WS_IMAGES.'banners/591x382/chanel/Banquet handbag_2662.jpg').'</a>';
//                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id=2242').'" title="Chanel Flap">'.zen_image(DIR_WS_IMAGES.'banners/591x382/chanel/Chanel Flap_2242.jpg').'</a>';
//                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id=2582').'" title="Chanel Cambon">'.zen_image(DIR_WS_IMAGES.'banners/591x382/chanel/Chanel Cambon_2528.jpg').'</a>';
//                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id=2590').'" title="Chanel Wallet">'.zen_image(DIR_WS_IMAGES.'banners/591x382/chanel/Chanel Wallet_2590.jpg').'</a>';
//                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id=1906').'" title="Chanel Denim Bags">'.zen_image(DIR_WS_IMAGES.'banners/591x382/chanel/Chanel Denim Bags_1906.jpg').'</a>';
//                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id=1921').'" title="Chanel Handbags">'.zen_image(DIR_WS_IMAGES.'banners/591x382/chanel/Chanel Handbags_1921.jpg').'</a>';
//                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id=2471').'" title="Chanel Coco">'.zen_image(DIR_WS_IMAGES.'banners/591x382/chanel/Chanel Coco_2471.jpg').'</a>';
                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'cPath=46').'" title="Prada">'.zen_image(DIR_WS_IMAGES.'banners/591x382/dodo/Prada.jpg').'</a>';
                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'cPath=47').'" title="Miu Miu">'.zen_image(DIR_WS_IMAGES.'banners/591x382/dodo/miumiu.jpg').'</a>';
                        ?>
                    </div>
                    </div>
                </div>
                <div class="back ml20">
                    <div id="attributesColor" class="attributesFinderBg">
                        <h2 id="attributesColor-header">Which color do you like?</h2>
                        <?php 
                        $options = getOptionValues("Color");
                        if(!empty($options)){
                            foreach ($options as $entry){
                                echo '<div class="back ml15 mb5">';
                                echo '<a href="'.  zen_href_link(FILENAME_DEFAULT,'options_values_id='.$entry['products_options_values_id']).'">';
                                echo zen_image(DIR_WS_IMAGES."attributes/".$entry['products_options_values_name'].".JPG",$entry['products_options_values_name'],40,40);
                                echo '</a>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <div class="frame_312x136"><?php echo zen_image(DIR_WS_IMAGES.'banners/312x136_banner.png')?></div>
                </div>
                <br class="clearBoth" />
            </div>
            <div>
                <div class="back frame_300x213">
                    <div class="top1Bg pr">
                        <?php
                        $top1_seller = get_best_sellers(0);
                        echo '<div id="top1ProductsName"><a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$top1_seller->fields['products_id']).'">'.$top1_seller->fields['products_name'].'</a></div>';
                        echo '<div id="top1ImageWrapper"><a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$top1_seller->fields['products_id']).'">'.zen_get_products_image($top1_seller->fields['products_id'],90,90)."</a></div>";
                        echo '<div id="top1TotalSales">Total Sales:'.$top1_seller->fields['total_sell']."</div>";
                        ?>
                    </div>   
                </div>
                <div class="back">
                    <div>
                        <div>
                            <ul class="l-s_n pr zi1">
                                <li id="tab-features" rel="tab-container-featured" class="menuTab back tab_l selected"><a href="javascript:;" class="tab_r">Features</a></li>
                                <li id="tab-bestSeller" rel="tab-container-bestSeller" class="menuTab back"><a href="javascript:;" class="tab_r">Best Seller</a></li>
                            </ul>
                        </div>
                        <div class="frame_613x182 tab-container">
                            <ul id="tab-container-featured" class="l-s_n show">
                                <?php
                                $featureds = get_featureds(5);
                                if (!empty($featureds)){
                                    foreach ($featureds as $entry){
                                        echo '<li class="back ml5 tac">';
                                        echo '<a href="'.  zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$entry['products_id']).'">';
                                        echo zen_image(DIR_WS_IMAGES.$entry['products_image'],$entry['products_name'],110,100);
                                        echo '</a>';
                                        echo '<br />';
                                        echo $currencies->display_price((zen_get_products_actual_price($entry['products_id'])),0);
                                        echo '</li>';
                                    }
                                }
                                ?>
                            </ul>
                            <ul id="tab-container-bestSeller" class="l-s_n hiden">
                                <?php
                                $best_sellers = get_best_sellers(5);
                                while (!$best_sellers->EOF){
                                ?>
                                <li class="back ml5 tac">
                                    <a href="<?php echo zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO,'products_id='.$best_sellers->fields['products_id'])?>">
                                    <?php echo zen_get_products_image($best_sellers->fields['products_id'],105,100); ?>
                                    </a>
                                    <br />
                                    <?php echo $currencies->display_price((zen_get_products_actual_price($best_sellers->fields['products_id'])),0);?>
                                </li>
                                <?php
                                    $best_sellers->MoveNext();
                                }
                                ?>
                                
                            </ul>
                        </div>
                        <script type="text/javascript">
                            $(".menuTab").mouseover(function(){
                                $(".menuTab").removeClass("selected");
                                $(this).addClass("selected");
                                $("ul",".tab-container").removeClass("show").addClass("hiden");
                                $("#"+$(this).attr("rel")).removeClass("hiden").addClass("show");
                            });
                        </script>
                    </div>
                </div>
                <br class="clearBoth" />
            </div>            
	</div>
</div>
<script type="text/javascript">
$("#Banner_slideshowHolder").player({
	width	: '586px',
	height  : '377px',
	time	: 3000
}).play();
$("#tab-container-featured").marquee({height:150,width:500});
//new srcMarquee("recent-orders-data",0,2,300,500,30,3000,3000,70);
//new srcMarquee("tab-container-featured",3,2,500,100,30,2000,2000,70);
</script>