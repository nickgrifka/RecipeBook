<?php

    // given a php array of recipe names, come up with a subarray of recipe names that match the query
    $query = 'Chicke'; // user is typing in 'Chicken Marsala'

    $mockRecipeList = array('Chicken Salad',
                            'Beef Stew',
                            'Pizza',
                            'Buttered Popcorn',
                            'Garden Salad',
                            'Chicken Pot Pie',
                            'Beef Tenderloin',
                            'Chickpeas',
                            'Hamburger',
                            'Ham Sandwhich');

    // Pre-output
    echo "recipe list size: " . $size . "\n";
    echo "recipe list:\n";
    var_dump($mockRecipeList);



    // pre loop preparation, convert everything to lower case
    $size = count($mockRecipeList);
    for ($i = 0; $i < $size; $i++)
    {
        $mockRecipeList[$i] = strtolower($mockRecipeList[$i]);
    }
    $results = array();
    $query = strtolower($query);
 

    // check if the query is a substring of any of the recipes
    for ($i = 0; $i < $size; $i++)
    {
        if (strpos($mockRecipeList[$i], $query) != false)
        {
            array_push($results, $mockRecipeList[$i]);
        }
    }


    // Output
    echo "Results:\n-----------------\n";
    var_dump($results);
    echo "\n-----------------\n";

?>