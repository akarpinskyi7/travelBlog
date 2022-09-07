<!-- Sidebar -->
<aside class="col-md-3 sidebar">


  <!-- Search -->
  <div class="widget">
    <div class="heading-lines">
      <h3 class="widget-title heading">Поиск по сайту</h3>
    </div>
    <form class="relative" action="<?php echo site_url() ?>" method="get">
      <input name="s" type="text" placeholder="Что ищем?">
      <input type="submit" value="Искать" id="submit-button" class="btn btn-lg btn-color">
    </form>
  </div>

  <?php if( $categories = get_categories() ) : ?>
    <!-- Categories -->
    <div class="widget categories">
      <div class="heading-lines">
        <h3 class="widget-title heading">Рубрики</h3>
      </div>
      <ul class="list-dividers">
        
        <?php foreach($categories as $cat) : ?>
          <li>
            <a href="<?php echo get_category_link( $cat ) ?>"><?php echo $cat->name ?></a><span>(<?php echo $cat->count ?>)</span>
          </li>
        <?php endforeach; ?>
        
      </ul>
    </div>
  <? endif; ?>


  <?php if( is_active_sidebar( 'rightside' ) ) dynamic_sidebar( 'rightside' ) ?>


  <?php
    $args = array(
      'posts_per_page' => '4',
      'ignore_sticky_posts' => true,

    );
    
    $query = new WP_Query( $args );

    if( $query->have_posts() ) :  // если посты найдены
  ?>


    <!-- Recent Posts -->
    <div class="widget recent-posts">
      <div class="heading-lines">
        <h3 class="widget-title heading">Свежее на блоге</h3>
      </div>
      <div class="entry-list w-thumbs">
        <ul class="posts-list list-dividers">
          
          <?php while( $query->have_posts() ) : $query->the_post(); ?>

            <li class="entry-li">
              <article class="post-small clearfix">
                <div class="entry-img">
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( 'smallsidebar' ) ?>
                  </a>
                </div>
                <div class="entry">
                  <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <ul class="entry-meta list-inline">
                    <li class="entry-date">
                      <?php the_time( 'j F Y' ) ?>
                    </li>
                  </ul>
                </div>
              </article>
            </li>

          <?php endwhile; ?>
                    
        </ul>
      </div>
    </div>

  <?php endif;
    wp_reset_postdata(); 
  ?>

</aside> <!-- end sidebar -->