<?php
global $wp_query; // Class_Reference/WP_Query 类实例
global $wp; // Class_Reference/WP 类实例

// SEO
$seo_title = ifEmptyText(get_term_meta($cat, 'seo_title', true));
$seo_description = ifEmptyText(get_term_meta($cat, 'seo_description', true));
$seo_keywords = ifEmptyText(get_term_meta($cat, 'seo_keywords', true));
$paged = get_query_var('paged'); // 当前页数
$max = intval($wp_query->max_num_pages); // 该分类总页数

// 当前页面url
$category = get_category($cat);
$get_full_path = get_full_path();
$page_url = $get_full_path . get_category_link($category->term_id);

$readBtn = ifEmptyText(json_config_array('header', 'vars', 1)['readBtn']['value'])
?>

<script>
    let res = <?php echo json_encode($news_items) ?>;
    console.log(res);
</script>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- SEO -->
    <title><?php echo $seo_title; ?></title>
    <meta name="keywords" content="<?php echo $seo_keywords; ?>" />
    <meta name="description" content="<?php echo $seo_description; ?>" />
    <link rel="canonical" href="<?php echo $page_url; ?>" />

    <?php if ($paged !== 0) { ?>
        <link rel="prev" href="<?php previous_posts(); ?>" />
    <?php } ?>
    <?php if ($max > 1 && $paged !== $max) { ?>
        <link rel="next" href="<?php next_posts(); ?>" />
    <?php } ?>
    <?php get_template_part('templates/components/head'); ?>

    <style>
        .main {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- header start -->
        <?php get_header() ?>
        <!--// header end  -->

        <!-- path -->
        <?php get_breadcrumbs(); ?>

        <!-- main_content start -->
        <div class="main_content info-product">
            <div class="layout">
                <!-- main begin -->
                <section class="main">
                    <header class="main-tit-bar">
                        <h1 class="title" style="text-transform:uppercase">INFO PRODUCT</h1>
                    </header>

                    <div class="blog_list">
                        <?php if (have_posts()) { ?>
                            <ul style="justify-content: flex-start;-webkit-justify-content: flex-start ">
                                <?php while (have_posts()) : the_post();   ?>
                                    <?php $thumbnail = get_post_meta(get_post()->ID, 'thumbnail', true); ?>
                                    <li class="blog-item">
                                        <figure class="item-wrap">
                                            <a href="<?php the_permalink(); ?>" class="item-img">
                                                <img style="width:100%;" src="<?php echo $thumbnail ?>" alt="<?php the_title(); ?>" />
                                            </a>
                                            <figcaption class="item-info">
                                                <h3 class="item-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h3>
                                                <div class="item-detail"><?php the_excerpt(); ?></div>
                                                <a href="<?php the_permalink(); ?>" class="item-more"><?php echo $readBtn ?></a>
                                            </figcaption>
                                        </figure>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php wpbeginner_numeric_posts_nav(); ?>
                        <?php } else { ?>
                            <div class="row">
                                <div class="no-product">No Product</div>
                            </div>
                        <?php } ?>
                    </div>

                    <?php get_template_part('templates/components/send-message') ?>

                    <?php get_template_part('templates/components/tags-random-category') ?>
                </section>
            </div>
        </div>
        <!--// main_content end -->

        <!--  footer start -->
        <?php get_template_part('templates/components/footer'); ?>
        <!--  footer end -->
    </div>
</body>

<?php get_footer(); ?>

<!--微数据-->
<?php get_template_part('templates/components/microdata') ?>

</html>