<?php
$tag = get_query_var('tag');
$title = stripslashes($options['title']);
//$username = $options['username'];
//$quantity = $options['quantity'];
//$taglink = $options['taglink'];
//$notes = $options['notes'];
if ($username != '') {
	$dynam = $username.'/'.$tag;
} else {
	$dynam = 'tag/'.$tag;
}

// Checks whether or not the user has chosen to have the active tag link to their user tag page
if ($taglink != '') {
	$tagged = '<a href="http://delicious.com/'.$dynam.'" title="'.$tag.'">'.$tag.'</a>';
} else {
	$tagged = $tag;
}

// Replaces the text #activetag# in the $title with the active tag
$replace = str_replace("#activetag#", $tagged, $title);

if ($username != '') {
// Get RSS Feed(s)
include_once(ABSPATH . WPINC . '/feed.php');

// Get a SimplePie feed object from the specified feed source.
$rss = fetch_feed(array('http://delicious.com/v2/rss/'.$dynam));
if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
    // Figure out how many total items there are, but limit it to 5. 
    $maxitems = $rss->get_item_quantity($quantity); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items(0, $maxitems); 
endif;

// @todo Uncomment & remove
//Print the theme compatibility code
//echo $before_widget;
//echo $before_title . $replace . $after_title;
?>
<ul>
    <?php if ($maxitems == 0) echo '<li>No items.</li>';
    else
    // Loop through each feed item and display each item as a hyperlink.
    foreach ( $rss_items as $item ) : ?>
    <li>
        <a href='<?php echo $item->get_permalink(); ?>'
        title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
        <?php echo $item->get_title(); ?></a>
        <?php if ($notes != '' && $item->get_content() != '') { ?>
        <p><?php echo $item->get_content(); ?></p>
        <?php } ?>
    </li>
    <?php endforeach; ?>
</ul>
<?php // echo $after_widget;

} else {
// Note that is only displayed if the user has yet to fill in their Delicious Username in the options panel.
// @todo Again, remove if works fine
//// Print the theme compatibility code
//echo $before_widget;
//echo $before_title . $replace . $after_title;
?>
<p>Enter your Delicious username in the plugin's options panel.</p>
<?php // echo $after_widget;
} ?>