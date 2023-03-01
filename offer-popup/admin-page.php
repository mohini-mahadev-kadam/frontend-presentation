<?php

function my_custom_menu_page() {
    add_menu_page(
      'Offer-Popup', // The title of the page
      'Offer-Popup', // The menu item text
      'manage_options', // The capability required to access the page
      'my-offer-popup', // The unique ID of the page
      'my_offer_page_callback', // The callback function that generates the page content
      'dashicons-bell' // The icon for the menu item
    );
  }
  add_action('admin_menu', 'my_custom_menu_page');
  
  function my_offer_page_callback() {
    
        // The code for generating the page content goes here
        echo '<div class="wrap">';
        echo '<h1>Daily Offers</h1>';

        // Check if a form has been submitted
        if (isset($_POST['submit'])) {
        // Add the new offer to the list of offers
        $new_offer = $_POST['offer'];
        $offers = get_option('my_custom_offers', array());
        $offers[] = $new_offer;
        update_option('my_custom_offers', $offers);

        // Display a success message
        echo '<div class="updated"><p>New offer added!</p></div>';
        }

        // Check if an offer has been deleted
        if (isset($_POST['delete'])) {
        // Remove the offer from the list of offers
        $offer_index = $_POST['offer_index'];
        $offers = get_option('my_custom_offers', array());
        unset($offers[$offer_index]);
        update_option('my_custom_offers', $offers);

        // Display a success message
        echo '<div class="updated"><p>Offer deleted!</p></div>';
        }

        // Display the list of offers
        $offers = get_option('my_custom_offers', array());
        echo '<table class="widefat">';
        echo '<thead><tr><th>Offer</th><th>Action</th></tr></thead>';
        echo '<tbody>';
        foreach ($offers as $index => $offer) {
        echo '<tr>';
        echo '<td>' . esc_html($offer) . '</td>';
        echo '<td>';
        echo '<form method="post">';
        echo '<input type="hidden" name="offer_index" value="' . esc_attr($index) . '">';
        echo '<input type="submit" name="delete" value="Delete" class="button button-secondary">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';

        // Display the form for adding a new offer
        echo '<h2>Add New Offer</h2>';
        echo '<form method="post">';
        echo '<label for="offer"><b>Offer: <b></label>';
        echo '<input type="text" id="offer" name="offer">&ensp;';
        echo '<input type="submit" name="submit" value="Add" class="button button-primary">';
        echo '</form>';

        echo '</div>';

        // Enqueue the CSS styles for the page
        wp_enqueue_style('my-custom-page-styles', get_stylesheet_directory_uri() . '/custom-page-styles.css');
    
  }
