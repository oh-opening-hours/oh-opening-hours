<?php

extract( $this->data['attributes'] );

/**
 * Variables defined by extraction
 *
 * @var     $before_widget      string w/ html before widget
 * @var     $after_widget       string w/ html after widget
 * @var     $before_title       string w/ html before title
 * @var     $after_title        string w/ html after title
 *
 * @var     $title              string w/ widget title
 * @var     $text               string w/ status text for widget
 * @var     $next_string        string w/ string for next period
 * @var     $next_period_classes  string w/ classes for next period span
 * @var     $is_open            bool whether set is open or not
 *
 * @var     $classes            string w/ classes for span
 */

echo $before_widget;

if ( ! empty( $title ) ) {
	echo $before_title . esc_html( $title ) . $after_title;
}

echo '<span class="' . esc_attr( $classes ) . '">' . $text . '</span>';

if ( !$is_open && isset($next_string) && is_string($next_string) ) {
	echo '<span class="op-next-period ' . esc_attr( $next_period_classes ) . '">' . esc_html( $next_string ). '</span>';
}

if (isset($today_string) && is_string($today_string) && strlen($today_string) > 0) {
	echo '<span class="op-today">'. esc_html( $today_string ) .'</span>';
}

echo $after_widget;