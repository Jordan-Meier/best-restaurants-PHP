<?php
    class Cuisine
    {
        private $type;
        private $id;

        function __construct($type, $id = null)
        {
            $this->type = $type;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function setType ($new_type)
        {
            $this->type = (string) $new_type;
        }

        function getType()
        {
            return $this->type;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisine (type) VALUES ('{$this->getType()}')");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisines = array();
            foreach($returned_cuisines as $cuisine) {
                $type = $cuisine['type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($type, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        function getRestaurants()
        {
            $restaurants = Array();
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()}");
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $happy_hour = $restaurant['happy_hour'];
                $address = $restaurant['address'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($id, $name, $happy_hour, $address, $cuisine_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM cuisine;");
        }

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id) {
                  $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

    }
?>
