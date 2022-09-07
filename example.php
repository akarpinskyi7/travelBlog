<?php

$args = array(
  '' => '',
);

$query = new WP_Query( $args );

if( $query->have_posts() ) :  // если посты найдены

  while( $query->have_posts() ) : $query->the_post();  // до тех пор пока посты есть, инициализируем пост

    the_title();  // функция для использования в цикле, например выводим заголовки

  endwhile;

else :
  //
endif;

wp_reset_postdata();


the_post();
the_title();