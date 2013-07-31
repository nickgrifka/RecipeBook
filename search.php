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

    $size = count($mockRecipeList);
    $results = array();
    $query = strtolower($query);

    for ($i = 0; $i < $size; $i++)
    {
        if (strpos( (" " . strtolower($mockRecipeList[$i])) , $query) != 0)
        {
            array_push($results, $mockRecipeList[$i]);
        }
        var_dump(" " . strtolower($mockRecipeList[$i]));
    }

    //
    //////////////////////////////////////////////////////////////////


    // Output
    echo "\nResults:\n-----------------\n";
    var_dump($results);
    echo "\n-----------------\n";

?>