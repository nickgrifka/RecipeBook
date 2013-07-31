<?php

    // given a php array of recipe names, come up with a subarray of recipe names that match the query
    $query = 'Chic'; // user is typing in 'Chicken Marsala'

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
    echo "\nQuery: " . $query;
    echo "\nRecipe list:\n";
    var_dump($mockRecipeList);


    ///////////////////////////////////////////////////////////////////
    // Algorithm

    // Convert all entries to lower case and prepend a ' ' to them
    $size = count($mockRecipeList);
    for ($i = 0; $i < $size; $i++)
    {
        $mockRecipeList[$i] = strtolower($mockRecipeList[$i]);
        $mockRecipeList[$i] = " " . $mockRecipeList[$i];
    }
    $results = array();
    $query = strtolower($query);
 

    // check if the query is a substring of any of the recipes
    for ($i = 0; $i < $size; $i++)
    {
        if (strpos($mockRecipeList[$i], $query) != 0)
        {
            array_push($results, $mockRecipeList[$i]);
        }
    }

    //
    //////////////////////////////////////////////////////////////////


    // Output
    echo "\nResults:\n-----------------\n";
    var_dump($results);
    echo "\n-----------------\n";

?>